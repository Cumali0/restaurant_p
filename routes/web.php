<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;

Route::get('/', function () {
    return view('index'); // resources/views/index.blade.php
});

// Dashboard (son 5 rezervasyonu gönderiyoruz)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $recentReservations = Reservation::latest()->take(5)->get();
        return view('admin.index', compact('recentReservations'));
    })->name('dashboard');
});

// Rezervasyon kaydetme
Route::post('/dashboard/reservations', [ReservationController::class, 'store'])->name('reservations.store');

// Rezervasyon yönetimi
Route::get('/dashboard/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::post('/dashboard/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
Route::delete('/dashboard/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');


Route::get('/tables-availability', [ReservationController::class, 'tablesAvailability']);


use App\Http\Controllers\AdminController;

Route::get('/dashboard/login', function () {
    return view('admin.login.index'); // resources/views/dashboard/login/index.blade.php
})->name('dashboard.login');


Route::post('/dashboard/login', [AdminController::class, 'login'])->name('dashboard.login.post');




use Illuminate\Support\Facades\Auth;

Route::post('/dashboard/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/dashboard/login'); // veya login sayfanın URL'si
})->name('logout');
