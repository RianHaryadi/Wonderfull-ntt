<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Controller ini FOKUS hanya untuk menangani proses pemesanan (booking) Paket Tour.
 */
class PaketTourBookingController extends Controller
{
    /**
     * Menyimpan data pemesanan dari formulir ke tabel transactions.
     * Ini adalah satu-satunya fungsi dari controller ini.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari formulir pemesanan
        $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'customer_name'   => 'required|string|max:255',
            'customer_email'  => 'required|email|max:255',
            'customer_phone'  => 'required|string|max:20',
            'booking_date'    => 'required|date|after_or_equal:today',
            'number_of_tickets' => 'required|integer|min:1',
        ]);

        // 2. Ambil data paket tour untuk mendapatkan harga
        $tourPackage = TourPackage::findOrFail($request->tour_package_id);

        // 3. Hitung detail harga
        $productPrice = $tourPackage->price;
        $totalPrice   = $productPrice * $request->number_of_tickets;
        $discount     = 0; // Logika diskon bisa ditambahkan di sini

        // 4. Buat data transaksi baru di tabel 'transactions'
        $transaction = Transaction::create([
            'booking_code'      => 'PKT-' . strtoupper(Str::random(10)),
            'customer_name'     => $request->customer_name,
            'customer_email'    => $request->customer_email,
            'customer_phone'    => $request->customer_phone,
            'tour_package_id'   => $tourPackage->id,
            'destination_id'    => null, // Pastikan ini null untuk pemesanan paket
            'booking_date'      => $request->booking_date,
            'number_of_tickets' => $request->number_of_tickets,
            'package_price'     => $productPrice,
            'discount'          => $discount,
            'total_price'       => $totalPrice - $discount,
            'status'            => Transaction::STATUS_PENDING,
        ]);

        // 5. Redirect ke halaman selanjutnya (misal: halaman pembayaran atau sukses)
        return redirect()->route('transaction.payment', $transaction->booking_code)
                         ->with('success', 'Pemesanan paket tour berhasil dibuat! Silakan selesaikan pembayaran.');
    }
}