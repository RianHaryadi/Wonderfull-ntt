@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section id="home" class="relative h-screen flex items-center justify-center text-white overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1566438480900-0609be27a4be?ixlib=rb-4.0.3&auto=format&fit=crop&w=2094&q=80" 
             class="w-full h-full object-cover brightness-50" alt="NTT Beach Landscape" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-teal-700/70"></div>
    </div>
    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
        <h1 class="text-4xl md:text-7xl font-extrabold mb-6 leading-tight animate__animated animate__fadeInUp">
            Unveil the <span class="text-yellow-300">Secret Wonders</span> of Eastern Indonesia
        </h1>
        <p class="text-lg md:text-2xl mb-8 text-gray-100 animate__animated animate__fadeInUp animate__delay-1s">
            Embark on a journey through pristine beaches, vibrant cultures, and awe-inspiring landscapes in East Nusa Tenggara.
        </p>
        <div class="flex flex-wrap justify-center gap-4 animate__animated animate__fadeInUp animate__delay-2s">
            <a href="#destinations" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-full transition duration-300 transform hover:scale-110 shadow-lg">
                Discover Destinations
            </a>
            <a href="#culture" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-900 text-white font-bold py-4 px-8 rounded-full transition duration-300 transform hover:scale-110 shadow-lg">
                Immerse in Culture
            </a>
        </div>
    </div>
    <div class="absolute bottom-10 left-0 right-0 text-center">
        <a href="#destinations" class="animate-bounce inline-block text-white">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </a>
    </div>
</section>

<!-- Top Destinations -->
<section id="destinations" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                <span class="block">Explore Our <span class="text-blue-600">Top Destinations</span></span>
            </h2>
            <div class="mt-3 h-1 w-24 bg-yellow-400 mx-auto"></div>
            <p class="mt-6 max-w-3xl mx-auto text-gray-600 text-xl">
                Discover must-visit spots that showcase the breathtaking beauty and rich heritage of East Nusa Tenggara.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($destinations as $destination)
                <div class="island-card rounded-2xl overflow-hidden shadow-xl bg-white transition duration-500 ease-in-out transform hover:-translate-y-2 hover:shadow-2xl relative">
                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ $destination->image ? asset('storage/destinations/' . preg_replace('#^/?destinations/|^/|/#', '', $destination->image)) : asset('images/fallback.jpg') }}"
                             alt="{{ $destination->name }}"
                             class="w-full h-full object-cover transition duration-500 hover:scale-110"
                             loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-10"></div>
                        <div class="absolute bottom-0 left-0 p-6 text-white z-20">
                            <h3 class="text-2xl font-bold">{{ $destination->name }}</h3>
                            <p class="text-sm opacity-90">{{ $destination->location }}</p>
                        </div>
                        <span class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow z-20">
                            {{ $destination->category }}
                        </span>
                        <div class="absolute inset-0 island-overlay flex items-center justify-center bg-black/40 opacity-0 hover:opacity-100 transition-opacity duration-300 z-30">
                            <a href="#" class="bg-white text-blue-600 px-6 py-3 rounded-full font-bold hover:bg-blue-600 hover:text-white transition">
                                Explore Now
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 text-base leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($destination->description, 120) }}
                        </p>
                        <div class="mt-6 flex justify-between items-center">
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-gray-500 ml-2 text-sm">4.7 (1.2k)</span>
                            </div>
                            <span class="text-blue-600 font-bold text-sm">IDR 500K</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600 col-span-3 text-lg">
                    No popular destinations available at the moment.
                </p>
            @endforelse
        </div>
        <div class="mt-16 text-center">
            <a href="{{ route('destinations.index') }}"
               class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-semibold rounded-full shadow-lg text-white bg-blue-600 hover:bg-blue-700 transition duration-300 transform hover:scale-105">
                View All Destinations
                <svg class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Hotel Recommendations -->
