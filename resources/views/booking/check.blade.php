@extends('layouts.app')

@section('title', 'Cek Status Booking')

@section('content')
<div class="min-h-screen bg-gray-50 pt-28 pb-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto space-y-8">
        
        {{-- Header Section --}}
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
                Cek Status Pesanan
            </h1>
            <p class="mt-3 text-lg text-gray-500">
                Masukkan nomor booking Anda untuk melihat detail perjalanan.
            </p>
        </div>

        {{-- Card Container --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            
            {{-- Form Section --}}
            <div class="p-8 border-b border-gray-100 bg-white">
                <form action="{{ route('booking.check') }}" method="POST" class="relative">
                    @csrf
                    <label for="booking_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Booking / Kode Reservasi</label>
                    <div class="flex gap-4">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                {{-- Search Icon --}}
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="booking_number" id="booking_number"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out sm:text-sm"
                                   value="{{ old('booking_number') }}" 
                                   placeholder="Contoh: BK-2023001" required>
                        </div>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            Cari
                        </button>
                    </div>
                    @error('booking_number')
                        <p class="text-red-500 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </form>
            </div>

            {{-- Result Section --}}
            @isset($data)
                <div class="bg-gray-50 p-8">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden relative">
                        {{-- Hiasan Garis Atas --}}
                        <div class="h-2 bg-blue-500 w-full"></div>

                        <div class="p-6">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Detail Booking</h2>
                                    <p class="text-sm text-gray-500">ID: #{{ $data->booking_number ?? $data->booking_code ?? '-' }}</p>
                                </div>
                                
                                {{-- Status Badge Dinamis --}}
                                @php
                                    $status = strtolower($data->status ?? '');
                                    $badgeColor = match($status) {
                                        'confirmed', 'success', 'paid' => 'bg-green-100 text-green-800 border-green-200',
                                        'pending', 'waiting' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'cancelled', 'failed' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200',
                                    };
                                @endphp
                                <span class="px-4 py-1.5 rounded-full text-sm font-bold border {{ $badgeColor }} uppercase tracking-wide">
                                    {{ $data->status ?? 'Unknown' }}
                                </span>
                            </div>

                            <hr class="border-dashed border-gray-200 my-6">

                            {{-- Grid Informasi Utama --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                
                                {{-- Kolom Kiri: Info Pemesan --}}
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Informasi Pemesan</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                                            <p class="font-medium text-gray-900">{{ $data->customer_name ?? $data->user?->name ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Email</p>
                                            <p class="font-medium text-gray-900 break-all">{{ $data->customer_email ?? $data->user?->email ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Nomor Telepon</p>
                                            <p class="font-medium text-gray-900">{{ $data->customer_phone ?? $data->user?->phone ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Kolom Kanan: Info Produk --}}
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Detail Layanan</h3>
                                    <div class="space-y-3">
                                        @if($bookingType === 'hotel')
                                            <div>
                                                <p class="text-sm text-gray-500">Hotel</p>
                                                <p class="font-medium text-gray-900 text-lg">{{ $data->hotel?->name ?? '-' }}</p>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <p class="text-sm text-gray-500">Check-in</p>
                                                    <p class="font-medium text-gray-900">{{ $data->check_in_date?->format('d M Y') ?? '-' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Check-out</p>
                                                    <p class="font-medium text-gray-900">{{ $data->check_out_date?->format('d M Y') ?? '-' }}</p>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Tipe Kamar</p>
                                                <p class="font-medium text-gray-900">{{ $data->room_type ?? '-' }} ({{ $data->guests ?? '0' }} Tamu)</p>
                                            </div>

                                        @elseif($bookingType === 'destination')
                                            <div>
                                                <p class="text-sm text-gray-500">Destinasi Wisata</p>
                                                <p class="font-medium text-gray-900 text-lg">{{ $data->destinationDirect?->name ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Tanggal Kunjungan</p>
                                                <p class="font-medium text-gray-900">{{ $data->booking_date?->format('d F Y') ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Tiket</p>
                                                <p class="font-medium text-gray-900">{{ $data->number_of_tickets ?? '-' }} Orang</p>
                                            </div>

                                        @elseif($bookingType === 'tour_package')
                                            <div>
                                                <p class="text-sm text-gray-500">Paket Tour</p>
                                                <p class="font-medium text-gray-900 text-lg">{{ $data->tourPackage?->name ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Lokasi</p>
                                                <p class="font-medium text-gray-900">{{ $data->tourPackage?->destination?->name ?? '-' }}</p>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <p class="text-sm text-gray-500">Mulai</p>
                                                    <p class="font-medium text-gray-900">{{ $data->tourPackage?->start_date ?? '-' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Selesai</p>
                                                    <p class="font-medium text-gray-900">{{ $data->tourPackage?->end_date ?? '-' }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Footer Promo --}}
                            @if($data->promoCode)
                            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center text-blue-600 bg-blue-50 -mx-6 -mb-6 px-6 py-3">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                <span class="text-sm font-medium">Promo Digunakan: <strong>{{ $data->promoCode->code }}</strong></span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endisset

            {{-- Fallback Error jika tidak ada data --}}
            @if(session('error'))
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 mx-8 mb-8">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection