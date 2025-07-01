<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

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

        // Update transaksi
        $transaction->update([
            'payment_method' => $paymentMethod,
            'status' => 'paid',
        ]);

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
