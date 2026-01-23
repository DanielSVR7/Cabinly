<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CabinController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminCabinController;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CabinController::class, 'index'])->name('cabins.index');
Route::get('/cabins/{cabin}', [CabinController::class, 'show'])->name('cabins.show');
Route::post('/cabins/{cabin}/book', [BookingController::class, 'store'])->name('bookings.store');

Route::get('/admin', [AdminAuthController::class, 'create'])->name('admin.login');
Route::post('/admin', [AdminAuthController::class, 'store'])->name('admin.login.store');
Route::post('/admin/logout', [AdminAuthController::class, 'destroy'])->name('admin.logout');

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/cabins/{cabin}/edit', [AdminCabinController::class, 'edit'])->name('cabins.edit');
    Route::put('/cabins/{cabin}', [AdminCabinController::class, 'update'])->name('cabins.update');
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
});
