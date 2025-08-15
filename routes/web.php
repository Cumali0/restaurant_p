<?php
use App\Models\Menu; // bu satırı controller'ın en üstüne ekle
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\OrderController;

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

Route::post('/dashboard/reservations', [ReservationController::class, 'store'])->name('reservations.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::delete('/dashboard/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/dashboard/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('/dashboard/reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
});


/*
// Rezervasyon kaydetme
Route::post('/dashboard/reservations', [ReservationController::class, 'store'])->name('reservations.store');

// Rezervasyon yönetimi
Route::get('/dashboard/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::post('/dashboard/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
Route::delete('/dashboard/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');


*/




Route::get('/dashboard/login', [AdminController::class, 'showLoginForm'])->name('dashboard.login');
Route::get('/dashboard/logout', [AdminController::class, 'showLoginForm'])->name('login'); // Bu satır kesin olmalı


Route::post('/dashboard/login', [AdminController::class, 'login'])->name('dashboard.login.post');
Route::post('/dashboard/logout', [AdminController::class, 'logout'])->name('admin.logout');



Route::get('/tables-availability', [ReservationController::class, 'tablesAvailability'])->name('tables.availability');


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('tables', App\Http\Controllers\Admin\TableController::class)->except(['create', 'edit', 'show']);

});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('tables', App\Http\Controllers\Admin\TableController::class)->except(['create', 'edit', 'show']);

    Route::get('/tables/{tableId}/reservations', [App\Http\Controllers\Admin\TableController::class, 'getReservations'])
        ->name('tables.reservations');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard/analytics', [ReservationController::class, 'analytics'])->name('analytics.index');
});


Route::get('/rezervasyon-tesekkurler', function () {
    return view('thankyou');
})->name('reservation.thankyou');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/profile', [App\Http\Controllers\AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('/admin/profile', [App\Http\Controllers\AdminProfileController::class, 'update'])->name('admin.profile.update');
});




Route::get('/admin/tables', [App\Http\Controllers\Admin\TableController::class, 'index'])->name('tables.index');



Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('menus', [AdminMenuController::class, 'index'])->name('admin.menus.index');
    Route::post('menus', [AdminMenuController::class, 'store'])->name('admin.menus.store');
    Route::put('menus/{menu}', [AdminMenuController::class, 'update'])->name('admin.menus.update');
    Route::delete('menus/{menu}', [AdminMenuController::class, 'destroy'])->name('admin.menus.destroy');
});




Route::get('/', [MenuController::class, 'index'])->name('home');

Route::post('/reservation/public', [ReservationController::class, 'storePublic'])
    ->name('reservations.store.public');

// Ön sipariş sayfası
Route::get('/reservation/{id}/preorder', [ReservationController::class, 'preorder'])->name('reservation.preorder');

// Sepete ekleme
Route::post('/reservation/{reservation}/add-to-cart', [ReservationController::class,'addToCart'])->name('reservation.addToCart');

// Siparişi Tamamlama
Route::post('/reservation/{reservation}/finalize-preorder', [ReservationController::class, 'finalizePreorder']);


// Checkout (şimdilik pasif, ödeme entegrasyonu gelince açarız)
// Route::get('/reservation/{reservation}/checkout', [ReservationController::class, 'checkout'])->name('reservation.checkout');
Route::get('/payment/{order}', [OrderController::class, 'paymentPage'])->name('payment.page');
