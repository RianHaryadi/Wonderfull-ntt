<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_package_id',
        'hotel_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'tour_price',
        'hotel_price',
        'total_price',
        'status',
        'payment_method',
        'booking_number',   
    ];

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function transaction()
{
    return $this->belongsTo(Transaction::class);
}

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
