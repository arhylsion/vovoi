<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Voucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Katalog Dinamis dengan Fitur Search, Filter Kategori, & Filter Harga
     */
    public function index(Request $request): View
    {
        $query = Product::with('category', 'reviews');

        // Filter Kategori (P12 Innovation)
        if ($request->filled('category')) {
            $catSlug = $request->query('category');
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        } elseif ($request->filled('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        // Pencarian Nama / Deskripsi
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('description', 'LIKE', '%'.$keyword.'%');
            });
        }

        // Pengurutan / Sorting
        if ($request->sort == 'termurah') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'termahal') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->get();
        $categories = Category::withCount('products')->get();

        return view('katalog', compact('products', 'categories'));
    }

    /**
     * Menampilkan 1 produk spesifik di halaman Detail
     */
    public function show(int|string $id): View
    {
        $product = Product::with(['category', 'reviews' => function ($q) {
            $q->latest();
        }])->findOrFail($id);

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                if ($product->category_id) {
                    $q->where('category_id', $product->category_id);
                }
            })
            ->take(4)
            ->get();

        return view('detail', compact('product', 'relatedProducts'));
    }

    /**
     * Menampilkan formulir Checkout: mendukung Beli Langsung (single) dan Keranjang Belanja (multi-produk)
     */
    public function checkout(int|string|null $id = null): View|RedirectResponse
    {
        // P1 Checklist: Tamu yang ingin beli diarahkan ke halaman login
        if (! Auth::check()) {
            return redirect()->guest('/login')->with('error', 'Silakan masuk ke akun Anda terlebih dahulu untuk melanjutkan pembelian.');
        }

        $cart = session()->get('cart', []);

        // Skenario 1: Checkout Multi-Produk dari Keranjang Belanja jika ada barang di keranjang
        if (($id === null || $id === 'cart') && ! empty($cart)) {
            $items = [];
            $subtotal = 0;
            foreach ($cart as $cId => $item) {
                $p = Product::find($cId);
                if ($p) {
                    $item['stock'] = $p->stock;
                    $item['subtotal'] = $p->price * $item['quantity'];
                    $subtotal += $item['subtotal'];
                    $items[] = $item;
                }
            }

            if (! empty($items)) {
                $user = Auth::user();

                return view('checkout', [
                    'isCart' => true,
                    'items' => $items,
                    'subtotal' => $subtotal,
                    'product' => Product::find($items[0]['id'] ?? 1) ?? Product::first(),
                    'user' => $user,
                ]);
            }
        }

        // Skenario 2: Beli Langsung 1 Produk Spesifik (atau produk pertama jika /checkout diakses tanpa cart)
        $product = ($id && $id !== 'cart') ? Product::findOrFail($id) : Product::first();

        if (! $product) {
            return redirect('/katalog');
        }

        if ($product->isOutOfStock() && $id) {
            return redirect('/detail/'.$product->id)->with('error', 'Mohon maaf, stok produk ini sedang habis.');
        }

        $user = Auth::user();

        return view('checkout', [
            'isCart' => false,
            'product' => $product,
            'items' => [
                [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => 1,
                    'subtotal' => $product->price,
                    'stock' => $product->stock,
                ],
            ],
            'subtotal' => $product->price,
            'user' => $user,
        ]);
    }

    /**
     * Merekam pesanan ke Database, memvalidasi stok, mengurangi stok, dan menerapkan voucher
     */
    public function storeTransaction(Request $request): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect('/login')->with('error', 'Silakan masuk ke akun Anda terlebih dahulu untuk menyelesaikan pembelian.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:30',
            'customer_address' => 'required|string|max:500',
            'courier' => 'required|string',
        ]);

        // Hitung Ongkos Kirim
        $shipping_cost = 15000; // JNE Reguler
        if ($request->courier === 'J&T Express') {
            $shipping_cost = 20000;
        } elseif ($request->courier === 'SiCepat BEST') {
            $shipping_cost = 25000;
        }

        $isCartCheckout = $request->boolean('is_cart') || $request->input('checkout_mode') === 'cart';
        $cart = session()->get('cart', []);

        // Cek Diskon Voucher
        $voucherCode = strtoupper(trim((string) $request->input('voucher_code', '')));
        $discountAmount = 0;

        return DB::transaction(function () use ($request, $shipping_cost, $isCartCheckout, $cart, $voucherCode, &$discountAmount) {
            $itemsToProcess = [];
            $totalQty = 0;
            $subtotal = 0;

            if ($isCartCheckout && ! empty($cart)) {
                // Multi-product checkout dari keranjang belanja
                foreach ($cart as $prodId => $cartItem) {
                    $product = Product::lockForUpdate()->findOrFail($prodId);
                    $qty = (int) ($cartItem['quantity'] ?? 1);

                    if ($product->stock < $qty) {
                        throw new \Exception("Stok {$product->name} tidak mencukupi (sisa: {$product->stock}).");
                    }

                    $lineSubtotal = $product->price * $qty;
                    $subtotal += $lineSubtotal;
                    $totalQty += $qty;

                    $itemsToProcess[] = [
                        'product' => $product,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $qty,
                        'subtotal' => $lineSubtotal,
                    ];
                }
            } else {
                // Single product direct checkout
                $product = Product::lockForUpdate()->findOrFail($request->product_id);
                $qty = max(1, (int) $request->input('quantity', 1));

                if ($product->stock < $qty) {
                    return redirect()->back()->withInput()->with('error', "Stok {$product->name} tidak mencukupi (sisa: {$product->stock}).");
                }

                $subtotal = $product->price * $qty;
                $totalQty = $qty;

                $itemsToProcess[] = [
                    'product' => $product,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];
            }

            // Validasi & Hitung Nilai Voucher
            if ($voucherCode) {
                $voucher = Voucher::where('code', $voucherCode)->where('is_active', true)->first();
                if ($voucher) {
                    $discountAmount = $voucher->calculateDiscount($subtotal);
                } elseif (in_array($voucherCode, ['VOVOIHEMAT', 'VOVOI', 'VOVOI500', 'DISKON10'])) {
                    // Fallback built-in voucher codes
                    if ($voucherCode === 'VOVOIHEMAT') {
                        $discountAmount = min(50000, $subtotal);
                    } elseif ($voucherCode === 'VOVOI' || $voucherCode === 'VOVOI500') {
                        $discountAmount = min(500000, $subtotal);
                    } elseif ($voucherCode === 'DISKON10') {
                        $discountAmount = (int) round(($subtotal * 10) / 100);
                    }
                }
            }

            $total_amount = max(0, $subtotal + $shipping_cost - $discountAmount);
            $invoice_code = 'INV-2026-'.rand(1000, 9999);

            $primaryProduct = $itemsToProcess[0]['product'];
            $displayName = $primaryProduct->name;
            if (count($itemsToProcess) > 1) {
                $displayName .= ' (+'.(count($itemsToProcess) - 1).' item lainnya)';
            }

            // Simpan Transaksi Utama
            $transaction = Transaction::create([
                'invoice_code' => $invoice_code,
                'user_id' => Auth::id(),
                'product_id' => $primaryProduct->id,
                'product_name' => $displayName,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'courier' => $request->courier,
                'quantity' => $totalQty,
                'shipping_cost' => $shipping_cost,
                'voucher_code' => $voucherCode ?: null,
                'discount_amount' => $discountAmount,
                'total_amount' => $total_amount,
                'status' => 'Pending',
            ]);

            // Simpan Rincian Item Transaksi & Kurangi Stok Produk
            foreach ($itemsToProcess as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Kurangi stok produk secara langsung
                $item['product']->decrement('stock', $item['quantity']);
            }

            // Kosongkan keranjang jika checkout berasal dari keranjang
            if ($isCartCheckout) {
                session()->forget('cart');
            }

            return redirect('/berhasil/'.$transaction->id);
        });
    }

    /**
     * Menampilkan halaman Invoice Berhasil & E-Invoice Cetak
     */
    public function success(int|string|null $id = null): View|RedirectResponse
    {
        $transaction = $id
            ? Transaction::with(['items.product', 'reviews'])->findOrFail($id)
            : Transaction::with(['items.product', 'reviews'])->latest('id')->first();

        if (! $transaction) {
            return redirect('/katalog');
        }

        // P5 Checklist: Customer tidak boleh membuka pesanan milik customer lain (Ditolak 403)
        if ($transaction->user_id) {
            if (! Auth::check()) {
                return redirect()->guest('/login')->with('error', 'Silakan masuk terlebih dahulu untuk melihat pesanan ini.');
            }

            if ($transaction->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
                abort(403, 'Akses ditolak: Anda tidak memiliki izin untuk melihat detail pesanan ini.');
            }
        }

        return view('berhasil', compact('transaction'));
    }

    /**
     * Pembatalan Pesanan oleh Pembeli Selama Status 'Pending' (Stok Kembali Bertambah)
     */
    public function cancelOrder(int|string $id): RedirectResponse
    {
        $transaction = Transaction::with('items')->findOrFail($id);

        if ($transaction->status !== 'Pending') {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan karena status saat ini adalah: '.$transaction->status);
        }

        DB::transaction(function () use ($transaction) {
            // Kembalikan stok untuk semua item
            if ($transaction->items->count() > 0) {
                foreach ($transaction->items as $item) {
                    if ($item->product_id) {
                        $product = Product::find($item->product_id);
                        if ($product) {
                            $product->increment('stock', $item->quantity);
                        }
                    }
                }
            } else {
                // Fallback transaksi lama tanpa tabel items
                $product = Product::find($transaction->product_id);
                if ($product) {
                    $product->increment('stock', $transaction->quantity);
                }
            }

            $transaction->update([
                'status' => 'Cancelled',
            ]);
        });

        return back()->with('success', 'Pesanan '.$transaction->invoice_code.' berhasil dibatalkan. Stok barang telah dikembalikan ke etalase.');
    }

    /**
     * Halaman Keranjang Belanja
     */
    public function cart(Request $request): View
    {
        $cart = session()->get('cart', []);

        // Tambah produk via query parameter (?add=ID)
        if ($request->has('add')) {
            $addId = (int) $request->query('add');
            $prod = Product::find($addId);
            if ($prod && $prod->stock > 0) {
                if (isset($cart[$addId])) {
                    $cart[$addId]['quantity']++;
                } else {
                    $cart[$addId] = [
                        'id' => $prod->id,
                        'name' => $prod->name,
                        'price' => $prod->price,
                        'image' => $prod->image,
                        'quantity' => 1,
                        'stock' => $prod->stock,
                    ];
                }
                session()->put('cart', $cart);
            }
        }

        // Inisialisasi awal jika keranjang kosong
        if (empty($cart)) {
            $defaultProduct = Product::where('stock', '>', 0)->first();
            if ($defaultProduct) {
                $cart[$defaultProduct->id] = [
                    'id' => $defaultProduct->id,
                    'name' => $defaultProduct->name,
                    'price' => $defaultProduct->price,
                    'image' => $defaultProduct->image,
                    'quantity' => 1,
                    'stock' => $defaultProduct->stock,
                ];
                session()->put('cart', $cart);
            }
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $recommendedProducts = Product::where('stock', '>', 0)->take(4)->get();

        return view('keranjang', compact('cart', 'subtotal', 'recommendedProducts'));
    }

    /**
     * Tambah barang ke keranjang via Form POST
     */
    public function addToCart(Request $request): RedirectResponse
    {
        $productId = (int) $request->input('product_id');
        $qty = max(1, (int) $request->input('quantity', 1));
        $product = Product::findOrFail($productId);

        if ($product->isOutOfStock()) {
            return back()->with('error', 'Produk ini sedang habis stok.');
        }

        $cart = session()->get('cart', []);

        $currentQty = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        if (($currentQty + $qty) > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia (sisa stok: '.$product->stock.').');
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $qty;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $qty,
                'stock' => $product->stock,
            ];
        }

        session()->put('cart', $cart);

        return redirect('/keranjang')->with('success', 'Produk "'.$product->name.'" berhasil ditambahkan ke keranjang!');
    }

    /**
     * Hapus barang dari keranjang
     */
    public function removeFromCart(int|string $id): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect('/keranjang')->with('info', 'Barang berhasil dihapus dari keranjang belanja.');
    }

    /**
     * AJAX Endpoint Validasi Kode Voucher Diskon
     */
    public function checkVoucher(Request $request): JsonResponse
    {
        $code = strtoupper(trim((string) $request->input('code', '')));
        $subtotal = (int) $request->input('subtotal', 0);

        if (! $code) {
            return response()->json([
                'valid' => false,
                'message' => 'Silakan masukkan kode voucher.',
            ], 422);
        }

        $voucher = Voucher::where('code', $code)->where('is_active', true)->first();

        if ($voucher) {
            if ($subtotal < $voucher->min_order) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Minimum belanja untuk voucher ini adalah Rp '.number_format($voucher->min_order, 0, ',', '.'),
                ]);
            }

            $discount = $voucher->calculateDiscount($subtotal);

            return response()->json([
                'valid' => true,
                'code' => $voucher->code,
                'name' => $voucher->name,
                'discount' => $discount,
                'message' => 'Voucher berhasil digunakan! Hemat Rp '.number_format($discount, 0, ',', '.'),
            ]);
        }

        // Built-in codes
        if ($code === 'VOVOIHEMAT') {
            $discount = min(50000, $subtotal);

            return response()->json([
                'valid' => true,
                'code' => 'VOVOIHEMAT',
                'discount' => $discount,
                'message' => 'Voucher VOVOI Hemat diterapkan! Potongan Rp '.number_format($discount, 0, ',', '.'),
            ]);
        } elseif ($code === 'VOVOI500' || $code === 'VOVOI') {
            $discount = min(500000, $subtotal);

            return response()->json([
                'valid' => true,
                'code' => $code,
                'discount' => $discount,
                'message' => 'Voucher Spesial VOVOI Rp 500.000 berhasil diterapkan!',
            ]);
        } elseif ($code === 'DISKON10') {
            $discount = (int) round(($subtotal * 10) / 100);

            return response()->json([
                'valid' => true,
                'code' => 'DISKON10',
                'discount' => $discount,
                'message' => 'Voucher Diskon 10% diterapkan! Hemat Rp '.number_format($discount, 0, ',', '.'),
            ]);
        }

        return response()->json([
            'valid' => false,
            'message' => 'Kode voucher tidak valid atau telah kedaluwarsa.',
        ]);
    }
}
