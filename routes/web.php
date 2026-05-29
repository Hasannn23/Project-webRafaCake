<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest & Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $products = \App\Models\Product::all();
    return view('Users.katalog', compact('products'));
})->name('produk');

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Khusus Member (Melihat History Pesanan)
    Route::get('/dashboard', function () {
        $orders = \App\Models\Order::with('review')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('Users.dashboard.dashboardusers', compact('orders'));
    })->name('dashboard');

    // Proses Pemesanan Member
    Route::post('/pesan-kue', [OrderController::class, 'store'])->name('order.store');

    // Review CRUD (Member)
    Route::post('/review/{order}', [ReviewController::class, 'store'])->name('review.store');
    Route::put('/review/{review}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');

    // Management Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Kelola Katalog (CRUD)
    Route::get('/katalog', [AdminController::class, 'katalog'])->name('katalog');
    Route::get('/katalog/create', [AdminController::class, 'createProduct'])->name('katalog.create');
    Route::post('/katalog', [AdminController::class, 'storeProduct'])->name('katalog.store');
    Route::get('/katalog/{id}/edit', [AdminController::class, 'editProduct'])->name('katalog.edit');
    Route::put('/katalog/{id}', [AdminController::class, 'updateProduct'])->name('katalog.update');
    Route::delete('/katalog/{id}', [AdminController::class, 'destroyProduct'])->name('katalog.destroy');
    Route::patch('/katalog/{id}/toggle-status', [AdminController::class, 'toggleProductStatus'])->name('katalog.toggleStatus');
    
    // Kelola Pemesanan & History
    Route::get('/pesanan', [AdminController::class, 'pesanan'])->name('pesanan');
    Route::patch('/pesanan/{id}/status', [AdminController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::get('/history', [AdminController::class, 'history'])->name('history');

    // Kelola Review
    Route::get('/review', [AdminController::class, 'review'])->name('review');
    Route::delete('/review/{id}', [AdminController::class, 'destroyReview'])->name('review.destroy');

    // Kelola User (CRUD)
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

require __DIR__.'/auth.php';