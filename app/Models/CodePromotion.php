<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [
        'active' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
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
     * Mengecek apakah kode promo masih aktif dan valid saat ini
     */
    public function isValid()
    {
        $now = now();

        return $this->active
            && (!$this->valid_from || $this->valid_from->lte($now))
            && (!$this->valid_until || $this->valid_until->gte($now));
    }
}
