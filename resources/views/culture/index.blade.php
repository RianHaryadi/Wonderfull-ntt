@extends('layouts.app')

@section('title', 'NTT Culture')

@section('content')
<section id="explore" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-animate" data-animate-in="fadeInUp">
            <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                <span class="block">Immerse in <span class="text-blue-600">NTT Culture</span></span>
            </h2>
            <div class="mt-3 h-1 w-24 bg-yellow-400 mx-auto"></div>
            <p class="mt-6 max-w-3xl mx-auto text-gray-600 text-xl">
                Discover the rich traditions, unique customs, and vibrant festivals of East Nusa Tenggara.
            </p>
        </div>

        @foreach($cultures as $index => $culture)
        @php $delay = number_format($index * 0.2, 1); @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-32 scroll-animate animate__hidden"
             data-animate-in="fadeInUp" data-delay="{{ $delay }}s">
            @if($index % 2 === 0)
                {{-- Image Right --}}
                <div class="order-2 md:order-1">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm font-bold mr-3">
                            {{ sprintf('%02d', $index + 1) }}
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $culture->title }}</h3>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $culture->description_1 }}</p>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $culture->description_2 }}</p>

                    <div class="flex flex-wrap gap-3">
                        @foreach($culture->tags as $tag)
                        <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                            <i class="fas fa-star mr-1"></i> {{ trim($tag) }}
                        </span>
                        @endforeach
                    </div>
                </div>
                <div class="order-1 md:order-2 relative">
                    <img src="{{ asset('storage/' . $culture->image) }}" alt="{{ $culture->title }}" 
                         class="w-full rounded-2xl shadow-xl transition duration-500 floating">
                    <div class="absolute -bottom-6 -left-6 bg-yellow-400 w-24 h-24 rounded-full z-0"></div>
                </div>
            @else
                {{-- Image Left --}}
                <div class="relative">
                    <img src="{{ asset('storage/' . $culture->image) }}" alt="{{ $culture->title }}" 
                         class="w-full rounded-2xl shadow-xl transition duration-500 floating">
                    <div class="absolute -bottom-6 -right-6 bg-blue-400 w-24 h-24 rounded-full z-0"></div>
                </div>
                <div>
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm font-bold mr-3">
                            {{ sprintf('%02d', $index + 1) }}
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $culture->title }}</h3>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $culture->description_1 }}</p>
                    <p class="text-gray-600 mb-6 leading-relaxed">{{ $culture->description_2 }}</p>

                    <div class="flex flex-wrap gap-3">
                        @foreach($culture->tags as $tag)        
                        <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                            <i class="fas fa-star mr-1"></i> {{ trim($tag) }}
                        </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    </div>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    .animate__hidden { opacity: 0; }
    .floating {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>



<script>
document.addEventListener('DOMContentLoaded', () => {
    const animatedEls = document.querySelectorAll('.scroll-animate');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const el = entry.target;
            const animateIn = el.dataset.animateIn || 'fadeInUp';
            const delay = el.dataset.delay || '0s';

            if (entry.isIntersecting) {
                el.classList.remove('animate__hidden');
                el.classList.add('animate__animated', `animate__${animateIn}`);
                el.style.animationDelay = delay;
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px',
    });

    animatedEls.forEach(el => {
        el.classList.add('animate__hidden');
        observer.observe(el);
    });
});
</script>
@endsection