<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'image',
        'category',
        'is_popular',
        'rating',         
        'rating_count',   
        'latitude',       
        'longitude',      
        'maps_url',       
        'price',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'rating' => 'float',
        'rating_count' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'destination_hotel');
    }

    public function tourPackages()
    {
        return $this->belongsToMany(TourPackage::class, 'destination_tour_package');
    }
}
