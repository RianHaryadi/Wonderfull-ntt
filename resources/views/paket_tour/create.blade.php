@extends('layouts.app')

@section('title', 'Book Tour Package')

@section('content')
<section class="py-12 bg-gradient-to-b from-amber-50 to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-amber-100">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Book Your Adventure</h2>
                <div class="bg-amber-100 text-amber-800 px-4 py-2 rounded-full text-sm font-medium">
                    <i class="fas fa-clock mr-2"></i> Instant Confirmation
                </div>
            </div>

            @if(session('error'))
                <div class="mb-6 p-4 text-red-600 bg-red-50 rounded-lg border border-red-200 font-medium flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('paket-tour.store') }}" method="POST" class="space-y-8">
                @csrf

                <input type="hidden" name="tour_package_id" value="{{ $tourPackage->id }}">
                <input type="hidden" name="promo_code_id" id="promoCodeId">
                <input type="hidden" name="discount_amount" id="discountInput">

                {{-- Tour Package Card --}}
                <div class="bg-amber-50 rounded-xl p-6 border border-amber-100">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="md:w-1/3">
                            <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $tourPackage->thumbnail) }}" 
                                    alt="{{ $tourPackage->name }} tour"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                    loading="eager"
                                    width="400"
                                    height="288">
                            </div>
                        </div>
                        <div class="md:w-2/3">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $tourPackage->name }}</h3>
                            <div class="flex items-center text-gray-600 mb-4">
                                <i class="fas fa-map-marker-alt text-amber-500 mr-2"></i>
                                <span>{{ $tourPackage->location }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Duration</p>
                                    <p class="font-medium">{{ $tourPackage->days }} days</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Price</p>
                                    <p class="font-bold text-amber-600" id="pricePerTicketDisplay">
                                        Rp {{ number_format($tourPackage->price, 0, ',', '.') }} / person
                                    </p>
                                    <input type="hidden" id="pricePerTicket" value="{{ $tourPackage->price }}">
                                </div>
                            </div>
                            <p class="text-gray-600">{{ Str::limit($tourPackage->description, 150) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Customer Information --}}
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2">Your Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Full Name --}}
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required
                                    class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-amber-500 focus:border-amber-500">
                            </div>
                            @error('customer_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" required
                                    class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-amber-500 focus:border-amber-500">
                            </div>
                            @error('customer_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone Number --}}
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" required
                                    class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-amber-500 focus:border-amber-500">
                            </div>
                            @error('customer_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Booking Details --}}
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2">Booking Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="destination_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Destination <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-map-marked-alt text-gray-400"></i>
                                </div>
                                <select name="destination_id" id="destination_id" required
                                        class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-amber-500 focus:border-amber-500">
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
                                    <i class="fas fa-ticket-alt text-gray-400"></i>
                                </div>
                                <input type="number" name="number_of_tickets" id="number_of_tickets" min="1" value="1" required
                                       class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-amber-500 focus:border-amber-500">
                            </div>
                        </div>
                        <div>
                            <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Booking Date <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-day text-gray-400"></i>
                                </div>
                                <input type="date" name="booking_date" id="booking_date" required min="{{ date('Y-m-d') }}"
                                       class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-amber-500 focus:border-amber-500">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div>
                        <label for="special_request" class="block text-sm font-medium text-gray-700 mb-1">
                            Special Requests
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                                <i class="fas fa-comment-dots text-gray-400"></i>
                            </div>
                            <textarea name="special_request" id="special_request" rows="3"
                                      class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-amber-500 focus:border-amber-500"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Promo Code Section --}}
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-tag text-indigo-600 mr-3"></i> Apply Promo Code
                    </h3>
                    <p class="text-gray-600 mb-4">Enter your promo code below to get discounts</p>
                    
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-grow relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-ticket-alt text-gray-400"></i>
                            </div>
                            <input type="text" id="promoInput" name="promo_code" 
                                   class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-indigo-500 focus:border-indigo-500" 
                                   placeholder="SUMMER2023">
                        </div>
                        <button type="button" id="applyPromoBtn" 
                                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                            Apply Code
                        </button>
                    </div>
                    
                    <div id="promoMessage" class="hidden mt-3 p-3 rounded-lg border text-sm"></div>
                    <div id="discountDisplay" class="mt-3 text-green-600 font-medium"></div>
                </div>

                {{-- Price Summary --}}
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Price Summary</h3>
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
                                <span id="totalPriceDisplay" class="text-amber-600 text-xl">Rp {{ number_format($tourPackage->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-lg font-bold rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        <i class="fas fa-check-circle mr-3"></i> Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- Promo JSON --}}
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