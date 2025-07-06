<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TourBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman pembayaran berdasarkan booking_code.
     */
    public function payment($booking_code)
    {
        $transaction = Transaction::where('booking_code', $booking_code)->firstOrFail();
        return view('transaction.payment', compact('transaction'));
    }

    /**
     * Memproses konfirmasi pembayaran dari user.
     */
    public function confirmPayment(Request $request, Transaction $transaction)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'payment_method' => ['required', 'in:bank_transfer,qris'],
            'booking_code' => ['required', 'string', 'exists:transactions,booking_code'],
        ]);

        // Pastikan booking_code cocok
        if ($transaction->booking_code !== $validated['booking_code']) {
            return back()->withErrors(['booking_code' => 'Kode booking tidak cocok.']);
        }

        // Konversi 'bank_transfer' ke 'transfer' agar cocok dengan enum
        $paymentMethod = $validated['payment_method'] === 'bank_transfer' ? 'transfer' : 'qris';

        // Gunakan transaksi database untuk memastikan konsistensi
        DB::transaction(function () use ($transaction, $paymentMethod) {
            // Update transaksi
            $transaction->update([
                'payment_method' => $paymentMethod,
                'status' => 'paid',
            ]);

            // Update status booking di tabel tour_bookings
            $booking = TourBooking::where('booking_number', $transaction->booking_code)->first();
            if ($booking) {
                $booking->update([
                    'status' => 'confirmed',
                    'payment_method' => $paymentMethod,
                ]);
            } else {
                // Log jika booking tidak ditemukan (untuk debugging)
                \Illuminate\Support\Facades\Log::warning('Booking not found for booking_code: ' . $transaction->booking_code);
            }
        });

        // Redirect ke halaman sukses
        return redirect()
            ->route('transactions.success', $transaction->booking_code)
            ->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    /**
     * Menampilkan halaman sukses setelah pembayaran.
     */
    public function success($booking_code)
    {
        $transaction = Transaction::where('booking_code', $booking_code)->firstOrFail();
        return view('transaction.success', compact('transaction'));
    }
}