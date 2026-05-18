<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController; // Import Controller Admin yang baru
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest & Public Routes (Poin #1, #4, #9, #17)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $products = \App\Models\Product::all();
    return view('Users.katalog', compact('products'));
})->name('produk');

/*
|--------------------------------------------------------------------------
| Member Routes (Poin #5, #6, #8, #12, #16)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Khusus Member (Melihat History - Poin #12)
    Route::get('/dashboard', function () {
        $orders = \App\Models\Order::where('user_id', auth()->id())->latest()->get();
        return view('Users.dashboard.dashboardusers', compact('orders'));
    })->name('dashboard');

    // Proses Pemesanan Member (Input ke Database - Poin #6)
    Route::post('/pesan-kue', [OrderController::class, 'store'])->name('order.store');

    // Management Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Poin #10, #11, #13, #14, #15)
|--------------------------------------------------------------------------
| Di sini kita menggunakan prefix 'admin' dan middleware 'auth'
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Kelola Katalog (Poin #13)
    Route::get('/katalog', [AdminController::class, 'katalog'])->name('katalog');
    
    // Kelola Pemesanan & History (Poin #11, #14)
    Route::get('/pesanan', [AdminController::class, 'pesanan'])->name('pesanan');
    Route::get('/history', [AdminController::class, 'history'])->name('history');

    // Kelola Review (Poin #15)
    Route::get('/review', [AdminController::class, 'review'])->name('review');

    // Management User (Poin #2)
    Route::get('/users', [AdminController::class, 'users'])->name('users');
});

require __DIR__.'/auth.php';