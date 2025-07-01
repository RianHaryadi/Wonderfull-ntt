@extends('layouts.app')

@section('title', 'Booking Hotel - ' . $hotel->name)

@section('content')
<section class="py-8 md:py-12 bg-gradient-to-b from-blue-50 to-white">
    <div class="container mx-auto px-4 max-w-6xl space-y-8">
        {{-- Hotel Overview --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <div class="md:flex">
                <div class="md:w-1/2 relative">
                    <img src="{{ $hotel->image ? asset('storage/' . $hotel->image) : asset('images/hotel-fallback.jpg') }}"
                         alt="{{ $hotel->name }}"
                         class="w-full h-80 md:h-full object-cover rounded-t-lg md:rounded-l-lg md:rounded-tr-none transition-transform duration-500 hover:scale-105">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                        <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $hotel->name }}</h1>
                        <div class="flex items-center mt-2 text-white/90">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>{{ $hotel->location }}</span>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 p-6 md:p-8 flex flex-col">
                    <div class="flex-grow">
                        <div class="flex items-center mb-4">
                            <div class="flex items-center text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star {{ $i < $hotel->stars ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-500">{{ $hotel->stars }} stars</span>
                        </div>
                        
                        <p class="text-gray-600 leading-relaxed">{{ $hotel->description }}</p>
                        
                        <div class="mt-6">
                            <h3 class="font-semibold text-gray-700 mb-3">Facilities:</h3>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $facilities = is_array($hotel->facilities)
                                        ? $hotel->facilities
                                        : ($hotel->facilities ? explode(',', $hotel->facilities) : []);
                                @endphp
                                @forelse($facilities as $facility)
                                    @php $f = strtolower(trim($facility)); @endphp
                                    <div class="flex items-center gap-1 px-3 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-100 text-sm">
                                        @if(str_contains($f, 'wifi')) <i class="fas fa-wifi text-sm"></i>
                                        @elseif(str_contains($f, 'pool')) <i class="fas fa-swimming-pool text-sm"></i>
                                        @elseif(str_contains($f, 'restaurant')) <i class="fas fa-utensils text-sm"></i>
                                        @elseif(str_contains($f, 'parking')) <i class="fas fa-parking text-sm"></i>
                                        @elseif(str_contains($f, 'ac')) <i class="fas fa-wind text-sm"></i>
                                        @elseif(str_contains($f, 'spa')) <i class="fas fa-spa text-sm"></i>
                                        @elseif(str_contains($f, 'bar')) <i class="fas fa-glass-martini-alt text-sm"></i>
                                        @else <i class="fas fa-check-circle text-gray-400 text-sm"></i>
                                        @endif
                                        <span>{{ ucwords(trim($facility)) }}</span>
                                    </div>
                                @empty
                                    <span class="text-gray-500 text-sm">No facilities available</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Booking Form --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="md:flex">
                {{-- Booking Steps --}}
                <div class="md:w-1/3 bg-blue-600 text-white p-6 md:p-8">
                    <h2 class="text-2xl font-bold mb-6">Booking Steps</h2>
                    <ol id="bookingSteps" class="space-y-6">
                        <li class="flex items-start space-x-4">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                <span class="font-semibold">1</span>
                            </div>
                            <div>
                                <h3 class="font-semibold">Room Selection</h3>
                                <p class="text-blue-100 text-sm mt-1">Choose your preferred room type</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-4 opacity-70">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-700 flex items-center justify-center">
                                <span class="font-semibold">2</span>
                            </div>
                            <div>
                                <h3 class="font-semibold">Dates & Promo Code</h3>
                                <p class="text-blue-100 text-sm mt-1">Select dates and apply promo code</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-4 opacity-70">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-700 flex items-center justify-center">
                                <span class="font-semibold">3</span>
                            </div>
                            <div>
                                <h3 class="font-semibold">Guest Details</h3>
                                <p class="text-blue-100 text-sm mt-1">Enter guest information</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-4 opacity-70">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-700 flex items-center justify-center">
                                <span class="font-semibold">4</span>
                            </div>
                            <div>
                                <h3 class="font-semibold">Confirmation</h3>
                                <p class="text-blue-100 text-sm mt-1">Review and complete booking</p>
                            </div>
                        </li>
                    </ol>
                    <div class="mt-8 pt-6 border-t border-blue-500">
                        <h3 class="font-semibold mb-2">Need Help?</h3>
                        <p class="text-blue-100 text-sm mb-3">Our customer service is available 24/7</p>
                        <a href="tel:+1234567890" class="flex items-center text-blue-100 hover:text-white">
                            <i class="fas fa-phone-alt mr-2"></i> +1 (234) 567-890
                        </a>
                        <a href="mailto:help@example.com" class="flex items-center text-blue-100 hover:text-white mt-2">
                            <i class="fas fa-envelope mr-2"></i> help@example.com
                        </a>
                    </div>
                </div>

                {{-- Form Content --}}
                <div class="md:w-2/3 p-6 md:p-8">
                    <form id="bookingForm" method="POST" action="{{ route('booking.hotel.store') }}">
                        @csrf

                        {{-- Hidden Inputs --}}
                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                        <input type="hidden" id="selectedRoomPrice" name="room_price" value="{{ $hotel->single_room_price ?? 0 }}">
                        <input type="hidden" id="discountAmount" name="discount_amount" value="0">
                        <input type="hidden" id="promoCodeId" name="promo_code_id" value="">
                        <input type="hidden" id="nightCount" name="night_count" value="1">
                        <input type="hidden" id="totalPrice" name="total_price" value="0">
                        <input type="hidden" id="tax" name="tax" value="0">
                        <input type="hidden" id="serviceCharge" name="service_charge" value="0">
                        <input type="hidden" name="status" value="pending">

                        {{-- Pass room prices to JavaScript --}}
                        <div id="roomPrices" 
                             data-single="{{ $hotel->single_room_price ?? 0 }}"
                             data-double="{{ $hotel->double_room_price ?? 0 }}"
                             data-family="{{ $hotel->family_room_price ?? 0 }}"
                             class="hidden"></div>

                        {{-- Display general form errors --}}
                        @if ($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Room Selection --}}
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-bed text-blue-500 mr-3"></i> Choose Your Room
                            </h2>
                            <p class="text-gray-500 mb-4">Select the room type that fits your needs</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @php
                                    $rooms = [
                                        ['type' => 'single', 'name' => 'Single', 'price' => $hotel->single_room_price ?? 0, 'icon' => 'fas fa-user', 'desc' => 'Perfect for solo travelers'],
                                        ['type' => 'double', 'name' => 'Double', 'price' => $hotel->double_room_price ?? 0, 'icon' => 'fas fa-users', 'desc' => 'Ideal for couples'],
                                        ['type' => 'family', 'name' => 'Family', 'price' => $hotel->family_room_price ?? 0, 'icon' => 'fas fa-home', 'desc' => 'Great for families'],
                                    ];
                                @endphp
                                @foreach($rooms as $room)
                                    <label class="room-option border rounded-xl p-4 cursor-pointer transition-all duration-200 hover:border-blue-300 hover:shadow-md {{ old('room_type') == $room['type'] ? 'selected border-blue-500 bg-blue-50' : 'border-gray-200' }}"
                                           data-type="{{ $room['type'] }}"
                                           data-price="{{ $room['price'] }}">
                                        <div class="flex flex-col h-full">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex items-center space-x-3">
                                                    <div class="bg-blue-100 p-2 rounded-lg">
                                                        <i class="{{ $room['icon'] }} text-blue-600"></i>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-semibold">{{ $room['name'] }} Room</h3>
                                                        <p class="text-sm text-gray-500">{{ $room['desc'] }}</p>
                                                    </div>
                                                </div>
                                                <div class="icon-check {{ old('room_type') == $room['type'] ? 'text-blue-600' : 'text-blue-300' }}">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                            </div>
                                            <div class="mt-auto pt-3 border-t border-gray-100">
                                                <p class="text-lg font-bold text-blue-600">Rp{{ number_format($room['price'], 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/night</span></p>
                                            </div>
                                        </div>
                                        <input type="radio" name="room_type" value="{{ $room['type'] }}" class="hidden" {{ old('room_type') == $room['type'] ? 'checked' : '' }} required>
                                    </label>
                                @endforeach
                            </div>
                            @error('room_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dates --}}
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-calendar-alt text-blue-500 mr-3"></i> Select Dates
                            </h2>
                            <p class="text-gray-500 mb-4">Choose your check-in and check-out dates</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Check-in Date</label>
                                    <div class="relative">
                                        <input type="date" id="checkIn" name="check_in_date" value="{{ old('check_in_date') }}" 
                                               class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-blue-500 focus:border-blue-500" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar-day text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('check_in_date') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Check-out Date</label>
                                    <div class="relative">
                                        <input type="date" id="checkOut" name="check_out_date" value="{{ old('check_out_date') }}" 
                                               class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-blue-500 focus:border-blue-500" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar-day text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('check_out_date') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Promo Code --}}
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-tag text-blue-500 mr-3"></i> Promo Code
                            </h2>
                            <p class="text-gray-500 mb-4">Have a discount code? Enter it here</p>
                            
                            <div class="flex flex-col sm:flex-row gap-3">
                                <div class="flex-grow relative">
                                    <input type="text" id="promoCode" name="promo_code" value="{{ old('promo_code') }}" 
                                           class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-blue-500 focus:border-blue-500" 
                                           placeholder="e.g. SUMMER2023">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-ticket-alt text-gray-400"></i>
                                    </div>
                                </div>
                                <button type="button" id="applyPromo" 
                                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium whitespace-nowrap">
                                    Apply Code
                                </button>
                            </div>
                            <div id="promoMessage" class="hidden mt-2 text-sm p-3 rounded-lg"></div>
                            @error('promo_code') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Guest Information --}}
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user-circle text-blue-500 mr-3"></i> Guest Information
                            </h2>
                            <p class="text-gray-500 mb-4">Enter your details for the reservation</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <div class="relative">
                                        <input type="text" id="customerName" name="customer_name" value="{{ old('customer_name') }}" 
                                               class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-blue-500 focus:border-blue-500" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('customer_name') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <div class="relative">
                                        <input type="email" id="customerEmail" name="customer_email" value="{{ old('customer_email') }}" 
                                               class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-blue-500 focus:border-blue-500" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('customer_email') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <div class="relative">
                                        <input type="tel" id="customerPhone" name="customer_phone" value="{{ old('customer_phone') }}" 
                                               class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-blue-500 focus:border-blue-500" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-phone text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('customer_phone') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Special Requests</label>
                                    <div class="relative">
                                        <input type="text" name="special_requests" value="{{ old('special_requests') }}" 
                                               class="w-full border border-gray-300 rounded-lg p-3 pl-10 focus:ring-blue-500 focus:border-blue-500" 
                                               placeholder="Optional">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-comment-dots text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-credit-card text-blue-500 mr-3"></i> Payment Method
                            </h2>
                            <p class="text-gray-500 mb-4">Choose how you'd like to pay</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="payment-method border rounded-lg p-4 cursor-pointer hover:border-blue-300 transition-colors duration-200 {{ old('payment_method') == 'transfer' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                    <div class="flex items-center space-x-3">
                                        <input type="radio" name="payment_method" value="transfer" {{ old('payment_method') == 'transfer' ? 'checked' : '' }} class="h-5 w-5 text-blue-600 focus:ring-blue-500">
                                        <div>
                                            <h3 class="font-medium">Bank Transfer</h3>
                                            <p class="text-sm text-gray-500">Pay via bank transfer</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex space-x-2">
                                        <div class="p-1 bg-white rounded shadow-xs">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/1/16/Former_Visa_%28company%29_logo.svg" class="h-6" alt="Visa">
                                        </div>
                                        <div class="p-1 bg-white rounded shadow-xs">
                                            <img src="https://pngimg.com/d/mastercard_PNG16.png" class="h-6" alt="Mastercard">
                                        </div>
                                    </div>
                                </label>
                                <label class="payment-method border rounded-lg p-4 cursor-pointer hover:border-blue-300 transition-colors duration-200 {{ old('payment_method') == 'qris' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                    <div class="flex items-center space-x-3">
                                        <input type="radio" name="payment_method" value="qris" {{ old('payment_method') == 'qris' ? 'checked' : '' }} class="h-5 w-5 text-blue-600 focus:ring-blue-500">
                                        <div>
                                            <h3 class="font-medium">QRIS</h3>
                                            <p class="text-sm text-gray-500">Scan QR code to pay</p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="p-1 bg-white rounded shadow-xs inline-block">
                                            <img src="https://images.seeklogo.com/logo-png/39/2/quick-response-code-indonesia-standard-qris-logo-png_seeklogo-391791.png" class="h-6" alt="QRIS">
                                        </div>
                                    </div>
                                </label>
                                <label class="payment-method border rounded-lg p-4 cursor-pointer hover:border-blue-300 transition-colors duration-200 {{ old('payment_method') == 'cash' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                    <div class="flex items-center space-x-3">
                                        <input type="radio" name="payment_method" value="cash" {{ old('payment_method') == 'cash' ? 'checked' : '' }} class="h-5 w-5 text-blue-600 focus:ring-blue-500">
                                        <div>
                                            <h3 class="font-medium">Pay on Arrival</h3>
                                            <p class="text-sm text-gray-500">Pay when you check in</p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="p-1 bg-white rounded shadow-xs inline-block">
                                            <i class="fas fa-money-bill-wave text-green-500 text-xl"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>

                        {{-- Price Summary --}}
                        <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-receipt text-blue-500 mr-3"></i> Price Summary
                            </h2>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <div>
                                        <span class="text-gray-600">Room (× <span id="nightsDisplay">1</span> nights)</span>
                                        <p class="text-xs text-gray-400">Base price</p>
                                    </div>
                                    <span id="summaryRoom" class="font-medium">Rp0</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <div>
                                        <span class="text-gray-600">Tax (10%)</span>
                                        <p class="text-xs text-gray-400">Government tax</p>
                                    </div>
                                    <span id="summaryTax" class="font-medium">Rp0</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <div>
                                        <span class="text-gray-600">Service Fee (5%)</span>
                                        <p class="text-xs text-gray-400">Hotel service charge</p>
                                    </div>
                                    <span id="summaryFee" class="font-medium">Rp0</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <div>
                                        <span class="text-gray-600">Discount</span>
                                        <p class="text-xs text-gray-400">Promo savings</p>
                                    </div>
                                    <span id="summaryDiscount" class="font-medium text-green-600">-Rp0</span>
                                </div>
                                <div class="flex justify-between pt-3">
                                    <div>
                                        <span class="font-semibold text-gray-700">Total</span>
                                        <p class="text-xs text-gray-400">Amount to be paid</p>
                                    </div>
                                    <span id="summaryTotal" class="text-xl font-bold text-blue-600">Rp0</span>
                                </div>
                            </div>
                        </div>

                        {{-- Terms & Submit --}}
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <label class="flex items-start space-x-3">
                                <input type="checkbox" name="agree_terms" {{ old('agree_terms') ? 'checked' : '' }} required 
                                       class="mt-1 h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                                <span class="text-gray-600 text-sm">
                                    I agree to the <a href="#" class="text-blue-600 hover:underline">terms & conditions</a> and <a href="#" class="text-blue-600 hover:underline">privacy policy</a>. I understand that my booking is subject to cancellation policies.
                                </span>
                            </label>
                            <button type="submit" 
                                    class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                <i class="fas fa-lock mr-2"></i> Complete Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hidden promo data -->
<div id="promoData" data-promos="{{ json_encode($promos->mapWithKeys(function ($promo) {
    return [strtoupper($promo->code) => [
        'id' => $promo->id,
        'amount' => $promo->discount_amount ?? null,
        'percent' => $promo->discount_percent ?? null,
        'valid_from' => $promo->valid_from ? $promo->valid_from->toDateString() : null,
        'valid_until' => $promo->valid_until ? $promo->valid_until->toDateString() : null,
        'active' => $promo->active,
    ]];
})->toArray()) }}"></div>

