<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Transaction;
use Tests\TestCase;

class CheckoutTransactionTest extends TestCase
{
    public function test_checkout_page_loads_with_correct_product_and_csrf_form(): void
    {
        $product = Product::firstOrFail();

        $response = $this->get('/checkout/'.$product->id);

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('Rp '.number_format($product->price, 0, ',', '.'));
        $response->assertSee('action="/checkout/proses"', false);
        $response->assertSee('name="product_id"', false);
        $response->assertSee('value="'.$product->id.'"', false);
        $response->assertSee('name="_token"', false); // CSRF token input
    }

    public function test_checkout_page_without_id_loads_successfully_without_404(): void
    {
        $product = Product::firstOrFail();

        $response = $this->get('/checkout');

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('action="/checkout/proses"', false);
    }

    public function test_detail_page_has_button_linking_to_checkout_with_product_id(): void
    {
        $product = Product::firstOrFail();

        $response = $this->get('/detail/'.$product->id);

        $response->assertStatus(200);
        $response->assertSee('/checkout/'.$product->id);
        $response->assertSee('/keranjang?add='.$product->id);
    }

    public function test_cart_page_loads_and_displays_cart_view(): void
    {
        $response = $this->get('/keranjang');

        $response->assertStatus(200);
        $response->assertSee('Keranjang Belanja');
        $response->assertSee('Ringkasan Belanja');
        $response->assertSee('Lanjut ke Checkout');
    }

    public function test_navbar_links_to_cart_page(): void
    {
        $response = $this->get('/katalog');

        $response->assertStatus(200);
        $response->assertSee('href="/keranjang"', false);
    }

    public function test_store_transaction_calculates_total_and_saves_to_database(): void
    {
        $product = Product::firstOrFail();

        $payload = [
            'product_id' => $product->id,
            'customer_name' => 'Sulthan Alawy Shihab',
            'customer_phone' => '081234567890',
            'customer_address' => 'Jl. Golf Ciriung, Cibinong, Bogor',
            'courier' => 'J&T Express',
            'quantity' => 2,
        ];

        $response = $this->post('/checkout/proses', $payload);

        // Expected calculation: ($product->price * 2) + 20000 (J&T Express)
        $expectedShipping = 20000;
        $expectedTotal = ($product->price * 2) + $expectedShipping;

        $transaction = Transaction::where('customer_name', 'Sulthan Alawy Shihab')
            ->latest('id')
            ->first();

        $this->assertNotNull($transaction);
        $this->assertEquals($product->id, $transaction->product_id);
        $this->assertEquals($product->name, $transaction->product_name);
        $this->assertEquals('081234567890', $transaction->customer_phone);
        $this->assertEquals('Jl. Golf Ciriung, Cibinong, Bogor', $transaction->customer_address);
        $this->assertEquals('J&T Express', $transaction->courier);
        $this->assertEquals(2, $transaction->quantity);
        $this->assertEquals($expectedShipping, $transaction->shipping_cost);
        $this->assertEquals($expectedTotal, $transaction->total_amount);
        $this->assertEquals('Pending', $transaction->status);
        $this->assertStringStartsWith('INV-2026-', $transaction->invoice_code);

        $response->assertRedirect('/berhasil/'.$transaction->id);
    }

    public function test_invoice_success_page_displays_transaction_details(): void
    {
        $product = Product::firstOrFail();

        $transaction = Transaction::create([
            'invoice_code' => 'INV-2026-7788',
            'product_id' => $product->id,
            'product_name' => $product->name,
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '089876543210',
            'customer_address' => 'Jl. Raya Bogor KM 43',
            'courier' => 'SiCepat BEST',
            'quantity' => 1,
            'shipping_cost' => 25000,
            'total_amount' => $product->price + 25000,
            'status' => 'Pending',
        ]);

        $response = $this->get('/berhasil/'.$transaction->id);

        $response->assertStatus(200);
        $response->assertSee('INV-2026-7788');
        $response->assertSee('Budi Santoso');
        $response->assertSee($product->name);
        $response->assertSee('SiCepat BEST');
        $response->assertSee('Rp '.number_format($product->price + 25000, 0, ',', '.'));
    }
}
