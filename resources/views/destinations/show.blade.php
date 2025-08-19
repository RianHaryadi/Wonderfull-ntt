@extends('layouts.app')

@section('title', $destination->name)

@section('content')
    <!-- Hero Section with Ken Burns Effect -->
    <header x-data="{ scrolled: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 50)"
            class="relative h-screen max-h-[36rem] overflow-hidden bg-gray-900 transition-all duration-300"
            :class="{ 'shadow-2xl': scrolled }">
        <!-- Background with Ken Burns effect -->
        <div class="absolute inset-0 ken-burns" 
             style="background-image: url('{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}');">
        </div>
        
        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/85 via-gray-900/30 to-transparent"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-end pb-16 text-center relative z-10">
            <!-- Breadcrumb with animation -->
            <nav class="hidden md:flex justify-center mb-6" aria-label="Breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <ol class="inline-flex items-center space-x-2 text-sm font-medium text-white/90">
                    <li class="inline-flex items-center">
                        <a href="/" class="inline-flex items-center hover:text-yellow-400 transition-colors duration-200">
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
                            <a href="{{ route('destinations.index') }}" class="ml-2 hover:text-yellow-400 transition-colors duration-200">Destinations</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-2 text-white font-semibold">{{ $destination->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 text-white tracking-tight drop-shadow-xl" data-aos="fade-up" data-aos-delay="400">
                {{ $destination->name }}
            </h1>
            
            <div class="flex flex-wrap justify-center items-center gap-x-6 gap-y-3 text-gray-100 text-lg mb-8" data-aos="fade-up" data-aos-delay="600">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $destination->location }}
                </div>
                <span class="hidden sm:inline text-gray-300">•</span>
                <span class="bg-white/20 backdrop-blur-md px-4 py-1.5 rounded-full text-sm font-semibold hover:bg-white/30 transition-all duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    {{ $destination->category }}
                </span>
            </div>
            
            <!-- Floating Action Buttons -->
            <div class="flex gap-4 justify-center md:justify-end mb-4" data-aos="fade-up" data-aos-delay="800">
                <a href="#booking" class="p-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </a>
                <button @click="navigator.share({ title: '{{ $destination->name }}', url: window.location.href })" 
                        class="p-3 bg-gray-800/80 text-white rounded-full shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C9.375 12.651 10.325 12.25 11.5 12.25s2.125.401 2.816 1.092m0 0l3.5 3.5m0 0l-3.5 3.5m3.5-3.5H21m-18 0H6.5m12-7.5l-3.5-3.5m0 0l3.5-3.5m-3.5 3.5H3" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Destination Details Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden lg:flex transition-all hover:shadow-2xl mb-16" data-aos="fade-up">
            <!-- Left Section: Image Gallery -->
            <div class="lg:w-1/2 p-6 flex flex-col">
                <div class="relative rounded-2xl overflow-hidden mb-4 shadow-lg">
                    <img id="main-image" 
                         src="{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}"
                         class="w-full h-96 object-cover transition-all duration-500"
                         alt="{{ $destination->name }}">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                        <a id="main-image-lightbox" 
                           href="{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}" 
                           data-lightbox="destination-gallery" 
                           class="text-white bg-black/50 rounded-full p-3 transform hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 0h-4m4 0l-5-5" />
                            </svg>
                        </a>
                    </div>
                </div>

                @if(isset($destination->gallery) && is_array($destination->gallery) && count($destination->gallery) > 0)
                    <div class="grid grid-cols-5 gap-3">
                        @foreach($destination->gallery as $image)
                            <a href="{{ asset('storage/' . $image) }}" 
                               data-lightbox="destination-gallery" 
                               class="block rounded-lg overflow-hidden border-2 border-transparent hover:border-yellow-400 transition-all focus:outline-none focus:border-yellow-500">
                                <img src="{{ asset('storage/' . $image) }}"
                                     class="w-full h-20 object-cover cursor-pointer transition-transform hover:scale-105"
                                     alt="Gallery image {{ $loop->iteration }}"
                                     onmouseover="document.getElementById('main-image').src = this.src; document.getElementById('main-image-lightbox').href = this.parentElement.href;">
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="grid grid-cols-5 gap-3">
                        <a href="{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}" 
                           data-lightbox="destination-gallery" 
                           class="block rounded-lg overflow-hidden border-2 border-yellow-400">
                            <img src="{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}"
                                 class="w-full h-20 object-cover"
                                 alt="{{ $destination->name }}">
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Right Section: Details -->
            <div class="lg:w-1/2 p-6 sm:p-8 flex flex-col">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-2" data-aos="fade-up" data-aos-delay="200">
                            Discover {{ $destination->name }}
                        </h2>
                        <div class="flex items-center space-x-4">
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
                    
                    <!-- Save Button -->
                    <button type="button" 
                            class="p-2 text-gray-400 hover:text-red-500 transition-colors duration-200" 
                            aria-label="Save to favorites" 
                            x-data="{ saved: false }" 
                            @click="saved = !saved">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" 
                             :fill="saved ? 'currentColor' : 'none'" 
                             viewBox="0 0 24 24" 
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                
                <!-- Description with Read More -->
                <div x-data="{ expanded: false }" class="mb-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="prose max-w-none text-gray-600 mb-4 relative" :class="{ 'max-h-24 overflow-hidden': !expanded }">
                        {!! Str::markdown($destination->description) !!}
                        <div x-show="!expanded" class="absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-white to-transparent"></div>
                    </div>
                    <button @click="expanded = !expanded" 
                            class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                        <span x-text="expanded ? 'Read less' : 'Read more'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="h-4 w-4 ml-1 transition-transform" 
                             :class="{ 'rotate-180': expanded }" 
                             fill="none" 
                             viewBox="0 0 24 24" 
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
                
                <!-- Key Features -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 text-center" data-aos="fade-up" data-aos-delay="600">
                    <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-blue-100 text-blue-600 rounded-full h-12 w-12 flex items-center justify-center mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800">Best Time</h4>
                        <p class="text-sm text-gray-500">Year-round</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-green-100 text-green-600 rounded-full h-12 w-12 flex items-center justify-center mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800">Safety</h4>
                        <p class="text-sm text-gray-500">Very High</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-purple-100 text-purple-600 rounded-full h-12 w-12 flex items-center justify-center mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 009.288 0M15 7a3 3 0 11-6 0 3 3 0 006 0zm6 3a2 2 0 11-4 0 2 2 0 004 0zM7 10a2 2 0 11-4 0 2 2 0 004 0z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800">Popularity</h4>
                        <p class="text-sm text-gray-500">High</p>
                    </div>
                    <div class="bg

