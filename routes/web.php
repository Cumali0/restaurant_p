<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
return view('index'); // resources/views/index.blade.php
});
Route::post('/rezervasyon', [ReservationController::class, 'store'])->name('rezervasyon.store');
