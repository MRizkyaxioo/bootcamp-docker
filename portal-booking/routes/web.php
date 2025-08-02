<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Tampilkan semua booking
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

// Form tambah booking
Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');

// Simpan booking baru
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

// Form edit booking
Route::get('/bookings/{id}/edit', [BookingController::class, 'edit'])->name('bookings.edit');

// Update booking
Route::put('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');

// Hapus booking
Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});

require __DIR__.'/auth.php';
