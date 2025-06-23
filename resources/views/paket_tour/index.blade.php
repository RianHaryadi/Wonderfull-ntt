@extends('layouts.app')

@section('meta')
    <meta name="description" content="Discover luxury tour packages in East Nusa Tenggara with exclusive accommodations and private guides.">
    <meta name="keywords" content="luxury tours, East Nusa Tenggara, Komodo Island, Labuan Bajo, premium travel">
@endsection

@section('title', 'Premium Tour Packages')

@section('content')
<!-- Luxury Hero Section -->
<div class="relative h-screen overflow-hidden bg-black">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
        <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80" 
             alt="Luxury travel destination"
             class="w-full h-full object-cover opacity-80"
             id="parallax-bg"
             loading="lazy">
    </div>
    <div class="relative z-10 h-full flex flex-col justify-center">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-light text-white mb-6 leading-tight">
                    <span class="font-serif italic">Curated</span> Journeys Through<br>East Nusa Tenggara
                </h1>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-10">
                    Exclusive access to the region's most breathtaking destinations with luxury accommodations and private guides
                </p>
                <div class="flex justify-center gap-4">
                    <a href="#tours" class="bg-white text-gray-900 px-8 py-4 rounded-full text-lg font-medium hover:bg-gray-100 transition duration-300">
                        Explore Tours
                    </a>
                    <a href="#" class="border border-white text-white px-8 py-4 rounded-full text-lg font-medium hover:bg-white/10 transition duration-300">
                        Custom Itinerary
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-10 left-0 right-0 flex flex-col items-center">
        <div class="animate-bounce flex flex-col items-center">
            <span class="text-xs text-white/80 mb-1">Explore</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <title>Scroll down</title>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
        <div class="w-px h-16 bg-gradient-to-t from-white/10 via-white/50 to-transparent mt-2"></div>
    </div>
</div>

<!-- Enhanced Luxury Destinations Marquee -->
<div class="bg-black py-12 border-t border-b border-gray-800 overflow-hidden group">
    <div class="relative">
        <div class="marquee-container group-hover:[animation-play-state:paused] focus-within:[animation-play-state:paused]">
            <div class="marquee-content">
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Komodo Island</span>
                <span class="text-4xl font-serif italic text-white mr-16">•</span>
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Labuan Bajo</span>
                <span class="text-4xl font-serif italic text-white mr-16">•</span>
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Flores Highlands</span>
                <span class="text-4xl font-serif italic text-white mr-16">•</span>
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Sumba</span>
                <span class="text-4xl font-serif italic text-white mr-16">•</span>
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Alor Archipelago</span>
                <span class="text-4xl font-serif italic text-white mr-16">•</span>
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Pink Beach</span>
            </div>
            <!-- Mirrored set for seamless looping -->
            <div class="marquee-content" aria-hidden="true">
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Komodo Island</span>
                <span class="text-4xl font-serif italic text-white mr-16">•</span>
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Labuan Bajo</span>
                <span class="text-4xl font-serif italic text-white mr-16">•</span>
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Flores Highlands</span>
                <span class="text-4xl font-serif italic text-white mr-16">•</span>
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Sumba</span>
                <span class="text-4xl font-serif italic text-white mr-16">•</span>
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Alor Archipelago</span>
                <span class="text-4xl font-serif italic text-white mr-16">•</span>
                <span class="text-4xl font-serif italic text-white mr-16 hover:text-amber-400 transition-colors duration-300">Pink Beach</span>
            </div>
        </div>
        
        <!-- Gradient fade effect on sides -->
        <div class="pointer-events-none absolute inset-y-0 left-0 w-20 bg-gradient-to-r from-black to-transparent"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-20 bg-gradient-to-l from-black to-transparent"></div>
    </div>
</div>

