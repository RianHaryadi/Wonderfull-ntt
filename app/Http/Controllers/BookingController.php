<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingHotel;
use App\Models\CodePromotion;
use App\Models\Hotel;

class BookingController extends Controller
{
    /**
     * Tampilkan form cek status booking.
     */
    public function checkForm()
    {
        return view('booking.check');
    }

    /**
     * Proses pencarian booking berdasarkan nomor booking.
     */
    public function check(Request $request)
    {
        $request->validate([
            'booking_number' => 'required|string',
        ]);

        $bookingNumber = $request->booking_number;

        // Cari booking hotel beserta relasi promo dan hotel
        $hotel = BookingHotel::with('promoCode', 'hotel')
                    ->where('booking_number', $bookingNumber)
                    ->first();

        if ($hotel) {
            return view('booking.check', [
                'bookingType' => 'hotel',
                'data' => $hotel,
            ]);
        }

        return back()->withErrors(['booking_number' => 'Nomor booking tidak ditemukan.']);
    }

    /**
     * Akses langsung ke detail booking via /booking/{booking_number}
     */
    public function show($booking_number)
    {
        $hotel = BookingHotel::with('promoCode', 'hotel')
                    ->where('booking_number', $booking_number)
                    ->first();

        if ($hotel) {
            return view('booking.check', [
                'bookingType' => 'hotel',
                'data' => $hotel,
            ]);
        }

        return redirect()->route('booking.checkForm')
                         ->withErrors(['booking_number' => 'Nomor booking tidak ditemukan.']);
    }

    /**
     * Tampilkan form booking hotel beserta daftar promo.
     */
    public function bookHotel(Hotel $hotel)
{
    $promoCodes = CodePromotion::all()->filter(fn($p) => $p->isValid());

$formattedPromoCodes = $promoCodes->mapWithKeys(function ($promo) {
    return [
        strtoupper($promo->code) => [
            'promo_code_id' => $promo->id,
            'type' => $promo->discount_percent > 0 ? 'percentage' : 'fixed',
            'amount' => $promo->discount_percent > 0 ? $promo->discount_percent : $promo->discount_amount
        ]
    ];
})->toArray();
    return view('booking.create', compact('hotel', 'promoCodes', 'formattedPromoCodes'));
}

}