<section id="hotels" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Heading -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                <span class="block">
                    Top <span class="text-blue-600">Hotel Picks</span>
                </span>
            </h2>
            <div class="mt-3 h-1 w-24 bg-yellow-400 mx-auto"></div>
            <p class="mt-6 max-w-3xl mx-auto text-gray-600 text-xl">
                Enjoy comfort, elegance, and unforgettable views in East Nusa Tenggara's finest hotels.
            </p>
        </div>

        <!-- Swiper Slider -->
        <div class="relative">
            <div class="swiper myHotelSwiper">
                <div class="swiper-wrapper">
                    @forelse($hotels as $hotel)
                        <div class="swiper-slide h-full">
                            <div class="bg-white h-full rounded-3xl shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-[1.02] flex flex-col justify-between group">

                                <!-- Hotel Image -->
                                <div class="relative overflow-hidden">
                                    <img 
                                        src="{{ $hotel->image ? asset('storage/' . $hotel->image) : asset('images/hotel-fallback.jpg') }}"
                                        alt="{{ $hotel->name }}"
                                        class="w-full h-56 object-cover group-hover:scale-110 transition duration-500 ease-in-out"
                                        loading="lazy"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                </div>

                                <!-- Hotel Details -->
                                <div class="p-6 flex flex-col justify-between flex-1">
                                    <h3 class="text-xl font-bold text-gray-800 truncate">{{ $hotel->name }}</h3>
                                    
                                    <!-- Star Rating -->
                                    <div class="flex items-center text-yellow-500 text-sm mt-1">
                                        @for($i = 0; $i < 5; $i++)
                                            <i class="fas fa-star {{ $i < 4 ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                        <span class="ml-2 text-gray-500">({{ rand(150, 500) }} reviews)</span>
                                    </div>

                                    <!-- Price -->
                                    <div class="mt-3 text-blue-600 text-lg font-semibold">
                                        IDR {{ number_format($hotel->single_room_price, 0, ',', '.') }}
                                        <span class="text-sm font-normal text-gray-500">/night</span>
                                    </div>

                                    <!-- Facilities -->
                                    @php
                                        $facilities = is_array($hotel->facilities) ? $hotel->facilities : explode(',', $hotel->facilities);
                                    @endphp
                                    @if(!empty($facilities))
                                        <div class="flex flex-wrap gap-2 mt-4 text-sm">
                                            @foreach($facilities as $facility)
                                                @php $f = strtolower(trim($facility)); @endphp
                                                <div class="flex items-center gap-1 px-3 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-100">
                                                    @if(str_contains($f, 'wifi'))
                                                        <i class="fas fa-wifi"></i>
                                                    @elseif(str_contains($f, 'pool'))
                                                        <i class="fas fa-swimming-pool"></i>
                                                    @elseif(str_contains($f, 'dining') || str_contains($f, 'restaurant'))
                                                        <i class="fas fa-utensils"></i>
                                                    @elseif(str_contains($f, 'parking'))
                                                        <i class="fas fa-parking"></i>
                                                    @elseif(str_contains($f, 'ac') || str_contains($f, 'air'))
                                                        <i class="fas fa-wind"></i>
                                                    @elseif(str_contains($f, 'bar'))
                                                        <i class="fas fa-glass-martini-alt"></i>
                                                    @elseif(str_contains($f, 'spa'))
                                                        <i class="fas fa-spa"></i>
                                                    @elseif(str_contains($f, 'yoga'))
                                                        <i class="fas fa-child"></i>
                                                    @elseif(str_contains($f, 'butler'))
                                                        <i class="fas fa-user-tie"></i>
                                                    @elseif(str_contains($f, 'diving'))
                                                        <i class="fas fa-water"></i>
                                                    @elseif(str_contains($f, 'meeting'))
                                                        <i class="fas fa-chalkboard"></i>
                                                    @else
                                                        <i class="fas fa-check-circle text-gray-400"></i>
                                                    @endif
                                                    {{ ucwords(trim($facility)) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="mt-6 flex gap-2">
                                        <a href="#" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm font-medium shadow">
                                            View Details
                                        </a>
                                        <a href="{{ route('hotels.book', ['hotel' => $hotel->id]) }}" class="flex-1 text-center bg-blue-600 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-700 transition font-semibold">
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

                <!-- Swiper Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>

        <!-- View All Button -->
        <div class="mt-16 text-center">
            <a href="{{ route('hotels.index') }}" class="inline-flex items-center px-8 py-4 text-white bg-blue-600 rounded-full hover:bg-blue-700 transition duration-300 transform hover:scale-105 shadow-lg text-lg font-semibold">
                View All Hotels
                <svg class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

    </div>
</section>


<!-- Tour Packages -->
<section id="tour-packages" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                <span class="block">Curated <span class="text-blue-600">Tour Packages</span></span>
            </h2>
            <div class="mt-3 h-1 w-24 bg-yellow-400 mx-auto"></div>
            <p class="mt-6 max-w-3xl mx-auto text-gray-600 text-xl">
                Handpicked tour packages to explore the stunning beauty of East Nusa Tenggara.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse ($TourPackage  as $paket)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition duration-300 hover:scale-105">
                    <img src="{{ $paket->thumbnail ? asset('storage/' . $paket->thumbnail) : asset('images/tour-fallback.jpg') }}"
                         class="w-full h-56 object-cover" alt="{{ $paket->name }}" loading="lazy">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800">{{ $paket->name }}</h3>
                        <p class="text-sm text-gray-500 mt-2">📍 {{ $paket->location }}</p>
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-blue-600 font-bold text-lg">
                                IDR {{ number_format($paket->price, 0, ',', '.') }}
                            </span>
                            <span class="text-sm text-gray-600">
                                {{ $paket->days ?? '3' }} Days
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-3">
                            Category: <span class="text-gray-800 font-medium">{{ ucfirst($paket->category) }}</span><br>
                            Hotel Included: 
                            @php
                                $hasHotel = $paket->variants->contains(fn($v) => $v->includes_hotel);
                            @endphp
                            <span class="font-medium {{ $hasHotel ? 'text-green-600' : 'text-red-600' }}">
                                {{ $hasHotel ? 'Yes' : 'No' }}
                            </span>
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('paket-tours.show', $paket->id) }}"
                               class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-300">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600 col-span-3 text-lg">
                    No tour packages available at the moment.
                </p>
            @endforelse
        </div>
        <div class="mt-16 text-center">
            <a href="{{ route('paket-tours.index') }}"
               class="inline-flex items-center px-8 py-4 text-white bg-blue-600 rounded-full hover:bg-blue-700 transition duration-300 transform hover:scale-105 shadow-lg text-lg font-semibold">
                Explore All Tour Packages
                <svg class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Culture Section -->