<!-- CSRF Token for AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
/* Room Options */
.room-option {
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid #e5e7eb;
    position: relative;
}
.room-option:hover {
    border-color: #93c5fd;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.room-option.selected {
    border-color: #3b82f6;
    background-color: rgba(59, 130, 246, 0.05);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    transform: translateY(-2px);
}
.room-option.selected:hover {
    border-color: #2563eb;
}

/* Icon Check */
.icon-check {
    transition: all 0.3s ease;
    opacity: 0;
}
.room-option.selected .icon-check {
    opacity: 1;
    color: #3b82f6;
}

/* Price Summary */
.price-summary-container {
    transition: all 0.3s ease;
    max-height: 0;
    opacity: 0;
    overflow: hidden;
}
.price-summary-container.visible {
    max-height: 500px;
    opacity: 1;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

/* Steps */
#bookingSteps li {
    transition: all 0.3s ease;
}
#bookingSteps li:not(.active-step) {
    opacity: 0.7;
}
#bookingSteps li div {
    transition: all 0.3s ease;
}

/* Form Elements */
input[type="date"]:disabled,
input[type="text"]:disabled {
    background-color: #f3f4f6;
    cursor: not-allowed;
}

/* Promo Message */
#promoMessage {
    transition: all 0.3s ease;
}
#promoMessage.hidden {
    opacity: 0;
    height: 0;
    padding: 0;
    margin: 0;
    overflow: hidden;
}

