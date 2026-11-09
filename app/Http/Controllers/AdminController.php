<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    // =========================================================================
    // MATERI PERTEMUAN 8: MANAJEMEN PESANAN MASUK & AGGREGATE QUERY
    // =========================================================================

    // FUNGSI 1: Menampilkan Halaman Dashboard & Tabel Pesanan Masuk (P8)
    public function transactions(): View
    {
        // A. Mengambil seluruh pesanan diurutkan dari yang paling baru masuk (latest)
        $transactions = Transaction::latest()->get();

        // B. Menghitung ringkasan bisnis otomatis (Aggregate Query)
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total_amount');

        // C. Mengirimkan seluruh data ke view resources/views/admin/transactions.blade.php
        return view('admin.transactions', compact(
            'transactions',
            'totalProducts',
            'totalTransactions',
            'totalRevenue'
        ));
    }

    // FUNGSI 2: Memperbarui Status Pesanan (Pending -> Paid / Shipped) (P8)
    public function updateStatus(Request $request, int|string $id): RedirectResponse
    {
        // A. Cari baris transaksi berdasarkan ID yang dikirim dari tabel Admin
        $transaction = Transaction::findOrFail($id);

        // B. Perbarui (UPDATE) kolom 'status' di MySQL sesuai tombol yang diklik Admin
        $transaction->update([
            'status' => $request->status,
        ]);

        // C. Kembalikan ke halaman tabel Admin sambil mengirim notifikasi Flash Session
        return back()->with(
            'success',
            'Status pesanan ' . $transaction->invoice_code . ' atas nama ' . $transaction->customer_name . ' berhasil diubah menjadi: ' . $request->status
        );
    }

    // =========================================================================
    // MATERI PERTEMUAN 9: MANAJEMEN PRODUK & UPLOAD FILE GAMBAR
    // =========================================================================

    // FUNGSI 3: Menampilkan Daftar Katalog Produk di Seller Center (P9)
    public function products(): View
    {
        // Mengambil seluruh produk diurutkan dari yang terbaru ditambahkan
        $products = Product::latest()->get();

        return view('admin.products', compact('products'));
    }

    // FUNGSI 4: Menampilkan Formulir Tambah Produk Baru (P9)
    public function createProduct(): View
    {
        return view('admin.create_product');
    }

    // FUNGSI 5: Memvalidasi Input, Mengunggah File Foto, & Menyimpan Produk ke MySQL (P9)
    public function storeProduct(Request $request): RedirectResponse
    {
        // A. Validasi ketahanan data dan keamanan file gambar (Maksimal 2MB / 2048 KB)
        $request->validate([
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:100',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // B. Proses penamaan unik dan pemindahan file foto ke folder public/assets/images
        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Membuat nama unik: gabungan detik saat ini + nama asli file (tanpa spasi)
            $imageName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            // Pindahkan fisik file ke folder public/assets/images
            $file->move(public_path('assets/images'), $imageName);
        }

        // C. Simpan baris data produk baru ke tabel products di MySQL
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        // D. Arahkan kembali ke halaman Daftar Produk Admin dengan notifikasi sukses
        return redirect('/admin/products')->with(
            'success',
            'Produk "' . $request->name . '" berhasil ditambahkan dan langsung tayang di etalase toko!'
        );
    }
}

