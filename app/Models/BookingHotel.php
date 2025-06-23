<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Mail\HotelBookingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BookingHotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'hotel_room_id',
        'room_type',
        'customer_name',
        'customer_email',
        'customer_phone',
        'check_in_date',
        'check_out_date',
        'night_count',
        'room_price',
        'tax',
        'service_charge',
        'total_price',
        'discount_precent',
        'discount_amount',
        'promo_code_id',
        'status',
        'payment_method',
        'booking_number',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function hotelRoom()
    {
        return $this->belongsTo(HotelRoom::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(CodePromotion::class, 'promo_code_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getHotelNameAttribute()
    {
        return $this->hotel->name ?? 'Unknown';
    }

    public function getNightCountAttribute()
    {
        if ($this->check_in_date && $this->check_out_date) {
            return $this->check_in_date->diffInDays($this->check_out_date);
        }
        return 0;
    }

    public function getRoomPriceAttribute($value)
    {
        if ($value !== null) return $value;

        if ($this->hotel) {
            return match ($this->room_type) {
                'single' => $this->hotel->single_room_price,
                'double' => $this->hotel->double_room_price,
                'family' => $this->hotel->family_room_price,
                default => 0
            };
        }

        return 0;
    }

    public function calculateTotalPrice()
    {
        $nights = $this->night_count;
        $basePrice = $this->room_price * $nights;
        $tax = $basePrice * 0.10;
        $service = $basePrice * 0.05;

        $discount = 0;
        if ($this->promoCode) {
            $discount = $this->promoCode->discount_type === 'percentage'
                ? $basePrice * ($this->promoCode->discount_amount / 100)
                : $this->promoCode->discount_amount;
        }

        $this->tax = $tax;
        $this->service_charge = $service;
        $this->discount_amount = $discount;
        $this->total_price = max($basePrice + $tax + $service - $discount, 0);

        return $this->total_price;
    }

    public function updateBookingStatusToCheckout()
    {
        if ($this->hotelRoom && $this->hotelRoom->status == 'available') {
            $this->update(['status' => 'checked-out']);
        }
    }

    protected static function booted()
{
    static::creating(function ($booking) {
        $booking->booking_number = 'BOOK-' . Carbon::now()->format('Ymd') . '-' . str_pad(BookingHotel::count() + 1, 4, '0', STR_PAD_LEFT);
    });

    static::saving(function ($booking) {
        $booking->night_count = $booking->check_in_date && $booking->check_out_date
            ? $booking->check_in_date->diffInDays($booking->check_out_date)
            : 0;

        if (!$booking->room_price && $booking->hotel) {
            $booking->room_price = match ($booking->room_type) {
                'single' => $booking->hotel->single_room_price,
                'double' => $booking->hotel->double_room_price,
                'family' => $booking->hotel->family_room_price,
                default => 0
            };
        }

        $basePrice = $booking->room_price * $booking->night_count;
        $tax = $basePrice * 0.10;
        $service = $basePrice * 0.05;

        $discount = 0;
        if ($booking->promoCode) {
            $discount = $booking->promoCode->discount_type === 'percentage'
                ? $basePrice * ($booking->promoCode->discount_amount / 100)
                : $booking->promoCode->discount_amount;
        }

        $booking->tax = $tax;
        $booking->service_charge = $service;
        $booking->discount_amount = $discount;
        $booking->total_price = max($basePrice + $tax + $service - $discount, 0);
    });

    static::created(function ($booking) {
        // hanya kurangi kamar jika status APPROVE saat pertama kali dibuat
        if ($booking->status === 'approve' && $booking->hotel) {
            match ($booking->room_type) {
                'single' => $booking->hotel->decrement('room_count_single'),
                'double' => $booking->hotel->decrement('room_count_double'),
                'family' => $booking->hotel->decrement('room_count_family'),
            };
        }

        // Kirim email jika metode pembayaran transfer atau qris
        try {
            if (in_array($booking->payment_method, ['transfer', 'qris']) && $booking->customer_email) {
                Mail::to($booking->customer_email)->send(new HotelBookingMail($booking));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send hotel booking email: ' . $e->getMessage());
        }
    });

    static::updating(function ($booking) {
        $original = $booking->getOriginal();
        $hotel = $booking->hotel;

        $originalStatus = $original['status'];
        $newStatus = $booking->status;
        $originalRoom = $original['room_type'];
        $newRoom = $booking->room_type;

        $roomFieldOld = match ($originalRoom) {
            'single' => 'room_count_single',
            'double' => 'room_count_double',
            'family' => 'room_count_family',
            default => null,
        };

        $roomFieldNew = match ($newRoom) {
            'single' => 'room_count_single',
            'double' => 'room_count_double',
            'family' => 'room_count_family',
            default => null,
        };

        // 1. Status berubah dari approve → failed/pending → kembalikan kamar
        if ($originalStatus === 'approve' && in_array($newStatus, ['pending', 'failed']) && $roomFieldOld) {
            $hotel->increment($roomFieldOld);
        }

        // 2. Status berubah dari pending/failed → approve → potong kamar
        if (in_array($originalStatus, ['pending', 'failed']) && $newStatus === 'approve' && $roomFieldNew) {
            $hotel->decrement($roomFieldNew);
        }

        // 3. Status tetap approve, tapi jenis kamar berubah
        if ($originalRoom !== $newRoom && $originalStatus === 'approve' && $newStatus === 'approve') {
            if ($roomFieldOld) $hotel->increment($roomFieldOld);
            if ($roomFieldNew) $hotel->decrement($roomFieldNew);
        }
    });
}
}
