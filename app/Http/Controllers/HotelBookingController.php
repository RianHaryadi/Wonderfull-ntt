<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\BookingHotel;
use App\Models\CodePromotion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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
        $promos = CodePromotion::active()
            ->where(function ($query) {
                $query->whereNull('valid_from')
                      ->orWhere('valid_from', '<=', Carbon::now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_until')
                      ->orWhere('valid_until', '>=', Carbon::now());
            })
            ->get();

        Log::info('Create booking page accessed', [
            'hotel_id' => $hotelId,
            'hotel_name' => $hotel->name,
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
                'promo_code_id' => 'nullable|exists:promotions,id',
                'promo_code' => 'nullable|string|max:255',
                'status' => 'required|in:pending,confirmed,canceled',
                'special_requests' => 'nullable|string|max:1000',
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
                    'room_type' => $validated['room_type'],
                ]);
                return back()->withErrors(['room_price' => 'The selected room price is invalid.'])->withInput();
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
                return back()->withErrors(['night_count' => 'The number of nights is invalid.'])->withInput();
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

                $promo = CodePromotion::find($promoCodeId);
                if (!$promo || !$promo->isValid() || strtoupper($promo->code) !== strtoupper($promoCode)) {
                    Log::warning('Invalid promo usage', [
                        'promo_code' => $promoCode,
                        'promo_code_id' => $promoCodeId,
                        'promo_exists' => !!$promo,
                        'is_valid' => $promo ? $promo->isValid() : false,
                        'code_match' => $promo ? strtoupper($promo->code) === strtoupper($promoCode) : false,
                    ]);
                    return back()->withErrors(['promo_code' => $promo ? 'The promo code is invalid or expired.' : 'The promo code does not exist.'])->withInput();
                }

                // Calculate server-side discount (bypassing destination check)
                $serverDiscount = $promo->discount_percent
                    ? ($basePrice * $promo->discount_percent / 100)
                    : ($promo->discount_amount ?? 0);

                if (abs($serverDiscount - $discount) > 0.01) {
                    Log::warning('Discount mismatch, using server value', [
                        'client_discount' => $discount,
                        'server_discount' => $serverDiscount,
                        'promo_code' => $promoCode,
                    ]);
                    $discount = $serverDiscount;
                }

                if ($discount <= 0 && ($promo->discount_amount > 0 || $promo->discount_percent > 0)) {
                    Log::warning('Invalid discount for valid promo', [
                        'promo_code' => $promoCode,
                        'promo_id' => $promoCodeId,
                        'client_discount' => $discount,
                        'server_discount' => $serverDiscount,
                    ]);
                    return back()->withErrors(['promo_code' => 'The promo code does not provide a valid discount.'])->withInput();
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
                return back()->withErrors(['tax' => 'The tax or service charge is invalid.'])->withInput();
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
                $validated['total_price'] = $expectedTotal;
            }

            // Log booking data before creation
            $bookingData = [
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
                'special_requests' => $validated['special_requests'] ?? null,
                'status' => 'pending',
                'booking_number' => 'BOOK-' . now()->format('YmdHis') . '-' . str_pad(random_int(1, 999), 3, '0', STR_PAD_LEFT),
            ];
            Log::debug('Booking data before creation', ['booking_data' => $bookingData]);

            // Create booking
            $booking = BookingHotel::create($bookingData);

            Log::info('Booking successfully created', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'promo_code' => $promoCode,
                'discount' => $discount,
                'total_price' => $validated['total_price'],
                'user_id' => 'guest',
                'redirecting_to' => route('booking.success', $booking->id),
            ]);

            return redirect()->route('booking.success', $booking->id)
                           ->with('success', 'Booking successfully created! Please review your booking details.');
        } catch (ValidationException $e) {
            Log::error('Booking validation error', [
                'errors' => $e->errors(),
                'input' => $request->except(['_token']),
                'user_id' => 'guest',
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Booking creation failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'stack_trace' => $e->getTraceAsString(),
                'input' => $request->except(['_token']),
                'booking_data' => isset($bookingData) ? $bookingData : null,
                'user_id' => 'guest',
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
                'user_id' => 'guest',
            ]);
            return view('booking.success', compact('booking'));
        } catch (\Exception $e) {
            Log::error('Error accessing success page', [
                'message' => $e->getMessage(),
                'booking_id' => $id,
                'user_id' => 'guest',
            ]);
            return redirect()->route('home')->with('error', 'Booking not found.');
        }
    }
}