<!-- Luxury Filter Section -->
<div class="bg-white py-8 sticky top-0 z-20 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h2 class="text-lg font-medium text-gray-900">Refine Your Search</h2>
            </div>
            
            <form action="{{ route('paket-tours.index') }}" method="GET" class="w-full lg:w-auto grid grid-cols-1 md:grid-cols-3 lg:flex gap-4">
                <div class="relative">
                    <label for="destination" class="sr-only">Destination</label>
                    <select id="destination" name="destination" class="luxury-select">
                        <option value="">All Destinations</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination }}" {{ request('destination') == $destination ? 'selected' : '' }}>
                                {{ $destination }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500 pointer-events-none" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        < Facet Normal
                    </svg>
                </div>

                <div class="relative">
                    <label for="duration" class="sr-only">Duration</label>
                    <select id="duration" name="duration" class="luxury-select">
                        <option value="">Duration</option>
                        <option value="1-3" {{ request('duration') == '1-3' ? 'selected' : '' }}>1-3 Days</option>
                        <option value="4-7" {{ request('duration') == '4-7' ? 'selected' : '' }}>4-7 Days</option>
                        <option value="8+" {{ request('duration') == '8+' ? 'selected' : '' }}>8+ Days</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500 pointer-events-none" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8l4 4 4-4" />
                    </svg>
                </div>

                <div class="relative">
                    <label for="price" class="sr-only">Price Range</label>
                    <select id="price" name="price" class="luxury-select">
                        <option value="">Price Range</option>
                        <option value="under-1000000" {{ request('price') == 'under-1000000' ? 'selected' : '' }}>Under 1M</option>
                        <option value="1-3" {{ request('price') == '1-3' ? 'selected' : '' }}>1M-3M</option>
                        <option value="3-5" {{ request('price') == '3-5' ? 'selected' : '' }}>3M-5M</option>
                        <option value="5+" {{ request('price') == '5+' ? 'selected' : '' }}>5M+</option>
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500 pointer-events-none" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8l4 4 4-4" />
                    </svg>
                </div>

                <button type="submit" class="bg-black text-white px-6 py-3 rounded-md text-sm font-medium hover:bg-gray-800 transition flex items-center justify-center gap-2">
                    Apply Filters
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Luxury Tours Grid -->
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-16" id="tours">
    <div class="flex justify-between items-center mb-12">
        <div>
            <h2 class="text-3xl font-light text-gray-900">
                @if(request()->hasAny(['q', 'destination', 'price', 'duration', 'category']))
                    {{ $paketTours->total() }} Exclusive Experiences
                @else
                    Our Signature Journeys
                @endif
            </h2>
            <p class="text-gray-500 mt-1">
                @if(request()->hasAny(['q', 'destination', 'price', 'duration', 'category']))
                    Matching your refined criteria
                @else
                    Handcrafted luxury tours in East Nusa Tenggara
                @endif
            </p>
        </div>
        
        <div class="flex items-center">
            <span class="text-sm text-gray-500 mr-3">Sort by:</span>
            <div class="relative">
                <label for="sort-select" class="sr-only">Sort by</label>
                <select id="sort-select" class="luxury-select">
                    <option value="popular">Most Exclusive</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                    <option value="duration">Duration</option>
                    <option value="rating">Highest Rated</option>
                </select>
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-500 pointer-events-none" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8l4 4 4-4" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Luxury Tour Cards -->
    <!-- Luxury Tour Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse ($paketTours as $paket)
        <div class="group relative bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
            <!-- Premium badge -->
            @if($paket->is_featured)
                <div class="absolute top-4 right-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-xs font-medium px-3 py-1 rounded-full z-10">
                    Premium
                </div>
            @endif
            
            <!-- Image with hover zoom -->
            <div class="relative h-64 overflow-hidden">
                @if($paket->thumbnail)
                    <img 
                        src="{{ asset('storage/' . $paket->thumbnail) }}" 
                        alt="{{ $paket->name }}" 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                    >
                @else
                    <div class="w-full h-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                
                <!-- Quick view overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                    <a href="{{ route('paket-tours.show', $paket->id) }}" 
                       class="bg-white text-gray-900 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition transform translate-y-3 group-hover:translate-y-0">
                        View Details
                    </a>
                </div>
            </div>

            <!-- Tour details -->
            <div class="p-6">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xl font-light text-gray-900">{{ $paket->name }}</h3>
                    <div class="flex items-center text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $paket->location }}
                    </div>
                </div>

                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @if($paket->duration_range)
                        {{ $paket->duration_range['min'] }}-{{ $paket->duration_range['max'] }} days
                    @else
                        1 day
                    @endif
                </div>

                <div class="mb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            @if($paket->price_range)
                                <span class="text-lg font-light text-gray-900">
                                    From IDR {{ number_format($paket->price_range['min'], 0, ',', '.') }}
                                </span>
                                @if($paket->price_range['min'] != $paket->price_range['max'])
                                    <span class="text-sm text-gray-500 ml-2">- {{ number_format($paket->price_range['max'], 0, ',', '.') }}</span>
                                @endif
                            @else
                                <span class="text-lg font-light text-gray-900">Contact for pricing</span>
                            @endif
                        </div>
                        
                        <span class="text-xs px-2 py-1 rounded-full {{ $paket->has_hotel_variant ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $paket->has_hotel_variant ? '5★ Hotels' : 'No Hotel' }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="flex items-center">
                        <div class="flex text-amber-400 mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($paket->average_rating))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500">({{ $paket->reviews_count }})</span>
                    </div>
                    
                    <a href="{{ route('paket-tours.show', $paket->id) }}" 
                       class="text-sm font-medium text-gray-900 hover:text-amber-600 transition flex items-center">
                        Explore
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-xl font-light text-gray-700 mt-6">No matching tours found</h3>
            <p class="text-gray-500 mt-2 max-w-md mx-auto">
                We couldn't find any tours
                @if(request('destination'))
                    for {{ request('destination') }}.
                @else
                    matching your refined criteria.
                @endif
                Try adjusting your filters or contact our concierge for a custom itinerary.
            </p>
            <a href="{{ route('paket-tours.index') }}" class="mt-4 inline-block text-sm font-medium text-amber-600 hover:text-amber-700">
                Reset all filters
            </a>
        </div>
    @endforelse
</div>

    @if($paketTours->hasPages())
        <div class="mt-12">
            {{ $paketTours->links() }}
        </div>
    @endif
</div>

<!-- Luxury Experience Section -->
<div class="bg-black text-white py-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-light mb-4">The <span class="font-serif italic">East Nusa Tenggara</span> Experience</h2>
            <div class="w-20 h-px bg-amber-500 mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center px-6">
                <div class="bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h3 class="text-xl font-light mb-3">Unparalleled Beauty</h3>
                <p class="text-gray-400">Discover pristine beaches, dramatic landscapes, and vibrant marine life in Indonesia's last paradise.</p>
            </div>
            
            <div class="text-center px-6">
                <div class="bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-light mb-3">Tailored Itineraries</h3>
                <p class="text-gray-400">Our travel designers craft personalized journeys to match your interests and travel style.</p>
            </div>
            
            <div class="text-center px-6">
                <div class="bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-light mb-3">Exclusive Access</h3>
                <p class="text-gray-400">Private boat charters, secluded resorts, and experiences unavailable to regular travelers.</p>
            </div>
        </div>
    </div>
</div>

<!-- Luxury Testimonials -->
<div class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-light text-gray-900 mb-4">Traveler <span class="font-serif italic">Testimonials</span></h2>
            <div class="w-20 h-px bg-amber-500 mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gray-50 p-8 rounded-lg">
                <div class="flex items-center mb-6">
                    <div class="flex text-amber-400 mr-3">
                        @for($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500">March 2023</span>
                </div>
                <p class="text-gray-700 italic mb-6">"The private island resort experience was beyond anything we could have imagined. Every detail was perfect, from the champagne sunset cruise to our private beach dinner under the stars."</p>
                <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Sophia R." class="w-12 h-12 rounded-full mr-4" loading="lazy">
                    <div>
                        <h4 class="font-medium text-gray-900">Sophia R.</h4>
                        <p class="text-sm text-gray-500">Komodo Luxury Cruise</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 p-8 rounded-lg">
                <div class="flex items-center mb-6">
                    <div class="flex text-amber-400 mr-3">
                        @for($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500">January 2023</span>
                </div>
                <p class="text-gray-700 italic mb-6">"Our guide's knowledge of Flores' cultural heritage brought each destination to life. The luxury safari tents with volcano views were the perfect blend of adventure and comfort."</p>
                <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/men/42.jpg" alt="James T." class="w-12 h-12 rounded-full mr-4" loading="lazy">
                    <div>
                        <h4 class="font-medium text-gray-900">James T.</h4>
                        <p class="text-sm text-gray-500">Flores Cultural Expedition</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Parallax effect with requestAnimationFrame
        let lastScroll = 0;
        function parallax() {
            const scrollPosition = window.pageYOffset;
            const parallaxBg = document.getElementById('parallax-bg');
            if (parallaxBg) {
                parallaxBg.style.transform = `translateY(${scrollPosition * 0.5}px)`;
            }
            lastScroll = scrollPosition;
            requestAnimationFrame(parallax);
        }
        window.addEventListener('scroll', () => requestAnimationFrame(parallax));

        // Marquee animation
        const marqueeContainer = document.querySelector('.marquee-container');
        const marqueeContent = document.querySelector('.marquee-content');
        if (marqueeContainer && marqueeContent && marqueeContainer.querySelectorAll('.marquee-content').length === 1) {
            const contentWidth = marqueeContent.offsetWidth;
            const duration = contentWidth / 50; // Dynamic duration based on content width
            marqueeContent.style.animationDuration = `${duration}s`;
            const copy = marqueeContent.cloneNode(true);
            marqueeContainer.appendChild(copy);
        }

        // Sort functionality
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('sort', this.value);
                window.location.href = url.toString();
            });
            
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('sort')) {
                sortSelect.value = urlParams.get('sort');
            }
        }
    });
</script>

<style>
    .luxury-select {
        @apply appearance-none bg-white border border-gray-300 rounded-md pl-4 pr-10 py-3 text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-amber-500 focus:border-amber-500;
    }
    
    .marquee-container {
        @apply overflow-hidden whitespace-nowrap;
    }
    
    .marquee-content {
        @apply inline-block whitespace-nowrap;
        animation: marquee 30s linear infinite;
    }
    
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    
    @media (prefers-reduced-motion: reduce) {
        .marquee-content {
            animation: none;
        }
    }
    
    @media (max-width: 640px) {
        .marquee-content span {
            font-size: 1.5rem;
        }
    }
</style>
@endsection