@extends('layouts.app')

@section('title', 'Booking Confirmation')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <div class="text-center mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-amber-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Booking Confirmed!</h2>
                <p class="text-gray-600">Thank you for your booking. We've received your request and will send a confirmation email soon.</p>
            </div>

            <!-- Booking Summary -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Booking Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Booking Code</p>
                        <p class="text-gray-900 font-semibold">{{ $bookingCode }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Tour Name</p>
                        <p class="text-gray-900">{{ $tourPackage->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Tour Date</p>
                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($bookingDetails['tour_date'])->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Number of Guests</p>
                        <p class="text-gray-900">{{ $bookingDetails['guest_count'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Total Price</p>
                        <p class="text-gray-900 font-semibold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                    </div>
                    @if($bookingDetails['special_request'])
                        <div>
                            <p class="text-sm font-medium text-gray-700">Special Requests</p>
                            <p class="text-gray-900">{{ $bookingDetails['special_request'] }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Information -->
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Your Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Name</p>
                        <p class="text-gray-900">{{ $bookingDetails['customer_name'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Email</p>
                        <p class="text-gray-900">{{ $bookingDetails['customer_email'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Phone Number</p>
                        <p class="text-gray-900">{{ $bookingDetails['customer_phone'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Next Steps</h3>
                <p class="text-gray-600 mb-4">
                    You'll receive an email confirmation with further details. Our team will contact you to finalize payment and itinerary details.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center justify-center px-5 py-3 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Return to Home
                    </a>
                    <a href="{{ route('paket-tours.index') }}"
                       class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-semibold rounded-lg shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Explore More Tours
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection