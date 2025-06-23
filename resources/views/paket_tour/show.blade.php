@extends('layouts.app')

@section('title', 'Detail Paket Tour - ' . $paketTour->name)

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
  /* Style tambahan untuk gambar hotel */
  .hotel-image {
    max-height: 150px;
    width: 100%;
    object-fit: cover;
    border-radius: 0.5rem;
    margin-top: 1rem;
    display: none; /* Sembunyikan secara default */
  }
  .hotel-image.active {
    display: block; /* Tampilkan saat hotel dipilih */
  }
</style>
@endsection

@section('content')
@php
  $photos = is_array($paketTour->photos) ? $paketTour->photos : json_decode($paketTour->photos ?? '[]', true);
  $fallbackImage = asset('images/default-tour-image.jpg');
  $fallbackHotelImage = asset('images/default-hotel-image.jpg');
@endphp

<section class="py-16 bg-gradient-to-b from-white to-blue-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="text-center mb-12 fade-in-up">
      <h1 class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600
        text-transparent bg-clip-text animate-typing overflow-hidden whitespace-nowrap border-r-4 border-blue-500 pr-2 mx-auto w-fit">
        {{ $paketTour->name }}
      </h1>

      <div class="mt-4 flex justify-center gap-3">
        <span class="px-4 py-1 rounded-full bg-yellow-400 text-white text-sm font-semibold shadow-md animate-bounce">
          📍 {{ $paketTour->location }}
        </span>

        @if ($paketTour->is_popular)
          <span class="px-4 py-1 rounded-full bg-green-500 text-white text-sm font-semibold shadow-md animate-pulse">
            🌟 Populer
          </span>
        @endif
      </div>

      <p class="mt-6 text-gray-600 max-w-2xl mx-auto text-base md:text-lg fade-in-up delay-[0.3s]">
        Jelajahi keindahan <strong class="text-blue-600">{{ $paketTour->location }}</strong> bersama paket tour eksklusif yang kami siapkan untuk pengalaman tak terlupakan.
      </p>
    </div>

    <!-- Image + Detail Grid -->
    <div class="grid lg:grid-cols-3 gap-10">

      <!-- Image Section -->
      <div class="lg:col-span-2 flex flex-col gap-6 fade-in-up">
        @php
          $main = $photos[0] ?? null;
          $mainPath = is_array($main) ? ($main['path'] ?? '') : $main;
        @endphp
        <div class="rounded-xl overflow-hidden shadow-lg aspect-video relative group transform transition duration-500 hover:scale-[1.01]">
          <img src="{{ asset('storage/' . ltrim($mainPath, '/')) }}"
               alt="Main Image"
               data-clickable
               class="w-full h-full object-cover cursor-zoom-in"
               onclick="showImageModal(this.src)"
               onerror="this.src='{{ $fallbackImage }}';">
        </div>

        <!-- Thumbnails Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          @foreach (array_slice($photos, 1, 4) as $thumb)
            @php $path = is_array($thumb) ? ($thumb['path'] ?? '') : $thumb; @endphp
            <img src="{{ asset('storage/' . ltrim($path, '/')) }}"
                 alt="Thumbnail"
                 class="h-32 w-full object-cover rounded-lg shadow-lg hover:scale-105 hover:ring-2 hover:ring-blue-400 transition-all duration-300 ease-in-out cursor-zoom-in"
                 onclick="showImageModal(this.src)"
                 onerror="this.src='{{ $fallbackImage }}';">
          @endforeach
        </div>
      </div>

      <!-- Detail & Info -->
      <div class="space-y-6 fade-in-up delay-[0.3s]">

        <!-- Price & Duration -->
        <div class="flex items-center gap-4">
          <div class="text-2xl font-bold text-blue-600">
            IDR {{ number_format($paketTour->price, 0, ',', '.') }}
          </div>
          <div class="text-sm font-medium text-gray-500 flex items-center gap-1">
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 4h10M5 11h14M5 15h14M5 19h14"></path>
            </svg>
            {{ $paketTour->days }} Hari
          </div>
        </div>

        <!-- Additional Info -->
        <div class="grid grid-cols-1 gap-3 text-sm text-gray-700">
          <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 11c1.656 0 3-1.344 3-3s-1.344-3-3-3-3 1.344-3 3 1.344 3 3 3z"></path>
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 22s8-6.5 8-13A8 8 0 1 0 4 9c0 6.5 8 13 8 13z"></path>
            </svg>
            <span><strong>Lokasi:</strong> {{ $paketTour->location }}</span>
          </div>

          <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-indigo-500 mt-0.5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 7v4a1 1 0 001 1h3l3 3V4l-3 3H4a1 1 0 00-1 1z"></path>
            </svg>
            <span><strong>Kategori:</strong> {{ ucfirst($paketTour->category ?? 'N/A') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Image Popup Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-80 items-center justify-center">
  <div class="relative max-w-4xl w-full mx-auto px-4">
    <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white text-3xl font-bold z-50">×</button>
    <img id="modalImage" src="#" alt="Popup Image" class="mx-auto rounded-lg shadow-xl" />
  </div>
</div>

<script>
  function showImageModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    if (src && modal && modalImg) {
      modalImg.src = src;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
  }

  function closeImageModal() {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    if (modal && modalImg) {
      modal.classList.remove('flex');
      modal.classList.add('hidden');
      modalImg.src = '';
    }
  }

  document.addEventListener('click', function (e) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    if (modal.classList.contains('flex') && !modalImg.contains(e.target) && !e.target.closest('img[data-clickable]')) {
      closeImageModal();
    }
  });

  function updateHotelImage(selectElement, id) {
    console.log('updateHotelImage called', { id, value: selectElement.value }); // Debug
    const hotelImage = document.getElementById(`hotel-image-${id}`);
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const imageSrc = selectedOption.getAttribute('data-image') || '{{ $fallbackHotelImage }}';
    console.log('Image src:', imageSrc); // Debug
    if (hotelImage) {
      hotelImage.src = imageSrc;
      if (selectElement.value) {
        hotelImage.classList.add('active');
      } else {
        hotelImage.classList.remove('active');
      }
    } else {
      console.error(`Hotel image element not found for id: ${id}`);
    }
  }
</script>
@endsection