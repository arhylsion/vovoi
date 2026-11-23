<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// =========================================================
// JALUR FRONT-STORE (SISI PEMBELI & PUBLIK)
// =========================================================

// 1. Katalog Produk Utama dengan Pencarian, Sorting, & Filter Kategori
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/katalog', [ProductController::class, 'index'])->name('catalog');

Route::get('/landing', function () {
    return view('landing');
});

// 2. Detail Produk & Ulasan Pembeli
Route::get('/detail/{id}', [ProductController::class, 'show'])->name('product.detail');

// 3. Checkout: Mendukung Beli Langsung & Keranjang Belanja Multi-Produk
Route::get('/checkout/{id?}', [ProductController::class, 'checkout'])->name('checkout');
Route::post('/checkout/proses', [ProductController::class, 'storeTransaction'])->name('checkout.process');

// 4. Invoice Dinamis & Cetak E-Invoice
Route::get('/berhasil/{id?}', [ProductController::class, 'success'])->name('checkout.success');

// 5. Keranjang Belanja (Shopping Cart)
Route::get('/keranjang', [ProductController::class, 'cart'])->name('cart');
Route::get('/cart', [ProductController::class, 'cart']);
Route::post('/keranjang/tambah', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/keranjang/hapus/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

// 6. Validasi Kode Voucher Diskon (AJAX / Live)
Route::post('/voucher/cek', [ProductController::class, 'checkVoucher'])->name('voucher.check');

// 7. Pembatalan Pesanan oleh Pembeli Selama Status 'Pending' (Stok Kembali)
Route::post('/pesanan/{id}/batal', [ProductController::class, 'cancelOrder'])->name('order.cancel');

// 8. Ulasan dan Rating Bintang 1-5 untuk Pesanan Berstatus 'Shipped'
Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');

// =========================================================
// JALUR AUTENTIKASI (LOGIN & LOGOUT)
// =========================================================

Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================
// JALUR TERPROTEKSI MIDDLEWARE AUTH (CUSTOMER & ADMIN)
// =========================================================

Route::middleware(['auth'])->group(function () {
    // Profil Customer (Ubah Nama, No HP, Alamat Default, Kata Sandi)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // =====================================================
    // SELLER CENTER (ADMINISTRATION PORTAL)
    // =====================================================

    // Manajemen Pesanan & Ekspor Laporan
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::post('/admin/transactions/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.transactions.status');
    Route::get('/admin/transactions/export/csv', [AdminController::class, 'exportCsv'])->name('admin.transactions.export.csv');
    Route::get('/admin/transactions/export/excel', [AdminController::class, 'exportExcel'])->name('admin.transactions.export.excel');
    Route::get('/admin/transactions/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.transactions.export.pdf');

    // Manajemen Katalog Produk (CRUD & Upload Gambar & Stok & Kategori)
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/admin/products/store', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.product.edit');
    Route::post('/admin/products/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::post('/admin/products/{id}/delete', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');

    // Manajemen Kategori Produk (CRUD Tabel categories)
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::post('/admin/categories/{id}/update', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::post('/admin/categories/{id}/delete', [CategoryController::class, 'destroy'])->name('admin.categories.delete');
});
