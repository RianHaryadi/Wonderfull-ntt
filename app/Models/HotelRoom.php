<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'customer_name',
        'room_type',
        'room_number',
        'status',
        'booking_hotel_id',
    ];

    
    // Relasi ke Hotel
    public function hotel()
{
    return $this->belongsTo(Hotel::class);
}
   // Relasi ke BookingHotel
public function bookingHotel()
{
    return $this->belongsTo(BookingHotel::class, 'booking_hotel_id');
}

    public static function generateRoomNumber(string $roomType): string
    {
        $prefixMap = [
            'single' => 'SG',
            'double' => 'DB',
            'family' => 'FM',
        ];

        $prefix = $prefixMap[$roomType] ?? 'XX';

        $count = self::where('room_type', $roomType)->count();

        $maxPerType = [
            'single' => 10,
            'double' => 10,
            'family' => 5,
        ];

        if ($count >= ($maxPerType[$roomType] ?? 0)) {
            throw new \Exception("Jumlah maksimal kamar untuk tipe '$roomType' sudah tercapai.");
        }

        return $prefix . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    
}