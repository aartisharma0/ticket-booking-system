<?php

use Illuminate\Support\Facades\Route;

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

Route::view('/', 'home')->name('home');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

// Dynamic views
Route::get('/book/{id}', function ($id) {
    return view('booking', ['event' => (object)['id' => $id]]);
})->name('book.event');

Route::view('/my-bookings', 'my-bookings')->name('my.bookings');

// Admin view (pass eventId from controller or route param)
Route::get('/admin/bookings/{eventId}', function ($eventId) {
    return view('admin.bookings', ['eventId' => $eventId]);
})->name('admin.bookings');

