@extends('layouts.app')

@section('title', 'Tour Packages')

@section('content')

<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-blue-500 to-blue-700 text-white py-20">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=1470&q=80"
             alt="Hero Background"
             class="w-full h-full object-cover">
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
            Explore the Beauty of <span class="text-yellow-300">East Nusa Tenggara</span>
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-8">
            Discover unforgettable adventures with our exclusive tour packages
        </p>
        <form action="{{ route('paket-tours.index') }}" method="GET" class="relative w-full max-w-md mx-auto">
            <input 
                type="text" 
                name="q" 
                placeholder="Search destination or tour..." 
                value="{{ request('q') }}"
                class="w-full px-6 py-4 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            <button type="submit"
                class="absolute right-2 top-2 bg-blue-600 text-white px-3 py-2 rounded-full hover:bg-blue-700 transition">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white shadow-sm py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-lg font-semibold text-gray-800">Filter Paket Tour:</h2>
            <form action="{{ route('paket-tours.index') }}" method="GET"
                  class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full md:w-auto">
                <select name="destination" class="bg-gray-100 border-0 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">All Destinations</option>
                    <option value="Labuan Bajo" {{ request('destination') == 'Labuan Bajo' ? 'selected' : '' }}>Labuan Bajo</option>
                    <option value="Kupang" {{ request('destination') == 'Kupang' ? 'selected' : '' }}>Kupang</option>
                    <option value="Flores" {{ request('destination') == 'Flores' ? 'selected' : '' }}>Flores</option>
                    <option value="Sumba" {{ request('destination') == 'Sumba' ? 'selected' : '' }}>Sumba</option>
                </select>

                <select name="price" class="bg-gray-100 border-0 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">All Prices</option>
                    <option value="under-1000000" {{ request('price') == 'under-1000000' ? 'selected' : '' }}>Below 1 Million</option>
                    <option value="1-3" {{ request('price') == '1-3' ? 'selected' : '' }}>1–3 Million</option>
                    <option value="3-5" {{ request('price') == '3-5' ? 'selected' : '' }}>3–5 Million</option>
                    <option value="above-5000000" {{ request('price') == 'above-5000000' ? 'selected' : '' }}>Above 5 Million</option>
                </select>

                <button type="submit"
                    class="col-span-2 sm:col-span-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-extrabold text-blue-700 sm:text-5xl mb-4">
            Explore the Best Tour Packages in NTT
        </h2>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Unforgettable adventures await you! Choose your favorite tour package and enjoy an amazing travel experience in East Nusa Tenggara.
        </p>
    </div>

    <!-- Tour Packages Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
  @forelse ($paketTours as $paket)
        @php
            $minPrice = $paket->variants->min('price') ?? $paket->price;
            $hasHotelVariant = $paket->variants->contains(fn($v) => $v->includes_hotel);
        @endphp

        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-1 duration-300">
            <div class="overflow-hidden rounded-t-2xl">
                @if($paket->thumbnail)
                    <img 
                        src="{{ asset('storage/' . $paket->thumbnail) }}" 
                        alt="{{ $paket->name }}" 
                        class="w-full h-52 object-cover hover:scale-110 transition duration-300"
                    >
                @else
                    <div class="w-full h-52 bg-gray-200 flex items-center justify-center text-gray-400">
                        No image available
                    </div>
                @endif
            </div>

            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-1">{{ $paket->name }}</h3>
                <p class="text-gray-500 text-sm mb-2">📍 {{ $paket->location }}</p>

                <p class="text-lg font-bold text-blue-700">
                    Starting from IDR {{ number_format($minPrice, 0, ',', '.') }}
                </p>

                <p class="mt-1 text-sm {{ $hasHotelVariant ? 'text-green-600' : 'text-red-500' }}">
                    🛏️ {{ $hasHotelVariant ? 'Hotel included variants available' : 'No hotel included' }}
                </p>

                <div class="flex items-center mt-2 text-yellow-500 text-sm">
                    ★★★★☆ <span class="text-gray-500 ml-2">(4.5/5)</span>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <a href="{{ route('paket-tours.show', $paket->id) }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium transition">
                        View Details
                    </a>
                    <a href="#" 
                       class="bg-blue-600 text-white px-4 py-2 text-sm rounded-lg hover:bg-blue-700 transition">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
  @empty
        <div class="col-span-3 text-center text-gray-500 text-lg">
            No tour packages available.
        </div>
  @endforelse
</div>
</div>
@endsection