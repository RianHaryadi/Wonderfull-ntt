@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Enhanced Hero Section -->
<section id="home" class="relative h-screen flex items-center justify-center text-white overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1566438480900-0609be27a4be?ixlib=rb-4.0.3&auto=format&fit=crop&w=2094&q=80" 
             class="w-full h-full object-cover brightness-50" alt="NTT Beach Landscape" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-teal-700/70"></div>
    </div>
    
    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
        <h1 class="text-4xl md:text-7xl font-extrabold mb-6 leading-tight animate__animated animate__fadeInUp">
            Unveil the <span class="text-yellow-300 bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-yellow-500">Secret Wonders</span> of Eastern Indonesia
        </h1>
        <p class="text-lg md:text-2xl mb-8 text-gray-100 animate__animated animate__fadeInUp animate__delay-1s">
            Embark on a journey through pristine beaches, vibrant cultures, and awe-inspiring landscapes in East Nusa Tenggara.
        </p>
        <div class="flex flex-wrap justify-center gap-4 animate__animated animate__fadeInUp animate__delay-2s">
            <a href="#destinations" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl">
                <i class="fas fa-map-marked-alt mr-2"></i> Discover Destinations
            </a>
            <a href="#culture" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-900 text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl">
                <i class="fas fa-masks-theater mr-2"></i> Immerse in Culture
            </a>
        </div>
    </div>
    
    <div class="absolute bottom-10 left-0 right-0 text-center animate-bounce">
        <a href="#destinations" class="inline-block text-white">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </a>
    </div>
</section>

