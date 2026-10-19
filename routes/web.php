<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// JALUR BARU (Menuju Manajer dulu, baru dirender ke Tampilan):
Route::get('/', [ProductController::class, 'index']);
Route::get('/katalog', [ProductController::class, 'index']);

Route::get('/landing', function () {
    return view('landing');
});

Route::get('/detail/{id}', [ProductController::class, 'show'])->name('product.detail');

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/berhasil', function () {
    return view('berhasil');
});
