<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LoginForm;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PaketTourController;
use App\Http\Controllers\CultureController;
use App\Http\Controllers\HotelBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransactionController;

// Halaman Utama dan Autentikasi
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', LoginForm::class)->name('login');

// Destinasi Wisata
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{id}', [DestinationController::class, 'show'])->name('destinations.show');
Route::get('/destinations/{destination}/book', [DestinationController::class, 'book'])->name('destinations.book');
Route::post('/destinations/store', [DestinationController::class, 'store'])->name('destinations.store');
Route::get('/transactions/{booking_code}/payment', [TransactionController::class, 'payment'])->name('transaction.payment');

// Hotel
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');
Route::get('/hotels/{hotel}/book', [HotelBookingController::class, 'create'])->name('hotels.book');

// Booking Hotel
Route::post('/booking/hotel', [HotelBookingController::class, 'store'])->name('booking.hotel.store');
Route::get('/booking/success/{id}', [HotelBookingController::class, 'success'])->name('booking.success');   


// Pengecekan Booking (Hotel/Tour)
Route::get('/booking/check', [BookingController::class, 'checkForm'])->name('booking.checkForm');
Route::post('/booking/check', [BookingController::class, 'check'])->name('booking.check');
Route::get('/booking/{booking_number}', [BookingController::class, 'show'])->name('booking.show');

// Paket Tour
Route::get('/paket-tours', [PaketTourController::class, 'index'])->name('paket-tours.index');
Route::get('/paket-tours/{id}', [PaketTourController::class, 'show'])->name('paket-tours.show');
Route::get('/paket-tour/create/{tourPackage}', [PaketTourController::class, 'create'])->name('paket-tour.create');
Route::post('/paket-tour/store', [PaketTourController::class, 'store'])->name('paket-tour.store'); 

// Budaya
Route::get('/cultures', [CultureController::class, 'index'])->name('cultures.index');

// route transaksi
Route::get('/transactions/{booking_code}/payment', [TransactionController::class, 'payment'])->name('transaction.payment');
Route::post('/transactions/{transaction}/pay', [TransactionController::class, 'confirmPayment'])->name('transactions.pay');
Route::get('/transactions/{booking_code}/success', [TransactionController::class, 'success'])->name('transactions.success');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
