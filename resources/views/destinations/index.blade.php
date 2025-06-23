@extends('layouts.app')

@section('title', 'Destinations')

@section('content')
    <!-- Hero Section -->
    <header class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Explore <span class="text-yellow-300">NTT</span> Destinations
            </h1>
            <p class="text-xl max-w-3xl mx-auto mb-8">
                Discover the breathtaking beauty of East Nusa Tenggara's islands, beaches, and cultural heritage
            </p>

            <!-- Search Box -->
            <form action="{{ route('destinations.index') }}" method="GET"
                  class="search-box mx-auto bg-white rounded-full px-4 py-2 flex items-center shadow-lg max-w-xl">
                <i class="fas fa-search text-gray-400 mr-2"></i>
                <input type="text" name="search" placeholder="Search destinations..."
                       class="flex-grow outline-none text-gray-800"
                       value="{{ request('search') }}">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition">
                    Search
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main id="destinations" class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Section Title -->
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                All <span class="text-blue-600">Destinations</span>
            </h2>
            <div class="mt-2 h-1 w-20 bg-yellow-400 mx-auto"></div>
            <p class="mt-4 max-w-3xl mx-auto text-lg text-gray-600">
                Discover all the amazing places in NTT, from stunning beaches to cultural sites.
            </p>
        </div>

        @php
            $currentCategory = request('category');
            $categories = ['All', 'Beach', 'Mountain', 'Culture', 'Nature'];
        @endphp

        <div class="mb-12">
            <!-- Title and Result Count -->
            <div class="text-center md:text-left mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Explore Destinations</h2>
                <p class="text-gray-600">
                    Showing {{ $destinations->total() }} amazing place{{ $destinations->total() > 1 ? 's' : '' }}
                    @if ($currentCategory)
                        in <span class="font-semibold text-blue-600">"{{ $currentCategory }}"</span>
                    @endif
                </p>
            </div>

            <!-- Filter Buttons -->
            <div class="flex flex-nowrap md:flex-wrap gap-2 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-gray-300">
                @foreach ($categories as $category)
                    @php
                        $isActive = ($category === 'All' && !$currentCategory) || ($category !== 'All' && $currentCategory === $category);
                        $params = ['search' => request('search')];
                        if ($category !== 'All') $params['category'] = $category;
                    @endphp
                    <a href="{{ route('destinations.index', array_filter($params)) }}"
                       class="whitespace-nowrap px-5 py-2 rounded-full text-sm font-medium transition border
                              {{ $isActive ? 'bg-blue-600 text-white border-blue-600 shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border-gray-300' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Destinations Grid -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($destinations as $destination)
                <div class="island-card rounded-xl overflow-hidden shadow-lg transition duration-500 ease-in-out transform hover:-translate-y-1">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}"
                             class="w-full h-full object-cover transition duration-300 hover:scale-110"
                             alt="{{ $destination->name }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                        <div class="absolute bottom-0 left-0 p-6 text-white">
                            <h3 class="text-xl font-bold">{{ $destination->name }}</h3>
                            <p class="text-sm opacity-90">{{ $destination->location }}</p>
                        </div>
                        <span class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                            {{ $destination->category }}
                        </span>
                    </div>
                    <div class="p-6 bg-white">
                        <p class="text-sm text-gray-600">
                            {{ \Illuminate\Support\Str::limit($destination->description, 100) }}
                        </p>
                        <div class="mt-4 flex justify-between items-center">
                            <a href="#"
                               class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                Jelajahi Lebih Lanjut →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-600">No destinations found.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($destinations->hasPages())
            @php
                $current = $destinations->currentPage();
                $last = $destinations->lastPage();
                $queryString = http_build_query(request()->except('page'));
                $query = $queryString ? '&' . $queryString : '';
            @endphp

            <div class="mt-16 flex flex-col items-center space-y-5">
                <div class="text-sm text-gray-500">
                    Page <span class="font-semibold text-gray-800">{{ $current }}</span>
                    of <span class="font-semibold text-gray-800">{{ $last }}</span> —
                    Showing <span class="font-semibold text-gray-800">{{ $destinations->count() }}</span>
                    of <span class="font-semibold text-gray-800">{{ $destinations->total() }}</span> destinations
                </div>

                <nav class="flex flex-wrap items-center justify-center gap-2 bg-white p-3 rounded-lg shadow border border-gray-200">
                    @if ($current > 3)
                        <a href="{{ $destinations->url(1) . $query }}"
                           class="px-3 py-1 text-xs md:text-sm rounded bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                            « First
                        </a>
                    @endif

                    @if ($destinations->onFirstPage())
                        <span class="px-3 py-1 text-xs md:text-sm rounded bg-gray-100 text-gray-400">← Prev</span>
                    @else
                        <a href="{{ $destinations->previousPageUrl() . $query }}"
                           class="px-3 py-1 text-xs md:text-sm rounded bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                            ← Prev
                        </a>
                    @endif

                    @foreach ($destinations->getUrlRange(
                        max(1, $current - 2),
                        min($last, $current + 2)
                    ) as $page => $url)
                        @if ($page == $current)
                            <span class="px-3 py-1 text-xs md:text-sm rounded bg-blue-600 text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url . $query }}"
                               class="px-3 py-1 text-xs md:text-sm rounded bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($destinations->hasMorePages())
                        <a href="{{ $destinations->nextPageUrl() . $query }}"
                           class="px-3 py-1 text-xs md:text-sm rounded bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                            Next →
                        </a>
                    @else
                        <span class="px-3 py-1 text-xs md:text-sm rounded bg-gray-100 text-gray-400">Next →</span>
                    @endif

                    @if ($current < $last - 2)
                        <a href="{{ $destinations->url($last) . $query }}"
                           class="px-3 py-1 text-xs md:text-sm rounded bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-600">
                            Last »
                        </a>
                    @endif
                </nav>
            </div>
        @endif
    </main>
@endsection