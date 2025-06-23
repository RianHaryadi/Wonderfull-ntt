@extends('layouts.app')
@section('title', 'Check Booking')

@section('content')
<section class="py-16 bg-gradient-to-b from-blue-50 to-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4 transform transition-all hover:rotate-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Check Your Booking</h1>
            <p class="text-gray-600 max-w-md mx-auto">Enter your booking reference to view your reservation details</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-xl p-6 shadow-md mb-10 transition-all hover:shadow-lg">
            <form action="{{ route('booking.check') }}" method="POST" class="space-y-5" id="bookingForm">
                @csrf
                <div>
                    <label for="booking_number" class="block text-base font-medium text-gray-700 mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        Booking Reference
                    </label>
                    <div class="relative">
                        <input type="text" id="booking_number" name="booking_number"
                               placeholder="e.g. BOOK-20250618-1234" required
                               value="{{ old('booking_number') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base transition duration-300 placeholder-gray-400"
                               aria-describedby="bookingHelp">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    @error('booking_number')
                        <p class="mt-2 text-sm text-red-600" id="booking-error">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500" id="bookingHelp">You can find your booking reference in your confirmation email or SMS.</p>
                </div>

                <button type="submit" id="searchBtn"
                    class="w-full bg-blue-600 text-white py-3 px-5 rounded-lg font-semibold text-base
                        hover:bg-blue-700 transition duration-300 flex items-center justify-center
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <span id="searchText">Find My Booking</span>
                    <svg id="searchIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                    </svg>
                    <svg id="spinnerIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 hidden animate-spin" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Search Result -->
        @isset($bookingType)
        <div id="resultContainer" class="opacity-0 translate-y-6 transition-all duration-500 ease-out">
            @if($bookingType === 'hotel')
            <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                <!-- Hotel Header with Image -->
                <div class="relative h-48 bg-gradient-to-r from-blue-600 to-blue-800">
                    @if($data->hotel->image)
                    <img src="{{ asset('storage/' . $data->hotel->image) }}" alt="{{ $data->hotel->name }}" class="w-full h-full object-cover opacity-70">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 w-full">
                        <div class="flex justify-between items-end">
                            <div>
                                <h2 class="text-2xl font-bold text-white">{{ $data->hotel->name ?? '-' }}</h2>
                                <div class="flex items-center mt-1">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                    <span class="text-white text-sm ml-2">{{ $data->hotel->location ?? '' }}</span>
                                </div>
                            </div>
                            <span class="bg-white text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ strtoupper($data->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Booking Info -->
                <div class="p-6 space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Guest Information -->
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Guest Information</h3>
                                    <p class="text-gray-600 mt-1">{{ $data->customer_name }}</p>
                                    <p class="text-gray-600">{{ $data->customer_email }}</p>
                                    <p class="text-gray-600">{{ $data->customer_phone }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Reservation Details -->
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Reservation Details</h3>
                                    <p class="text-gray-600 mt-1">{{ $data->booking_number }}</p>
                                    <p class="text-gray-600">{{ ucfirst($data->room_type) }} ({{ $data->guests }} Guest{{ $data->guests > 1 ? 's' : '' }})</p>
                                    <p class="text-gray-600">
                                        {{ $data->check_in_date->format('M d, Y') }} - {{ $data->check_out_date->format('M d, Y') }}
                                        ({{ $data->check_in_date->diffInDays($data->check_out_date) }} Night{{ $data->check_in_date->diffInDays($data->check_out_date) > 1 ? 's' : '' }})
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="bg-blue-50 p-5 rounded-lg border border-blue-100">
                        <h3 class="font-semibold text-gray-800 mb-3">Payment Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Room Rate</span>
                                <span class="text-gray-800">Rp {{ number_format($data->room_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Taxes</span>
                                <span class="text-gray-800">Rp {{ number_format($data->tax,0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Fees</span>
                                <span class="text-gray-800">Rp {{ number_format($data->service_charge, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-200 my-2"></div>
                            <div class="flex justify-between font-semibold">
                                <span class="text-gray-800">Total Paid</span>
                                <span class="text-blue-700">Rp {{ number_format($data->total_price, 0, ',', '.') }}</span>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button onclick="window.print()" class="flex items-center justify-center gap-2 bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg text-sm hover:bg-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                            </svg>
                            Print Confirmation
                        </button>
                        <a href="#" class="flex items-center justify-center gap-2 bg-blue-600 text-white py-2 px-4 rounded-lg text-sm hover:bg-blue-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            Need Help?
                        </a>
                    </div>
                </div>
            </div>

            <!-- Hotel Policies -->
            <div class="mt-6 bg-white rounded-xl p-6 shadow-sm">
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Hotel Policies</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-700">Check-in / Check-out</h4>
                            <p class="text-gray-600 mt-1">Check-in after 2:00 PM | Check-out before 12:00 PM (WIB)</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-700">Breakfast</h4>
                            <p class="text-gray-600 mt-1">Included for {{ $data->guests }} guest{{ $data->guests > 1 ? 's' : '' }} (06:30 - 10:30 AM)</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-700">Cancellation Policy</h4>
                            <p class="text-gray-600 mt-1">Free cancellation up to 48 hours before check-in. After that, the first night will be charged.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endisset
    </div>
</section>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('bookingForm');
        const btn = document.getElementById('searchBtn');
        const searchIcon = document.getElementById('searchIcon');
        const spinnerIcon = document.getElementById('spinnerIcon');
        const text = document.getElementById('searchText');

        // Show spinner when submitting form
        form.addEventListener('submit', function () {
            searchIcon.classList.add('hidden');
            spinnerIcon.classList.remove('hidden');
            text.textContent = 'Searching...';
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        });

        // Animation for result container
        const result = document.getElementById("resultContainer");
        if (result) {
            setTimeout(() => {
                result.classList.remove('opacity-0', 'translate-y-6');
                result.classList.add('opacity-100', 'translate-y-0');
            }, 100);
        }

        // Focus on input field when page loads
        const bookingInput = document.getElementById('booking_number');
        if (bookingInput) {
            bookingInput.focus();
        }
    });
</script>
@endsection