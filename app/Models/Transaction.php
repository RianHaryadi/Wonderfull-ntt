<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketsEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_package_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'base_price',
        'ticket_quantity',
        'promo_code',
        'discount',
        'total_price',
        'payment_method',
        'status',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'base_price' => 'float',
        'discount' => 'float',
        'total_price' => 'float',
    ];

    // Optional: status constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';

    // Relasi
    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function bookingHotel()
    {
        return $this->belongsTo(BookingHotel::class, 'booking_hotel_id');
    }


    // Boot method: generate tiket dan kirim email otomatis
    protected static function booted()
    {
        parent::booted();

        static::created(function ($transaction) {
            if ($transaction->status === self::STATUS_CONFIRMED) {
                self::generateTicketsAndSendEmail($transaction);
            }
        });

        static::updated(function ($transaction) {
            if ($transaction->isDirty('status') && $transaction->status === self::STATUS_CONFIRMED) {
                self::generateTicketsAndSendEmail($transaction);
            }
        });
    }

    protected static function generateTicketsAndSendEmail($transaction)
    {
        if ($transaction->tickets()->exists()) {
            // Tiket sudah dibuat, jangan buat ulang
            return;
        }

        $tickets = [];
        for ($i = 0; $i < $transaction->ticket_quantity; $i++) {
            $tickets[] = Ticket::create([
                'transaction_id' => $transaction->id,
                'ticket_code' => 'TKT-' . strtoupper(Str::random(8)),
                'status' => 'active',
            ]);
        }

        try {
            Mail::to($transaction->customer_email)->send(new TicketsEmail($transaction, $tickets));
        } catch (\Exception $e) {
            Log::error('Failed to send tickets email: ' . $e->getMessage());
        }
    }

    // Accessor untuk total_price dengan format Rp
    public function getTotalPriceFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
    
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}

