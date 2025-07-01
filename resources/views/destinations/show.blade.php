@extends('layouts.app')

@section('title', $destination->name)

@section('content')
    <!-- Hero Section with Parallax Effect -->
    <header class="relative h-screen max-h-[32rem] overflow-hidden bg-gray-900">
        <!-- Background with parallax effect -->
        <div class="absolute inset-0 bg-[url('{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}')] bg-cover bg-center bg-no-repeat opacity-80 transform translate-y-0 transition-all duration-1000 ease-out bg-fixed"></div>
        
        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/30 to-transparent"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-end pb-16 text-center relative z-10">
            <!-- Breadcrumb -->
            <nav class="hidden md:flex justify-center mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium text-white/80">
                    <li class="inline-flex items-center">
                        <a href="/" class="inline-flex items-center hover:text-white transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('destinations.index') }}" class="ml-1 hover:text-white transition-colors">Destinations</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-white">{{ $destination->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-white tracking-tight drop-shadow-lg animate-fade-in-up">
                {{ $destination->name }}
            </h1>
            
            <div class="flex flex-wrap justify-center items-center gap-4 text-gray-100 text-lg mb-8">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $destination->location }}
                </div>
                <span class="hidden sm:inline text-gray-300">•</span>
                <span class="bg-white/20 backdrop-blur px-3 py-1 rounded-full text-sm font-medium hover:bg-white/30 transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    {{ $destination->category }}
                </span>
            </div>
            
            <!-- Floating action button for mobile -->
            <div class="md:hidden fixed bottom-6 right-6 z-50">
                <a href="#booking" class="p-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-110 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Destination Details Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden lg:flex transition-all hover:shadow-2xl mb-16">
            <!-- Left Section: Image Gallery -->
            <div class="lg:w-1/2 relative">
                <!-- Main Image with lightbox -->
                <a href="{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}" data-lightbox="destination-gallery" class="block h-64 sm:h-96 lg:h-full relative group">
                    <img src="{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}"
                         class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105"
                         alt="{{ $destination->name }}">
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </div>
                </a>
                
                <!-- Thumbnail Gallery (if additional images exist) -->
                @if(isset($destination->gallery) && is_array($destination->gallery) && count($destination->gallery) > 0)
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                        <div class="flex space-x-2 overflow-x-auto pb-2">
                            @foreach($destination->gallery as $image)
                                <a href="{{ asset('storage/' . $image) }}" data-lightbox="destination-gallery" class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $image) }}" class="w-16 h-16 object-cover rounded-sm border-2 border-white/50 hover:border-yellow-400 transition-all" alt="Gallery image {{ $loop->iteration }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Right Section: Details -->
            <div class="lg:w-1/2 p-6 sm:p-8 flex flex-col">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-2">
                            Discover {{ $destination->name }}
                        </h2>
                        <div class="flex items-center space-x-3">
                            @if ($destination->rating)
                                <div class="flex items-center bg-yellow-50 px-3 py-1 rounded-full">
                                    <span class="text-yellow-800 font-bold mr-1">{{ number_format($destination->rating, 1) }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-sm text-yellow-600 ml-1">({{ $destination->rating_count ?? 0 }})</span>
                                </div>
                            @endif
                            <span class="text-sm text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Updated {{ $destination->updated_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Save button -->
                    <button type="button" class="p-2 text-gray-400 hover:text-red-500 transition-colors" aria-label="Save to favorites">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                
                <!-- Description with read more -->
                <div class="mb-6">
                    <div class="prose max-w-none text-gray-600 mb-4">
                        {!! Str::markdown($destination->description) !!}
                    </div>
                    <button class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                        Read more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
                
                <!-- Key Features -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="flex items-start">
                        <div class="bg-blue-50 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Best Time to Visit</h4>
                            <p class="text-sm text-gray-500">Year-round</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-green-50 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Safety</h4>
                            <p class="text-sm text-gray-500">Very High</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-purple-50 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Popularity</h4>
                            <p class="text-sm text-gray-500">Very Popular</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-yellow-50 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Price Range</h4>
                            <p class="text-sm text-gray-500">$$ - Moderate</p>
                        </div>
                    </div>
                </div>
                
                <!-- Location Details -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Location Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if ($destination->maps_url)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Google Maps</h4>
                                <a href="{{ $destination->maps_url }}" target="_blank"
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors text-sm">
                                    View on Google Maps
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                        
                        @if ($destination->latitude && $destination->longitude)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Coordinates</h4>
                                <div class="text-gray-600 space-y-1 text-sm">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Latitude: {{ $destination->latitude }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Longitude: {{ $destination->longitude }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="mt-auto">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#booking"
                           class="flex-1 inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-bold rounded-lg hover:from-yellow-500 hover:to-yellow-600 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Book Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        
                        @if($destination->latitude && $destination->longitude)
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $destination->latitude }},{{ $destination->longitude }}" 
                               target="_blank"
                               class="flex-1 inline-flex items-center justify-center px-6 py-4 border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-all hover:shadow-md">
                                Get Directions
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        @if($destination->latitude && $destination->longitude)
            <div class="mb-16">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Location Map
                </h3>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <iframe 
                        class="w-full h-96"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0"
                        src="https://maps.google.com/maps?q={{ $destination->latitude }},{{ $destination->longitude }}&z=15&output=embed&markers={{ $destination->latitude }},{{ $destination->longitude }}"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        @endif

                
        <!-- Nearby Attractions -->
        <div class="mb-16">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Nearby Attractions
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @for($i = 0; $i < 3; $i++)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all hover:shadow-xl hover:-translate-y-1">
                        <a href="#" class="block">
                            <div class="relative h-48 overflow-hidden">
                                <img src="https://source.unsplash.com/random/600x400/?tourist,attraction,{{ $i }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" alt="Nearby attraction">
                                <div class="absolute top-3 right-3 bg-white/80 backdrop-blur px-2 py-1 rounded-full text-xs font-medium">
                                    2.3km away
                                </div>
                            </div>
                            <div class="p-5">
                                <h4 class="font-bold text-lg text-gray-900 mb-1">Nearby Attraction {{ $i+1 }}</h4>
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $destination->location }}
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-sm font-medium">4.{{ $i+5 }}</span>
                                        <span class="text-xs text-gray-500 ml-1">(1{{ $i+2 }}4)</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">${{ 10 + ($i*5) }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endfor
            </div>
            
            <div class="mt-8 text-center">
                <button class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all">
                    View All Nearby Attractions
                </button>
            </div>
        </div>
        
        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection