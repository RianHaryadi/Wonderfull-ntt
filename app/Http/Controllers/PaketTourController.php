<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\Transaction;
use App\Models\TourBooking;
use App\Models\Destination;
use App\Models\CodePromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PaketTourController extends Controller
{
    /**
     * Menampilkan daftar semua tour packages dengan filter.
     */
    public function index(Request $request)
    {
        $destinations = TourPackage::select('location')->distinct()->orderBy('location')->pluck('location');
        $query = TourPackage::query();

        if ($request->filled('q')) {
            $searchTerm = '%' . $request->q . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('location', 'like', $searchTerm);
            });
        }

        if ($request->filled('destination')) {
            $query->where('location', $request->destination);
        }

        if ($request->filled('duration')) {
            switch ($request->duration) {
                case '1-3': $query->where('days', '<=', 3); break;
                case '4-7': $query->whereBetween('days', [4, 7]); break;
                case '8+':  $query->where('days', '>=', 8); break;
            }
        }

        if ($request->filled('price')) {
            switch ($request->price) {
                case 'under-1000000': $query->where('price', '<', 1000000); break;
                case '1-3': $query->whereBetween('price', [1000000, 3000000]); break;
                case '3-5': $query->whereBetween('price', [3000000, 5000000]); break;
                case '5+':  $query->where('price', '>=', 5000000); break;
            }
        }

        $sort = $request->input('sort', 'popular');
        switch ($sort) {
            case 'price-asc': $query->orderBy('price', 'asc'); break;
            case 'price-desc': $query->orderBy('price', 'desc'); break;
            case 'duration': $query->orderBy('days', 'asc'); break;
            case 'rating': $query->orderBy('rating', 'desc'); break;
            case 'popular':
            default: $query->orderBy('created_at', 'desc'); break;
        }

        $paketTours = $query->paginate(12)->appends($request->query());
        return view('paket_tour.index', compact('paketTours', 'destinations'));
    }

    /**
     * Menampilkan detail satu tour package.
     */
    public function show($id)
    {
        $paketTour = TourPackage::findOrFail($id);
        return view('paket_tour.show', compact('paketTour'));
    }

    /**
     * Menampilkan halaman pemesanan.
     */
    public function create(TourPackage $tourPackage)
{
    $destinations = Destination::pluck('name', 'id');
    $promos = CodePromotion::active()->get(); // scopeActive() di model

    $promoJson = $promos->mapWithKeys(function ($promo) {
        return [strtoupper($promo->code) => [
            'id' => $promo->id,
            'amount' => $promo->discount_amount,
            'percent' => $promo->discount_percent,
            'valid_from' => optional($promo->valid_from)->toDateString(),
            'valid_until' => optional($promo->valid_until)->toDateString(),
            'active' => $promo->active,
        ]];
    });

    return view('paket_tour.create', compact('tourPackage', 'destinations', 'promos', 'promoJson'));
}


    /**
     * Menyimpan pemesanan dan transaksi tour package.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_package_id'    => 'required|exists:tour_packages,id',
            'destination_id'     => 'required|exists:destinations,id',
            'customer_name'      => 'required|string|max:255',
            'customer_email'     => 'required|email|max:255',
            'customer_phone'     => 'required|string|max:20',
            'booking_date'       => 'required|date|after_or_equal:today',
            'number_of_tickets'  => 'required|integer|min:1',
            'promo_code_id'      => 'nullable|integer',
            'discount_amount'    => 'nullable|numeric|min:0',
            'discount_percent'   => 'nullable|numeric|min:0|max:100',
            'payment_method'     => 'nullable|in:transfer,qris,cash',
            'special_request'    => 'nullable|string',
        ]);

        $tourPackage = TourPackage::findOrFail($validated['tour_package_id']);
        $destination = Destination::findOrFail($validated['destination_id']);
        $subtotal = $tourPackage->price * $validated['number_of_tickets'];
        $bookingCode = 'PKT-' . strtoupper(Str::random(10));

        // Validasi kode promo
        $promo = null;
        if ($validated['promo_code_id'] ?? false) {
            $promo = CodePromotion::active()
                ->where('id', $validated['promo_code_id'])
                ->whereDate('valid_from', '<=', now())
                ->whereDate('valid_until', '>=', now())
                ->first();
        }

        // Hitung diskon
        $discount = 0;
        if ($promo) {
            $discount = $promo->discount_amount ?: ($promo->discount_percent ? $subtotal * $promo->discount_percent / 100 : 0);
        } elseif ($validated['discount_amount'] ?? false) {
            $discount = $validated['discount_amount'];
        } elseif ($validated['discount_percent'] ?? false) {
            $discount = $subtotal * ($validated['discount_percent'] / 100);
        }

        $totalPrice = max($subtotal - $discount, 0);

        DB::transaction(function () use ($validated, $tourPackage, $destination, $bookingCode, $subtotal, $discount, $totalPrice, $promo) {
    Transaction::create([
        'booking_code'       => $bookingCode,
        'tour_package_id'    => $tourPackage->id,
        'destination_id'     => $destination->id,
        'customer_name'      => $validated['customer_name'],
        'customer_email'     => $validated['customer_email'],
        'customer_phone'     => $validated['customer_phone'],
        'booking_date'       => $validated['booking_date'],
        'number_of_tickets'  => $validated['number_of_tickets'],
        'package_price'      => $tourPackage->price,
        'discount'           => $discount,
        'total_price'        => $totalPrice,
        'status'             => Transaction::STATUS_PENDING,
        'payment_method'     => $validated['payment_method'] ?? null, // Allow NULL instead of 'pending'
        'promo_code_id'      => $promo?->id,
    ]);

    TourBooking::create([
        'tour_package_id'    => $tourPackage->id,
        'destination_id'     => $destination->id,
        'hotel_id'           => $tourPackage->includes_hotel ? optional($tourPackage->hotels()->first())->id : null,
        'customer_name'      => $validated['customer_name'],
        'customer_email'     => $validated['customer_email'],
        'customer_phone'     => $validated['customer_phone'],
        'tour_price'         => $subtotal,
        'hotel_price'        => 0,
        'total_price'        => $totalPrice,
        'status'             => 'pending',
        'payment_method'     => $validated['payment_method'] ?? null, // Allow NULL instead of 'pending'
        'booking_number'     => $bookingCode,
    ]);
});

        return redirect()->route('transaction.payment', $bookingCode)
                         ->with('success', 'Pemesanan berhasil! Silakan lanjutkan pembayaran.');
    }

    /**
     * Mengubah hotel untuk tour package (admin).
     */
    public function updateHotel(Request $request, $id)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
        ]);

        $tourPackage = TourPackage::findOrFail($id);
        $tourPackage->hotels()->sync([$validated['hotel_id']]);

        return redirect()->route('paket-tours.show', $id)->with('success', 'Hotel updated successfully.');
    }
}