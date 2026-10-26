<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin transactions dashboard with live KPI metrics.
     */
    public function transactions(): View
    {
        $transactions = Transaction::latest('id')->get();

        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = (int) Transaction::sum('total_amount');

        return view('admin.transactions', compact('transactions', 'totalProducts', 'totalTransactions', 'totalRevenue'));
    }

    /**
     * Update the order status of a specific transaction.
     */
    public function updateStatus(Request $request, int|string $id): RedirectResponse
    {
        $transaction = Transaction::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Pending,Paid,Shipped'],
        ]);

        $transaction->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            "Status pesanan {$transaction->invoice_code} atas nama {$transaction->customer_name} berhasil diubah menjadi: {$validated['status']}"
        );
    }
}