<!-- Enhanced Destinations Section -->
<section id="destinations" class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                <span class="block">Explore Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-teal-600">Top Destinations</span></span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-yellow-500 mx-auto rounded-full"></div>
            <p class="mt-6 max-w-3xl mx-auto text-gray-600 text-xl">
                Discover must-visit spots that showcase the breathtaking beauty and rich heritage of East Nusa Tenggara.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($destinations as $destination)
                <div class="group flex flex-col justify-between relative overflow-hidden rounded-2xl shadow-xl transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">
                    {{-- Bagian Atas Kartu (Gambar & Info Awal) --}}
                    <div>
                        <div class="relative h-72 overflow-hidden">
                            <img src="{{ $destination->image ? asset('storage/' . $destination->image) : asset('images/fallback.jpg') }}"
                                 alt="{{ $destination->name }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                 loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                            
                            <div class="absolute bottom-0 left-0 p-6 text-white z-20">
                                <h3 class="text-2xl font-bold">{{ $destination->name }}</h3>
                                <p class="text-sm opacity-90 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2"></i> {{ $destination->location }}
                                </p>
                            </div>
                            
                            <span class="absolute top-4 right-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg z-20">
                                {{ $destination->category }}
                            </span>

                            @if($destination->is_popular)
                                <span class="absolute top-4 left-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg z-20 flex items-center">
                                    <i class="fas fa-fire mr-1.5"></i> Popular
                                </span>
                            @endif
                            
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-30">
                                <a href="{{ route('destinations.show', $destination) }}" class="bg-white text-blue-600 px-6 py-3 rounded-full font-bold hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:scale-105">
                                    Explore Now <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="bg-white p-6">
                            <p class="text-gray-600 mb-4 leading-relaxed h-14">
                                {{ \Illuminate\Support\Str::limit($destination->description, 120) }}
                            </p>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400">
                                        @php
                                            $rating = $destination->rating ?? 0;
                                            $fullStars = floor($rating);
                                            $halfStar = ($rating - $fullStars) >= 0.5;
                                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                        @endphp
                                        @for ($i = 0; $i < $fullStars; $i++) <i class="fas fa-star"></i> @endfor
                                        @if ($halfStar) <i class="fas fa-star-half-alt"></i> @endif
                                        @for ($i = 0; $i < $emptyStars; $i++) <i class="far fa-star"></i> @endfor
                                    </div>
                                    @if($destination->rating_count > 0)
                                        <span class="text-gray-500 ml-2 text-sm">
                                            {{ number_format($destination->rating, 1) }} ({{ $destination->rating_count >= 1000 ? number_format($destination->rating_count / 1000, 1) . 'k' : $destination->rating_count }})
                                        </span>
                                    @endif
                                </div>
                                <span class="text-blue-600 font-bold text-lg">
                                    IDR {{ number_format($destination->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white px-6 pb-6 pt-2">
                        <a href="{{ route('destinations.show', $destination) }}" 
                           class="block w-full text-center bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Book Now
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="inline-block p-8 bg-white rounded-2xl shadow-lg">
                        <i class="fas fa-map-marked-alt text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 text-lg">
                            Belum ada destinasi populer yang tersedia saat ini.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
        
        <div class="mt-16 text-center">
            <a href="{{ route('destinations.index') }}"
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-full hover:shadow-xl transition-all duration-300 transform hover:scale-105 shadow-lg text-lg font-semibold">
                Lihat Semua Destinasi
                <svg class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Luxury Stays Carousel -->
<section id="luxury-stays" class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-16">
            <div class="flex flex-col gap-6 text-center">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900">
                    Luxury <span class="text-blue-600">Stays & Retreats</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-md mx-auto">
                    Experience unparalleled comfort in East Nusa Tenggara's most exquisite accommodations
                </p>
            </div>
            <div class="w-24 h-1 bg-yellow-400 mx-auto rounded-full mt-6"></div>
        </div>
    </div>

    <div class="relative px-12">
        <div class="swiper luxuryHotelSwiper">
            <div class="swiper-wrapper pb-12">
                @forelse($hotels as $hotel)
                    <div class="swiper-slide h-full flex">
                        <div class="bg-white h-full rounded-3xl shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-[1.02] flex flex-col justify-between group">
                            <div class="relative overflow-hidden">
                                <img src="{{ $hotel->image ? asset('storage/' . $hotel->image) : asset('images/hotel-fallback.jpg') }}"
                                     alt="{{ $hotel->name }}"
                                     class="w-full h-56 object-cover group-hover:scale-110 transition duration-500 ease-in-out"
                                     loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                <div class="absolute top-4 left-4 bg-yellow-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg flex items-center">
                                    <i class="fas fa-crown mr-1"></i> PREMIUM
                                </div>
                            </div>

                            <div class="p-6 flex flex-col justify-between flex-1">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 truncate">{{ $hotel->name }}</h3>

                                    <p class="text-gray-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                                        {{ $hotel->location ?? 'East Nusa Tenggara' }}
                                    </p>

                                    <div class="mt-3 text-blue-600 text-lg font-semibold">
                                        IDR {{ number_format($hotel->price_per_night ?? $hotel->single_room_price ?? 0, 0, ',', '.') }}
                                        <span class="text-sm font-normal text-gray-500">/night</span>
                                    </div>

                                    @php
                                        $facilities = [];
                                        if (!empty($hotel->facilities)) {
                                            $facilities = is_array($hotel->facilities) ? $hotel->facilities : explode(',', $hotel->facilities);
                                        }
                                        $highlightedFacilities = array_slice($facilities, 0, 3);
                                    @endphp
                                    @if(!empty($facilities))
                                        <div class="flex flex-wrap gap-2 mt-4 text-sm">
                                            @foreach($highlightedFacilities as $facility)
                                                @php $f = strtolower(trim($facility)); @endphp
                                                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-100">
                                                    @if(str_contains($f, 'wifi')) <i class="fas fa-wifi"></i>
                                                    @elseif(str_contains($f, 'pool')) <i class="fas fa-swimming-pool"></i>
                                                    @elseif(str_contains($f, 'spa')) <i class="fas fa-spa"></i>
                                                    @elseif(str_contains($f, 'restaurant')) <i class="fas fa-utensils"></i>
                                                    @else <i class="fas fa-check-circle text-gray-400"></i>
                                                    @endif
                                                    <span>{{ ucwords(trim($facility)) }}</span>
                                                </div>
                                            @endforeach
                                            @if(count($facilities) > 3)
                                                <div class="flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                                    +{{ count($facilities) - 3 }} more
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-6 flex gap-3">
                                    <a href="{{ route('hotels.show', $hotel->id) }}" 
                                       class="flex-1 text-center bg-white border border-blue-600 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition text-sm font-semibold shadow-sm">
                                        View Details
                                    </a>
                                    <a href="{{ route('hotels.book', $hotel->id) }}" 
                                       class="flex-1 text-center bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold shadow-md">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide text-center text-gray-600 text-lg py-10">
                        No hotels available at the moment.
                    </div>
                @endforelse
            </div>
            
            <div class="swiper-pagination !relative !mt-10"></div>
        </div>
        
        <div class="swiper-button-prev luxury-hotel-prev absolute left-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-blue-50 transition cursor-pointer">
            <i class="fas fa-chevron-left text-blue-600"></i>
        </div>
        <div class="swiper-button-next luxury-hotel-next absolute right-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-blue-50 transition cursor-pointer">
            <i class="fas fa-chevron-right text-blue-600"></i>
        </div>
    </div>
    
    <div class="mt-16 text-center">
        <a href="{{ route('hotels.index') }}" class="inline-flex items-center px-8 py-4 text-white bg-blue-600 rounded-full hover:bg-blue-700 transition duration-300 transform hover:scale-105 shadow-lg text-lg font-semibold">
            View All Hotels
            <svg class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </a>
    </div>
</div>
</section>

<!-- Tour Packages Section -->
<section id="tour-packages" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                <span class="block">Exclusive <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-teal-600">Tour Packages</span></span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-yellow-500 mx-auto rounded-full"></div>
            <p class="mt-6 max-w-3xl mx-auto text-gray-600 text-xl">
                Choose from a variety of curated travel experiences to explore the wonders of East Nusa Tenggara.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($TourPackage as $package)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition hover:-translate-y-1 hover:shadow-2xl group">
                    <div class="relative h-60 overflow-hidden">
                          <img src="{{ $package->thumbnail ? asset('storage/' . $package->thumbnail) : asset('image/tour-fallback.jpg') }}"
                             alt="{{ $package->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                        <div class="absolute top-4 left-4 bg-yellow-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                            {{ ucfirst($package->type) }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate">{{ $package->name }}</h3>
                        <p class="text-gray-600 mb-4">
                            {{ \Illuminate\Support\Str::limit($package->description, 100) }}
                        </p>
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span><i class="fas fa-map-marker-alt mr-1 text-blue-500"></i>{{ $package->location }}</span>
                            <span class="text-blue-600 font-bold">IDR {{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-4 flex gap-2">
                        <a href="{{ route('paket-tour.create', $package->id) }}#booking"
                        class="flex-1 text-center bg-white text-blue-600 border border-blue-600 py-2 rounded-md hover:bg-blue-50 transition font-semibold text-sm">
                            Book Now
                        </a>
                    </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <div class="inline-block p-6 bg-white rounded-xl shadow-lg">
                        <i class="fas fa-suitcase-rolling text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 text-lg">No tour packages available at the moment.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-16 text-center">
            <a href="{{ route('paket-tours.index') }}"
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-full hover:shadow-xl transition-all duration-300 transform hover:scale-105 shadow-lg text-lg font-semibold">
                View All Tour Packages
                <svg class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>
    </div>
</section>


<!-- Enhanced Culture Section -->
<section id="culture" class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                <span class="block">Immerse in <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-teal-600">NTT Culture</span></span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-yellow-500 mx-auto rounded-full"></div>
            <p class="mt-6 max-w-3xl mx-auto text-gray-600 text-xl">
                Discover the rich traditions, unique customs, and vibrant festivals of East Nusa Tenggara.
            </p>
        </div>

        @php
            $tagStyles = [
                ['bg' => 'bg-gradient-to-r from-yellow-100 to-yellow-200', 'text' => 'text-yellow-800', 'icon' => 'fa-sun'],
                ['bg' => 'bg-gradient-to-r from-blue-100 to-blue-200', 'text' => 'text-blue-800', 'icon' => 'fa-water'],
                ['bg' => 'bg-gradient-to-r from-green-100 to-green-200', 'text' => 'text-green-800', 'icon' => 'fa-leaf'],
                ['bg' => 'bg-gradient-to-r from-pink-100 to-pink-200', 'text' => 'text-pink-800', 'icon' => 'fa-heart'],
                ['bg' => 'bg-gradient-to-r from-purple-100 to-purple-200', 'text' => 'text-purple-800', 'icon' => 'fa-masks-theater'],
            ];
        @endphp

        @foreach($cultures as $index => $culture)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-20 scroll-animate" 
                 data-animate-in="fadeInUp" 
                 data-animate-out="fadeOutDown"
                 data-delay="{{ $index * 0.1 }}s">
                
                <div class="{{ $index % 2 === 0 ? 'order-2 md:order-1' : 'order-2 md:order-2' }}">
                    <h3 class="text-3xl font-bold text-gray-800 mb-6">{{ $culture->title }}</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $culture->description_1 }}</p>
                    
                    @if($culture->description_2)
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $culture->description_2 }}</p>
                    @endif
                    
                    @if($culture->tags)
                        <div class="flex flex-wrap gap-3">
                            @foreach($culture->tags as $tagIndex => $tag)
                                @php $style = $tagStyles[$tagIndex % count($tagStyles)]; @endphp
                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold {{ $style['text'] }} {{ $style['bg'] }} shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                    <i class="fas {{ $style['icon'] }}"></i>
                                    {{ $tag }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="{{ $index % 2 === 0 ? 'order-1 md:order-2' : 'order-1 md:order-1' }} relative">
                    <div class="relative overflow-hidden rounded-2xl shadow-xl floating">
                        <img src="{{ asset('storage/' . $culture->image) }}" 
                             alt="{{ $culture->title }}" 
                             class="w-full h-auto object-cover transition-transform duration-700 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-black/10 to-transparent"></div>
                    </div>
                    <div class="absolute -bottom-4 {{ $index % 2 === 0 ? '-left-4' : '-right-4' }} w-20 h-20 rounded-full bg-gradient-to-r {{ $index % 2 === 0 ? 'from-yellow-400 to-yellow-500' : 'from-blue-400 to-blue-500' }} z-0"></div>
                </div>
            </div>
        @endforeach

        <div class="mt-16 text-center animate__animated animate__fadeInUp">
            <a href="{{ route('cultures.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-full hover:shadow-xl transition-all duration-300 transform hover:scale-105 shadow-lg text-lg font-semibold">
                Discover More Cultural Experiences
                <svg class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-teal-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Stay Updated</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Subscribe to our newsletter for the latest travel deals and updates from East Nusa Tenggara.
        </p>
        
        <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            <input type="email" placeholder="Your email address" 
                   class="flex-grow px-5 py-3 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-gray-900 font-bold rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg">
                Subscribe
            </button>
        </form>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                <span class="block">Traveler <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-teal-600">Testimonials</span></span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-yellow-500 mx-auto rounded-full"></div>
            <p class="mt-6 max-w-3xl mx-auto text-gray-600 text-xl">
                Hear what our visitors say about their experiences in East Nusa Tenggara.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([1, 2, 3] as $testimonial)
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 mr-2">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-gray-500 text-sm">5.0</span>
                    </div>
                    <p class="text-gray-600 mb-6 italic">
                        "The cultural experiences in East Nusa Tenggara were unforgettable. The local guides were knowledgeable and the landscapes were breathtaking."
                    </p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/{{ $testimonial % 2 ? 'men' : 'women' }}/{{ $testimonial }}2.jpg" 
                             alt="Traveler" 
                             class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $testimonial % 2 ? 'John' : 'Sarah' }} {{ $testimonial == 2 ? 'W.' : 'D.' }}</h4>
                            <p class="text-sm text-gray-500">From Australia</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Dependencies -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<!-- Additional Styles -->
<style>
    .floating {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .scroll-animate {
        opacity: 0;
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    
    .scroll-animate.animate__animated {
        opacity: 1;
    }
    
    /* Custom Swiper Styles for Luxury Hotel */
   .luxuryHotelSwiper .swiper-wrapper {
        /* 1. Memaksa wrapper untuk meregangkan semua slide di dalamnya */
        align-items: stretch;
    }

    .luxuryHotelSwiper .swiper-slide {
        /* 2. Mengatur tinggi slide agar otomatis mengikuti wrapper */
        height: auto;
        display: flex; /* 3. Membuat slide menjadi flex container */
    }

    .luxuryHotelSwiper .swiper-slide > div {
        /* 4. Memastikan kartu di dalam slide mengisi 100% tinggi yang tersedia */
        width: 100%;
    }
    
    #luxury-stays:hover .luxury-hotel-prev,
    #luxury-stays:hover .luxury-hotel-next {
        opacity: 1;
        transform: scale(1);
    }
    
    .luxury-hotel-prev:hover, .luxury-hotel-next:hover {
        background: #EFF6FF !important;
    }
</style>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Luxury Hotel Swiper
        const luxuryHotelSwiper = new Swiper('.luxuryHotelSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: true,
            },
            navigation: {
                nextEl: '.luxury-hotel-next',
                prevEl: '.luxury-hotel-prev',
            },
            pagination: {
                el: '.luxuryHotelSwiper .swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 25
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
            }
        });

        // Pause autoplay when hovering
        const swiperContainer = document.querySelector('.luxuryHotelSwiper');
        swiperContainer.addEventListener('mouseenter', () => {
            luxuryHotelSwiper.autoplay.stop();
        });
        swiperContainer.addEventListener('mouseleave', () => {
            luxuryHotelSwiper.autoplay.start();
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Scroll animation observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const animateIn = entry.target.getAttribute('data-animate-in');
                    const delay = entry.target.getAttribute('data-delay') || '0s';
                    
                    entry.target.style.animationDelay = delay;
                    entry.target.classList.add('animate__animated', animateIn);
                    
                    // Remove the animation class after it completes to avoid repetition
                    const handleAnimationEnd = () => {
                        entry.target.classList.remove('animate__animated', animateIn);
                        entry.target.removeEventListener('animationend', handleAnimationEnd);
                    };
                    
                    entry.target.addEventListener('animationend', handleAnimationEnd);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe all elements with scroll-animate class
        document.querySelectorAll('.scroll-animate').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endsection