/* Payment Methods */
.payment-method {
    transition: all 0.3s ease;
    border: 2px solid #e5e7eb;
}
.payment-method:hover {
    border-color: #93c5fd;
}
.payment-method input[type="radio"]:checked ~ div {
    border-color: #3b82f6;
    background-color: rgba(59, 130, 246, 0.05);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .room-option {
        margin-bottom: 1rem;
    }
    #bookingSteps li {
        margin-bottom: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // DOM element references
    const form = document.getElementById('bookingForm');
    const roomOptions = document.querySelectorAll('.room-option');
    const checkIn = document.getElementById('checkIn');
    const checkOut = document.getElementById('checkOut');
    const promoInput = document.getElementById('promoCode');
    const applyPromoBtn = document.getElementById('applyPromo');
    const promoMessage = document.getElementById('promoMessage');
    const discountInput = document.getElementById('discountAmount');
    const promoCodeIdInput = document.getElementById('promoCodeId');
    const selectedRoomPrice = document.getElementById('selectedRoomPrice');
    const nightsInput = document.getElementById('nightCount');
    const taxInput = document.getElementById('tax');
    const serviceChargeInput = document.getElementById('serviceCharge');
    const totalInput = document.getElementById('totalPrice');
    const nightsDisplay = document.getElementById('nightsDisplay');
    const summaryRoom = document.getElementById('summaryRoom');
    const summaryTax = document.getElementById('summaryTax');
    const summaryFee = document.getElementById('summaryFee');
    const summaryDiscount = document.getElementById('summaryDiscount');
    const summaryTotal = document.getElementById('summaryTotal');

    // Verify DOM elements
    if (!form || !roomOptions.length || !checkIn || !checkOut || !promoInput || !applyPromoBtn || 
        !promoMessage || !discountInput || !promoCodeIdInput || !selectedRoomPrice || !nightsInput || 
        !taxInput || !serviceChargeInput || !totalInput || !nightsDisplay || !summaryRoom || 
        !summaryTax || !summaryFee || !summaryDiscount || !summaryTotal) {
        console.error('Missing required DOM elements');
        alert('An error occurred. Please refresh the page and try again.');
        return;
    }

    // Load promo codes
    let promoCodes = {};
    try {
        const promoDataElement = document.getElementById('promoData');
        if (promoDataElement?.dataset.promos) {
            promoCodes = JSON.parse(promoDataElement.dataset.promos);
            console.log('Loaded promo codes:', Object.keys(promoCodes));
        } else {
            console.warn('Promo data not found');
        }
    } catch (error) {
        console.error('Failed to parse promo data:', error);
        promoMessage.textContent = 'Error loading promo codes';
        promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
        promoMessage.classList.remove('hidden');
    }

    // Load room prices
    const priceEl = document.getElementById('roomPrices');
    const roomPrices = {
        single: parseFloat(priceEl.dataset.single) || 0,
        double: parseFloat(priceEl.dataset.double) || 0,
        family: parseFloat(priceEl.dataset.family) || 0,
    };
    console.log('Loaded room prices:', roomPrices);

    // Format number to Rupiah
    function formatRupiah(value) {
        return 'Rp' + Math.round(value).toLocaleString('id-ID');
    }

    // Calculate number of nights
    function getNightCount() {
        if (!checkIn.value || !checkOut.value) {
            console.warn('Missing check-in or check-out date');
            return 1;
        }
        const checkInDate = new Date(checkIn.value);
        const checkOutDate = new Date(checkOut.value);
        if (checkOutDate <= checkInDate) {
            console.warn('Invalid date range');
            checkOut.value = '';
            return 1;
        }
        const diff = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
        const nights = Math.max(diff, 1);
        console.log('Nights calculated:', nights);
        return nights;
    }

    // Calculate and update prices
    function calculatePrices() {
        const nights = getNightCount();
        const price = parseFloat(selectedRoomPrice.value) || 0;
        if (isNaN(price) || price <= 0) {
            console.warn('Invalid room price:', price);
            promoMessage.textContent = 'Please select a room type';
            promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
            promoMessage.classList.remove('hidden');
            return;
        }

        const subtotal = price * nights;
        const tax = subtotal * 0.10;
        const service = subtotal * 0.05;
        let discount = parseFloat(discountInput.value) || 0;

        if (isNaN(discount) || discount < 0) {
            console.warn('Invalid discount:', discount);
            discount = 0;
            discountInput.value = '0';
        }

        const total = Math.max(subtotal + tax + service - discount, 0);

        // Update form inputs
        nightsInput.value = nights;
        taxInput.value = tax.toFixed(2);
        serviceChargeInput.value = service.toFixed(2);
        discountInput.value = discount.toFixed(2);
        totalInput.value = total.toFixed(2);

        // Update summary display
        nightsDisplay.textContent = nights;
        summaryRoom.textContent = formatRupiah(subtotal);
        summaryTax.textContent = formatRupiah(tax);
        summaryFee.textContent = formatRupiah(service);
        summaryDiscount.textContent = formatRupiah(discount);
        summaryTotal.textContent = formatRupiah(total);

        console.log('Price breakdown:', { nights, price, subtotal, tax, service, discount, total });
    }

    // Clear promo code data
    function clearPromo() {
        promoMessage.textContent = '';
        promoMessage.classList.add('hidden');
        promoMessage.classList.remove('text-red-600', 'text-green-600', 'border', 'border-red-200', 'border-green-200', 'bg-red-50', 'bg-green-50');
        promoInput.value = '';
        promoCodeIdInput.value = '';
        discountInput.value = '0';
        console.log('Promo code reset');
        calculatePrices();
    }

    // Room selection handler
    roomOptions.forEach(option => {
        option.addEventListener('click', () => {
            roomOptions.forEach(o => {
                o.classList.remove('selected', 'border-blue-500', 'bg-blue-50');
                o.classList.add('border-gray-200');
                o.querySelector('.icon-check').classList.remove('text-blue-600');
                o.querySelector('.icon-check').classList.add('text-blue-300');
            });
            option.classList.add('selected', 'border-blue-500', 'bg-blue-50');
            option.classList.remove('border-gray-200');
            option.querySelector('.icon-check').classList.add('text-blue-600');
            option.querySelector('.icon-check').classList.remove('text-blue-300');

            const price = parseFloat(option.dataset.price) || 0;
            selectedRoomPrice.value = price.toFixed(2);
            option.querySelector('input[name="room_type"]').checked = true;
            console.log('Room selected:', { type: option.dataset.type, price });
            clearPromo();
        });
    });

    // Check-in date handler
    checkIn.addEventListener('change', () => {
        if (checkIn.value) {
            const minOut = new Date(checkIn.value);
            minOut.setDate(minOut.getDate() + 1);
            checkOut.min = minOut.toISOString().split('T')[0];
            if (checkOut.value && new Date(checkOut.value) <= new Date(checkIn.value)) {
                checkOut.value = '';
                console.log('Check-out date cleared due to invalid range');
            }
        }
        calculatePrices();
    });

    // Check-out date handler
    checkOut.addEventListener('change', calculatePrices);

    // Apply promo code handler with debouncing
    let isApplyingPromo = false;
    applyPromoBtn.addEventListener('click', () => {
        if (isApplyingPromo) return;
        isApplyingPromo = true;
        setTimeout(() => { isApplyingPromo = false; }, 500);

        const code = promoInput.value.trim().toUpperCase();
        console.log('Attempting to apply promo:', code);
        clearPromo();

        const promo = promoCodes[code];
        if (promo && promo.active) {
            const today = new Date().toISOString().split('T')[0];
            if (promo.valid_from && promo.valid_from > today) {
                promoMessage.textContent = `Promo ${code} is valid from ${promo.valid_from}`;
                promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
                promoMessage.classList.remove('hidden');
                console.log('Promo not yet valid:', promo.valid_from);
                calculatePrices();
                return;
            }
            if (promo.valid_until && promo.valid_until < today) {
                promoMessage.textContent = `Promo ${code} expired on ${promo.valid_until}`;
                promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
                promoMessage.classList.remove('hidden');
                console.log('Promo expired:', promo.valid_until);
                calculatePrices();
                return;
            }

            let discount = 0;
            let discountType = '';
            const nights = getNightCount();
            const price = parseFloat(selectedRoomPrice.value) || 0;
            if (price <= 0) {
                promoMessage.textContent = 'Please select a room type before applying a promo code';
                promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
                promoMessage.classList.remove('hidden');
                console.log('No room selected for promo');
                return;
            }
            const subtotal = price * nights;

            if (promo.percent && !isNaN(parseFloat(promo.percent)) && parseFloat(promo.percent) > 0) {
                discount = subtotal * (parseFloat(promo.percent) / 100);
                discountType = `${parseFloat(promo.percent)}%`;
                console.log('Applied percentage discount:', { percent: promo.percent, discount });
            } else if (promo.amount && !isNaN(parseFloat(promo.amount)) && parseFloat(promo.amount) > 0) {
                discount = parseFloat(promo.amount);
                discountType = formatRupiah(promo.amount);
                console.log('Applied fixed discount:', { amount: promo.amount, discount });
            } else {
                promoMessage.textContent = `Invalid discount for promo ${code}`;
                promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
                promoMessage.classList.remove('hidden');
                console.log('Invalid discount data:', promo);
                calculatePrices();
                return;
            }

            if (discount <= 0) {
                promoMessage.textContent = `Promo ${code} has no valid discount`;
                promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
                promoMessage.classList.remove('hidden');
                console.log('No discount applied:', { code, discount });
                calculatePrices();
                return;
            }

            promoCodeIdInput.value = promo.id;
            promoInput.value = code;
            discountInput.value = discount.toFixed(2);
            promoMessage.textContent = `Promo ${code} applied! Save ${discountType} (${formatRupiah(discount)})`;
            promoMessage.classList.add('text-green-600', 'border', 'border-green-200', 'bg-green-50');
            promoMessage.classList.remove('hidden');
            console.log('Promo applied:', { id: promo.id, code, discount, discountType });
            calculatePrices();
        } else {
            promoMessage.textContent = `Invalid or inactive promo code: ${code}`;
            promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
            promoMessage.classList.remove('hidden');
            console.log('Invalid promo code:', code);
            calculatePrices();
        }
    });

    // Form submission handler
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const promoCode = formData.get('promo_code');
        const promoCodeId = formData.get('promo_code_id');
        const discountAmount = parseFloat(formData.get('discount_amount')) || 0;
        let totalPrice = parseFloat(formData.get('total_price')) || 0;

        console.log('Form submission data:', Object.fromEntries(formData));

        if (promoCode && !promoCodeId) {
            promoMessage.textContent = 'Please apply the promo code before submitting';
            promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
            promoMessage.classList.remove('hidden');
            console.error('Submission error: Promo code not applied', { promoCode, promoCodeId });
            return;
        }

        if (promoCodeId && !promoCode) {
            promoMessage.textContent = 'Promo code ID present without code';
            promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
            promoMessage.classList.remove('hidden');
            console.error('Submission error: Promo code ID without code', { promoCode, promoCodeId });
            return;
        }

        if (isNaN(discountAmount) || discountAmount < 0) {
            promoMessage.textContent = 'Invalid discount amount';
            promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
            promoMessage.classList.remove('hidden');
            console.error('Submission error: Invalid discount', { discountAmount });
            discountInput.value = '0';
            calculatePrices();
            return;
        }

        if (promoCode && discountAmount <= 0) {
            promoMessage.textContent = 'Promo code applied but no discount';
            promoMessage.classList.add('text-red-600', 'border', 'border-red-200', 'bg-red-50');
            promoMessage.classList.remove('hidden');
            console.error('Submission error: No discount for promo', { promoCode, discountAmount });
            return;
        }

        // Final price validation
        const nights = getNightCount();
        const price = parseFloat(selectedRoomPrice.value) || 0;
        const subtotal = price * nights;
        const tax = subtotal * 0.10;
        const service = subtotal * 0.05;
        const discount = discountAmount;
        const expectedTotal = Math.max(subtotal + tax + service - discount, 0);

        if (Math.abs(expectedTotal - totalPrice) > 0.01) {
            console.warn('Client total price adjusted', { clientTotal: totalPrice, expectedTotal });
            totalPrice = expectedTotal;
            totalInput.value = totalPrice.toFixed(2);
            summaryTotal.textContent = formatRupiah(totalPrice);
        }

        console.log('Final prices:', { subtotal, tax, service, discount, total: totalPrice });
        formData.set('total_price', totalPrice.toFixed(2));
        console.log('Submitting form with data:', Object.fromEntries(formData));

        form.submit();
    });

    // Set minimum check-in date
    checkIn.min = new Date().toISOString().split('T')[0];

    // Initialize check-out min date if check-in is set
    if (checkIn.value) {
        const minOut = new Date(checkIn.value);
        minOut.setDate(minOut.getDate() + 1);
        checkOut.min = minOut.toISOString().split('T')[0];
        if (checkOut.value && new Date(checkOut.value) <= new Date(checkIn.value)) {
            checkOut.value = '';
            console.log('Check-out date cleared on load due to invalid range');
        }
    }

    // Initial price calculation
    calculatePrices();
});
</script>
@endsection