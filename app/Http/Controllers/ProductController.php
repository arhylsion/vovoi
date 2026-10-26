<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction; // <-- [WAJIB] Panggil Model Transaction untuk menyimpan pesanan
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    // FUNGSI 1: Menampilkan seluruh produk di Katalog (P5)
    public function index(): View
    {
        // 1. Manajer menarik seluruh data dari Gudang
        $products = Product::all();

        // 2. Manajer melempar paket data tersebut ke halaman 'katalog'
        return view('katalog', compact('products'));
    }

    // FUNGSI 2: Menampilkan 1 produk spesifik di halaman Detail (P6)
    public function show(int|string $id): View
    {
        // 1. Manajer mencari SATU produk di database berdasarkan ID dari URL
        // Fitur orFail akan otomatis memunculkan 404 jika ID diketik sembarangan
        $product = Product::findOrFail($id);

        // 2. Jika ketemu, kirim paket data tunggal tersebut ke halaman 'detail'
        return view('detail', compact('product'));
    }

    // FUNGSI 3: Menampilkan halaman Form Checkout dengan membawa data barang yang dipilih (P7)
    public function checkout(int|string|null $id = null): View|RedirectResponse
    {
        // Jika ID diberikan, cari produk spesifik; jika tidak, ambil produk pertama agar /checkout tidak 404
        $product = $id ? Product::findOrFail($id) : Product::first();

        if (! $product) {
            return redirect('/katalog');
        }

        return view('checkout', compact('product'));
    }

    // FUNGSI 4: Menangkap kiriman Form (POST), menghitung total, dan menyimpan ke MySQL (P7)
    public function storeTransaction(Request $request): RedirectResponse
    {
        // A. Cari data produk asli di database berdasarkan product_id yang dikirim form
        $product = Product::findOrFail($request->product_id);

        // B. Tentukan tarif ongkos kirim otomatis berdasarkan pilihan kurir
        $shipping_cost = 15000; // Tarif dasar JNE Reguler
        if ($request->courier === 'J&T Express') {
            $shipping_cost = 20000;
        } elseif ($request->courier === 'SiCepat BEST') {
            $shipping_cost = 25000;
        }

        // C. Hitung Total Bayar: (Harga Produk x Jumlah Beli) + Ongkos Kirim
        $quantity = (int) $request->quantity;
        $subtotal = $product->price * $quantity;
        $total_amount = $subtotal + $shipping_cost;

        // D. Buat kode Invoice unik otomatis (Contoh: INV-2026-4829)
        $invoice_code = 'INV-2026-'.rand(1000, 9999);

        // E. Simpan (INSERT) seluruh data transaksi ke dalam tabel MySQL
        $transaction = Transaction::create([
            'invoice_code' => $invoice_code,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'courier' => $request->courier,
            'quantity' => $quantity,
            'shipping_cost' => $shipping_cost,
            'total_amount' => $total_amount,
            'status' => 'Pending',
        ]);

        // F. Arahkan pembeli menuju halaman Berhasil sambil membawa ID transaksi barunya
        return redirect('/berhasil/'.$transaction->id);
    }

    // FUNGSI 5: Menampilkan halaman Invoice Berhasil berdasarkan ID Transaksi (P7)
    public function success(int|string|null $id = null): View|RedirectResponse
    {
        // Jika ID diberikan, cari transaksi spesifik; jika tidak, ambil transaksi terbaru agar /berhasil tidak 404
        $transaction = $id ? Transaction::findOrFail($id) : Transaction::latest('id')->first();

        if (! $transaction) {
            return redirect('/katalog');
        }

        return view('berhasil', compact('transaction'));
    }

    // FUNGSI 6: Menampilkan halaman Keranjang Belanja (Shopping Cart)
    public function cart(Request $request): View
    {
        $cart = session()->get('cart', []);

        // Jika ada request ?add=ID, tambahkan produk ke keranjang
        if ($request->has('add')) {
            $addId = (int) $request->query('add');
            $prod = Product::find($addId);
            if ($prod) {
                if (isset($cart[$addId])) {
                    $cart[$addId]['quantity']++;
                } else {
                    $cart[$addId] = [
                        'id' => $prod->id,
                        'name' => $prod->name,
                        'price' => $prod->price,
                        'image' => $prod->image,
                        'quantity' => 1,
                    ];
                }
                session()->put('cart', $cart);
            }
        }

        // Inisialisasi awal jika keranjang kosong agar pengguna langsung melihat tampilan keranjang interaktif
        if (empty($cart)) {
            $defaultProduct = Product::first();
            if ($defaultProduct) {
                $cart[$defaultProduct->id] = [
                    'id' => $defaultProduct->id,
                    'name' => $defaultProduct->name,
                    'price' => $defaultProduct->price,
                    'image' => $defaultProduct->image,
                    'quantity' => 1,
                ];
                session()->put('cart', $cart);
            }
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $recommendedProducts = Product::take(4)->get();

        return view('keranjang', compact('cart', 'subtotal', 'recommendedProducts'));
    }

    // FUNGSI 7: Tambah barang ke keranjang via Form POST
    public function addToCart(Request $request): RedirectResponse
    {
        $productId = (int) $request->input('product_id');
        $qty = max(1, (int) $request->input('quantity', 1));
        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $qty;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $qty,
            ];
        }

        session()->put('cart', $cart);

        return redirect('/keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // FUNGSI 8: Hapus barang dari keranjang
    public function removeFromCart(int|string $id): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect('/keranjang')->with('info', 'Barang berhasil dihapus dari keranjang.');
    }
}
