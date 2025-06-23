@extends('layouts.app')

@section('title', 'Booking Success - ' . $booking->hotel->name)

@section('content')
<section class="py-16 bg-gradient-to-br from-blue-50 to-green-50">
    <div class="container mx-auto px-4 max-w-5xl">
        <!-- Success Card -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-xl transform transition-all duration-300 hover:shadow-2xl">
            <!-- Decorative header stripe -->
            <div class="h-2 bg-gradient-to-r from-green-400 to-blue-500"></div>
            
            <div class="p-8 md:p-10">
                <!-- Animated success header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-green-100 text-green-600 mb-4 animate-bounce">
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Booking Confirmed!</h1>
                    <p class="text-lg text-gray-600">Your reservation at <span class="font-semibold text-blue-600">{{ $booking->hotel->name }}</span> is confirmed</p>
                    
                    <!-- Highlighted Booking Number -->
                    <div class="mt-4 inline-flex items-center px-4 py-2 rounded-lg bg-blue-50 border border-blue-100 shadow-sm">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="font-mono font-bold text-blue-700 tracking-wider">{{ $booking->booking_number }}</span>
                    </div>
                </div>

                <!-- Hotel card with image -->
                <div class="flex flex-col md:flex-row bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
                    <div class="md:w-1/3 mb-4 md:mb-0">
                        <img src="{{ $booking->hotel->image ? asset('storage/' . $booking->hotel->image) : asset('images/hotel-fallback.jpg') }}" 
                             alt="{{ $booking->hotel->name }}"
                             class="w-full h-64 object-cover rounded-lg transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <div class="md:w-2/3 md:pl-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $booking->hotel->name }}</h3>
                        <p class="text-gray-600 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $booking->hotel->location }}
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                {{ ucfirst($booking->room_type) }} Room
                            </span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                {{ $booking->night_count }} Nights
                            </span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <!-- Booking details -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Booking Details</h3>
                    
                    <div class="space-y-4">
                        <!-- Highlighted Booking Number in details -->
                        <div class="flex justify-between items-center bg-blue-50 px-4 py-3 rounded-lg">
                            <span class="text-gray-600 font-medium">Booking Number</span>
                            <span class="font-mono font-bold text-blue-700 tracking-wider">{{ $booking->booking_number }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Room Price (per night)</span>
                            <span>Rp{{ number_format($booking->room_price, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Room Total ({{ $booking->night_count }} nights)</span>
                            <span>Rp{{ number_format($booking->room_price * $booking->night_count, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax (10%)</span>
                            <span>Rp{{ number_format($booking->tax, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Service Fee (5%)</span>
                            <span>Rp{{ number_format($booking->service_charge, 0, ',', '.') }}</span>
                        </div>
                        
                        @if ($booking->promo_code || $booking->promo_code_id)
                            @php
                                $promo = $booking->promo_code_id ? \App\Models\CodePromotion::find($booking->promo_code_id) : null;
                                $effectiveDiscount = ($promo && $promo->discount_percent > 0)
                                    ? ($booking->room_price * $booking->night_count * $promo->discount_percent / 100)
                                    : ($booking->discount_amount ?? 0);
                                $discountDisplay = ($promo && $promo->discount_percent > 0)
                                    ? $promo->discount_percent . '% (Rp' . number_format($effectiveDiscount, 0, ',', '.') . ')'
                                    : ($booking->discount_amount > 0 ? 'Rp' . number_format($booking->discount_amount, 0, ',', '.') : 'None');
                            @endphp
                            <div class="flex justify-between text-green-600">
                                <span class="font-medium">Promo Code</span>
                                <span class="font-medium">{{ $booking->promo_code ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between text-green-600">
                                <span class="font-medium">Discount</span>
                                <span class="font-medium">{{ $discountDisplay }}</span>
                            </div>
                            @if ($effectiveDiscount != ($booking->discount_amount ?? 0))
                                <div class="text-red-600 text-sm mt-2">
                                    Warning: Discount mismatch (Expected: Rp{{ number_format($effectiveDiscount, 0, ',', '.') }}, Stored: Rp{{ number_format($booking->discount_amount ?? 0, 0, ',', '.') }}).
                                </div>
                            @endif
                        @endif
                        
                        <div class="pt-4 mt-4 border-t border-gray-200 flex justify-between text-lg font-bold">
                            <span>Total Amount</span>
                            @php
                                $calculatedTotal = ($booking->room_price * $booking->night_count) + $booking->tax + $booking->service_charge - $effectiveDiscount;
                            @endphp
                            <span class="text-blue-600">Rp{{ number_format($calculatedTotal, 0, ',', '.') }}</span>
                        </div>
                        @if (abs($calculatedTotal - $booking->total_price) > 0.01)
                            <div class="text-red-600 text-sm mt-2">
                                Note: Calculated total (Rp{{ number_format($calculatedTotal, 0, ',', '.') }}) differs from stored total (Rp{{ number_format($booking->total_price, 0, ',', '.') }}). Please contact support.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Next steps -->
                <div class="bg-blue-50 rounded-xl p-6 mb-8 border border-blue-100">
                    <h3 class="text-xl font-bold text-blue-800 mb-4">What's Next?</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 text-blue-500 mr-3 mt-1">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">Confirmation Email</h4>
                                <p class="text-gray-600 text-sm">We've sent booking details to your email address</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-6 w-6 text-blue-500 mr-3 mt-1">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">Check-in Instructions</h4>
                                <p class="text-gray-600 text-sm">Present this confirmation at the hotel reception</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('home') }}" class="flex-1 flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-1">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Back to Home
                    </a>
                    <a href="{{ route('booking.show', ['booking_number' => $booking->booking_number]) }}" class="flex-1 flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-xl shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-1">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        View My Bookings
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Confetti celebration -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Small confetti burst
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#3b82f6', '#10b981', '#ffffff']
        });
    });
</script>
@endsection