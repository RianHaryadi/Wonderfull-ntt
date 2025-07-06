@extends('layouts.app')

@section('title', 'Book Tour Package')

@section('content')
<section class="py-12 bg-gradient-to-b from-blue-50 to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-3xl shadow-xl border border-blue-100">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-between relative">
                    <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 -translate-y-1/2 z-0"></div>
                    <div class="flex items-center justify-between w-full relative z-10">
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold mb-2">
                                1
                            </div>
                            <span class="text-sm font-medium text-blue-600">Booking Details</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold mb-2">
                                2
                            </div>
                            <span class="text-sm font-medium text-gray-500">Payment</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold mb-2">
                                3
                            </div>
                            <span class="text-sm font-medium text-gray-500">Confirmation</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-800 font-serif">Book Your Adventure</h2>
                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Instant Confirmation
                </div>
            </div>

            @if(session('error'))
                <div class="mb-6 p-4 text-red-600 bg-red-50 rounded-lg border border-red-200 font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('paket-tour.store') }}" method="POST" class="space-y-8">
                @csrf

                <input type="hidden" name="tour_package_id" value="{{ $tourPackage->id }}">
                <input type="hidden" name="promo_code_id" id="promoCodeId">
                <input type="hidden" name="discount_amount" id="discountInput">

                <!-- Tour Package Card -->
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-100 transition-all duration-300 hover:shadow-md">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="md:w-1/3 relative">
                            <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-xl overflow-hidden shadow-md">
                                <img src="{{ asset('storage/' . $tourPackage->thumbnail) }}" 
                                    alt="{{ $tourPackage->name }} tour"
                                    class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                                    loading="eager"
                                    width="400"
                                    height="288">
                            </div>
                            <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                {{ $tourPackage->days }} Days
                            </div>
                        </div>
                        <div class="md:w-2/3">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2 font-serif">{{ $tourPackage->name }}</h3>
                            <div class="flex items-center text-gray-600 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $tourPackage->location }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Difficulty</p>
                                    <p class="font-medium flex items-center">
                                        @for($i = 0; $i < $tourPackage->difficulty; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Price</p>
                                    <p class="font-bold text-blue-600 text-lg" id="pricePerTicketDisplay">
                                        Rp {{ number_format($tourPackage->price, 0, ',', '.') }} <span class="text-sm font-normal">/ person</span>
                                    </p>
                                    <input type="hidden" id="pricePerTicket" value="{{ $tourPackage->price }}">
                                </div>
                            </div>
                            <p class="text-gray-600">{{ Str::limit($tourPackage->description, 150) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Your Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required
                                    class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 transition duration-200">
                            </div>
                            @error('customer_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" required
                                    class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 transition duration-200">
                            </div>
                            @error('customer_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <input type="tel" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" required
                                    class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 transition duration-200">
                            </div>
                            @error('customer_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Booking Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="destination_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Destination <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <select name="destination_id" id="destination_id" required
                                        class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 transition duration-200 appearance-none bg-white">
                                    @foreach ($destinations as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="number_of_tickets" class="block text-sm font-medium text-gray-700 mb-1">
                                Number of Tickets <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                </div>
                                <input type="number" name="number_of_tickets" id="number_of_tickets" min="1" max="10" value="1" required
                                       class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 transition duration-200">
                            </div>
                        </div>
                        <div>
                            <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Booking Date <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" name="booking_date" id="booking_date" required min="{{ date('Y-m-d') }}"
                                       class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 transition duration-200">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="special_request" class="block text-sm font-medium text-gray-700 mb-1">
                            Special Requests
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <textarea name="special_request" id="special_request" rows="3"
                                      class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 transition duration-200"
                                      placeholder="Any special requirements or notes..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Promo Code Section -->
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-100 transition-all duration-300 hover:shadow-md">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        Apply Promo Code
                    </h3>
                    <p class="text-gray-600 mb-4">Enter your promo code below to get discounts</p>
                    
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-grow relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                            </div>
                            <input type="text" id="promoInput" name="promo_code" 
                                   class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 transition duration-200" 
                                   placeholder="SUMMER2023">
                        </div>
                        <button type="button" id="applyPromoBtn" 
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Apply Code
                        </button>
                    </div>
                    
                    <div id="promoMessage" class="hidden mt-3 p-3 rounded-lg border text-sm"></div>
                    <div id="discountDisplay" class="mt-3 text-green-600 font-medium"></div>
                </div>

                <!-- Price Summary -->
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Price Summary
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Base Price</span>
                            <span id="basePriceDisplay" class="text-gray-800">Rp {{ number_format($tourPackage->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Number of Tickets</span>
                            <span id="ticketCountDisplay" class="text-gray-800">1</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span id="subtotalDisplay" class="text-gray-800">Rp {{ number_format($tourPackage->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Discount</span>
                            <span id="discountAmountDisplay" class="text-green-600">- Rp 0</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between font-bold">
                                <span class="text-gray-800">Total Payment</span>
                                <span id="totalPriceDisplay" class="text-blue-600 text-xl">Rp {{ number_format($tourPackage->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-lg font-bold rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Promo JSON -->
<div id="promoData" data-promos='@json($promoJson)'></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum booking date
        document.getElementById('booking_date').min = new Date().toISOString().split('T')[0];

        // Get elements
        const promoData = document.getElementById('promoData');
        const promoCodes = JSON.parse(promoData.dataset.promos);
        const promoInput = document.getElementById('promoInput');
        const promoCodeIdInput = document.getElementById('promoCodeId');
        const discountInput = document.getElementById('discountInput');
        const applyPromoBtn = document.getElementById('applyPromoBtn');
        const promoMessage = document.getElementById('promoMessage');
        const ticketInput = document.getElementById('number_of_tickets');
        const discountDisplay = document.getElementById('discountDisplay');
        const pricePerTicket = parseFloat(document.getElementById('pricePerTicket').value);
        const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });

        // Price summary elements
        const basePriceDisplay = document.getElementById('basePriceDisplay');
        const ticketCountDisplay = document.getElementById('ticketCountDisplay');
        const subtotalDisplay = document.getElementById('subtotalDisplay');
        const discountAmountDisplay = document.getElementById('discountAmountDisplay');
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');

        // Initialize price display
        function updatePriceSummary() {
            const ticketCount = parseInt(ticketInput.value) || 1;
            const subtotal = ticketCount * pricePerTicket;
            const discount = parseFloat(discountInput.value) || 0;
            const total = subtotal - discount;

            ticketCountDisplay.textContent = ticketCount;
            subtotalDisplay.textContent = formatter.format(subtotal);
            discountAmountDisplay.textContent = discount > 0 ? `- ${formatter.format(discount)}` : '- Rp 0';
            totalPriceDisplay.textContent = formatter.format(total);
        }

        // Clear promo code
        function clearPromo() {
            promoMessage.classList.add('hidden');
            promoMessage.textContent = '';
            promoMessage.className = 'hidden mt-3 p-3 rounded-lg border text-sm';
            discountInput.value = '0';
            promoCodeIdInput.value = '';
            discountDisplay.textContent = '';
            updatePriceSummary();
        }

        // Apply promo code
        applyPromoBtn.addEventListener('click', () => {
            const code = promoInput.value.trim().toUpperCase();
            clearPromo();

            const promo = promoCodes[code];
            const today = new Date().toISOString().split('T')[0];
            const ticketCount = parseInt(ticketInput.value) || 1;
            const subtotal = ticketCount * pricePerTicket;

            if (!promo || !promo.active) {
                showPromoMessage(`Promo code "${code}" is invalid`, 'error');
                return;
            }

            if (promo.valid_from && promo.valid_from > today) {
                showPromoMessage(`Promo ${code} is valid from ${promo.valid_from}`, 'error');
                return;
            }

            if (promo.valid_until && promo.valid_until < today) {
                showPromoMessage(`Promo ${code} expired on ${promo.valid_until}`, 'error');
                return;
            }

            let discount = 0;
            let discountType = '';

            if (promo.percent && parseFloat(promo.percent) > 0) {
                discount = subtotal * (parseFloat(promo.percent) / 100);
                discountType = `${parseFloat(promo.percent)}%`;
            } else if (promo.amount && parseFloat(promo.amount) > 0) {
                discount = parseFloat(promo.amount);
                discountType = formatter.format(discount);
            }

            if (discount <= 0) {
                showPromoMessage(`Promo ${code} has no valid discount`, 'error');
                return;
            }

            promoCodeIdInput.value = promo.id;
            discountInput.value = discount.toFixed(2);
            showPromoMessage(`Promo ${code} applied! You saved ${discountType} (${formatter.format(discount)})`, 'success');
            discountDisplay.textContent = `Discount applied: ${formatter.format(discount)}`;
            updatePriceSummary();
        });

        // Show promo message
        function showPromoMessage(message, type) {
            promoMessage.textContent = message;
            promoMessage.className = 'mt-3 p-3 rounded-lg border text-sm';
            
            if (type === 'success') {
                promoMessage.classList.add('text-green-600', 'border-green-200', 'bg-green-50');
            } else {
                promoMessage.classList.add('text-red-600', 'border-red-200', 'bg-red-50');
            }
            
            promoMessage.classList.remove('hidden');
        }

        // Ticket input change handler
        ticketInput.addEventListener('change', function() {
            clearPromo();
            updatePriceSummary();
        });

        // Initialize price summary
        updatePriceSummary();
    });
</script>
@endsection