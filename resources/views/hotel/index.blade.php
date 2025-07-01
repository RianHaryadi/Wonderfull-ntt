@extends('layouts.app')

@section('title', 'All Hotels')

@section('content')
<!-- Hero Section with Parallax Effect -->
<div class="relative h-96 overflow-hidden">
    <!-- Background image with parallax effect -->
    <div 
        class="absolute inset-0 bg-cover bg-center bg-no-repeat transform scale-100 md:scale-110 transition-transform duration-1000 ease-out hover:scale-105"
        style="background-image: url('https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&h=1080&q=80')"
        data-parallax="true"
    ></div>
    
    <!-- Gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 via-blue-700/50 to-blue-500/20"></div>
    
    <!-- Content -->
    <div class="relative h-full flex flex-col justify-center items-center text-center px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 animate-fade-in-down">
            Discover Your <span class="text-yellow-300">Dream Stay</span>
        </h1>
        
        <div class="w-24 h-1 bg-yellow-400 rounded-full mb-6 animate-grow-x"></div>
        
        <p class="text-lg sm:text-xl text-blue-100 max-w-3xl mx-auto animate-fade-in-up">
            Explore handpicked accommodations across East Nusa Tenggara, from beachfront villas to mountain retreats
        </p>
    </div>
</div>

<!-- Search Filters with Floating Effect -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 z-10 relative">
    <div class="bg-white rounded-xl shadow-xl p-6 transition-all duration-300 hover:shadow-2xl">
        <form method="GET" action="{{ route('hotels.index') }}" id="search-form">
            <div class="space-y-6">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Find Your Perfect Hotel
                    </h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Location Select -->
                    <div class="col-span-1 md:col-span-3">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                        <div class="relative">
                            <select id="location" name="location" class="block w-full pl-4 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg transition-all duration-200">
                                <option value="">Anywhere in East Nusa Tenggara</option>
                                @foreach($locations as $loc)
                                    @if($loc)
                                        <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>
                                            {{ $loc }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full h-[42px] bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-2 px-6 rounded-lg shadow-md transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Hotel Grid Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Results Count and Sorting -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">
            {{ $hotels->total() }} {{ $hotels->total() === 1 ? 'Hotel' : 'Hotels' }} Found
            @if(request('location'))
                in <span class="text-blue-600">{{ request('location') }}</span>
            @endif
        </h2>
        
        <form method="GET" action="{{ route('hotels.index') }}" id="sort-form">
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">Sort by:</span>
                <select name="sort" id="sort" class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition" onchange="this.form.submit()">
                    <option value="recommended" {{ request('sort') == 'recommended' || !request('sort') ? 'selected' : '' }}>Recommended</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                    <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Rating</option>
                </select>
                <!-- Hidden input to preserve location filter -->
                <input type="hidden" name="location" value="{{ request('location') }}">
            </div>
        </form>
    </div>
    
    <!-- Hotel Cards Grid -->
    @if($hotels->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($hotels as $hotel)
            @php
                $prices = [
                    $hotel->single_room_price ?? 999999999,
                    $hotel->double_room_price ?? 999999999,
                    $hotel->family_room_price ?? 999999999,
                ];
                $minPrice = min(array_filter($prices, fn($val) => $val !== null));
                $minPrice = min(array_filter($prices, fn($val) => $val !== null));
                
                // Generate a random rating between 3.5 and 5 for demo purposes
                $rating = rand(35, 50) / 10;
            @endphp

            <div class="group relative bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <!-- Image with overlay -->
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ $hotel->image ? asset('storage/' . $hotel->image) : asset('images/hotel-fallback.jpg') }}"
                        alt="{{ $hotel->name }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    
                    <!-- Price Tag -->
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-blue-700 font-bold text-sm px-3 py-1 rounded-full shadow-md">
                        Rp {{ number_format($minPrice, 0, ',', '.') }} <span class="font-normal">/night</span>
                    </div>
                    
                    <!-- Rating Badge -->
                    <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-md flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-800">{{ $rating }}</span>
                    </div>
                </div>
                
                <!-- Card Content -->
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $hotel->name }}</h3>
                            <div class="flex items-center text-gray-600 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12l4.243-4.243m-6.586 8.486L10.586 12 6.343 7.757" />
                                </svg>
                                <span class="text-sm">{{ $hotel->location }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <p class="mt-3 text-gray-600 text-sm">{{ \Illuminate\Support\Str::limit($hotel->description, 100) }}</p>
                    
                    <!-- Facilities Chips -->
                    @if($hotel->facilities)
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach(explode(',', $hotel->facilities) as $facility)
                                @if($loop->index < 3)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ trim($facility) }}
                                    </span>
                                @endif
                            @endforeach
                            @if(count(explode(',', $hotel->facilities)) > 3)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    +{{ count(explode(',', $hotel->facilities)) - 3 }} more
                                </span>
                            @endif
                        </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="mt-6 flex justify-between space-x-3">
                        <a href="{{ route('hotels.show', $hotel->id) }}" class="flex-1 text-center bg-white border border-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg hover:bg-gray-50 transition duration-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Details
                        </a>
                        <a href="{{ route('hotels.book', $hotel->id) }}" class="flex-1 text-center bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium py-2 px-4 rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2m4 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m8 0h4M8 7H6" />
                            </svg>
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center px-4 py-6 bg-white">
  <nav class="flex items-center space-x-2" aria-label="Pagination">
    <!-- Previous Button -->
    <a href="{{ $hotels->previousPageUrl() }}" 
       class="p-2 rounded-full transition-all duration-300 ease-out {{ $hotels->onFirstPage() ? 'text-gray-300 cursor-default' : 'text-blue-500 hover:bg-blue-50 hover:shadow-sm' }}"
       {{ $hotels->onFirstPage() ? 'disabled' : '' }}>
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>

    <!-- Dynamic Page Numbers -->
    @php
      $start = max(1, $hotels->currentPage() - 2);
      $end = min($hotels->lastPage(), $hotels->currentPage() + 2);
      
      if($hotels->currentPage() < 3) $end = min(5, $hotels->lastPage());
      if($hotels->currentPage() > $hotels->lastPage() - 2) $start = max(1, $hotels->lastPage() - 4);
    @endphp

    <!-- First Page + Ellipsis -->
    @if($start > 1)
      <a href="{{ $hotels->url(1) }}" 
         class="w-10 h-10 flex items-center justify-center text-sm font-medium rounded-full transition-all duration-300 hover:bg-blue-50 hover:text-blue-600">
        1
      </a>
      @if($start > 2)
        <span class="w-10 h-10 flex items-center justify-center text-gray-400">...</span>
      @endif
    @endif

    <!-- Page Numbers -->
    @foreach(range($start, $end) as $page)
      <a href="{{ $hotels->url($page) }}"
         class="relative w-10 h-10 flex items-center justify-center text-sm font-medium rounded-full transition-all duration-300
                {{ $page == $hotels->currentPage() 
                   ? 'bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-md shadow-blue-200' 
                   : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
        {{ $page }}
        @if($page == $hotels->currentPage())
          <span class="absolute -bottom-1 w-4 h-1 bg-blue-400 rounded-full"></span>
        @endif
      </a>
    @endforeach

    <!-- Last Page + Ellipsis -->
    @if($end < $hotels->lastPage())
      @if($end < $hotels->lastPage() - 1)
        <span class="w-10 h-10 flex items-center justify-center text-gray-400">...</span>
      @endif
      <a href="{{ $hotels->url($hotels->lastPage()) }}" 
         class="w-10 h-10 flex items-center justify-center text-sm font-medium rounded-full transition-all duration-300 hover:bg-blue-50 hover:text-blue-600">
        {{ $hotels->lastPage() }}
      </a>
    @endif

    <!-- Next Button -->
    <a href="{{ $hotels->nextPageUrl() }}"
       class="p-2 rounded-full transition-all duration-300 ease-out {{ !$hotels->hasMorePages() ? 'text-gray-300 cursor-default' : 'text-blue-500 hover:bg-blue-50 hover:shadow-sm' }}"
       {{ !$hotels->hasMorePages() ? 'disabled' : '' }}>
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7"/>
      </svg>
    </a>
  </nav>
</div>

    @else
    <div class="text-center py-16">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">No hotels found</h3>
        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
        <div class="mt-6">
            <a href="{{ route('hotels.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Clear filters
            </a>
        </div>
    </div>
    @endif
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit form when location changes
        document.getElementById('location').addEventListener('change', function() {
            document.getElementById('search-form').submit();
        });
        
        // Add smooth scrolling to all links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>

<style>
    @keyframes fade-in-down {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fade-in-up {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes grow-x {
        0% {
            width: 0;
        }
        100% {
            width: 100px;
        }
    }
    
    .animate-fade-in-down {
        animation: fade-in-down 0.6s ease-out forwards;
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out 0.2s forwards;
        opacity: 0;
    }
    
    .animate-grow-x {
        animation: grow-x 0.8s ease-out 0.4s forwards;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    
    /* Custom select arrow */
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1em;
    }
</style>
@endsection