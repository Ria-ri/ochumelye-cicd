<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterClassController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Categories
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

// Cabinet (only for master)
Route::get('/cabinet', [CabinetController::class, 'index'])->name('cabinet');

// Master classes (create/edit)
Route::get('/master-class/create', [MasterClassController::class, 'create'])->name('master-class.create');
Route::post('/master-class', [MasterClassController::class, 'store'])->name('master-class.store');
Route::get('/master-class/{masterClass}/edit', [MasterClassController::class, 'edit'])->name('master-class.edit');
Route::put('/master-class/{masterClass}', [MasterClassController::class, 'update'])->name('master-class.update');
Route::get('/master-class/create', [MasterClassController::class, 'create'])->name('master-class.create');

// Booking
Route::get('/booking/confirm/{masterClass}', [BookingController::class, 'confirmForm'])->name('booking.confirm');
Route::post('/booking/{masterClass}', [BookingController::class, 'confirm'])->name('booking.store');
Route::get('/booking/cancel/{masterClass}', [BookingController::class, 'cancel'])->name('booking.cancel');
