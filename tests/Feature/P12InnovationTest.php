<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class P12InnovationTest extends TestCase
{
    protected function getAdmin(): User
    {
        return User::firstOrCreate(
            ['email' => 'admin@vovoi.com'],
            ['name' => 'admin', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );
    }

    protected function getCustomer(): User
    {
        return User::firstOrCreate(
            ['email' => 'customer.test@vovoi.com'],
            ['name' => 'Customer Tester', 'password' => Hash::make('password123'), 'role' => 'customer', 'phone' => '081234567890', 'address' => 'Jl. Pengujian No. 1, Bogor']
        );
    }

    // =========================================================================
    // 1. LKPD P12 AUTHENTICATION & MIDDLEWARE SECURITY TESTS
    // =========================================================================

    public function test_p12_unauthenticated_access_to_admin_is_blocked_by_middleware(): void
    {
        $response = $this->get('/admin/transactions');
        $response->assertRedirect('/login');

        $response2 = $this->get('/admin/products');
        $response2->assertRedirect('/login');

        $response3 = $this->get('/admin/categories');
        $response3->assertRedirect('/login');
    }

    public function test_p12_login_page_renders_with_show_password_button(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('SELLER CENTER');
        $response->assertSee('Masuk ke Portal Toko');
        $response->assertSee('togglePassword()', false);
        $response->assertSee('Lihat');
    }

    public function test_p12_login_with_incorrect_password_is_rejected(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@vovoi.com',
            'password' => 'passwordsalah123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }

    public function test_p12_login_with_valid_credentials_succeeds_and_logout_works(): void
    {
        $admin = $this->getAdmin();

        $response = $this->post('/login', [
            'email' => 'admin@vovoi.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin/transactions');
        $this->assertAuthenticatedAs($admin);

        // Test Logout
        $logoutResponse = $this->post('/logout');
        $logoutResponse->assertRedirect('/login');
        $this->assertGuest();
    }

    // =========================================================================
    // 2. FEATURE 1: CETAK E-INVOICE (window.print, @media print, tombol tersembunyi)
    // =========================================================================

    public function test_e_invoice_page_contains_print_trigger_and_print_styles(): void
    {
        $customer = $this->getCustomer();
        $product = Product::firstOrFail();
        $transaction = Transaction::create([
            'invoice_code' => 'INV-2026-PRINT01',
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'customer_name' => 'Cetak Tester',
            'customer_phone' => '081299990000',
            'customer_address' => 'Jl. Percetakan Negara No. 10',
            'courier' => 'JNE Reguler',
            'quantity' => 1,
            'shipping_cost' => 15000,
            'total_amount' => $product->price + 15000,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($customer)->get('/berhasil/'.$transaction->id);

        $response->assertStatus(200);
        $response->assertSee('window.print()', false);
        $response->assertSee('@media print', false);
        $response->assertSee('Cetak E-Invoice');
        $response->assertSee('no-print');
        $response->assertSee('INV-2026-PRINT01');

        $transaction->delete();
    }

    // =========================================================================
    // 3. FEATURE 2: LABEL "STOK HABIS" & TOMBOL NONAKTIF JIKA STOK 0
    // =========================================================================

    public function test_product_with_zero_stock_shows_out_of_stock_label_and_disabled_buttons(): void
    {
        $product = Product::create([
            'name' => 'VOVOI Out of Stock Test Unit',
            'price' => 5000000,
            'stock' => 0,
            'description' => 'Produk dengan stok 0 untuk pengujian badge dan disable button.',
        ]);

        // Catalog shows badge
        $catalogResponse = $this->get('/katalog');
        $catalogResponse->assertStatus(200);
        $catalogResponse->assertSee('STOK HABIS');

        // Detail page shows badge and disabled state
        $detailResponse = $this->get('/detail/'.$product->id);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('STOK HABIS');
        $detailResponse->assertSee('Stok Habis (0 Unit)');
        $detailResponse->assertSee('disabled', false);

        // Direct add to cart for out of stock product is blocked
        $cartResponse = $this->post('/keranjang/tambah', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $cartResponse->assertSessionHas('error');

        $product->delete();
    }

    // =========================================================================
    // 4. FEATURE 3: HALAMAN PROFIL CUSTOMER (Ubah nama, no hp, alamat, password)
    // =========================================================================

    public function test_customer_can_view_and_update_profile(): void
    {
        $customer = $this->getCustomer();

        $pageResponse = $this->actingAs($customer)->get('/profile');
        $pageResponse->assertStatus(200);
        $pageResponse->assertSee('Profil Pengguna');
        $pageResponse->assertSee($customer->name);
        $pageResponse->assertSee('Alamat Pengiriman Default');

        $updateResponse = $this->actingAs($customer)->post('/profile/update', [
            'name' => 'Customer Tester Updated',
            'phone' => '089988776655',
            'address' => 'Jl. Pajajaran Baru No. 88, Bogor Timur',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $updateResponse->assertSessionHas('success');

        $customer->refresh();
        $this->assertEquals('Customer Tester Updated', $customer->name);
        $this->assertEquals('089988776655', $customer->phone);
        $this->assertEquals('Jl. Pajajaran Baru No. 88, Bogor Timur', $customer->address);
        $this->assertTrue(Hash::check('newpassword123', $customer->password));
    }

    // =========================================================================
    // 5. FEATURE 4: KODE VOUCHER DISKON SAAT CHECKOUT
    // =========================================================================

    public function test_voucher_discount_is_applied_at_checkout(): void
    {
        $customer = $this->getCustomer();
        $product = Product::where('stock', '>', 0)->firstOrFail();

        $voucher = Voucher::updateOrCreate(
            ['code' => 'TESTVOUCHER50K'],
            [
                'name' => 'Voucher Uji 50k',
                'discount_type' => 'fixed',
                'discount_amount' => 50000,
                'min_order' => 100000,
                'is_active' => true,
            ]
        );

        $payload = [
            'product_id' => $product->id,
            'customer_name' => 'Voucher Buyer',
            'customer_phone' => '081234567890',
            'customer_address' => 'Jl. Diskon No. 1',
            'courier' => 'JNE Reguler', // 15000
            'quantity' => 1,
            'voucher_code' => 'TESTVOUCHER50K',
        ];

        $response = $this->actingAs($customer)->post('/checkout/proses', $payload);

        $transaction = Transaction::where('customer_name', 'Voucher Buyer')->latest('id')->first();
        $this->assertNotNull($transaction);
        $this->assertEquals('TESTVOUCHER50K', $transaction->voucher_code);
        $this->assertEquals(50000, $transaction->discount_amount);

        $expectedTotal = ($product->price * 1) + 15000 - 50000;
        $this->assertEquals($expectedTotal, $transaction->total_amount);

        // Invoice displays discount
        $invoiceResponse = $this->actingAs($customer)->get('/berhasil/'.$transaction->id);
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee('Diskon Voucher');
        $invoiceResponse->assertSee('TESTVOUCHER50K');

        $transaction->delete();
        $voucher->delete();
    }

    // =========================================================================
    // 6. FEATURE 5: PEMBATALAN PESANAN OLEH PEMBELI SELAMA PENDING (STOK KEMBALI)
    // =========================================================================

    public function test_buyer_can_cancel_pending_order_and_restores_stock(): void
    {
        $customer = $this->getCustomer();
        $product = Product::create([
            'name' => 'VOVOI Cancel Test Phone',
            'price' => 1000000,
            'stock' => 5,
            'description' => 'Test pembatalan pesanan.',
        ]);

        // Purchase 2 units
        $this->actingAs($customer)->post('/checkout/proses', [
            'product_id' => $product->id,
            'customer_name' => 'Pembeli Batal',
            'customer_phone' => '0811223344',
            'customer_address' => 'Jl. Batal',
            'courier' => 'JNE Reguler',
            'quantity' => 2,
        ]);

        $product->refresh();
        $this->assertEquals(3, $product->stock); // 5 - 2 = 3

        $transaction = Transaction::where('customer_name', 'Pembeli Batal')->latest('id')->first();
        $this->assertEquals('Pending', $transaction->status);

        // Cancel order
        $cancelResponse = $this->actingAs($customer)->post('/pesanan/'.$transaction->id.'/batal');
        $cancelResponse->assertSessionHas('success');

        $transaction->refresh();
        $this->assertEquals('Cancelled', $transaction->status);

        // Stock must be restored back to 5!
        $product->refresh();
        $this->assertEquals(5, $product->stock);

        // Attempting to cancel again should fail
        $secondCancel = $this->actingAs($customer)->post('/pesanan/'.$transaction->id.'/batal');
        $secondCancel->assertSessionHas('error');

        $transaction->delete();
        $product->delete();
    }

    // =========================================================================
    // 7. FEATURE 6: EKSPOR LAPORAN PENJUALAN KE CSV, EXCEL, & PDF
    // =========================================================================

    public function test_admin_can_export_sales_report_to_csv_excel_and_pdf(): void
    {
        $admin = $this->getAdmin();

        // 1. CSV export
        $csvResponse = $this->actingAs($admin)->get('/admin/transactions/export/csv');
        $csvResponse->assertStatus(200);
        $this->assertStringContainsString('text/csv', $csvResponse->headers->get('content-type'));

        // 2. Excel export
        $excelResponse = $this->actingAs($admin)->get('/admin/transactions/export/excel');
        $excelResponse->assertStatus(200);

        // 3. PDF / Printable Report
        $pdfResponse = $this->actingAs($admin)->get('/admin/transactions/export/pdf');
        $pdfResponse->assertStatus(200);
        $pdfResponse->assertSee('VOVOI OFFICIAL STORE');
        $pdfResponse->assertSee('Laporan Rekapitulasi Penjualan');
        $pdfResponse->assertSee('window.print()', false);
    }

    // =========================================================================
    // 8. FEATURE 7: KERANJANG BELANJA MULTI-PRODUK DENGAN SEKALI CHECKOUT
    // =========================================================================

    public function test_multi_product_cart_checkout_in_single_process(): void
    {
        $customer = $this->getCustomer();
        $p1 = Product::create(['name' => 'Item Cart 1', 'price' => 100000, 'stock' => 10, 'description' => 'desc']);
        $p2 = Product::create(['name' => 'Item Cart 2', 'price' => 200000, 'stock' => 10, 'description' => 'desc']);

        // Add both to session cart
        session()->put('cart', [
            $p1->id => ['id' => $p1->id, 'name' => $p1->name, 'price' => $p1->price, 'quantity' => 2],
            $p2->id => ['id' => $p2->id, 'name' => $p2->name, 'price' => $p2->price, 'quantity' => 1],
        ]);

        $checkoutPage = $this->actingAs($customer)->get('/checkout');
        $checkoutPage->assertStatus(200);
        $checkoutPage->assertSee('Item Cart 1');
        $checkoutPage->assertSee('Item Cart 2');

        // Process checkout for entire cart
        $response = $this->actingAs($customer)->post('/checkout/proses', [
            'is_cart' => 1,
            'checkout_mode' => 'cart',
            'product_id' => $p1->id,
            'customer_name' => 'Multi Product Buyer',
            'customer_phone' => '087766554433',
            'customer_address' => 'Jl. Keranjang Bersama No. 9',
            'courier' => 'J&T Express', // 20000
        ]);

        $transaction = Transaction::where('customer_name', 'Multi Product Buyer')->latest('id')->first();
        $this->assertNotNull($transaction);
        $this->assertEquals(3, $transaction->quantity); // 2 + 1 = 3

        // Subtotal: (100000*2) + (200000*1) = 400000 + 20000 = 420000
        $this->assertEquals(420000, $transaction->total_amount);

        // Transaction items persisted
        $this->assertCount(2, $transaction->items);

        // Both products had their stock decremented!
        $p1->refresh();
        $p2->refresh();
        $this->assertEquals(8, $p1->stock); // 10 - 2
        $this->assertEquals(9, $p2->stock); // 10 - 1

        // Session cart is cleared
        $this->assertEmpty(session('cart', []));

        $transaction->delete();
        $p1->delete();
        $p2->delete();
    }

    // =========================================================================
    // 9. FEATURE 8: ULASAN & RATING BINTANG 1-5 UNTUK PESANAN SHIPPED
    // =========================================================================

    public function test_customer_can_submit_review_only_when_order_is_shipped(): void
    {
        $customer = $this->getCustomer();
        $product = Product::firstOrFail();

        // 1. Pending order review attempt must be rejected
        $pendingTx = Transaction::create([
            'invoice_code' => 'INV-2026-REV01',
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'customer_name' => 'Pending Reviewer',
            'customer_phone' => '081200001111',
            'customer_address' => 'Jl. Belum Dikirim',
            'courier' => 'JNE Reguler',
            'quantity' => 1,
            'shipping_cost' => 15000,
            'total_amount' => $product->price + 15000,
            'status' => 'Pending',
        ]);

        $failResponse = $this->actingAs($customer)->post('/reviews/store', [
            'transaction_id' => $pendingTx->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Review sebelum dikirim.',
        ]);
        $failResponse->assertSessionHas('error');

        // 2. Shipped order review attempt succeeds
        $pendingTx->update(['status' => 'Shipped']);

        $successResponse = $this->actingAs($customer)->post('/reviews/store', [
            'transaction_id' => $pendingTx->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Produk original luar biasa, pengiriman kilat!',
        ]);
        $successResponse->assertSessionHas('success');

        $review = Review::where('transaction_id', $pendingTx->id)->first();
        $this->assertNotNull($review);
        $this->assertEquals(5, $review->rating);
        $this->assertEquals('Produk original luar biasa, pengiriman kilat!', $review->comment);

        // Product detail displays the new review
        $detailResponse = $this->get('/detail/'.$product->id);
        $detailResponse->assertSee('Produk original luar biasa, pengiriman kilat!');

        $review->delete();
        $pendingTx->delete();
    }

    // =========================================================================
    // 10. FEATURE 9: TABEL CATEGORIES DENGAN CRUD DAN RELASI CATEGORY_ID
    // =========================================================================

    public function test_categories_crud_and_product_relation(): void
    {
        $admin = $this->getAdmin();

        // 1. Create Category
        $responseCreate = $this->actingAs($admin)->post('/admin/categories/store', [
            'name' => 'Laptop Gaming VOVOI',
            'description' => 'Kategori laptop high performance.',
        ]);
        $responseCreate->assertRedirect('/admin/categories');

        $category = Category::where('name', 'Laptop Gaming VOVOI')->first();
        $this->assertNotNull($category);
        $this->assertEquals('laptop-gaming-vovoi', $category->slug);

        // 2. Product has category relation
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'VOVOI Blade 16',
            'price' => 30000000,
            'stock' => 4,
            'description' => 'Laptop gaming RTX 4080.',
        ]);

        $this->assertEquals($category->name, $product->category->name);
        $this->assertTrue($category->products->contains($product));

        // 3. Catalog filter by category slug
        $catalogResponse = $this->get('/katalog?category='.$category->slug);
        $catalogResponse->assertStatus(200);
        $catalogResponse->assertSee('VOVOI Blade 16');

        // 4. Update Category
        $responseUpdate = $this->actingAs($admin)->post('/admin/categories/'.$category->id.'/update', [
            'name' => 'Laptop & Workstation VOVOI',
            'description' => 'Kategori laptop dan workstation.',
        ]);
        $responseUpdate->assertRedirect('/admin/categories');

        $category->refresh();
        $this->assertEquals('Laptop & Workstation VOVOI', $category->name);

        // 5. Delete Category
        $responseDelete = $this->actingAs($admin)->post('/admin/categories/'.$category->id.'/delete');
        $responseDelete->assertRedirect('/admin/categories');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);

        $product->delete();
    }

    // =========================================================================
    // 11. MODUL 5: PESANAN SAYA & MODUL 6: MANAJEMEN RESI DAN HAPUS PESANAN
    // =========================================================================

    public function test_pesanan_saya_displays_only_logged_in_customer_orders(): void
    {
        $customer = $this->getCustomer();
        $otherCustomer = User::firstOrCreate(
            ['email' => 'other.tester@vovoi.com'],
            ['name' => 'Other Customer', 'password' => Hash::make('password123'), 'role' => 'customer']
        );

        $product = Product::firstOrFail();

        $myTx = Transaction::create([
            'invoice_code' => 'INV-2026-MY01',
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'product_name' => 'My Product Order',
            'customer_name' => $customer->name,
            'customer_phone' => '081234567890',
            'customer_address' => 'Jl. Alamat Saya',
            'courier' => 'JNE Reguler',
            'quantity' => 1,
            'shipping_cost' => 15000,
            'total_amount' => 500000,
            'status' => 'Shipped',
            'tracking_number' => 'JNE-VOV-998811',
        ]);

        $otherTx = Transaction::create([
            'invoice_code' => 'INV-2026-OTHER01',
            'user_id' => $otherCustomer->id,
            'product_id' => $product->id,
            'product_name' => 'Other Secret Product',
            'customer_name' => $otherCustomer->name,
            'customer_phone' => '089988776655',
            'customer_address' => 'Jl. Rahasia',
            'courier' => 'J&T Express',
            'quantity' => 1,
            'shipping_cost' => 20000,
            'total_amount' => 700000,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($customer)->get('/pesanan-saya');
        $response->assertStatus(200);
        $response->assertSee('Pesanan Saya');
        $response->assertSee('INV-2026-MY01');
        $response->assertSee('JNE-VOV-998811');
        $response->assertDontSee('INV-2026-OTHER01');

        // Unauthenticated guest cannot view Pesanan Saya
        $this->post('/logout');
        $guestCheck = $this->get('/pesanan-saya');
        $guestCheck->assertRedirect('/login');

        $myTx->delete();
        $otherTx->delete();
    }

    public function test_admin_can_update_status_and_tracking_number_and_delete_transaction(): void
    {
        $admin = $this->getAdmin();
        $product = Product::firstOrFail();

        $tx = Transaction::create([
            'invoice_code' => 'INV-2026-ADM01',
            'product_id' => $product->id,
            'product_name' => $product->name,
            'customer_name' => 'Admin Test Customer',
            'customer_phone' => '081234567890',
            'customer_address' => 'Jl. Admin No. 1',
            'courier' => 'J&T Express',
            'quantity' => 1,
            'shipping_cost' => 20000,
            'total_amount' => 300000,
            'status' => 'Pending',
        ]);

        // Update to Shipped with tracking number
        $response = $this->actingAs($admin)->post('/admin/transactions/'.$tx->id.'/status', [
            'status' => 'Shipped',
            'tracking_number' => 'JNT-VOV-776655',
        ]);
        $response->assertSessionHas('success');

        $tx->refresh();
        $this->assertEquals('Shipped', $tx->status);
        $this->assertEquals('JNT-VOV-776655', $tx->tracking_number);

        // Delete transaction
        $delResponse = $this->actingAs($admin)->post('/admin/transactions/'.$tx->id.'/delete');
        $delResponse->assertSessionHas('success');

        $this->assertDatabaseMissing('transactions', ['id' => $tx->id]);
    }
}
