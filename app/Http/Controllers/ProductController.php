<?php

namespace App\Http\Controllers;

use App\Models\Product; // Panggil Model Database (Kepala Gudang)
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        // 1. Manajer menarik seluruh data dari Gudang
        $products = Product::all();

        // 2. Manajer melempar paket data tersebut ke halaman 'katalog'
        return view('katalog', compact('products'));
    }

    public function show(int|string $id): View
    {
        // 1. Manajer mencari SATU produk di database berdasarkan ID dari URL
        // Fitur orFail akan otomatis memunculkan 404 jika ID diketik sembarangan
        $product = Product::findOrFail($id);

        // 2. Jika ketemu, kirim paket data tunggal tersebut ke halaman 'detail'
        return view('detail', compact('product'));
    }
}
