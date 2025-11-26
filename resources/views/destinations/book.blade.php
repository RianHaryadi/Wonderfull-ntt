@extends('layouts.app')

@section('title', 'Pesan Destinasi - ' . ($destination->name ?? 'Destination'))

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="antialiased bg-gradient-to-b from-gray-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">
            {{-- Left Column: Destination Details --}}
            <div class="lg:col-span-3 space-y-6">
                {{-- Destination Image Gallery --}}
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden group">
                    <div class="relative w-full aspect-w-16 aspect-h-9">
                        <img src="{{ $destination->image ? asset('storage/' . ltrim($destination->image, '/')) : asset('images/fallback.jpg') }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                             alt="{{ $destination->name ?? 'Destination' }}">
                        <div class="absolute bottom-4 left-4 bg-white/80 rounded-lg px-3 py-1 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i>
                                <span class="font-medium text-gray-800">{{ $destination->location ?? 'Unknown Location' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Destination Details --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                    <div class="flex justify-between items-start">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $destination->name ?? 'Destination' }}</h1>
                        <div class="flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-check-circle mr-1.5"></i>
                            Tersedia
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-indigo-600 mr-3"></i> Tentang Destinasi
                        </h2>
                        <div class="prose prose-indigo max-w-none text-gray-600">
                            {!! $destination->description ?? '<p>Deskripsi tidak tersedia.</p>' !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Booking Form --}}
            <div class="lg:col-span-2">
                <div id="bookingCard" 
                     class="bg-white rounded-2xl shadow-lg overflow-hidden lg:sticky lg:top-8"
                     data-price-per-ticket="{{ $destination->price ?? 0 }}">
                    {{-- Price Header --}}
                    <div class="bg-indigo-600 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <span class="text-white font-medium">Mulai dari</span>
                            <span class="text-2xl font-bold text-white">
                                Rp {{ number_format($destination->price ?? 0, 0, ',', '.') }}
                                <span class="text-base font-normal">/ orang</span>
                            </span>
                        </div>
                    </div>

                    <div class="p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-gray-900">Pesan Sekarang</h2>
                        <p class="text-gray-500 mt-1">Amankan tempat Anda sekarang juga!</p>

                        @if ($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md my-4" role="alert">
                                <div class="flex">
                                    <div class="flex-shrink-0"><i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i></div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Terjadi {{ $errors->count() }} kesalahan validasi</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form id="bookingForm" action="{{ route('destinations.store') }}" method="POST" class="space-y-4 mt-4">
                            @csrf
                            <input type="hidden" name="destination_id" value="{{ $destination->id }}">
                            <input type="hidden" name="promo_code_id" id="promoCodeId" value="{{ old('promo_code_id') }}">
                            {{-- Input hidden discountAmount --}}
                            <input type="hidden" name="discount_amount" id="discountAmount" value="{{ old('discount_amount', 0) }}">

                            {{-- Customer Information --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" required class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                    <input type="tel" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" required class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                            <hr class="my-6">
                            {{-- Booking Details --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kunjungan</label>
                                    <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date') }}" min="{{ date('Y-m-d') }}" required class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="number_of_tickets" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Orang</label>
                                    <input type="number" name="number_of_tickets" id="number_of_tickets" value="{{ old('number_of_tickets', 1) }}" min="1" max="50" required class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                            <hr class="my-6">
                            {{-- Promo Code --}}
                            <div>
                                <label for="promoCode" class="block text-sm font-medium text-gray-700 mb-1">Kode Promo (Opsional)</label>
                                <div class="flex gap-3">
                                    <input type="text" id="promoCode" name="promo_code" value="{{ old('promo_code') }}" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan kode">
                                    <button type="button" id="applyPromoBtn" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 font-medium whitespace-nowrap">Terapkan</button>
                                </div>
                                <div id="promoMessage" class="hidden mt-2 text-sm p-3 rounded-lg"></div>
                            </div>

                            {{-- Price Summary --}}
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-bold text-gray-800 mb-3">Rincian Pembayaran</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Harga Tiket</span>
                                        <span class="text-gray-800" id="subtotal-display">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Diskon</span>
                                        <span id="discount-display" class="text-green-600 font-medium">- Rp 0</span>
                                    </div>
                                    <div class="flex justify-between font-bold text-lg pt-2 border-t mt-2">
                                        <span class="text-gray-800">Total Pembayaran</span>
                                        <span id="total-price-display" class="text-indigo-600">Rp 0</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="mt-8">
                                <button type="submit" class="w-full flex items-center justify-center gap-x-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-bold py-3.5 px-6 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                    <i class="fas fa-shield-alt"></i>
                                    Lanjutkan ke Pembayaran
                                </button>
                            </div>

                            <p class="text-xs text-gray-500 text-center mt-4">
                                Dengan melanjutkan, Anda menyetujui <a href="#" class="text-indigo-600 hover:underline">Syarat & Ketentuan</a> kami.
                            </p>
                        </form>

                        {{-- Hidden Promo Data dengan Mapping yang Benar --}}
                        <div id="promoData" class="hidden" 
                            data-promos='{{ $promos ? json_encode($promos->mapWithKeys(fn($promo) => [strtoupper($promo->code) => [
                                "id" => $promo->id,
                                "amount" => (float) ($promo->discount_amount ?? 0),  
                                "percent" => (float) ($promo->discount_percent ?? 0), 
                                "active" => $promo->active,
                                "valid_from" => $promo->valid_from,
                                "valid_until" => $promo->valid_until
                            ]])) : "{}" }}'>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- State Variables ---
    const state = {
        pricePerTicket: 0,
        ticketCount: 1,
        promo: null // Struktur: { id, code, amount, percent }
    };

    // --- DOM Elements ---
    const ui = {
        bookingCard: document.getElementById('bookingCard'),
        ticketInput: document.getElementById('number_of_tickets'),
        promoInput: document.getElementById('promoCode'),
        applyPromoBtn: document.getElementById('applyPromoBtn'),
        promoMessage: document.getElementById('promoMessage'),
        promoCodeIdInput: document.getElementById('promoCodeId'),
        discountAmountInput: document.getElementById('discountAmount'),
        subtotalDisplay: document.getElementById('subtotal-display'),
        discountDisplay: document.getElementById('discount-display'),
        totalPriceDisplay: document.getElementById('total-price-display'),
        form: document.getElementById('bookingForm'),
    };
    
    // --- Load Data ---
    // Parsing JSON dengan aman
    const rawPromoData = ui.bookingCard.querySelector('#promoData').dataset.promos;
    const allPromos = JSON.parse(rawPromoData || '{}');
    
    // Set harga awal
    state.pricePerTicket = parseFloat(ui.bookingCard.dataset.pricePerTicket) || 0;
    state.ticketCount = Math.max(1, parseInt(ui.ticketInput.value, 10) || 1);

    // --- Helper Functions ---
    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    };
    
    const showMessage = (msg, type) => {
        ui.promoMessage.textContent = msg;
        ui.promoMessage.className = `mt-2 text-sm p-3 rounded-lg ${type === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'}`;
        ui.promoMessage.classList.remove('hidden');
    };

    // --- Core Calculation Logic ---
    const calculateTotals = () => {
        const subtotal = state.pricePerTicket * state.ticketCount;
        let discountValue = 0;

        // Cek apakah ada promo aktif di state
        if (state.promo) {
            // Logika Prioritas: Persen dulu, baru nominal
            if (state.promo.percent > 0) {
                discountValue = subtotal * (state.promo.percent / 100);
            } else if (state.promo.amount > 0) {
                discountValue = state.promo.amount;
            }
        }

        // Cegah diskon > subtotal
        if (discountValue > subtotal) discountValue = subtotal;

        const total = Math.max(0, subtotal - discountValue);

        // Update UI
        ui.subtotalDisplay.textContent = `${formatRupiah(state.pricePerTicket)} x ${state.ticketCount}`;
        ui.discountDisplay.textContent = `- ${formatRupiah(discountValue)}`;
        ui.totalPriceDisplay.textContent = formatRupiah(total);
        
        // Update Hidden Input untuk dikirim ke Server
        ui.discountAmountInput.value = Math.floor(discountValue); // Kirim angka bulat
    };

    // --- Apply Promo Logic ---
    const applyPromoCode = () => {
        const code = ui.promoInput.value.trim().toUpperCase();
        
        // Reset state jika input kosong
        if (!code) {
            state.promo = null;
            ui.promoCodeIdInput.value = '';
            calculateTotals();
            showMessage('Masukkan kode promo.', 'error');
            return;
        }

        const promoData = allPromos[code];

        // Validasi Ketersediaan
        if (!promoData) {
            state.promo = null;
            calculateTotals();
            showMessage('Kode promo tidak ditemukan.', 'error');
            return;
        }

        // Validasi Status Aktif
        if (!promoData.active) {
            state.promo = null;
            calculateTotals();
            showMessage('Kode promo tidak aktif.', 'error');
            return;
        }

        // Validasi Tanggal
        const today = new Date().toISOString().split('T')[0];
        if (promoData.valid_from && promoData.valid_from > today) {
            showMessage(`Promo baru berlaku mulai ${promoData.valid_from}.`, 'error');
            return;
        }
        if (promoData.valid_until && promoData.valid_until < today) {
            showMessage('Kode promo sudah kadaluarsa.', 'error');
            return;
        }

        // Validasi Nilai Diskon (Pastikan Float)
        const pPercent = parseFloat(promoData.percent) || 0;
        const pAmount = parseFloat(promoData.amount) || 0;

        if (pPercent <= 0 && pAmount <= 0) {
            showMessage('Promo valid tapi tidak memiliki nilai diskon.', 'error');
            return;
        }

        // Set State Promo Berhasil
        state.promo = {
            id: promoData.id,
            code: code,
            percent: pPercent,
            amount: pAmount
        };

        ui.promoCodeIdInput.value = promoData.id;
        
        // Pesan Sukses
        const diskonInfo = pPercent > 0 ? `${pPercent}%` : formatRupiah(pAmount);
        showMessage(`Kode "${code}" berhasil! Hemat ${diskonInfo}`, 'success');

        calculateTotals();
    };

    // --- Event Listeners ---
    
    // 1. Input Jumlah Tiket berubah -> Hitung ulang total & diskon
    ui.ticketInput.addEventListener('input', (e) => {
        let val = parseInt(e.target.value, 10);
        if (isNaN(val) || val < 1) val = 1;
        state.ticketCount = val;
        
        // Update tampilan input jika user mengetik angka aneh
        // ui.ticketInput.value = val; 
        
        calculateTotals();
    });

    // 2. Tombol Terapkan Promo
    ui.applyPromoBtn.addEventListener('click', (e) => {
        e.preventDefault();
        applyPromoCode();
    });

    // 3. Submit Form check
    ui.form.addEventListener('submit', (e) => {
        // Peringatan jika kode diisi tapi belum diapply
        if (ui.promoInput.value && !state.promo) {
            const confirmSubmit = confirm('Anda memasukkan kode promo tapi belum menerapkannya. Lanjutkan tanpa diskon?');
            if (!confirmSubmit) {
                e.preventDefault();
            }
        }
    });

    // --- Init ---
    // Hitung total awal saat halaman dimuat
    calculateTotals();
});
</script>
@endsection