<section id="culture" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate__animated animate__fadeInUp">
            <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                <span class="block">Immerse in <span class="text-blue-600">NTT Culture</span></span>
            </h2>
            <div class="mt-3 h-1 w-24 bg-yellow-400 mx-auto"></div>
            <p class="mt-6 max-w-3xl mx-auto text-gray-600 text-xl">
                Discover the rich traditions, unique customs, and vibrant festivals of East Nusa Tenggara.
            </p>
        </div>

        @php
            $tagStyles = [
                ['bg' => 'from-yellow-100 to-yellow-300', 'text' => 'text-yellow-900', 'icon' => 'fa-sun'],
                ['bg' => 'from-blue-100 to-blue-300', 'text' => 'text-blue-900', 'icon' => 'fa-water'],
                ['bg' => 'from-green-100 to-green-300', 'text' => 'text-green-900', 'icon' => 'fa-leaf'],
                ['bg' => 'from-pink-100 to-pink-300', 'text' => 'text-pink-900', 'icon' => 'fa-heart'],
                ['bg' => 'from-purple-100 to-purple-300', 'text' => 'text-purple-900', 'icon' => 'fa-masks-theater'],
                ['bg' => 'from-red-100 to-red-300', 'text' => 'text-red-900', 'icon' => 'fa-fire'],
                ['bg' => 'from-teal-100 to-teal-300', 'text' => 'text-teal-900', 'icon' => 'fa-fish'],
                ['bg' => 'from-orange-100 to-orange-300', 'text' => 'text-orange-900', 'icon' => 'fa-mountain'],
                ['bg' => 'from-indigo-100 to-indigo-300', 'text' => 'text-indigo-900', 'icon' => 'fa-drum'],
                ['bg' => 'from-rose-100 to-rose-300', 'text' => 'text-rose-900', 'icon' => 'fa-star'],
            ];
        @endphp

        @foreach($cultures as $index => $culture)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-20 scroll-animate" data-animate-in="fadeInUp" data-animate-out="fadeOutDown">
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
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold {{ $style['text'] }} bg-gradient-to-r {{ $style['bg'] }} shadow-md hover:shadow-xl hover:scale-105 transition duration-300">
                            <i class="fas {{ $style['icon'] }}"></i>
                            {{ $tag }}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="{{ $index % 2 === 0 ? 'order-1 md:order-2' : 'order-1 md:order-1' }} relative">
            <img src="{{ asset('storage/' . $culture->image) }}" alt="{{ $culture->title }}" class="w-full rounded-2xl shadow-xl floating">
            <div class="absolute -bottom-6 {{ $index % 2 === 0 ? '-left-6 bg-yellow-400' : '-right-6 bg-blue-400' }} w-24 h-24 rounded-full z-0"></div>
        </div>
    </div>
@endforeach

        <div class="mt-16 text-center animate__animated animate__fadeInUp">
            <a href="{{ route('cultures.index') }}" class="inline-flex items-center px-8 py-4 text-white bg-blue-600 rounded-full hover:bg-blue-700 transition duration-300 transform hover:scale-105 shadow-lg text-lg font-semibold">
                Discover More Cultural Experiences
                <svg class="ml-3 w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</section>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .animate__hidden {
            opacity: 0;
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>


    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Swiper Initialization for Hotels
        new Swiper('.myHotelSwiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            }
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Scroll Animation for Culture Section (Fade In & Out without flicker)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const el = entry.target;
                const animateIn = el.getAttribute('data-animate-in') || 'fadeInUp';
                const animateOut = el.getAttribute('data-animate-out') || 'fadeOutDown';
                const delay = el.getAttribute('data-delay') || '0s';

                // Hindari penggantian class selama animasi aktif
                if (el.classList.contains('is-animating')) return;

                if (entry.isIntersecting) {
                    el.classList.remove('animate__hidden', `animate__${animateOut}`);
                    el.classList.add('animate__animated', `animate__${animateIn}`, 'is-animating');
                    el.style.animationDelay = delay;

                    el.addEventListener('animationend', () => {
                        el.classList.remove('is-animating', `animate__${animateIn}`);
                    }, { once: true });
                } else {
                    el.classList.remove(`animate__${animateIn}`);
                    el.classList.add('animate__animated', `animate__${animateOut}`, 'is-animating');
                    el.style.animationDelay = '0s';

                    el.addEventListener('animationend', () => {
                        el.classList.remove('is-animating', `animate__${animateOut}`);
                        el.classList.add('animate__hidden');
                    }, { once: true });
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -10% 0px'
        });

        // Only observe elements within #culture
        document.querySelectorAll('#culture .scroll-animate').forEach(el => {
            el.classList.add('animate__hidden'); // Hide initially
            observer.observe(el);
        });
    });
</script>
@endsection