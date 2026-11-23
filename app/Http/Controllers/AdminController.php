<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    // =========================================================================
    // MANAJEMEN PESANAN MASUK & AGGREGATE QUERY
    // =========================================================================

    public function transactions(): View
    {
        $transactions = Transaction::with(['items.product', 'reviews'])->latest()->get();

        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::where('status', '!=', 'Cancelled')->sum('total_amount');

        return view('admin.transactions', compact(
            'transactions',
            'totalProducts',
            'totalTransactions',
            'totalRevenue'
        ));
    }

    public function updateStatus(Request $request, int|string $id): RedirectResponse
    {
        $transaction = Transaction::findOrFail($id);

        $oldStatus = $transaction->status;
        $newStatus = $request->status;

        // Jika diubah menjadi Cancelled dari Pending, kembalikan stok
        if ($newStatus === 'Cancelled' && $oldStatus === 'Pending') {
            if ($transaction->items()->count() > 0) {
                foreach ($transaction->items as $item) {
                    $item->product?->increment('stock', $item->quantity);
                }
            } else {
                $p = Product::find($transaction->product_id);
                $p?->increment('stock', $transaction->quantity);
            }
        }

        $transaction->update([
            'status' => $newStatus,
        ]);

        return back()->with(
            'success',
            'Status pesanan '.$transaction->invoice_code.' atas nama '.$transaction->customer_name.' berhasil diubah menjadi: '.$newStatus
        );
    }

    // =========================================================================
    // FITUR INOVASI P12: EKSPOR LAPORAN PENJUALAN (CSV, EXCEL, & PDF)
    // =========================================================================

    /**
     * Ekspor Laporan Penjualan ke Format CSV
     */
    public function exportCsv(): StreamedResponse
    {
        $fileName = 'laporan_penjualan_vovoi_'.date('Y-m-d_His').'.csv';
        $transactions = Transaction::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            // Menulis UTF-8 BOM agar Excel membaca karakter dengan benar
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header Kolom
            fputcsv($file, [
                'No.',
                'No Invoice',
                'Tanggal & Waktu',
                'Nama Pembeli',
                'No Telepon',
                'Alamat Pengiriman',
                'Produk Dipesan',
                'Jumlah Qty',
                'Kurir',
                'Ongkir (Rp)',
                'Kode Voucher',
                'Diskon (Rp)',
                'Total Bayar (Rp)',
                'Status Pesanan',
            ]);

            foreach ($transactions as $index => $t) {
                fputcsv($file, [
                    $index + 1,
                    $t->invoice_code,
                    $t->created_at ? $t->created_at->format('Y-m-d H:i:s') : '-',
                    $t->customer_name,
                    $t->customer_phone,
                    $t->customer_address,
                    $t->product_name,
                    $t->quantity,
                    $t->courier,
                    $t->shipping_cost,
                    $t->voucher_code ?: '-',
                    $t->discount_amount ?: 0,
                    $t->total_amount,
                    $t->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Ekspor Laporan Penjualan ke Format Excel (Spreadsheet CSV)
     */
    public function exportExcel(): StreamedResponse
    {
        $fileName = 'rekap_penjualan_vovoi_'.date('Y-m-d').'.csv';

        return $this->exportCsv();
    }

    /**
     * Ekspor Laporan Penjualan ke Format PDF / Halaman Cetak Siap Print
     */
    public function exportPdf(): View
    {
        $transactions = Transaction::latest()->get();
        $totalOrders = $transactions->count();
        $paidOrders = $transactions->where('status', 'Paid')->count();
        $shippedOrders = $transactions->where('status', 'Shipped')->count();
        $pendingOrders = $transactions->where('status', 'Pending')->count();
        $cancelledOrders = $transactions->where('status', 'Cancelled')->count();
        $totalRevenue = $transactions->where('status', '!=', 'Cancelled')->sum('total_amount');

        return view('admin.report_pdf', compact(
            'transactions',
            'totalOrders',
            'paidOrders',
            'shippedOrders',
            'pendingOrders',
            'cancelledOrders',
            'totalRevenue'
        ));
    }

    // =========================================================================
    // MANAJEMEN PRODUK & UPLOAD FILE GAMBAR & STOK & KATEGORI
    // =========================================================================

    public function products(): View
    {
        $products = Product::with('category')->latest()->get();

        return view('admin.products', compact('products'));
    }

    public function createProduct(): View
    {
        $categories = Category::all();

        return view('admin.create_product', compact('categories'));
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:100',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time().'_'.str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('assets/images'), $imageName);
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->input('stock', 10),
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return redirect('/admin/products')->with(
            'success',
            'Produk "'.$request->name.'" berhasil ditambahkan dan langsung tayang di etalase toko!'
        );
    }

    public function editProduct(int|string $id): View
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.edit_product', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, int|string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:150',
            'price' => 'required|numeric|min:100',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imageName = $product->image;

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('assets/images/'.$product->image))) {
                @unlink(public_path('assets/images/'.$product->image));
            }

            $file = $request->file('image');
            $imageName = time().'_'.str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('assets/images'), $imageName);
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->input('stock', $product->stock),
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return redirect('/admin/products')->with(
            'success',
            'Perubahan pada produk "'.$product->name.'" berhasil disimpan!'
        );
    }

    public function deleteProduct(int|string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $deletedName = $product->name;

        if ($product->image && file_exists(public_path('assets/images/'.$product->image))) {
            @unlink(public_path('assets/images/'.$product->image));
        }

        $product->delete();

        return redirect('/admin/products')->with(
            'success',
            'Produk "'.$deletedName.'" berhasil dihapus dari etalase.'
        );
    }
}
