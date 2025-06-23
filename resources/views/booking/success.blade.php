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

                <!-- Booking timeline -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Your Booking Timeline</h3>
                    <div class="relative">
                        <!-- Timeline line -->
                        <div class="absolute left-4 top-0 h-full w-0.5 bg-blue-200"></div>
                        
                        <div class="space-y-6">
                            <!-- Current step - Check-in -->
                            <div class="relative flex items-start">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center z-10">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-800">Booking Confirmed</h4>
                                    <p class="text-gray-600 text-sm">Today, {{ now()->format('g:i A') }}</p>
                                </div>
                            </div>
                            
                            <!-- Future steps -->
                            <div class="relative flex items-start">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-white border-2 border-blue-300 flex items-center justify-center z-10">
                                    <span class="h-2 w-2 bg-blue-300 rounded-full"></span>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-700">Check-in</h4>
                                    <p class="text-gray-500 text-sm">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('l, F j, Y') }} at 2:00 PM
                                    </p>
                                </div>
                            </div>
                            
                            <div class="relative flex items-start">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-white border-2 border-blue-300 flex items-center justify-center z-10">
                                    <span class="h-2 w-2 bg-blue-300 rounded-full"></span>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-700">Check-out</h4>
                                    <p class="text-gray-500 text-sm">
                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('l, F j, Y') }} at 12:00 PM
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hotel card with image -->
                <div class="flex flex-col md:flex-row bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200 hover:border-blue-200 transition-colors duration-200">
                    <div class="md:w-1/3 mb-4 md:mb-0">
                        <img src="{{ $booking->hotel->image ? asset('storage/' . $booking->hotel->image) : asset('images/hotel-fallback.jpg') }}" 
                             alt="{{ $booking->hotel->name }}"
                             class="w-full h-64 object-cover rounded-lg transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <div class="md:w-2/3 md:pl-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $booking->hotel->name }}</h3>
                        <div class="flex items-center text-gray-600 mb-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $booking->hotel->location }}
                        </div>
                        
                        <!-- Rating -->
                        <div class="flex items-center mb-3">
                            <div class="flex items-center">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 {{ $i < $booking->hotel->stars ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-500">{{ $booking->hotel->stars }} stars</span>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                {{ ucfirst($booking->room_type) }} Room
                            </span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                {{ $booking->night_count }} Nights
                            </span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                {{ ucfirst($booking->payment_method) }} Payment
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

                <!-- Two-column layout for details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Booking details -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Booking Summary</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Booking Number</span>
                                <span class="font-medium text-blue-700">{{ $booking->booking_number }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Booking Date</span>
                                <span>{{ $booking->created_at->format('d M Y, g:i A') }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                <span class="px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                       ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Method</span>
                                <span class="font-medium">{{ ucfirst($booking->payment_method) }}</span>
                            </div>
                            
                            @if ($booking->promo_code)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Promo Code</span>
                                <span class="font-medium text-green-600">{{ $booking->promo_code }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Guest details -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Guest Information</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Name</span>
                                <span class="font-medium">{{ $booking->customer_name }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email</span>
                                <span class="font-medium">{{ $booking->customer_email }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phone</span>
                                <span class="font-medium">{{ $booking->customer_phone }}</span>
                            </div>
                            
                            @if ($booking->special_requests)
                            <div class="pt-4 mt-4 border-t border-gray-200">
                                <h4 class="text-sm font-medium text-gray-600 mb-1">Special Requests</h4>
                                <p class="text-gray-800">{{ $booking->special_requests }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Price breakdown -->
                <div class="bg-white rounded-xl p-6 mb-8 border border-gray-200 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Price Breakdown</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Room Price ({{ $booking->night_count }} nights)</span>
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
                            @endphp
                            <div class="flex justify-between text-green-600">
                                <span class="font-medium">Discount Applied</span>
                                <span class="font-medium">-Rp{{ number_format($effectiveDiscount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        
                        <div class="pt-4 mt-4 border-t border-gray-200 flex justify-between text-lg font-bold">
                            <span>Total Amount</span>
                            <span class="text-blue-600">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Next steps and important info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Next steps -->
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                        <h3 class="text-xl font-bold text-blue-800 mb-4">What's Next?</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 text-blue-500 mr-3 mt-1">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.827 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Confirmation Email</h4>
                                    <p class="text-gray-600 text-sm">We've sent booking details to <span class="font-medium">{{ $booking->customer_email }}</span></p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 text-blue-500 mr-3 mt-1">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Download Invoice</h4>
                                    <p class="text-gray-600 text-sm">Available in your booking management</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Important information -->
                    <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-100">
                        <h3 class="text-xl font-bold text-yellow-800 mb-4">Important Information</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 text-yellow-500 mr-3 mt-1">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Cancellation Policy</h4>
                                    <p class="text-gray-600 text-sm">Free cancellation until {{ \Carbon\Carbon::parse($booking->check_in_date)->subDays(2)->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 text-yellow-500 mr-3 mt-1">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Check-in Instructions</h4>
                                    <p class="text-gray-600 text-sm">Present ID and this confirmation at reception</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hotel contact information -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Hotel Contact</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium">+62 123 4567 8910</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">wonderfullntt@gmail.com</p>
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
                        View My Booking
                    </a>
                    <button onclick="window.print()" class="flex-1 flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-xl shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-1">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Confirmation
                    </button>
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
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#3b82f6', '#10b981', '#ffffff', '#f59e0b'],
            decay: 0.9
        });
        
        // Additional bursts for celebration
        setTimeout(() => {
            confetti({
                particleCount: 100,
                angle: 60,
                spread: 55,
                origin: { x: 0 }
            });
            
            confetti({
                particleCount: 100,
                angle: 120,
                spread: 55,
                origin: { x: 1 }
            });
        }, 300);
    });
</script>

<!-- Print styles -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .container, .container * {
        visibility: visible;
    }
    .container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
    .bg-gradient-to-br, .bg-gradient-to-r {
        background: white !important;
    }
}
</style>
@endsection

<!-- PERLU DI FIX -->