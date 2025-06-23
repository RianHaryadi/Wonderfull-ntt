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
        'is_popular', // tambah ini
    ];

    protected $casts = [
        'is_popular' => 'boolean', // supaya otomatis boolean
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

