    @extends('layouts.app')

    @section('meta')
        <meta name="description" content="Discover luxury tour packages in East Nusa Tenggara with exclusive accommodations, private guides, and bespoke experiences.">
        <meta name="keywords" content="luxury tours, East Nusa Tenggara, Komodo Island, Labuan Bajo, premium travel">
        <meta property="og:title" content="Premium Tour Packages - Luxury Travel in East Nusa Tenggara">
        <meta property="og:description" content="Exclusive access to the region's most breathtaking destinations with luxury accommodations and private guides">
        <meta property="og:image" content="{{ asset('images/luxury-beach-ntt.jpg') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Premium Tour Packages - Luxury Travel in East Nusa Tenggara">
        <meta name="twitter:description" content="Exclusive access to the region's most breathtaking destinations with luxury accommodations and private guides">
        <meta name="twitter:image" content="{{ asset('images/luxury-beach-ntt.jpg') }}">
    @endsection

    @section('title', 'Premium Tour Packages | Luxury Travel in East Nusa Tenggara')

    @section('content')
        <section class="relative h-screen overflow-hidden bg-black">
            <div class="absolute inset-0 z-0">
                <video autoplay muted loop playsinline class="w-full h-full object-cover opacity-80" poster="{{ asset('images/luxury-beach-ntt.jpg') }}">
                    <source src="{{ asset('videos/hero-background.mp4') }}" type="video/mp4">
                </video>
                <noscript>
                    <img src="{{ asset('images/luxury-beach-ntt.jpg') }}" alt="Luxury travel destination in East Nusa Tenggara" class="w-full h-full object-cover opacity-80">
                </noscript>
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
            </div>

            <div class="relative z-10 h-full flex flex-col justify-center">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-light text-white mb-6 leading-tight">
                        <span class="font-serif italic block mb-2">Curated</span>
                        <span class="drop-shadow-lg">Luxury Journeys Through</span><br>
                        <span class="text-amber-300 font-medium">East Nusa Tenggara</span>
                    </h1>
                    <p class="text-xl text-gray-200 max-w-3xl mx-auto mb-10 tracking-wide">
                        Exclusive access to the region's most breathtaking destinations with luxury accommodations, private guides, and bespoke experiences
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="#tours" class="bg-amber-500 text-gray-900 px-8 py-4 rounded-full text-lg font-medium hover:bg-amber-400 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition transform hover:scale-105 shadow-lg">
                            Explore Tours
                        </a>
                        <a href="#contact" class="border border-white text-white px-8 py-4 rounded-full text-lg font-medium hover:bg-white/10 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition transform hover:scale-105">
                            Custom Itinerary
                        </a>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-10 left-0 right-0 flex flex-col items-center">
                <a href="#tours" class="animate-bounce flex flex-col items-center group">
                    <span class="text-xs text-white/80 mb-1 group-hover:text-amber-300">Explore</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white group-hover:text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>
                <div class="w-px h-16 bg-gradient-to-t from-white/10 via-white/50 to-transparent mt-2"></div>
            </div>
        </section>

        <section class="bg-black py-16 border-y border-gray-800 overflow-hidden group relative">
            <div class="relative max-w-screen-2xl mx-auto">
                <div class="marquee-wrapper">
                    <div class="marquee-track group-hover:paused group-focus-within:paused">
                        @foreach(['Komodo Island', 'Labuan Bajo', 'Flores Highlands', 'Sumba', 'Alor Archipelago', 'Pink Beach', 'Kelimutu Lakes', 'Padar Island'] as $dest)
                            <span role="link" aria-label="Explore {{ $dest }}" tabindex="0" class="text-3xl md:text-4xl text-white font-serif italic mx-10 inline-block transition transform hover:text-amber-400 hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-300">
                                {{ $dest }}
                            </span>
                            @if (!$loop->last)
                                <span class="text-3xl md:text-4xl text-white/50 font-serif mx-8">•</span>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="pointer-events-none absolute inset-y-0 left-0 w-28 bg-gradient-to-r from-black via-black/80 to-transparent z-10"></div>
                <div class="pointer-events-none absolute inset-y-0 right-0 w-28 bg-gradient-to-l from-black via-black/80 to-transparent z-10"></div>
            </div>
        </section>

        <section class="bg-white py-6 sticky top-0 z-20 border-b border-gray-200 shadow-sm transition-all duration-300" id="filters">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                    <div class="flex items-center w-full lg:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-900">Refine Your Search</h2>
                    </div>
                    
                    <form action="{{ route('paket-tours.index') }}" method="GET" class="w-full" id="tour-filter-form">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="relative group">
                                <label for="destination" class="absolute -top-2 left-3 bg-white px-1 text-xs font-medium text-gray-500">Destination</label>
                                <select id="destination" name="destination" class="luxury-select">
                                    <option value="">All Destinations</option>
                                    @foreach($destinations ?? [] as $destination)
                                        <option value="{{ $destination }}" {{ request('destination') == $destination ? 'selected' : '' }}>{{ $destination }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="relative group">
                                <label for="duration" class="absolute -top-2 left-3 bg-white px-1 text-xs font-medium text-gray-500">Duration</label>
                                <select id="duration" name="duration" class="luxury-select">
                                    <option value="">Any Duration</option>
                                    <option value="1-3" {{ request('duration') == '1-3' ? 'selected' : '' }}>1-3 Days</option>
                                    <option value="4-7" {{ request('duration') == '4-7' ? 'selected' : '' }}>4-7 Days</option>
                                    <option value="8+" {{ request('duration') == '8+' ? 'selected' : '' }}>8+ Days</option>
                                </select>
                            </div>
                            
                            <div class="relative group">
                                <label for="price" class="absolute -top-2 left-3 bg-white px-1 text-xs font-medium text-gray-500">Price Range</label>
                                <select id="price" name="price" class="luxury-select">
                                    <option value="">Any Price</option>
                                    <option value="under-1000000" {{ request('price') == 'under-1000000' ? 'selected' : '' }}>Under 1M</option>
                                    <option value="1-3" {{ request('price') == '1-3' ? 'selected' : '' }}>1M-3M</option>
                                    <option value="3-5" {{ request('price') == '3-5' ? 'selected' : '' }}>3M-5M</option>
                                    <option value="5+" {{ request('price') == '5+' ? 'selected' : '' }}>5M+</option>
                                </select>
                            </div>
                            
                            <div class="relative group">
                                <label for="category" class="absolute -top-2 left-3 bg-white px-1 text-xs font-medium text-gray-500">Category</label>
                                <select id="category" name="category" class="luxury-select">
                                    <option value="">All Categories</option>
                                    <option value="adventure" {{ request('category') == 'adventure' ? 'selected' : '' }}>Adventure</option>
                                    <option value="luxury" {{ request('category') == 'luxury' ? 'selected' : '' }}>Luxury</option>
                                    <option value="family" {{ request('category') == 'family' ? 'selected' : '' }}>Family</option>
                                    <option value="honeymoon" {{ request('category') == 'honeymoon' ? 'selected' : '' }}>Honeymoon</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-300 transform hover:scale-[1.02]" aria-label="Apply filter settings">
                                Apply Filters
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 py-16" id="tours">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
                <div>
                    <h2 class="text-3xl font-light text-gray-900">
                        @if(request()->hasAny(['q', 'destination', 'price', 'duration', 'category']))
                            {{ $paketTours->total() }} Exclusive Experiences
                        @else
                            Our <span class="font-serif italic">Signature</span> Journeys
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
                <div class="flex items-center w-full md:w-auto">
                    <span class="text-sm text-gray-500 mr-3">Sort by:</span>
                    <div class="relative flex-grow md:flex-grow-0">
                        <label for="sort-select" class="sr-only">Sort by</label>
                        <select id="sort-select" class="luxury-select" onchange="window.location.href = this.value" aria-label="Sort tour packages">
                            <option value="{{ route('paket-tours.index', array_merge(request()->query(), ['sort' => 'popular'])) }}" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Exclusive</option>
                            <option value="{{ route('paket-tours.index', array_merge(request()->query(), ['sort' => 'price-asc'])) }}" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ route('paket-tours.index', array_merge(request()->query(), ['sort' => 'price-desc'])) }}" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="{{ route('paket-tours.index', array_merge(request()->query(), ['sort' => 'duration'])) }}" {{ request('sort') == 'duration' ? 'selected' : '' }}>Duration</option>
                            <option value="{{ route('paket-tours.index', array_merge(request()->query(), ['sort' => 'rating'])) }}" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($paketTours as $paket)
                    <article class="group relative bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1" role="region" aria-label="{{ $paket->name }} tour package">
                        <div class="relative h-72 overflow-hidden">
                            @if($paket->thumbnail)
                                <img src="{{ asset('storage/' . $paket->thumbnail) }}" 
                                    alt="{{ $paket->name }} tour"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                    loading="{{ $loop->index < 3 ? 'eager' : 'lazy' }}"
                                    width="400"
                                    height="288">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                                <a href="{{ route('paket-tour.create', $paket) }}"
                                class="ml-2 bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-800 focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all transform group-hover:translate-y-0 duration-300 shadow-lg"
                                aria-label="Book {{ $paket->name }}">
                                    Book Now
                                </a>
                            </div>
                            @if($paket->is_featured)
                                <div class="absolute top-4 right-4 bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                    Featured
                                </div>
                            @endif
                            @if($paket->category)
                                <div class="absolute top-4 left-4 bg-gray-900/80 text-white text-xs font-medium px-3 py-1 rounded-full backdrop-blur-sm">
                                    {{ ucfirst($paket->category) }}
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-light text-gray-900">{{ $paket->name }}</h3>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $paket->location }}
                                </div>
                            </div>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $paket->days }} {{ Str::plural('day', $paket->days) }}
                                @if($paket->includes_hotel)
                                    <span class="ml-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Hotel Included
                                    </span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if($paket->price)
                                            <span class="text-xl font-light text-gray-900">
                                                IDR {{ number_format($paket->price, 0, ',', '.') }}
                                            </span>
                                            <span class="block text-xs text-gray-500 mt-1">per person</span>
                                        @else
                                            <span class="text-lg font-light text-gray-900">Contact for pricing</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <p class="text-gray-500 text-sm mb-4 line-clamp-2">
                                {{ $paket->description }}
                            </p>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center">
                                    <div class="flex text-amber-400 mr-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="{{ $i <= floor($paket->rating ?? 0) ? 'currentColor' : 'none' }}" stroke="currentColor" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500">({{ $paket->rating_count ?? 0 }} reviews)</span>
                                </div>
                                <a href="{{ route('paket-tours.show', $paket->id) }}" class="text-sm font-medium text-gray-900 hover:text-amber-600 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition flex items-center group" aria-label="Explore {{ $paket->name }} tour">
                                    Explore
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-700 mt-6">No matching tours found</h3>
                        <p class="text-gray-500 text-sm mt-2 max-w-md mx-auto">
                            We couldn't find any tours
                            @if (request('destination'))
                                for {{ request('destination') }}.
                            @else
                                matching your filters.
                            @endif
                            Try adjusting your filters or contact our concierge for a custom itinerary.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('paket-tours.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-300" aria-label="Reset all filters">
                                Reset all filters
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
            
            @if($paketTours->hasPages())
                <div class="mt-16">
                    {{ $paketTours->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </section>

        <section class="bg-black text-white py-24" aria-label="East Nusa Tenggara Experience">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-light mb-4">The <span class="font-serif italic text-amber-300">East Nusa Tenggara</span> Experience</h2>
                    <div class="w-20 h-px bg-amber-500 mx-auto"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    @foreach([
                        ['title' => 'Unparalleled Beauty', 'description' => 'Discover pristine beaches, dramatic landscapes, and vibrant marine life in Indonesia\'s last paradise.', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                        ['title' => 'Tailored Itineraries', 'description' => 'Our travel designers craft personalized journeys to match your interests and travel style.', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['title' => 'Exclusive Access', 'description' => 'Private boat charters, secluded resorts, and experiences unavailable to regular travelers.', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z']
                    ] as $feature)
                        <div class="text-center px-6 transform hover:scale-105 transition duration-300">
                            <div class="bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-400 group-hover:rotate-12 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feature['icon'] }}" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-light mb-3">{{ $feature['title'] }}</h3>
                            <p class="text-gray-400">{{ $feature['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-white py-24" aria-label="Traveler Testimonials">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-light text-gray-900 mb-4">Traveler <span class="font-serif italic text-amber-600">Testimonials</span></h2>
                    <div class="w-20 h-px bg-amber-500 mx-auto"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach([
                        ['name' => 'Sophia R.', 'tour' => 'Komodo Luxury Cruise', 'date' => 'June 2025', 'quote' => 'The private island resort experience was beyond anything we could have imagined. Every detail was perfect, from the champagne sunset cruise to our private beach dinner under the stars.', 'image' => 'https://randomuser.me/api/portraits/women/65.jpg', 'rating' => 5],
                        ['name' => 'James T.', 'tour' => 'Flores Cultural Expedition', 'date' => 'May 2025', 'quote' => 'Our guide\'s knowledge of Flores\' cultural heritage brought each destination to life. The luxury safari tents with volcano views were the perfect blend of adventure and comfort.', 'image' => 'https://randomuser.me/api/portraits/men/42.jpg', 'rating' => 4],
                        ['name' => 'Emma & David L.', 'tour' => 'Sumba Luxury Escape', 'date' => 'April 2025', 'quote' => 'Celebrating our anniversary in Sumba was magical. The private villa with infinity pool overlooking the ocean and personalized service made it unforgettable.', 'image' => 'https://randomuser.me/api/portraits/women/44.jpg', 'rating' => 5]
                    ] as $testimonial)
                        <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center mb-6">
                                <div class="flex text-amber-400 mr-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="{{ $i <= $testimonial['rating'] ? 'currentColor' : 'none' }}" stroke="currentColor" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500">{{ $testimonial['date'] }}</span>
                            </div>
                            <blockquote class="text-gray-700 italic mb-6">"{{ $testimonial['quote'] }}"</blockquote>
                            <div class="flex items-center">
                                <img src="{{ $testimonial['image'] }}" alt="Portrait of {{ $testimonial['name'] }}" class="w-12 h-12 rounded-full mr-4" loading="lazy" width="48" height="48">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $testimonial['name'] }}</h4>
                                    <p class="text-sm text-gray-500">{{ $testimonial['tour'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="relative bg-gray-900 py-24 overflow-hidden" id="contact" aria-label="Call to Action">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/beach-sunset.jpg') }}" 
                    alt="Beach sunset in East Nusa Tenggara" 
                    class="w-full h-full object-cover opacity-30"
                    loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-900/90 to-gray-900/60"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl md:text-4xl font-light text-white mb-6">
                        Ready for Your <span class="font-serif italic text-amber-300">Luxury Adventure</span>?
                    </h2>
                    <p class="text-xl text-gray-200 max-w-3xl mx-auto mb-10 tracking-wide">
                        Contact our travel specialists to create your personalized East Nusa Tenggara experience
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="#" class="bg-amber-500 text-gray-900 px-8 py-4 rounded-full text-lg font-medium hover:bg-amber-400 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-amber-500/30" aria-label="Enquire about luxury tours">
                            Enquire Now
                        </a>
                        <a href="tel:+62361234567" class="border border-white text-white px-8 py-4 rounded-full text-lg font-medium hover:bg-white/10 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 flex items-center justify-center" aria-label="Call +62 361 234567 for booking">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            +62 361 234567
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <style>
        .luxury-select {
            width: 100%; padding-left: 1rem; padding-right: 1rem; padding-top: 0.75rem; padding-bottom: 0.75rem;
            border-radius: 0.5rem; border-width: 1px; border-color: #e5e7eb; color: #4b5563;
            font-size: 0.875rem; line-height: 1.25rem; background-color: #ffffff;
            transition: all 0.3s ease; appearance: none; -webkit-appearance: none; -moz-appearance: none;
            background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="%236b7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"%3e%3cpath d="M6 8l4 4 4-4"/%3e%3c/svg%3e');
            background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1em 1em;
        }
        .luxury-select:focus {
            box-shadow: 0 0 0 2px #f59e0b; border-color: #f59e0b; outline: none;
        }
        .marquee-wrapper {
            overflow: hidden; white-space: nowrap; position: relative;
        }
        .marquee-track {
            display: inline-block; white-space: nowrap; animation: marquee 40s linear infinite;
        }
        .group:hover .marquee-track, .group:focus-within .marquee-track {
            animation-play-state: paused;
        }
        [role="link"]:focus {
            outline: none; box-shadow: 0 0 0 2px #fff, 0 0 0 4px #f59e0b; border-radius: 0.25rem;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Smooth Scroll for Anchors ---
            document.querySelectorAll('a[href^="#"]').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const id = link.getAttribute('href').substring(1);
                    const target = document.getElementById(id);
                    if (target) {
                        const offset = document.getElementById('filters')?.offsetHeight || 80;
                        const top = target.getBoundingClientRect().top + window.scrollY - offset;
                        window.scrollTo({ top, behavior: 'smooth' });
                        target.setAttribute('tabindex', '-1');
                        target.focus({ preventScroll: true });
                    }
                });
            });

            // --- Marquee Setup (with duplication for seamless loop) ---
            const marqueeWrapper = document.querySelector('.marquee-wrapper');
            if (marqueeWrapper) {
                const track = marqueeWrapper.querySelector('.marquee-track');
                if(track) {
                    const content = Array.from(track.children);
                    content.forEach(item => {
                        const clone = item.cloneNode(true);
                        clone.setAttribute('aria-hidden', 'true');
                        track.appendChild(clone);
                    });
                }
            }
            
            // --- Debounced Filter Submit ---
            const filterForm = document.getElementById('tour-filter-form');
            if (filterForm) {
                const submitForm = () => filterForm.submit();
                filterForm.querySelectorAll('select').forEach(select => {
                    select.addEventListener('change', submitForm);
                });
            }
            
            // --- Lazy Load Images ---
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.removeAttribute('loading');
                            observer.unobserve(img);
                        }
                    });
                }, { rootMargin: '200px' });

                document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                    imageObserver.observe(img);
                });
            }

            // --- Video Optimization ---
            const video = document.querySelector('video');
            if (video) {
                const playVideo = () => {
                    if (video.paused) {
                        video.play().catch(() => {
                            video.muted = true;
                            video.play();
                        });
                    }
                };
                const videoObserver = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        entry.isIntersecting ? playVideo() : video.pause();
                    });
                }, { threshold: 0.5 });
                videoObserver.observe(video);
                document.addEventListener('click', playVideo, { once: true });
            }
        });
        </script>
    @endsection