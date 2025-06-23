<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'description',
        'facilities',
        'location',
        'single_room_price',
        'double_room_price',
        'family_room_price',
        'room_count_single',
        'room_count_double',
        'room_count_family',
        'image',
    ];

    /**
     * Relasi ke tabel hotel_rooms
     */
    public function hotelRooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'destination_hotel');
    }


    /**
     * Alias relasi rooms (opsional, sama dengan hotelRooms)
     */
    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    /**
     * Mengurangi jumlah kamar sesuai tipe saat booking dibuat
     */
    public function decrementRoomCount($roomType)
    {
        if ($roomType === 'single') {
            $this->decrement('room_count_single');
        } elseif ($roomType === 'double') {
            $this->decrement('room_count_double');
        } elseif ($roomType === 'family') {
            $this->decrement('room_count_family');
        }
    }

    /**
     * Menambahkan kembali kamar saat status booking menjadi check-out
     */
    public function incrementRoomCount($roomType)
    {
        if ($roomType === 'single') {
            $this->increment('room_count_single');
        } elseif ($roomType === 'double') {
            $this->increment('room_count_double');
        } elseif ($roomType === 'family') {
            $this->increment('room_count_family');
        }
    }

    // public function tourPackages()
    // {
    //     return $this->belongsToMany(TourPackage::class, 'tour_package_hotel', 'hotel_id', 'tour_package_id');
    // }
}
