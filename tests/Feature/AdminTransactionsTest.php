<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Transaction;
use Tests\TestCase;

class AdminTransactionsTest extends TestCase
{
    public function test_admin_transactions_page_loads_and_displays_kpi_and_orders(): void
    {
        $product = Product::firstOrFail();

        $transaction = Transaction::create([
            'invoice_code' => 'INV-2026-TEST01',
            'product_id' => $product->id,
            'product_name' => $product->name,
            'customer_name' => 'Admin Test User',
            'customer_phone' => '081299998888',
            'customer_address' => 'Gedung VOVOI Cyber Center, Jakarta',
            'courier' => 'JNE Reguler',
            'quantity' => 1,
            'shipping_cost' => 15000,
            'total_amount' => $product->price + 15000,
            'status' => 'Pending',
        ]);

        $response = $this->get('/admin/transactions');

        $response->assertStatus(200);
        $response->assertSee('Daftar Pesanan &amp; Transaksi Toko', false);
        $response->assertSee('TOTAL PRODUK DI ETALASE');
        $response->assertSee('TOTAL PESANAN MASUK');
        $response->assertSee('TOTAL OMZET PENJUALAN');
        $response->assertSee('INV-2026-TEST01');
        $response->assertSee('Admin Test User');
        $response->assertSee('Lihat Nota Pembeli');
    }

    public function test_admin_can_update_transaction_status(): void
    {
        $product = Product::firstOrFail();

        $transaction = Transaction::create([
            'invoice_code' => 'INV-2026-TEST02',
            'product_id' => $product->id,
            'product_name' => $product->name,
            'customer_name' => 'Update Status Buyer',
            'customer_phone' => '081277776666',
            'customer_address' => 'Jl. Merdeka No. 45',
            'courier' => 'J&T Express',
            'quantity' => 1,
            'shipping_cost' => 20000,
            'total_amount' => $product->price + 20000,
            'status' => 'Pending',
        ]);

        $response = $this->from('/admin/transactions')->post('/admin/transactions/'.$transaction->id.'/status', [
            'status' => 'Paid',
        ]);

        $response->assertRedirect('/admin/transactions');
        $response->assertSessionHas('success');

        $transaction->refresh();
        $this->assertEquals('Paid', $transaction->status);
    }
}
