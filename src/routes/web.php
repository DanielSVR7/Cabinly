<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CabinController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CabinController::class, 'index'])->name('cabins.index');
Route::get('/cabins/{cabin}', [CabinController::class, 'show'])->name('cabins.show');
Route::post('/cabins/{cabin}/book', [BookingController::class, 'store'])->name('bookings.store');
