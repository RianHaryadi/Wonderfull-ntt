<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Transaction;
use App\Models\CodePromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    /**
     * Menampilkan daftar semua destinasi dengan filter.
     */
    public function index(Request $request)
    {
        // Define valid categories
        $validCategories = [
            'Beach' => 'Beach',
            'Mountain' => 'Mountain',
            'Culture' => 'Culture',
            'Nature' => 'Nature',
        ];

        // Start with a query builder instance
        $query = Destination::query();

        // Apply category filter
        if ($request->has('category') && array_key_exists($request->category, $validCategories)) {
            $query->where('category', $validCategories[$request->category]);
        }

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Apply price filters
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }

        // Apply rating filters
        if ($request->has('min_rating') && is_numeric($request->min_rating)) {
            $query->where('rating', '>=', $request->min_rating);
        }

        if ($request->has('max_rating') && is_numeric($request->max_rating)) {
            $query->where('rating', '<=', $request->max_rating);
        }

        // Apply popular filter
        if ($request->has('is_popular') && $request->is_popular) {
            $query->where('is_popular', true);
        }

        // Order by latest and paginate
        $destinations = $query->latest()->paginate(12);

        // Append query parameters to pagination links
        $destinations->appends($request->only([
            'category',
            'search',
            'min_price',
            'max_price',
            'min_rating',
            'max_rating',
            'is_popular'
        ]));

        // Pass categories to the view
        $categories = ['All', ...array_keys($validCategories)];

        return view('destinations.index', compact('destinations', 'categories'));
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

        // Ambil promo yang aktif dan dalam rentang tanggal berlaku
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
        // Validasi input
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

        // Hitung total harga
        $subtotal = $destination->price * $request->number_of_tickets;
        $discount = $request->discount_amount ?? 0;
        $totalPrice = max($subtotal - $discount, 0);

        // Buat transaksi
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
            'promo_code_id'      => $request->promo_code_id,
        ]);

        // Redirect ke halaman pembayaran
        return redirect()->route('transaction.payment', $transaction->booking_code)
                         ->with('success', 'Pemesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
    }
}