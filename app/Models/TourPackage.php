<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'destination_id',
        'price',
        'days',
        'includes_hotel',
        'location',
        'thumbnail',
        'category',
        'photos',
        'description',
        'rating',
        'rating_count',
        
    ];

    protected $casts = [
        'photos' => 'array',
        'includes_hotel' => 'boolean',
    ];

    // =======================
    // RELATIONS
    // =======================

    /**
     * Satu paket tur bisa memiliki banyak transaksi
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relasi ke satu destinasi utama (via foreign key destination_id)
     */
    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    /**
     * Jika paket tur terhubung dengan banyak destinasi (pivot table: destination_tour_package)
     */
    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'destination_tour_package');
    }

    /**
     * Jika paket tur memiliki banyak hotel terkait (pivot table: tour_package_hotel)
     */
    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'tour_package_hotel', 'tour_package_id', 'hotel_id');
    }

    /**
     * Jika kamu aktifkan varian paket tur (tur tidak bundling)
     */
    // public function variants()
    // {
    //     return $this->hasMany(TourPackageVariant::class);
    // }

    // =======================
    // ACCESSORS
    // =======================

    /**
     * Mengakses full URL dari semua foto
     */
    public function getPhotoUrlsAttribute()
    {
        return collect($this->photos)->map(function ($photo) {
            return asset('storage/' . ltrim($photo, '/'));
        });
    }

    // =======================
    // CUSTOM QUERY
    // =======================

    /**
     * Mendapatkan hotel terdekat berdasarkan lokasi (untuk rekomendasi)
     */
    public function nearbyHotels()
    {
        return Hotel::where('location', 'LIKE', '%' . $this->location . '%')->get();
    }
}
