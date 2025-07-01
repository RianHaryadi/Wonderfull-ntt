@extends('layouts.app')

@section('title', 'Pembayaran - ' . $transaction->booking_code)

@section('content')
<div class="antialiased bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-12 px-4 sm:px-6">
    <div class="container mx-auto max-w-2xl">
        <!-- Success Notification -->
        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg mb-6 shadow-sm flex items-start">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-bold">Pemesanan Berhasil Dibuat!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Payment Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-indigo-600 px-8 py-6">
                <div class="text-center">
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">Selesaikan Pembayaran Anda</h1>
                    <div class="mt-3 flex items-center justify-center text-indigo-100">
                        <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">Pemesanan akan hangus jika tidak dibayar dalam 1x24 jam</span>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6 sm:p-8">
                <!-- Bill Summary -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Ringkasan Tagihan</h2>
                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full">#{{ $transaction->booking_code }}</span>
                    </div>
                    
                    <div class="space-y-3.5 text-sm md:text-base">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama Pemesan:</span>
                            <span class="font-medium text-gray-800">{{ $transaction->customer_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal Kunjungan:</span>
                            <span class="font-medium text-gray-800">{{ $transaction->booking_date->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Produk:</span>
                            <span class="font-medium text-gray-800 text-right">
                                {{ $transaction->destination?->name ?? $transaction->tourPackage?->name ?? '-' }}
                            </span>
                        </div>
                        
                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-700">Total Pembayaran:</span>
                                <span class="text-2xl font-bold text-indigo-600">{{ $transaction->total_price_formatted }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Metode Pembayaran</h3>
                    
                    <div class="space-y-3">
                        <!-- Bank Transfer -->
                        <div class="group relative">
                            <input type="radio" name="payment_method_choice" id="bank_transfer" value="bank_transfer" class="peer absolute opacity-0 h-0 w-0">
                            <label for="bank_transfer" class="flex items-start p-4 border rounded-lg cursor-pointer transition-all duration-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:ring-2 peer-checked:ring-indigo-200 hover:border-indigo-300">
                                <div class="flex items-center h-5 mt-0.5">
                                    <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center transition-all duration-200 group-[.peer:checked+label]:border-indigo-500">
                                        <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full scale-0 transition-transform duration-200 peer-checked:scale-100"></div>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="flex items-center">
                                        <span class="font-semibold text-gray-800">Transfer Bank</span>
                                        <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded">Rekomendasi</span>
                                    </div>
                                    <p class="text-gray-500 text-sm mt-1">Bayar melalui bank (Virtual Account)</p>
                                    <div class="mt-3 flex space-x-2">
                                        <div class="bg-white p-1.5 rounded border">
                                            <img src="https://logo.clearbit.com/bca.co.id" alt="BCA" class="h-5 object-contain">
                                        </div>
                                        <div class="bg-white p-1.5 rounded border">
                                            <img src="https://logo.clearbit.com/mandiri.co.id" alt="Mandiri" class="h-5 object-contain">
                                        </div>
                                        <div class="bg-white p-1.5 rounded border">
                                            <img src="https://logo.clearbit.com/bni.co.id" alt="BNI" class="h-5 object-contain">
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- QRIS -->
                        <div class="group relative">
                            <input type="radio" name="payment_method_choice" id="qris" value="qris" class="peer absolute opacity-0 h-0 w-0">
                            <label for="qris" class="flex items-start p-4 border rounded-lg cursor-pointer transition-all duration-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:ring-2 peer-checked:ring-indigo-200 hover:border-indigo-300">
                                <div class="flex items-center h-5 mt-0.5">
                                    <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center transition-all duration-200 group-[.peer:checked+label]:border-indigo-500">
                                        <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full scale-0 transition-transform duration-200 peer-checked:scale-100"></div>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <span class="font-semibold text-gray-800">QRIS</span>
                                    <p class="text-gray-500 text-sm mt-1">Bayar dengan QR Code melalui OVO, GoPay, dll</p>
                                    <div class="mt-3">
                                        <div class="bg-white p-1.5 rounded border inline-flex">
                                            <img src="https://logo.clearbit.com/qris.id" alt="QRIS" class="h-5 object-contain">
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Payment Button -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <form action="{{ route('transactions.pay', $transaction->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_code" value="{{ $transaction->booking_code }}">
                        <input type="hidden" name="payment_method" id="payment_method">
                        
                        <button type="submit" id="pay-button" class="w-full flex items-center justify-center gap-x-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold py-3.5 px-6 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed" disabled>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Konfirmasi Pembayaran
                        </button>
                        
                        <p class="text-xs text-gray-500 text-center mt-3">
                            Dengan melanjutkan, Anda menyetujui <a href="#" class="text-indigo-600 hover:underline">Syarat & Ketentuan</a> kami
                        </p>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Help Section -->
        <div class="mt-6 text-center">
            <a href="#" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Butuh bantuan?
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="payment_method_choice"]');
        const payButton = document.getElementById('pay-button');
        const paymentInput = document.getElementById('payment_method');

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    paymentInput.value = this.value;
                    payButton.disabled = false;
                }
            });
        });
    });
</script>
@endsection