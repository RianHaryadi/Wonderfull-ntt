@extends('layouts.app')

@section('title', 'Booking Hotel - ' . $hotel->name)

@section('content')
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4 max-w-5xl space-y-10">
        {{-- Hotel Overview --}}
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="md:flex">
                <div class="md:w-1/2">
                    <img src="{{ $hotel->image ? asset('storage/' . $hotel->image) : asset('images/hotel-fallback.jpg') }}"
                         alt="{{ $hotel->name }}"
                         class="w-full h-80 object-cover rounded-t-lg md:rounded-l-lg transform hover:scale-105 transition-transform duration-300">
                </div>
                <div class="md:w-1/2 p-8 flex flex-col justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-800">{{ $hotel->name }}</h1>
                        <p class="text-gray-600 mt-4">{{ $hotel->description }}</p>
                    </div>
                    <div class="mt-6 space-y-2">
                        <div class="text-blue-600 flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $hotel->location }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @php
                                $facilities = is_array($hotel->facilities)
                                    ? $hotel->facilities
                                    : explode(',', $hotel->facilities);
                            @endphp
                            @foreach($facilities as $facility)
                                @php $f = strtolower(trim($facility)); @endphp
                                <div class="flex items-center gap-1 px-4 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-200">
                                    @if(str_contains($f, 'wifi')) <i class="fas fa-wifi"></i>
                                    @elseif(str_contains($f, 'pool')) <i class="fas fa-swimming-pool"></i>
                                    @elseif(str_contains($f, 'restaurant')) <i class="fas fa-utensils"></i>
                                    @elseif(str_contains($f, 'parking')) <i class="fas fa-parking"></i>
                                    @elseif(str_contains($f, 'ac')) <i class="fas fa-wind"></i>
                                    @elseif(str_contains($f, 'spa')) <i class="fas fa-spa"></i>
                                    @elseif(str_contains($f, 'bar')) <i class="fas fa-glass-martini-alt"></i>
                                    @else <i class="fas fa-check-circle text-gray-400"></i>
                                    @endif
                                    <span>{{ ucwords(trim($facility)) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Booking Form --}}
        <div class="bg-white shadow-lg rounded-2xl p-8">
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
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Room Selection --}}
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4 flex items-center">
                        <i class="fas fa-bed text-blue-500 mr-3"></i> Choose Room Type
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                            $rooms = [
                                ['type' => 'single', 'name' => 'Single', 'price' => $hotel->single_room_price ?? 0, 'icon' => 'fas fa-user'],
                                ['type' => 'double', 'name' => 'Double', 'price' => $hotel->double_room_price ?? 0, 'icon' => 'fas fa-users'],
                                ['type' => 'family', 'name' => 'Family', 'price' => $hotel->family_room_price ?? 0, 'icon' => 'fas fa-home'],
                            ];
                        @endphp
                        @foreach($rooms as $room)
                            <label class="room-option border-2 rounded-xl p-6 cursor-pointer hover:shadow-md transition-transform duration-200 hover:scale-105 {{ old('room_type') == $room['type'] ? 'selected border-blue-500' : 'border-gray-200' }}"
                                   data-type="{{ $room['type'] }}"
                                   data-price="{{ $room['price'] }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <i class="{{ $room['icon'] }} text-3xl text-blue-500"></i>
                                        <div>
                                            <h3 class="font-semibold text-lg">{{ $room['name'] }} Room</h3>
                                            <p class="text-gray-500">Rp{{ number_format($room['price'], 0, ',', '.') }} /night</p>
                                        </div>
                                    </div>
                                    <div class="icon-check {{ old('room_type') == $room['type'] ? '' : 'opacity-0' }} text-blue-600">
                                        <i class="fas fa-check-circle text-2xl"></i>
                                    </div>
                                </div>
                                <input type="radio" name="room_type" value="{{ $room['type'] }}" class="hidden" {{ old('room_type') == $room['type'] ? 'checked' : '' }} required>
                            </label>
                        @endforeach
                        @error('room_type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Dates --}}
                <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 font-semibold text-gray-600">Check-in</label>
                        <input type="date" id="checkIn" name="check_in_date" value="{{ old('check_in_date') }}" class="w-full border rounded-lg p-3 focus:ring-blue-400 focus:border-blue-400" required>
                        @error('check_in_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 font-semibold text-gray-600">Check-out</label>
                        <input type="date" id="checkOut" name="check_out_date" value="{{ old('check_out_date') }}" class="w-full border rounded-lg p-3 focus:ring-blue-400 focus:border-blue-400" required>
                        @error('check_out_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Promo --}}
                <div class="mb-8">
                    <label class="block mb-2 font-semibold text-gray-600">Promo Code (optional)</label>
                    <div class="flex items-center space-x-3">
                        <input type="text" id="promoCode" name="promo_code" value="{{ old('promo_code') }}" class="flex-1 border rounded-lg p-3 focus:ring-blue-400 focus:border-blue-400" placeholder="e.g. TEMANRIAN1">
                        <button type="button" id="applyPromo" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">Apply</button>
                    </div>
                    <div id="promoMessage" class="hidden text-sm mt-2"></div>
                    @error('promo_code') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                    @error('promo_code_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                    @error('discount_amount') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                </div>

                {{-- Summary --}}
                <div class="bg-gray-50 p-6 rounded-xl shadow-inner mb-8">
                    <h3 class="font-bold text-2xl text-gray-700 mb-4 flex items-center">
                        <i class="fas fa-calculator text-blue-500 mr-3"></i> Price Summary
                    </h3>
                    <div class="space-y-3 text-gray-700">
                        <div class="flex justify-between"><span>Room (× <span id="nightsDisplay">1</span> nights)</span><span id="summaryRoom">Rp0</span></div>
                        <div class="flex justify-between"><span>Tax (10%)</span><span id="summaryTax">Rp0</span></div>
                        <div class="flex justify-between"><span>Service Fee (5%)</span><span id="summaryFee">Rp0</span></div>
                        <div class="flex justify-between text-green-600"><span>Discount</span><span id="summaryDiscount">Rp0</span></div>
                        <hr class="my-3">
                        <div class="flex justify-between font-bold text-xl"><span>Total</span><span id="summaryTotal" class="text-blue-600">Rp0</span></div>
                    </div>
                </div>

                {{-- Guest & Payment --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="space-y-4 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-700 flex items-center">
                            <i class="fas fa-user-circle text-blue-500 mr-3"></i> Guest Information
                        </h3>
                        <div>
                            <label class="block mb-1 font-medium">Full Name</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="w-full border rounded-lg p-3 focus:ring-blue-400 focus:border-blue-400" required>
                            @error('customer_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Email</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="w-full border rounded-lg p-3 focus:ring-blue-400 focus:border-blue-400" required>
                            @error('customer_email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Phone</label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" class="w-full border rounded-lg p-3 focus:ring-blue-400 focus:border-blue-400" required>
                            @error('customer_phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                        </div>
                    </div>
                    <div class="space-y-4 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-700 flex items-center">
                            <i class="fas fa-credit-card text-blue-500 mr-3"></i> Payment Method
                        </h3>
                        <div class="space-y-2">
                            @foreach(['transfer', 'qris', 'cash'] as $method)
                                <label class="flex items-center space-x-3">
                                    <input type="radio" name="payment_method" value="{{ $method }}" {{ old('payment_method') == $method ? 'checked' : '' }} required class="h-5 w-5 text-blue-600 focus:ring-blue-400">
                                    <span class="capitalize font-medium">{{ ucfirst($method) }}</span>
                                </label>
                            @endforeach
                            @error('payment_method') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                        </div>
                    </div>
                </div>

                {{-- Additional error fields --}}
                @error('night_count') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                @error('room_price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                @error('tax') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                @error('service_charge') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif
                @error('total_price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @endif

                {{-- Terms & Submit --}}
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="agree_terms" {{ old('agree_terms') ? 'checked' : '' }} required class="text-blue-600 rounded focus:ring-blue-400">
                        <span class="text-gray-600 text-sm">I agree to the <a href="#" class="text-blue-500 underline">terms & conditions</a>.</span>
                    </label>
                    <button type="submit" class="bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 transform hover:scale-105 transition duration-200">
                        <i class="fas fa-lock mr-2"></i> Book Now
                    </button>
                </div>
            </form>
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
.room-option.selected {
    border-color: #3B82F6;
    box-shadow: 0 0 0 2px rgba(59,130,246,0.3);
}
.icon-check {
    transition: opacity 0.2s ease-in-out;
}
.room-option:hover {
    transform: scale(1.02);
}
.text-green-600 { color: #16a34a; }
.text-red-600 { color: #dc2626; }
.hidden { display: none; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
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
    if (!form || !roomOptions || !checkIn || !checkOut || !promoInput || !applyPromoBtn || !promoMessage ||
        !discountInput || !promoCodeIdInput || !selectedRoomPrice || !nightsInput || !taxInput ||
        !serviceChargeInput || !totalInput || !nightsDisplay || !summaryRoom || !summaryTax ||
        !summaryFee || !summaryDiscount || !summaryTotal) {
        console.error('One or more DOM elements are missing');
        return;
    }

    // Load promo codes
    let promoCodes = {};
    try {
        const promoDataElement = document.getElementById('promoData');
        if (promoDataElement && promoDataElement.dataset.promos) {
            promoCodes = JSON.parse(promoDataElement.dataset.promos);
            console.log('Available promo codes:', promoCodes);
        } else {
            console.warn('No promo data found');
        }
    } catch (error) {
        console.error('Error parsing promo data:', error);
        promoMessage.textContent = 'Error loading promo codes.';
        promoMessage.classList.add('text-red-600');
        promoMessage.classList.remove('hidden');
    }

    // Load room prices
    const priceEl = document.getElementById('roomPrices');
    const hotelPrices = {
        single: parseFloat(priceEl.dataset.single) || 0,
        double: parseFloat(priceEl.dataset.double) || 0,
        family: parseFloat(priceEl.dataset.family) || 0,
    };
    console.log('Room prices:', hotelPrices);

    function formatRupiah(value) {
        return 'Rp' + Math.round(value).toLocaleString('id-ID');
    }

    function getNightCount() {
        if (!checkIn.value || !checkOut.value) {
            console.warn('Check-in or check-out date missing');
            return 1;
        }
        const diff = Math.ceil((new Date(checkOut.value) - new Date(checkIn.value)) / (1000 * 60 * 60 * 24));
        const nights = diff > 0 ? diff : 1;
        console.log('Calculated nights:', nights);
        return nights;
    }

    function calculatePrices() {
        const nights = getNightCount();
        const price = parseFloat(selectedRoomPrice.value) || 0;
        if (isNaN(price) || price <= 0) {
            console.warn('Invalid room price', { price });
            return;
        }
        const subtotal = price * nights;
        const tax = subtotal * 0.10;
        const service = subtotal * 0.05;
        let discount = parseFloat(discountInput.value) || 0;

        if (isNaN(discount) || discount < 0) {
            console.warn('Invalid discount value, resetting to 0', { discount });
            discount = 0;
            discountInput.value = '0';
        }

        const total = Math.max(subtotal + tax + service - discount, 0);

        // Update hidden inputs
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

        console.log('Price calculation:', { nights, price, subtotal, tax, service, discount, total });
    }

    function clearPromo() {
        promoMessage.textContent = '';
        promoMessage.classList.add('hidden');
        promoMessage.classList.remove('text-red-600', 'text-green-600');
        promoInput.value = '';
        promoCodeIdInput.value = '';
        discountInput.value = '0';
        console.log('Promo cleared');
        calculatePrices();
    }

    roomOptions.forEach(option => {
        option.addEventListener('click', () => {
            roomOptions.forEach(o => {
                o.classList.remove('selected', 'border-blue-500');
                o.classList.add('border-gray-200');
                o.querySelector('.icon-check').classList.add('opacity-0');
            });
            option.classList.add('selected', 'border-blue-500');
            option.classList.remove('border-gray-200');
            option.querySelector('.icon-check').classList.remove('opacity-0');

            const price = parseFloat(option.dataset.price) || 0;
            selectedRoomPrice.value = price.toFixed(2);
            console.log('Selected room price:', price);
            clearPromo();
        });
    });

    checkIn.addEventListener('change', () => {
        if (checkIn.value) {
            const minOut = new Date(checkIn.value);
            minOut.setDate(minOut.getDate() + 1);
            checkOut.min = minOut.toISOString().split('T')[0];
            if (checkOut.value && new Date(checkOut.value) <= new Date(checkIn.value)) {
                checkOut.value = '';
                console.log('Check-out date reset due to invalid range');
            }
        }
        calculatePrices();
    });

    checkOut.addEventListener('change', calculatePrices);

    applyPromoBtn.addEventListener('click', () => {
        const code = promoInput.value.trim().toUpperCase();
        console.log('Applying promo code:', code);
        clearPromo();

        const promo = promoCodes[code];
        if (promo && promo.active) {
            const today = new Date().toISOString().split('T')[0];
            if (promo.valid_from && promo.valid_from > today) {
                promoMessage.textContent = `Promo ${code} is not yet valid until ${promo.valid_from}.`;
                promoMessage.classList.add('text-red-600');
                promoMessage.classList.remove('hidden');
                console.log('Promo not yet valid:', { code, valid_from: promo.valid_from });
                calculatePrices();
            } else if (promo.valid_until && promo.valid_until < today) {
                promoMessage.textContent = `Promo ${code} expired on ${promo.valid_until}.`;
                promoMessage.classList.add('text-red-600');
                promoMessage.classList.remove('hidden');
                console.log('Promo expired:', { code, valid_until: promo.valid_until });
                calculatePrices();
            } else {
                let discount = 0;
                let discountType = '';
                if (promo.percent !== null && !isNaN(parseFloat(promo.percent)) && parseFloat(promo.percent) > 0) {
                    const nights = getNightCount();
                    const price = parseFloat(selectedRoomPrice.value) || 0;
                    const subtotal = price * nights;
                    discount = subtotal * (parseFloat(promo.percent) / 100);
                    discountType = `${parseFloat(promo.percent)}%`;
                    console.log('Applying percentage discount:', { code, percent: promo.percent, subtotal, discount });
                } else if (promo.amount !== null && !isNaN(parseFloat(promo.amount)) && parseFloat(promo.amount) > 0) {
                    discount = parseFloat(promo.amount);
                    discountType = formatRupiah(promo.amount);
                    console.log('Applying fixed amount discount:', { code, amount: promo.amount, discount });
                } else {
                    promoMessage.textContent = `Promo ${code} has no valid discount.`;
                    promoMessage.classList.add('text-red-600');
                    promoMessage.classList.remove('hidden');
                    console.log('No valid discount for promo:', { code, amount: promo.amount, percent: promo.percent });
                    calculatePrices();
                    return;
                }

                if (discount <= 0) {
                    promoMessage.textContent = `Promo ${code} resulted in no discount.`;
                    promoMessage.classList.add('text-red-600');
                    promoMessage.classList.remove('hidden');
                    console.log('Invalid discount calculated:', { code, discount });
                    calculatePrices();
                    return;
                }

                promoCodeIdInput.value = promo.id;
                promoInput.value = code;
                discountInput.value = discount.toFixed(2);
                promoMessage.textContent = `Promo ${code} applied! Discount: ${discountType} (Rp${Math.round(discount).toLocaleString('id-ID')})`;
                promoMessage.classList.add('text-green-600');
                promoMessage.classList.remove('hidden');
                console.log('Promo successfully applied:', { id: promo.id, code, discount, discountType });
                calculatePrices();
            }
        } else {
            promoMessage.textContent = 'Invalid promo code.';
            promoMessage.classList.add('text-red-600');
            promoMessage.classList.remove('hidden');
            console.log('Invalid promo code:', code);
            calculatePrices();
        }
    });

    form.addEventListener('submit', (e) => {
        e.preventDefault(); // Prevent default submission to validate
        const formData = new FormData(form);
        const promoCode = formData.get('promo_code');
        const promoCodeId = formData.get('promo_code_id');
        const discountAmount = parseFloat(formData.get('discount_amount')) || 0;
        let totalPrice = parseFloat(formData.get('total_price')) || 0;

        console.log('Attempting form submission with data:', Object.fromEntries(formData));

        if (promoCode && !promoCodeId) {
            promoMessage.textContent = 'Please apply the promo code before submitting.';
            promoMessage.classList.add('text-red-600');
            promoMessage.classList.remove('hidden');
            console.error('Form submission prevented: Promo code entered but not applied', { promoCode, promoCodeId, discountAmount });
            return;
        }

        if (promoCodeId && !promoCode) {
            promoMessage.textContent = 'Promo code ID present but no promo code entered.';
            promoMessage.classList.add('text-red-600');
            promoMessage.classList.remove('hidden');
            console.error('Form submission prevented: Promo code ID without code', { promoCode, promoCodeId, discountAmount });
            return;
        }

        if (isNaN(discountAmount) || discountAmount < 0) {
            promoMessage.textContent = 'Invalid discount amount.';
            promoMessage.classList.add('text-red-600');
            promoMessage.classList.remove('hidden');
            console.error('Form submission prevented: Invalid discount amount', { promoCode, promoCodeId, discountAmount });
            discountInput.value = '0';
            calculatePrices();
            return;
        }

        if (promoCode && discountAmount <= 0) {
            promoMessage.textContent = 'Promo code applied but no discount calculated.';
            promoMessage.classList.add('text-red-600');
            promoMessage.classList.remove('hidden');
            console.error('Form submission prevented: No discount for promo code', { promoCode, promoCodeId, discountAmount });
            return;
        }

        // Recalculate prices to ensure accuracy
        const nights = getNightCount();
        const price = parseFloat(selectedRoomPrice.value) || 0;
        const subtotal = price * nights;
        const tax = subtotal * 0.10;
        const service = subtotal * 0.05;
        const discount = discountAmount;
        const expectedTotal = Math.max(subtotal + tax + service - discount, 0);

        totalInput.value = expectedTotal.toFixed(2);
        summaryTotal.textContent = formatRupiah(expectedTotal);
        console.log('Final price before submission:', { subtotal, tax, service, discount, expectedTotal });

        // Rebuild form data with updated total
        formData.set('total_price', expectedTotal.toFixed(2));
        console.log('Updated form submission data:', Object.fromEntries(formData));

        // Submit the form manually
        form.submit();
    });

    // Set minimum date for check-in to today
    const today = new Date().toISOString().split('T')[0];
    checkIn.min = today;

    // Initial calculation
    calculatePrices();
});
</script>
@endsection