-gray-50 p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="bg-yellow-100 text-yellow-600 rounded-full h-12 w-12 flex items-center justify-center mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800">Price</h4>
                        <p class="text-sm text-gray-500">$$ - Moderate</p>
                    </div>
                </div>
                
                <!-- Location Details -->
                <div class="mb-8" data-aos="fade-up" data-aos-delay="800">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 006 0z" />
                        </svg>
                        Location Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if ($destination->maps_url)
                            <div class="bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors">
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
                            <div class="bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors">
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
                <div class="mt-auto" data-aos="fade-up" data-aos-delay="1000">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 006 0z" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        @if($destination->latitude && $destination->longitude)
            <div class="mb-16" data-aos="fade-up" data-aos-delay="200">
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
        
        <!-- Tour Packages Section -->
        @if($destination->tourPackages->count() > 0)
            <div class="mb-16" data-aos="fade-up" data-aos-delay="600">
                <h3 class="text-3xl font-extrabold text-gray-900 mb-8 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Tour Packages
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($destination->tourPackages as $tourPackage)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all hover:shadow-xl hover:-translate-y-2 duration-300">
                            <a href="{{ route('paket-tours.show', $tourPackage->id) }}" class="block">
                                <div class="relative h-56 overflow-hidden">
                                    <img src="{{ $tourPackage->thumbnail ? asset('storage/' . ltrim($tourPackage->thumbnail, '/')) : asset('images/fallback.jpg') }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" 
                                         alt="{{ $tourPackage->name }}">
                                    <div class="absolute top-3 right-3 bg-white/80 backdrop-blur px-2 py-1 rounded-full text-xs font-medium">
                                        {{ $tourPackage->days }} Days
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h4 class="font-bold text-lg text-gray-900 mb-1">{{ $tourPackage->name }}</h4>
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $tourPackage->location }}
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-gray-900">${{ $tourPackage->price }} <span class="text-sm font-normal text-gray-500">/ person</span></span>
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-sm font-medium">{{ $tourPackage->rating }}</span>
                                            <span class="text-xs text-gray-500 ml-1">({{ $tourPackage->rating_count }})</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            scroll-behavior: smooth;
        }

        .ken-burns {
            background-size: cover;
            background-position: center;
            animation: kenburns-animation 20s ease-out infinite;
        }

        @keyframes kenburns-animation {
            0% {
                transform: scale(1) translate(0, 0);
            }
            50% {
                transform: scale(1.1) translate(5px, -5px);
            }
            100% {
                transform: scale(1) translate(0, 0);
            }
        }

        /* Custom Scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            height: 8px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 800,
                once: true,
            });
        });
    </script>
@endsection