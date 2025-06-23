<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\BookingHotel;
use App\Models\CodePromotion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class HotelBookingController extends Controller
{
    /**
     * Show the booking creation page for a specific hotel.
     *
     * @param int $hotelId
     * @return \Illuminate\View\View
     */
    public function create($hotelId)
    {
        Log::debug('Entering create method', ['hotel_id' => $hotelId]);
        $hotel = Hotel::findOrFail($hotelId);

        $promos = collect([]);
        if (Schema::hasTable('promotions')) {
            $promos = CodePromotion::where('active', true)
                ->where(function ($query) {
                    $query->whereNull('valid_from')
                          ->orWhere('valid_from', '<=', Carbon::now());
                })
                ->where(function ($query) {
                    $query->whereNull('valid_until')
                          ->orWhere('valid_until', '>=', Carbon::now());
                })
                ->get();
        } else {
            Log::warning('promotions table does not exist, no promos loaded');
        }

        Log::info('Create booking page accessed', [
            'hotel_id' => $hotelId,
            'promo_count' => $promos->count(),
            'promo_codes' => $promos->pluck('code')->toArray(),
        ]);

        return view('booking.create', compact('hotel', 'promos'));
    }

    /**
     * Store a new hotel booking and redirect to success page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Log::debug('Entering store method', ['input' => $request->except(['_token'])]);

        try {
            // Validate request data
            $validated = $request->validate([
                'hotel_id' => 'required|exists:hotels,id',
                'room_type' => 'required|in:single,double,family',
                'check_in_date' => 'required|date|after_or_equal:today',
                'check_out_date' => 'required|date|after:check_in_date',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
                'payment_method' => 'required|in:transfer,qris,cash',
                'agree_terms' => 'required|accepted',
                'room_price' => 'required|numeric|min:0',
                'night_count' => 'required|integer|min:1',
                'tax' => 'required|numeric|min:0',
                'service_charge' => 'required|numeric|min:0',
                'total_price' => 'required|numeric|min:0',
                'discount_amount' => 'required|numeric|min:0',
                'promo_code_id' => 'nullable|integer',
                'promo_code' => 'nullable|string|max:255',
                'status' => 'required|in:pending,confirmed,canceled',
            ]);

            Log::debug('Validation passed', ['validated' => $validated]);

            // Fetch hotel and verify room price
            $hotel = Hotel::findOrFail($validated['hotel_id']);
            $priceKey = $validated['room_type'] . '_room_price';
            $roomPrice = $hotel->$priceKey ?? 0;

            if (abs($roomPrice - $validated['room_price']) > 0.01) {
                Log::warning('Room price mismatch', [
                    'client_price' => $validated['room_price'],
                    'server_price' => $roomPrice,
                ]);
                return back()->withErrors(['room_price' => 'Invalid room price.'])->withInput();
            }

            // Calculate nights and base costs
            $checkIn = Carbon::parse($validated['check_in_date']);
            $checkOut = Carbon::parse($validated['check_out_date']);
            $nights = $checkIn->diffInDays($checkOut);
            $basePrice = $roomPrice * $nights;
            $tax = $basePrice * 0.10;
            $service = $basePrice * 0.05;
            $baseTotal = $basePrice + $tax + $service;

            // Verify night count
            if ($nights != $validated['night_count']) {
                Log::warning('Night count mismatch', [
                    'client_nights' => $validated['night_count'],
                    'server_nights' => $nights,
                ]);
                return back()->withErrors(['night_count' => 'Invalid night count.'])->withInput();
            }

            // Handle promo code
            $discount = (float) ($validated['discount_amount'] ?? 0);
            $promoCode = $validated['promo_code'] ?? null;
            $promoCodeId = $validated['promo_code_id'] ?? null;

            if ($promoCode || $promoCodeId) {
                if (!$promoCode || !$promoCodeId) {
                    Log::warning('Incomplete promo data', [
                        'promo_code' => $promoCode,
                        'promo_code_id' => $promoCodeId,
                    ]);
                    return back()->withErrors(['promo_code' => 'Both promo code and ID must be provided.'])->withInput();
                }

                if (!Schema::hasTable('promotions')) {
                    Log::warning('promotions table does not exist, ignoring promo', [
                        'promo_code' => $promoCode,
                        'promo_code_id' => $promoCodeId,
                    ]);
                    return back()->withErrors(['promo_code' => 'Promo codes are not supported at this time.'])->withInput();
                }

                $promo = CodePromotion::find($promoCodeId);
                if (!$promo) {
                    Log::warning('Promo not found', [
                        'promo_code_id' => $promoCodeId,
                    ]);
                    return back()->withErrors(['promo_code_id' => 'Promo code not found.'])->withInput();
                }

                if (!$promo->active || strtoupper($promo->code) !== strtoupper($promoCode) ||
                    ($promo->valid_from && $promo->valid_from > now()) ||
                    ($promo->valid_until && $promo->valid_until < now())) {
                    Log::warning('Invalid promo usage', [
                        'promo_code' => $promoCode,
                        'promo_code_id' => $promoCodeId,
                        'promo_active' => $promo->active,
                        'code_match' => strtoupper($promo->code) === strtoupper($promoCode),
                        'valid_from' => $promo->valid_from,
                        'valid_until' => $promo->valid_until,
                    ]);
                    return back()->withErrors(['promo_code_id' => 'Invalid or expired promo code.'])->withInput();
                }

                // Calculate server-side discount
                $serverDiscount = $promo->discount_percent
                    ? ($basePrice * $promo->discount_percent / 100)
                    : ($promo->discount_amount ?? 0);

                // Log client discount for debugging
                $clientDiscount = $discount;
                if (abs($serverDiscount - $clientDiscount) > 0.01) {
                    Log::warning('Discount mismatch, using server value', [
                        'client_discount' => $clientDiscount,
                        'server_discount' => $serverDiscount,
                    ]);
                    $discount = $serverDiscount; // Use server value
                }

                if ($discount <= 0 && ($promo->discount_amount > 0 || $promo->discount_percent > 0)) {
                    Log::warning('Invalid discount for valid promo', [
                        'promo_code' => $promoCode,
                        'promo_id' => $promoCodeId,
                        'client_discount' => $clientDiscount,
                        'server_discount' => $serverDiscount,
                    ]);
                    return back()->withErrors(['discount_amount' => 'Invalid discount amount for the promo code.'])->withInput();
                }
            }

            // Verify tax and service charge
            if (abs($tax - $validated['tax']) > 0.01 || abs($service - $validated['service_charge']) > 0.01) {
                Log::warning('Tax or service charge mismatch', [
                    'client_tax' => $validated['tax'],
                    'client_service' => $validated['service_charge'],
                    'server_tax' => $tax,
                    'server_service' => $service,
                ]);
                return back()->withErrors(['tax' => 'Invalid tax or service charge.'])->withInput();
            }

            // Verify total price
            $expectedTotal = max($baseTotal - $discount, 0);
            if (abs($expectedTotal - $validated['total_price']) > 0.01) {
                Log::warning('Total price mismatch, using server value', [
                    'client_total' => $validated['total_price'],
                    'calculated_total' => $expectedTotal,
                    'base_total' => $baseTotal,
                    'discount' => $discount,
                ]);
                $validated['total_price'] = $expectedTotal; // Use server-calculated total
            }

            // Create booking
            $booking = BookingHotel::create([
                'hotel_id' => $hotel->id,
                'room_type' => $validated['room_type'],
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'night_count' => $nights,
                'room_price' => round($roomPrice, 2),
                'tax' => round($tax, 2),
                'service_charge' => round($service, 2),
                'discount_amount' => round($discount, 2),
                'promo_code_id' => $promoCodeId,
                'promo_code' => $promoCode,
                'total_price' => round($validated['total_price'], 2),
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'booking_number' => 'BOOK-' . now()->format('Ymd') . '-' . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT),
            ]);

            Log::info('Booking successfully created', [
                'booking_id' => $booking->id,
                'promo_code' => $promoCode,
                'discount' => $discount,
                'total_price' => $validated['total_price'],
                'redirecting_to' => route('booking.success', $booking->id),
            ]);

            return redirect()->route('booking.success', $booking->id)
                            ->with('success', 'Booking successfully created! Please review your booking details.');
        } catch (ValidationException $e) {
            Log::error('Booking validation error', [
                'errors' => $e->errors(),
                'input' => $request->except(['_token']),
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Booking creation failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['_token']),
            ]);
            return redirect()->back()->with('error', 'An error occurred while creating the booking: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the booking success page.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function success($id)
    {
        Log::debug('Entering success method', ['booking_id' => $id]);
        try {
            $booking = BookingHotel::with('hotel')->findOrFail($id);
            Log::info('Accessed booking success page', [
                'booking_id' => $id,
                'booking_number' => $booking->booking_number,
                'promo_code' => $booking->promo_code,
                'discount_amount' => $booking->discount_amount,
            ]);
            return view('booking.success', compact('booking'));
        } catch (\Exception $e) {
            Log::error('Error accessing success page', [
                'message' => $e->getMessage(),
                'booking_id' => $id,
            ]);
            return redirect()->route('home')->with('error', 'Booking not found.');
        }
    }
}