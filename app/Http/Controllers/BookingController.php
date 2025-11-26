<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingHotel;
use App\Models\Transaction;
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

        $bookingNumber = strtoupper(trim($request->booking_number));

        // 1. Cek apakah ini booking hotel (format: BOOK-*)
        if (str_starts_with($bookingNumber, 'BOOK-')) {
            $booking = BookingHotel::with(['promoCode', 'hotel'])
                        ->where('booking_number', $bookingNumber)
                        ->first();

            if ($booking) {
                return view('booking.check', [
                    'bookingType' => 'hotel',
                    'data' => $booking,
                ]);
            }
        }

        // 2. Cek apakah ini booking destinasi (format: DST-*)
        if (str_starts_with($bookingNumber, 'DST-')) {
            $booking = Transaction::with(['destinationDirect', 'promoCode'])
                        ->where('booking_code', $bookingNumber)
                        ->whereNotNull('destination_id')
                        ->first();

            if ($booking) {
                return view('booking.check', [
                    'bookingType' => 'destination',
                    'data' => $booking,
                ]);
            }
        }

        // 3. Cek apakah ini booking paket tour (format: PKT-*)
        if (str_starts_with($bookingNumber, 'PKT-')) {
            $booking = Transaction::with(['tourPackage', 'tourPackage.destination', 'promoCode'])
                        ->where('booking_code', $bookingNumber)
                        ->whereNotNull('tour_package_id')
                        ->first();

            if ($booking) {
                return view('booking.check', [
                    'bookingType' => 'tour_package',
                    'data' => $booking,
                ]);
            }
        }

        // 4. Jika tidak ada prefix yang cocok, coba cari di semua tabel
        // Cari di booking hotel
        $hotelBooking = BookingHotel::with(['promoCode', 'hotel'])
                        ->where('booking_number', $bookingNumber)
                        ->first();

        if ($hotelBooking) {
            return view('booking.check', [
                'bookingType' => 'hotel',
                'data' => $hotelBooking,
            ]);
        }

        // Cari di transactions
        $transaction = Transaction::with(['destinationDirect', 'tourPackage', 'tourPackage.destination', 'promoCode'])
                        ->where('booking_code', $bookingNumber)
                        ->first();

        if ($transaction) {
            if ($transaction->destination_id) {
                return view('booking.check', [
                    'bookingType' => 'destination',
                    'data' => $transaction,
                ]);
            } elseif ($transaction->tour_package_id) {
                return view('booking.check', [
                    'bookingType' => 'tour_package',
                    'data' => $transaction,
                ]);
            }
        }

        return back()
            ->withErrors(['booking_number' => 'Nomor booking tidak ditemukan.'])
            ->withInput();
    }

    /**
     * Akses langsung ke detail booking via /booking/{booking_number}
     */
    public function show($booking_number)
    {
        $bookingNumber = strtoupper(trim($booking_number));

        // Gunakan logika yang sama dengan method check
        if (str_starts_with($bookingNumber, 'BOOK-')) {
            $booking = BookingHotel::with(['promoCode', 'hotel'])
                        ->where('booking_number', $bookingNumber)
                        ->first();

            if ($booking) {
                return view('booking.check', [
                    'bookingType' => 'hotel',
                    'data' => $booking,
                ]);
            }
        }

        if (str_starts_with($bookingNumber, 'DST-')) {
            $booking = Transaction::with(['destinationDirect', 'promoCode'])
                        ->where('booking_code', $bookingNumber)
                        ->whereNotNull('destination_id')
                        ->first();

            if ($booking) {
                return view('booking.check', [
                    'bookingType' => 'destination',
                    'data' => $booking,
                ]);
            }
        }

        if (str_starts_with($bookingNumber, 'PKT-')) {
            $booking = Transaction::with(['tourPackage', 'tourPackage.destination', 'promoCode'])
                        ->where('booking_code', $bookingNumber)
                        ->whereNotNull('tour_package_id')
                        ->first();

            if ($booking) {
                return view('booking.check', [
                    'bookingType' => 'tour_package',
                    'data' => $booking,
                ]);
            }
        }

        // Fallback: cari di semua tabel
        $hotelBooking = BookingHotel::with(['promoCode', 'hotel'])
                        ->where('booking_number', $bookingNumber)
                        ->first();

        if ($hotelBooking) {
            return view('booking.check', [
                'bookingType' => 'hotel',
                'data' => $hotelBooking,
            ]);
        }

        $transaction = Transaction::with(['destinationDirect', 'tourPackage', 'tourPackage.destination', 'promoCode'])
                        ->where('booking_code', $bookingNumber)
                        ->first();

        if ($transaction) {
            if ($transaction->destination_id) {
                return view('booking.check', [
                    'bookingType' => 'destination',
                    'data' => $transaction,
                ]);
            } elseif ($transaction->tour_package_id) {
                return view('booking.check', [
                    'bookingType' => 'tour_package',
                    'data' => $transaction,
                ]);
            }
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