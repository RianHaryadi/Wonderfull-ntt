@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6">
    <div class="max-w-3xl mx-auto">
        <!-- Success Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-emerald-500 px-6 py-8 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-white bg-opacity-20 mb-4">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Pembayaran Berhasil!</h1>
                <p class="text-emerald-100 mt-2">Terima kasih telah memesan dengan kami</p>
            </div>

            <!-- Content -->
            <div class="p-6 sm:p-8">
                <!-- Booking Summary -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Pemesanan</h2>
                    
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Kode Booking</p>
                                <p class="font-mono font-bold text-indigo-600 text-lg">{{ $transaction->booking_code }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Pembayaran</p>
                                <p class="font-medium text-gray-800">{{ now()->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nama Pemesan</p>
                                <p class="font-medium text-gray-800">{{ $transaction->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Pembayaran</p>
                                <p class="font-bold text-gray-800">{{ $transaction->total_price_formatted }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tickets Section -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">
                        Tiket Anda
                        <span class="ml-2 bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $transaction->tickets->count() }} Tiket
                        </span>
                    </h2>

                    <div class="space-y-4">
                        @foreach($transaction->tickets as $ticket)
                        <div class="border rounded-lg p-4 hover:border-indigo-300 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $transaction->destination?->name ?? $transaction->tourPackage?->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <span class="font-medium">{{ $ticket->visitor_name }}</span>
                                    </p>
                                </div>
                                <div class="bg-indigo-50 text-indigo-800 px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $ticket->ticket_code }}
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-dashed border-gray-200">
                                <p class="text-sm text-gray-500">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $transaction->booking_date->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex justify-center">
                    <a href="{{ url('/') }}"
                    class="inline-flex items-center justify-center gap-2 w-full max-w-md bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-base px-6 py-3 rounded-xl shadow-md transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
                
                <!-- Help Info -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">Butuh bantuan? 
                        <a href="#" class="text-indigo-600 hover:underline">Hubungi kami</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection