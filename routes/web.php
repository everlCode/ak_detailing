<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingRequestController;
use App\Http\Controllers\ContactsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services/{alias}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts');

Route::post('/booking', [BookingRequestController::class, 'store'])->name('booking.store');
