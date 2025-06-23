@extends('layouts.app')
@section('title', 'Check Booking')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">

        <!-- Header Section -->
        <div class="text-center mb-10">
            <div class="inline-block p-2 bg-blue-100 rounded-full mb-3">
                <i class="fas fa-hotel text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Check Your Booking</h1>
            <p class="text-gray-600 max-w-md mx-auto text-sm">Enter your booking number to view reservation status</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-xl p-6 shadow-sm mb-10">
            <form action="{{ route('booking.check') }}" method="POST" class="space-y-4" id="bookingForm">
                @csrf
                <div>
                    <label for="booking_number" class="block text-base font-medium text-gray-700 mb-1">
                        <i class="fas fa-search mr-1 text-blue-500"></i> Booking Number
                    </label>
                    <div class="relative">
                        <input type="text" id="booking_number" name="booking_number"
                               placeholder="Example: BOOK-20250618-1234" required
                               value="{{ old('booking_number') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base transition duration-300">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-barcode text-gray-400"></i>
                        </div>
                    </div>
                    @error('booking_number')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                    <p class="mt-1 text-xs text-gray-400">You can find your booking number in your email.</p>
                </div>

                <button type="submit" id="searchBtn"
                    class="w-full bg-blue-600 text-white py-3 px-5 rounded-lg font-semibold text-base
                        hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                    <i id="searchIcon" class="fas fa-search mr-2"></i>
                    <span id="searchText">Search</span>
                </button>
            </form>
        </div>

        <!-- Search Result -->
        @isset($bookingType)
        @if($bookingType === 'hotel')
        <div id="resultContainer" style="opacity: 0; transform: translateY(30px); transition: all 0.6s ease;">
            <div class="bg-white rounded-xl overflow-hidden shadow-md">
                <!-- Hotel Header -->
                <div class="relative h-40 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                    <div class="absolute inset-0 bg-black opacity-25"></div>
                    <div class="relative z-10 text-center text-white">
                        <h2 class="text-xl font-bold">{{ $data->hotel->name ?? '-' }}</h2>
                        <div class="flex justify-center mt-1">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-yellow-300 text-sm"></i>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Booking Info -->
                <div class="p-6 space-y-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Booking Details</h3>
                            <p class="text-sm text-gray-500">Here is your reservation information</p>
                        </div>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                            <i class="fas fa-check-circle mr-1"></i> {{ ucfirst($data->status) }}
                        </span>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-md space-y-2">
                            <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                                <i class="fas fa-user text-blue-500 mr-2"></i> Guest
                            </h4>
                            <p class="text-sm text-gray-600">{{ $data->customer_name }}</p>
                            <p class="text-sm text-gray-600">{{ $data->customer_email }}</p>
                            <p class="text-sm text-gray-600">{{ $data->customer_phone }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-md space-y-2">
                            <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                                <i class="fas fa-calendar text-blue-500 mr-2"></i> Reservation
                            </h4>
                            <p class="text-sm text-gray-600">{{ $data->booking_number }}</p>
                            <p class="text-sm text-gray-600">{{ ucfirst($data->room_type) }} ({{ $data->guests }} Guest{{ $data->guests > 1 ? 's' : '' }})</p>
                            <p class="text-sm text-gray-600">
                                {{ $data->check_in_date->format('M d, Y') }} - {{ $data->check_out_date->format('M d, Y') }}
                                ({{ $data->check_in_date->diffInDays($data->check_out_date) }} Night{{ $data->check_in_date->diffInDays($data->check_out_date) > 1 ? 's' : '' }})
                            </p>
                        </div>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-md flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-lg font-bold text-blue-700">Rp {{ number_format($data->total_price, 0, ',', '.') }}</p>
                        </div>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                            <i class="fas fa-check-circle mr-1"></i> Paid
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#" class="flex-1 bg-white border border-blue-500 text-blue-600 py-2 px-4 rounded-md text-sm text-center hover:bg-blue-50 transition">
                            <i class="fas fa-print mr-1"></i> Print
                        </a>
                        <a href="#" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md text-sm text-center hover:bg-blue-700 transition">
                            <i class="fas fa-question-circle mr-1"></i> Help
                        </a>
                    </div>
                </div>
            </div>

            <!-- Extra Info -->
            <div class="mt-6 bg-white rounded-xl p-5 shadow-sm text-sm space-y-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-clock text-blue-500 mt-1"></i>
                    <div>
                        <p class="font-medium text-gray-700">Check-in / Check-out</p>
                        <p class="text-gray-600">Check-in after 2:00 PM | Check-out before 12:00 PM (WIB)</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-utensils text-blue-500 mt-1"></i>
                    <div>
                        <p class="font-medium text-gray-700">Breakfast</p>
                        <p class="text-gray-600">Included for {{ $data->guests }} guest{{ $data->guests > 1 ? 's' : '' }} (06:30 - 10:30 AM)</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-ban text-blue-500 mt-1"></i>
                    <div>
                        <p class="font-medium text-gray-700">Cancellation</p>
                        <p class="text-gray-600">Free cancellation up to 48 hours before check-in</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endisset
    </div>
</section>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('bookingForm');
        const btn = document.getElementById('searchBtn');
        const icon = document.getElementById('searchIcon');
        const text = document.getElementById('searchText');

        // Show spinner when submitting form
        form.addEventListener('submit', function () {
            icon.classList.remove('fa-search');
            icon.classList.add('fa-spinner', 'fa-spin');
            text.textContent = 'Searching...';
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        });

        // Animation for result container
        const result = document.getElementById("resultContainer");
        if (result) {
            setTimeout(() => {
                result.style.opacity = 1;
                result.style.transform = "translateY(0)";
            }, 200);
        }
    });
</script>
@endsection
