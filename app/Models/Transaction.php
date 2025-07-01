<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\TicketsEmail;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'destination_id',
        'tour_package_id',
        'booking_date',
        'number_of_tickets',
        'package_price',
        'total_price',
        'status',
        'payment_method',
        'payment_gateway_token',
        'payment_deadline',
        'promo_code_id',
        'discount_amount',
        'discount_percent',
        'special_request',
    ];

    protected $casts = [
        'booking_date'       => 'date',
        'package_price'      => 'float',
        'discount_amount'    => 'float',
        'discount_percent'   => 'float',
        'total_price'        => 'float',
        'payment_deadline'   => 'datetime',
    ];

    public const STATUS_PENDING   = 'pending';
    public const STATUS_PAID      = 'paid';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_EXPIRED   = 'expired';

    // ========================
    // RELATIONS
    // ========================

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function destinationDirect()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    public function destinationViaPackage()
    {
        return $this->hasOneThrough(
            Destination::class,
            TourPackage::class,
            'id',
            'id',
            'tour_package_id',
            'destination_id'
        );
    }

    public function promoCode()
    {
        return $this->belongsTo(CodePromotion::class, 'promo_code_id');
    }

    public function tourBooking()
    {
        return $this->hasOne(TourBooking::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Getter dinamis: destination bisa dari direct atau package
    public function getDestinationAttribute()
    {
        return $this->destinationDirect ?? $this->destinationViaPackage;
    }

    // ========================
    // EVENT LOGIC
    // ========================

    protected static function booted()
    {
        parent::booted();

        static::updated(function ($transaction) {
            if ($transaction->isDirty('status') && $transaction->status === self::STATUS_PAID) {
                self::generateTicketsAndSendEmail($transaction);
            }
        });
    }

    protected static function generateTicketsAndSendEmail($transaction)
    {
        if ($transaction->tickets()->exists()) {
            Log::warning("Attempted to generate duplicate tickets for transaction ID: {$transaction->id}");
            return;
        }

        $generatedTickets = [];

        for ($i = 0; $i < $transaction->number_of_tickets; $i++) {
            $generatedTickets[] = Ticket::create([
                'transaction_id' => $transaction->id,
                'guest_name'     => $transaction->customer_name,
                'ticket_code'    => 'TIX-' . $transaction->booking_code . '-' . strtoupper(Str::random(4)),
                'status'         => 'active',
            ]);
        }

        try {
            Mail::to($transaction->customer_email)->send(new TicketsEmail($transaction, $generatedTickets));
        } catch (\Exception $e) {
            Log::error("Failed to send tickets email for transaction ID {$transaction->id}: " . $e->getMessage());
        }
    }

    // ========================
    // SCOPES
    // ========================

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    // ========================
    // ACCESSORS
    // ========================

    public function getTotalPriceFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getFormattedBookingDateAttribute(): string
    {
        return $this->booking_date->translatedFormat('d F Y');
    }
}
