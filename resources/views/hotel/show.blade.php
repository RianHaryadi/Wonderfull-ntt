@extends('layouts.app')

@section('title', $hotel->name . ' - Hotel Details')

@section('content')

@php
    // Calculate minimum price for booking widget
    $prices = [
        $hotel->single_room_price,
        $hotel->double_room_price,
        $hotel->family_room_price,
    ];
    $filteredPrices = array_filter($prices, fn($val) => $val > 0);
    $minPrice = !empty($filteredPrices) ? min($filteredPrices) : 0;
@endphp

<!-- Hero Section with Image Gallery -->
<div class="relative h-[65vh] min-h-[500px] bg-gray-900 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ $hotel->image ? asset('storage/' . $hotel->image) : asset('images/hotel-fallback.jpg') }}"
             alt="View of {{ $hotel->name }}"
             class="w-full h-full object-cover transition-transform duration-1000 hover:scale-105">
    </div>
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    
    <!-- Content -->
    <div class="relative h-full flex flex-col justify-end text-white p-6 md:p-12">
        <div class="max-w-7xl mx-auto w-full">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 mb-4">
                <a href="{{ route('hotels.index') }}" class="text-sm text-white/90 hover:text-white transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    All Hotels
                </a>
                <span class="text-white/50">/</span>
                <span class="text-sm text-white font-medium">{{ Str::limit($hotel->name, 20) }}</span>
            </div>
            
            <!-- Hotel Title and Rating -->
            <div class="flex flex-col md:flex-row md:items-end justify-between">
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight leading-tight">{{ $hotel->name }}</h1>
                    <div class="flex items-center mt-2">
                        <div class="flex items-center mr-4">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $hotel->rating ? 'text-yellow-400' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                            <span class="ml-1 text-white/90">{{ $hotel->rating }} ({{ $hotel->reviews_count }} reviews)</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12l4.243-4.243m-6.586 8.486L10.586 12 6.343 7.757" />
                            </svg>
                            <span class="text-lg">{{ $hotel->location }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Price from -->
                <div class="mt-4 md:mt-0 bg-white/10 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                    <p class="text-sm text-white/80">Starting from</p>
                    <p class="text-2xl font-bold text-white">
                        Rp {{ number_format($minPrice, 0, ',', '.') }}
                        <span class="text-base font-normal">/ night</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="lg:grid lg:grid-cols-3 lg:gap-12">
        
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- About Hotel Section -->
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 relative pb-4 after:absolute after:bottom-0 after:left-0 after:w-16 after:h-1 after:bg-blue-600">
                    About {{ $hotel->name }}
                </h2>
                <div class="prose max-w-none text-gray-600">
                    {!! nl2br(e($hotel->description)) !!}
                </div>
            </div>

            <!-- Facilities Section -->
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 relative pb-4 after:absolute after:bottom-0 after:left-0 after:w-16 after:h-1 after:bg-blue-600">
                    Hotel Facilities
                </h2>
                @if($hotel->facilities)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach(explode(',', $hotel->facilities) as $facility)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                                <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="font-medium text-gray-700">{{ trim($facility) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No facility information available.</p>
                @endif
            </div>

            <!-- Rooms Section -->
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 relative pb-4 after:absolute after:bottom-0 after:left-0 after:w-16 after:h-1 after:bg-blue-600">
                    Our Rooms
                </h2>
                <div class="space-y-6">
                    @if($hotel->single_room_price)
                    <div class="flex flex-col sm:flex-row border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow">
                        <div class="sm:w-1/3 h-48 sm:h-auto">
                            <img src="{{ asset('images/room-single.jpg') }}" alt="Single Room" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 sm:w-2/3">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Single Room</h3>
                            <p class="text-blue-600 text-2xl font-bold mb-3">Rp {{ number_format($hotel->single_room_price, 0, ',', '.') }} <span class="text-base font-normal text-gray-500">/ night</span></p>
                            <p class="text-gray-600 mb-4">Cozy single room perfect for solo travelers with all essential amenities.</p>
                            <a href="{{ route('hotels.book', $hotel->id) }}?room=single" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                Book Now
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($hotel->double_room_price)
                    <div class="flex flex-col sm:flex-row border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow">
                        <div class="sm:w-1/3 h-48 sm:h-auto">
                            <img src="{{ asset('images/room-double.jpg') }}" alt="Double Room" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 sm:w-2/3">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Double Room</h3>
                            <p class="text-blue-600 text-2xl font-bold mb-3">Rp {{ number_format($hotel->double_room_price, 0, ',', '.') }} <span class="text-base font-normal text-gray-500">/ night</span></p>
                            <p class="text-gray-600 mb-4">Spacious room with a comfortable double bed, ideal for couples.</p>
                            <a href="{{ route('hotels.book', $hotel->id) }}?room=double" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                Book Now
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($hotel->family_room_price)
                    <div class="flex flex-col sm:flex-row border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow">
                        <div class="sm:w-1/3 h-48 sm:h-auto">
                            <img src="{{ asset('images/room-family.jpg') }}" alt="Family Room" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 sm:w-2/3">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Family Room</h3>
                            <p class="text-blue-600 text-2xl font-bold mb-3">Rp {{ number_format($hotel->family_room_price, 0, ',', '.') }} <span class="text-base font-normal text-gray-500">/ night</span></p>
                            <p class="text-gray-600 mb-4">Large room with multiple beds, perfect for families or groups.</p>
                            <a href="{{ route('hotels.book', $hotel->id) }}?room=family" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                Book Now
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Right Column (Sidebar) -->
        <div class="lg:col-span-1 mt-8 lg:mt-0">
            <div class="sticky top-6 space-y-6">
                <!-- Right Column: Booking Widget -->
                <div class="lg:col-span-1 mt-8 lg:mt-0">
                    <div class="sticky top-24 space-y-8">
                <!-- Contact Info -->
                <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-200">
                    <div class="bg-blue-600 p-4 text-white">
                        <h3 class="text-xl font-bold">Contact</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <h4 class="font-medium text-gray-700">Phone</h4>
                                <p class="text-gray-600">{{ $hotel->phone ?? 'Not provided' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <h4 class="font-medium text-gray-700">Email</h4>
                                <p class="text-gray-600">{{ $hotel->email ?? 'Not provided' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12l4.243-4.243m-6.586 8.486L10.586 12 6.343 7.757" />
                            </svg>
                            <div>
                                <h4 class="font-medium text-gray-700">Address</h4>
                                <p class="text-gray-600">{{ $hotel->address ?? $hotel->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Style for prose content -->
<style>
    .prose {
        line-height: 1.75;
        color: #4b5563;
    }
    .prose p {
        margin-bottom: 1.25em;
    }
    .prose ul {
        list-style-type: disc;
        padding-left: 1.5em;
        margin-bottom: 1.25em;
    }
    .prose li {
        margin-bottom: 0.5em;
    }
</style>
@endsection