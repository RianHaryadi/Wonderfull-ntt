<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // Import Attribute

class CodePromotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = [
        'code',
        'description',
        'discount_amount',
        'discount_percent',
        'valid_from',
        'valid_until',
        'active',
    ];

    /**
     * The attributes that should be cast.
     * Menggunakan 'datetime' untuk perbandingan yang lebih akurat dengan now().
     */
    protected $casts = [
        'active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    /**
     * Relasi ke tabel booking_hotels
     */
    public function bookingHotels()
    {
        return $this->hasMany(BookingHotel::class, 'promo_code_id');
    }

    /**
     * Relasi ke tabel transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'promo_code_id');
    }

    public function destinasi()
    {
        return $this->belongsToMany(Destination::class, 'destination_promo', 'promo_code_id', 'destination_id');
    }
    
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope untuk mendapatkan promosi yang aktif dan dalam rentang tanggal yang valid.
     */
    public function scopeCurrentlyValid($query)
    {
        return $query->where('active', true)
            ->where(function ($q) {
                $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
            })
            ->where(function ($q) {
                // Cek sampai akhir hari (23:59:59)
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            });
    }

    /**
     * Mengecek apakah kode promo masih aktif dan valid saat ini.
     * Logika disempurnakan untuk menangani tanggal 'valid_until' secara inklusif.
     */
    public function isValid(): bool
    {
        $now = now();

        $isStarted = !$this->valid_from || $this->valid_from->isPast() || $this->valid_from->isToday();
        
        // Promosi valid sampai akhir hari dari tanggal valid_until
        $isNotExpired = !$this->valid_until || $this->valid_until->endOfDay()->isFuture();

        return $this->active && $isStarted && $isNotExpired;
    }

    /**
     * NEW: Accessor untuk digunakan oleh Filament Table.
     * Ini membuat properti 'is_currently_valid' yang bisa diakses.
     */
    protected function isCurrentlyValid(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->isValid(),
        );
    }
}