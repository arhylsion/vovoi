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

// 3. Keranjang Belanja (Shopping Cart)
Route::get('/keranjang', [ProductController::class, 'cart'])->name('cart');
Route::get('/cart', [ProductController::class, 'cart']);
Route::post('/keranjang/tambah', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/keranjang/hapus/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

// 4. Validasi Kode Voucher Diskon (AJAX / Live)
Route::post('/voucher/cek', [ProductController::class, 'checkVoucher'])->name('voucher.check');

// =========================================================
// JALUR AUTENTIKASI (LOGIN, REGISTER, & LOGOUT)
// =========================================================

Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================
// JALUR TERPROTEKSI CUSTOMER (AUTH - MODUL 4 & 5)
// =========================================================

Route::middleware(['auth'])->group(function () {
    // 1. Checkout: Mendukung Beli Langsung & Keranjang Belanja Multi-Produk
    Route::get('/checkout/{id?}', [ProductController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/proses', [ProductController::class, 'storeTransaction'])->name('checkout.process');

    // 2. Invoice Dinamis & Cetak E-Invoice (Dilindungi Cek Kepemilikan 403)
    Route::get('/berhasil/{id?}', [ProductController::class, 'success'])->name('checkout.success');

    // 3. Halaman Pesanan Saya (Modul 5 & Matriks QA No. 9)
    Route::get('/pesanan-saya', [ProductController::class, 'myOrders'])->name('orders.mine');

    // 4. Pembatalan Pesanan oleh Pembeli Selama Status 'Pending' (Stok Kembali)
    Route::post('/pesanan/{id}/batal', [ProductController::class, 'cancelOrder'])->name('order.cancel');

    // 5. Ulasan dan Rating Bintang 1-5 untuk Pesanan Berstatus 'Shipped'
    Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');

    // 6. Profil Customer (Ubah Nama, No HP, Alamat Default, Kata Sandi)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// =========================================================
// JALUR SELLER CENTER (ADMINISTRATION PORTAL - KHUSUS ROLE ADMIN)
// =========================================================

Route::middleware(['auth', 'admin'])->group(function () {
    // Manajemen Pesanan & Ekspor Laporan
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::post('/admin/transactions/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.transactions.status');
    Route::post('/admin/transactions/{id}/delete', [AdminController::class, 'deleteTransaction'])->name('admin.transactions.delete');
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
