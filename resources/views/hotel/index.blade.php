    @extends('layouts.app')

    @section('title', 'All Hotels')

    @section('content')
    <!-- Hero Section with Enhanced Animation -->
    <div class="relative bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?nature')] bg-cover bg-center opacity-20 animate-bg-zoom"></div>
        
        <div class="max-w-7xl mx-auto py-20 px-4 sm:py-28 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Main Heading with Slide and Fade Animation -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white mb-6 animate-slide-up">
                Find Your 
                <span class="relative text-yellow-300 group">
                    Perfect Stay
                </span>
            </h1>

            <!-- Animated underline with dynamic width expansion -->
            <div class="mx-auto mb-8 h-1 w-0 bg-yellow-400 rounded-full animate-expand-underline"></div>

            <!-- Subheading with delayed fade and subtle bounce -->
            <p class="text-lg sm:text-xl text-blue-100 max-w-3xl mx-auto animate-fade-in-bounce">
                From coastal retreats to mountain hideaways, explore top-rated hotels handpicked for your unforgettable journey through 
                <span class="font-semibold text-white">East Nusa Tenggara</span>.
            </p>
        </div>
    </div>


    <!-- Search Filters -->
    <div class="max-w-7xl mx-auto px-4 py-10">
        <form method="GET" action="{{ route('hotels.index') }}" id="search-form">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 md:p-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12m0 0L17.657 7.757M6.343 7.757L10.586 12m0 0L6.343 16.243" />
                    </svg>
                    Filter Your Stay
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Select Location</label>
                        <div class="relative">
                            <select id="location" name="location"
                                    class="appearance-none block w-full bg-white border border-gray-300 rounded-md py-2 pl-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">All Locations</option>
                                @foreach($hotels->pluck('location')->unique() as $loc)
                                    @if($loc)
                                        <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>
                                            {{ $loc }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.894.553l4 8a1 1 0 01-.788 1.447H5.894a1 1 0 01-.788-1.447l4-8A1 1 0 0110 3zm0 4a1 1 0 10-.001 2.001A1 1 0 0010 7z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16l-4-4m0 0l4-4m-4 4h16"/>
                            </svg>
                            Search Hotels
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Hotel Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($hotels as $hotel)
                @php
                    $prices = [
                        $hotel->single_room_price ?? 999999999,
                        $hotel->double_room_price ?? 999999999,
                        $hotel->family_room_price ?? 999999999,
                    ];
                    $minPrice = min(array_filter($prices, fn($val) => $val !== null));
                @endphp

                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition duration-300 group relative overflow-hidden">
                    <!-- Image -->
                    <div class="relative overflow-hidden">
                        <img src="{{ $hotel->image ? asset('storage/' . $hotel->image) : asset('images/hotel-fallback.jpg') }}"
                            alt="{{ $hotel->name }}"
                            class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105">
                        <!-- Price Tag -->
                        <div class="absolute top-3 right-3 bg-blue-600 text-white text-xs px-3 py-1 rounded-full shadow-md">
                            Start from Rp {{ number_format($minPrice, 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6 flex flex-col">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $hotel->name }}</h2>
                            <div class="flex items-center text-sm text-gray-500 mt-1">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.657 16.657L13.414 12l4.243-4.243M6.343 7.757L10.586 12l-4.243 4.243"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                </svg>
                                {{ $hotel->location }}
                            </div>
                            <p class="text-sm text-gray-600 mt-2">{{ \Illuminate\Support\Str::limit($hotel->description, 90) }}</p>
                            @if($hotel->facilities)
                                <p class="text-sm text-gray-500 mt-1">
                                    <span class="font-semibold">Facilities:</span> {{ \Illuminate\Support\Str::limit($hotel->facilities, 50) }}
                                </p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between gap-2 pt-4">
                            <a href="#" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm px-4 py-2 rounded-md hover:bg-gray-200 transition font-semibold">
                                View Details
                            </a>
                            <a href="{{ route('hotels.book', ['hotel' => $hotel->id]) }}" class="flex-1 text-center bg-blue-600 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-700 transition font-semibold">
                                    Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500 py-20">
                    <p>No hotels found at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
    @endsection


    <!-- Custom-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('location').addEventListener('change', () => {
                document.getElementById('search-form').submit();
            });
        });
    </script>
    <!-- Custom Tailwind Animations -->
    <style>
    @layer utilities {
        /* Slide up and fade in animation */
        .animate-slide-up {
            animation: slideUp 1s ease-out forwards;
        }

        @keyframes slideUp {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Underline expansion animation */
        .animate-expand-underline {
            animation: expandUnderline 1.2s ease-out 0.5s forwards;
        }

        @keyframes expandUnderline {
            0% {
                width: 0;
            }
            100% {
                width: 100px;
            }
        }

        /* Fade in with slight bounce for subheading */
        .animate-fade-in-bounce {
            animation: fadeInBounce 1.5s ease-out 0.8s forwards;
            opacity: 0;
        }

        @keyframes fadeInBounce {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            60% {
                opacity: 0.7;
                transform: translateY(-5px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Background subtle zoom effect */
        .animate-bg-zoom {
            animation: bgZoom 20s ease-in-out infinite;
        }

        @keyframes bgZoom {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
    }
    </style>
