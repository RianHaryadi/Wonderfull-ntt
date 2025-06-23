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
    ];

    // Cast kolom photos sebagai array
    protected $casts = [
        'photos' => 'array',
        'includes_hotel' => 'boolean',
    ];

    /**
     * Relasi ke tabel transactions (satu paket bisa punya banyak transaksi)
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relasi ke satu destinasi utama (jika destination_id digunakan)
     */
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Relasi ke banyak destinasi (jika ada tabel pivot destination_tour_package)
     */
    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'destination_tour_package');
    }

    /**
     * Relasi ke banyak hotel (melalui tabel pivot tour_package_hotel)
     */
    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'tour_package_hotel', 'tour_package_id', 'hotel_id');
    }

    /**
     * Relasi ke satu hotel (jika hanya ada satu hotel utama)
     */
    // public function hotel()
    // {
    //     return $this->belongsTo(Hotel::class);
    // }

    /**
     * Relasi ke banyak varian tur dalam satu paket
     */
    public function variants()
    {
        return $this->hasMany(TourPackageVariant::class);
    }

    /**
     * Akses ke properti photos (jika disimpan sebagai array di kolom JSON)
     */
    public function getPhotoUrlsAttribute()
    {
        return collect($this->photos)->map(function ($photo) {
            return asset('storage/' . ltrim($photo, '/'));
        });
    }

    public function nearbyHotels()
    {
        return Hotel::where('location', 'LIKE', '%' . $this->location . '%')->get();
    }
}
