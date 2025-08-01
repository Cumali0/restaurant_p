<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('index'); // resources/views/index.blade.php
});

Route::get('/dashboard', function () {
    return view('admin.index');
});


 Route::post('/rezervasyon', [ReservationController::class, 'store'])->name('rezervasyon.store');

// Aşağıdaki admin prefix içindeki rezervasyon rotalarını komple kaldır:

/*
Route::prefix('admin')->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('admin.reservations.index');
    Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('admin.reservations.approve');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('admin.reservations.destroy');
});
*/

