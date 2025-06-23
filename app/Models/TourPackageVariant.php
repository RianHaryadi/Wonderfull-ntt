<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackageVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_package_id',
        'label',
        'includes_hotel',
        'hotel_id',
    ];

   public function tourPackage()
{
    return $this->belongsTo(TourPackage::class);
}

   public function hotel()
{
    return $this->belongsTo(Hotel::class);
}

    public function getFinalPriceAttribute()
{
    $variantPrice = $this->price ?? 0; // pastikan ada kolom price di tabel variants kalau perlu

    if ($this->includes_hotel && $this->hotel) {
        switch (strtolower($this->label)) {
            case 'single room':
                $hotelPrice = $this->hotel->single_room_price ?? 0;
                break;
            case 'double room':
                $hotelPrice = $this->hotel->double_room_price ?? 0;
                break;
            case 'family room':
                $hotelPrice = $this->hotel->family_room_price ?? 0;
                break;
            default:
                $hotelPrice = 0;
        }
        return $hotelPrice + $variantPrice;
    }
    return $variantPrice;
}
}