]@extends('layouts.app')

@section('title', 'Destinations')

@section('content')
    <!-- Hero Section with Parallax Effect -->
    <header class="relative h-96 overflow-hidden bg-gray-900">
        <div class="parallax-bg absolute inset-0 bg-[url('https://images.unsplash.com/photo-1505228395891-9a51e7e86bf6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')] bg-cover bg-center bg-no-repeat opacity-70 transform translate-y-0"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center text-center relative z-10">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-white tracking-tight">
                Discover <span class="text-yellow-400">NTT's</span> Hidden Gems
            </h1>
            <p class="text-xl max-w-3xl mx-auto mb-8 text-gray-100">
                Explore the breathtaking landscapes, pristine beaches, and rich cultural heritage of East Nusa Tenggara
            </p>

            <!-- Search Box with Glassmorphism Effect -->
            <form action="{{ route('destinations.index') }}" method="GET"
                  class="search-box mx-auto bg-white/10 backdrop-blur-md rounded-xl px-6 py-3 flex flex-col sm:flex-row items-center gap-4 shadow-2xl max-w-3xl border border-white/20">
                <div class="flex items-center w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-200 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" placeholder="Search destinations..."
                           class="flex-grow sm:flex-grow-0 outline-none bg-transparent text-white placeholder-gray-300 w-full sm:w-64"
                           value="{{ request('search') }}">
                </div>
                <button type="submit"
                        class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 px-6 py-2 rounded-lg hover:from-yellow-500 hover:to-yellow-600 transition-all font-medium shadow-lg">
                    Search
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main id="destinations" class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Section Title with Decorative Elements -->
        <div class="mb-16 text-center relative">
            <div class="absolute left-1/2 transform -translate-x-1/2 -top-8 w-24 h-1 bg-gradient-to-r from-transparent via-yellow-400 to-transparent"></div>
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl relative inline-block">
                <span class="relative z-10 px-4 bg-white">
                    Our <span class="text-blue-600">Destinations</span>
                </span>
                <span class="absolute left-0 right-0 top-1/2 h-0.5 bg-gray-200 -z-1"></span>
            </h2>
            <p class="mt-6 max-w-3xl mx-auto text-lg text-gray-600 leading-relaxed">
                From the pink beaches of Padar to the ancient villages of Flores, discover all the amazing places that make NTT special.
            </p>
        </div>

        @php
            $currentCategory = request('category', 'All');
            $categories = ['All', 'Beach', 'Mountain', 'Culture', 'Nature'];
        @endphp

        <!-- Filter Section -->
        <div class="mb-16 bg-gray-50 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Find Your Perfect Destination</h2>
                    <p class="text-gray-600 mt-1">
                        {{ $destinations->total() }} amazing place{{ $destinations->total() > 1 ? 's' : '' }} found
                        @if ($currentCategory && $currentCategory !== 'All')
                            in <span class="font-semibold text-blue-600">"{{ $currentCategory }}"</span>
                        @endif
                        @if (request('is_popular'))
                            <span class="font-semibold text-blue-600">Popular destinations</span>
                        @endif
                        @if (request('min_price') || request('max_price'))
                            with price
                            @if (request('min_price'))
                                from ${{ number_format(request('min_price'), 2) }}
                            @endif
                            @if (request('max_price'))
                                up to ${{ number_format(request('max_price'), 2) }}
                            @endif
                        @endif
                        @if (request('min_rating') || request('max_rating'))
                            with rating
                            @if (request('min_rating'))
                                {{ request('min_rating') }}+
                            @endif
                            @if (request('max_rating'))
                                up to {{ request('max_rating') }}
                            @endif
                        @endif
                    </p>
                </div>

                <!-- Filter Buttons with Icons -->
                <div class="flex flex-nowrap md:flex-wrap gap-3 overflow-x-auto pb-3 scrollbar-thin scrollbar-thumb-gray-300">
                    @foreach ($categories as $category)
                        @php
                            $isActive = ($category === 'All' && !$currentCategory) || ($currentCategory === $category);
                            $params = array_filter([
                                'search' => request('search'),
                                'min_price' => request('min_price'),
                                'max_price' => request('max_price'),
                                'min_rating' => request('min_rating'),
                                'max_rating' => request('max_rating'),
                                'is_popular' => request('is_popular'),
                                'category' => $category !== 'All' ? $category : null,
                            ]);
                            $icons = [
                                'All' => 'grid',
                                'Beach' => 'umbrella-beach',
                                'Mountain' => 'mountain',
                                'Culture' => 'landmark',
                                'Nature' => 'tree'
                            ];
                        @endphp
                        <a href="{{ route('destinations.index', $params) }}"
                           class="whitespace-nowrap px-5 py-2.5 rounded-lg text-sm font-medium transition-all flex items-center gap-2
                                  {{ $isActive ? 'bg-gradient-to-br from-blue-600 to-blue-800 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 shadow-sm' }}">
                            <i class="fas fa-{{ $icons[$category] }} w-4 h-4"></i>
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Destinations Grid -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($destinations as $destination)
                <div class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 ease-in-out transform hover:-translate-y-2">
                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}"
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                             alt="{{ $destination->name ?? 'Destination' }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-90"></div>
                        <div class="absolute bottom-0 left-0 p-6 text-white">
                            <h3 class="text-xl font-bold">{{ $destination->name ?? 'Unknown' }}</h3>
                            <div class="flex items-center mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-sm opacity-90">{{ $destination->location ?? 'Unknown Location' }}</p>
                            </div>
                            @if ($destination->maps_url)
                                <a href="{{ $destination->maps_url }}" target="_blank" class="text-sm text-yellow-400 hover:underline mt-1 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                    View on Map
                                </a>
                            @endif
                        </div>
                        <span class="absolute top-4 right-4 bg-white/90 backdrop-blur text-gray-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                            {{ $destination->category ?? 'N/A' }}
                        </span>
                        @if ($destination->is_popular)
                            <span class="absolute top-4 left-4 bg-yellow-400 text-gray-900 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                Popular
                            </span>
                        @endif
                    </div>
                    <div class="p-6 bg-white">
                        <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                            {{ $destination->description ?? 'No description available.' }}
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center text-yellow-400">
                                @if ($destination->rating)
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $i <= round($destination->rating) ? 'fill-current' : 'fill-current opacity-30' }}" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                    <span class="text-xs text-gray-500 ml-1">({{ $destination->rating_count ?? 0 }})</span>
                                @else
                                    <span class="text-xs text-gray-500">No ratings yet</span>
                                @endif
                            </div>
                            @if ($destination->price)
                                <span class="text-sm font-semibold text-gray-800">Rp{{ number_format($destination->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-4 mt-6">
                            <a href="{{ route('destinations.show', $destination->id) }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold text-sm rounded-2xl shadow-lg transition-all duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span>Show Details</span>
                            </a>
                            <a href="{{ route('destinations.book', ['destination' => $destination->id]) }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-gray-900 font-semibold text-sm rounded-2xl shadow-lg transition-all duration-300 group"
                               aria-label="Book {{ $destination->name ?? 'Destination' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Book Now</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No destinations found</h3>
                    <p class="mt-1 text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                    <a href="{{ route('destinations.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Reset filters
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($destinations->hasPages())
            @php
                $current = $destinations->currentPage();
                $last = $destinations->lastPage();
                $queryString = http_build_query(array_filter(request()->except('page')));
                $query = $queryString ? '&' . $queryString : '';
            @endphp

            <div class="mt-20">
                <div class="flex flex-col items-center">
                    <div class="text-sm text-gray-500 mb-6">
                        Showing <span class="font-semibold text-gray-800">{{ $destinations->firstItem() }}</span>
                        to <span class="font-semibold text-gray-800">{{ $destinations->lastItem() }}</span>
                        of <span class="font-semibold text-gray-800">{{ $destinations->total() }}</span> destinations
                    </div>

                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        @if ($current > 3)
                            <a href="{{ $destinations->url(1) . $query }}"
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">First</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        @if ($destinations->onFirstPage())
                            <span class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $destinations->previousPageUrl() . $query }}"
                               class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        @foreach ($destinations->getUrlRange(max(1, $current - 2), min($last, $current + 2)) as $page => $url)
                            @if ($page == $current)
                                <a href="{{ $url . $query }}" aria-current="page"
                                   class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    {{ $page }}
                                </a>
                            @else
                                <a href="{{ $url . $query }}"
                                   class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        @if ($destinations->hasMorePages())
                            <a href="{{ $destinations->nextPageUrl() . $query }}"
                               class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif

                        @if ($current < $last - 2)
                            <a href="{{ $destinations->url($last) . $query }}"
                               class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Last</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                    </nav>
                </div>
            </div>
        @endif
    </main>

    <script>
        // Simple parallax effect for hero section
        document.addEventListener('scroll', function() {
            const scrollPosition = window.pageYOffset;
            const parallaxBg = document.querySelector('.parallax-bg');
            if (parallaxBg) {
                parallaxBg.style.transform = `translateY(${scrollPosition * 0.3}px)`;
            }
        });
    </script>
@endsection