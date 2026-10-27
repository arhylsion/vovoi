<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// 1. Jalur Beranda Katalog (Dari P5)
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/katalog', [ProductController::class, 'index'])->name('catalog');

Route::get('/landing', function () {
    return view('landing');
});

// 2. Jalur Detail Produk Dinamis (Dari P6)
Route::get('/detail/{id}', [ProductController::class, 'show'])->name('product.detail');

// 3. Jalur Menampilkan Formulir Checkout sesuai ID Barang (MATERI P7 - ID opsional agar /checkout tidak 404)
Route::get('/checkout/{id?}', [ProductController::class, 'checkout'])->name('checkout');

// 4. Jalur Rahasia (POST) untuk Merekam Pesanan ke Database (MATERI P7)
Route::post('/checkout/proses', [ProductController::class, 'storeTransaction'])->name('checkout.process');

// 5. Jalur Menampilkan Halaman Berhasil & Invoice Dinamis (MATERI P7 - ID opsional agar /berhasil tidak 404)
Route::get('/berhasil/{id?}', [ProductController::class, 'success'])->name('checkout.success');

// 6. Jalur Keranjang Belanja (Shopping Cart)
Route::get('/keranjang', [ProductController::class, 'cart'])->name('cart');
Route::get('/cart', [ProductController::class, 'cart']);
Route::post('/keranjang/tambah', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/keranjang/hapus/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/admin/transactions', [AdminController::class, 'transactions']);
Route::post('/admin/transactions/{id}/status', [AdminController::class, 'updateStatus']);
