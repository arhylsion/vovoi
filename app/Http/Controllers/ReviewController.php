<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:1000',
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);

        if ($transaction->status !== 'Shipped') {
            return back()->with('error', 'Ulasan dan penilaian hanya dapat diberikan jika pesanan telah berstatus Shipped (Dikirim).');
        }

        // Determine product ID: from request, or transaction's product_id
        $productId = $request->input('product_id', $transaction->product_id);
        if (! $productId) {
            $firstItem = $transaction->items()->first();
            $productId = $firstItem ? $firstItem->product_id : Product::first()?->id;
        }

        // Check if review already exists for this transaction and product
        $existing = Review::where('transaction_id', $transaction->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->update([
                'rating' => (int) $request->rating,
                'comment' => $request->comment,
            ]);

            return back()->with('success', 'Ulasan Anda berhasil diperbarui!');
        }

        Review::create([
            'transaction_id' => $transaction->id,
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'customer_name' => $transaction->customer_name ?: (Auth::user()?->name ?? 'Pembeli Terverifikasi'),
            'rating' => (int) $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan dan rating bintang 5 Anda!');
    }
}
