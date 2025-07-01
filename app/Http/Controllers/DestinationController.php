<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Transaction;
use App\Models\CodePromotion; // ✅ Tambahkan model promo
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    /**
     * Menampilkan daftar semua destinasi.
     */
    public function index()
    {
        $destinations = Destination::latest()->paginate(12);
        return view('destinations.index', compact('destinations'));
    }

    /**
     * Menampilkan detail satu destinasi.
     */
    public function show($id)
    {
        $destination = Destination::findOrFail($id);
        return view('destinations.show', compact('destination'));
    }

    /**
     * Menampilkan halaman formulir pemesanan.
     */
    public function book($id)
    {
        $destination = Destination::findOrFail($id);

        // ✅ Ambil promo yang aktif dan dalam rentang tanggal berlaku
        $promos = CodePromotion::where('active', true)
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_until', '>=', now())
            ->get();

        return view('destinations.book', compact('destination', 'promos'));
    }

    /**
     * Memproses dan menyimpan data dari formulir pemesanan.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'destination_id'     => 'required|exists:destinations,id',
            'customer_name'      => 'required|string|max:255',
            'customer_email'     => 'required|email|max:255',
            'customer_phone'     => 'required|string|max:20',
            'booking_date'       => 'required|date|after_or_equal:today',
            'number_of_tickets'  => 'required|integer|min:1',
            'promo_code_id'      => 'nullable|integer',
            'discount_amount'    => 'nullable|numeric|min:0',
        ]);

        $destination = Destination::findOrFail($request->destination_id);

        // 2. Hitung total harga
        $subtotal = $destination->price * $request->number_of_tickets;
        $discount = $request->discount_amount ?? 0;
        $totalPrice = max($subtotal - $discount, 0);

        // 3. Buat transaksi
        $transaction = Transaction::create([
            'booking_code'       => 'DST-' . strtoupper(Str::random(10)),
            'customer_name'      => $request->customer_name,
            'customer_email'     => $request->customer_email,
            'customer_phone'     => $request->customer_phone,
            'destination_id'     => $destination->id,
            'tour_package_id'    => null,
            'booking_date'       => $request->booking_date,
            'number_of_tickets'  => $request->number_of_tickets,
            'package_price'      => $destination->price,
            'discount'           => $discount,
            'total_price'        => $totalPrice,
            'status'             => Transaction::STATUS_PENDING,
            'promo_code_id'      => $request->promo_code_id, // ✅ simpan jika ada
        ]);

        // 4. Redirect ke halaman pembayaran
        return redirect()->route('transaction.payment', $transaction->booking_code)
                         ->with('success', 'Pemesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
    }
}
