<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminSellerCenterTest extends TestCase
{
    public function test_admin_products_page_loads_and_displays_seller_center(): void
    {
        $response = $this->get('/admin/products');

        $response->assertStatus(200);
        $response->assertSee('SELLER CENTER');
        $response->assertSee('Daftar Produk Toko');
        $response->assertSee('+ Tambah Produk Baru');
        $response->assertSee('Plus Jakarta Sans');
    }

    public function test_admin_create_product_page_loads_with_multipart_form(): void
    {
        $response = $this->get('/admin/products/create');

        $response->assertStatus(200);
        $response->assertSee('Tambah Produk Baru');
        $response->assertSee('action="/admin/products/store"', false);
        $response->assertSee('enctype="multipart/form-data"', false);
        $response->assertSee('name="image"', false);
        $response->assertSee('name="name"', false);
        $response->assertSee('name="price"', false);
        $response->assertSee('name="description"', false);
        $response->assertSee('previewFile(this)', false);
    }

    public function test_store_product_validation_rejects_empty_inputs(): void
    {
        $response = $this->from('/admin/products/create')->post('/admin/products/store', []);

        $response->assertRedirect('/admin/products/create');
        $response->assertSessionHasErrors(['name', 'price', 'description', 'image']);
    }

    public function test_store_product_validation_rejects_non_image_files(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');

        $payload = [
            'name' => 'Produk Uji Coba PDF',
            'price' => 500000,
            'description' => 'Deskripsi produk uji coba keamanan validasi file.',
            'image' => $file,
        ];

        $response = $this->from('/admin/products/create')->post('/admin/products/store', $payload);

        $response->assertRedirect('/admin/products/create');
        $response->assertSessionHasErrors(['image']);
    }

    public function test_store_product_validation_rejects_file_exceeding_2mb(): void
    {
        // 3000 KB > 2048 KB
        $largeFile = UploadedFile::fake()->create('large_image.jpg', 3000, 'image/jpeg');

        $payload = [
            'name' => 'Produk Foto Terlalu Besar',
            'price' => 750000,
            'description' => 'Deskripsi produk ukuran besar.',
            'image' => $largeFile,
        ];

        $response = $this->from('/admin/products/create')->post('/admin/products/store', $payload);

        $response->assertRedirect('/admin/products/create');
        $response->assertSessionHasErrors(['image']);
    }

    public function test_store_product_successfully_uploads_image_and_persists_to_database(): void
    {
        $testImage = UploadedFile::fake()->image('asus_rog_strix.jpg', 600, 600);

        $payload = [
            'name' => 'Asus ROG Strix G16 RTX 4060',
            'price' => 24500000,
            'description' => 'Garansi Resmi 2 Tahun. RAM 16GB DDR5, SSD 1TB NVMe, Intel Core i7 13650HX.',
            'image' => $testImage,
        ];

        $response = $this->post('/admin/products/store', $payload);

        $response->assertRedirect('/admin/products');
        $response->assertSessionHas('success');

        $product = Product::where('name', 'Asus ROG Strix G16 RTX 4060')->first();
        $this->assertNotNull($product);
        $this->assertEquals(24500000, $product->price);
        $this->assertStringContainsString('asus_rog_strix.jpg', $product->image);

        // Verify physical file exists in public/assets/images
        $savedFilePath = public_path('assets/images/' . $product->image);
        $this->assertFileExists($savedFilePath);

        // Cleanup uploaded test file
        if (file_exists($savedFilePath)) {
            @unlink($savedFilePath);
        }

        // Clean up database row
        $product->delete();
    }

    public function test_admin_transactions_page_loads_and_displays_aggregate_stats(): void
    {
        $response = $this->get('/admin/transactions');

        $response->assertStatus(200);
        $response->assertSee('TOTAL PRODUK DI ETALASE');
        $response->assertSee('TOTAL PESANAN MASUK');
        $response->assertSee('TOTAL OMZET PENJUALAN');
        $response->assertSee('Daftar Pesanan Pembeli (Diurutkan dari yang Terbaru)');
    }

    public function test_admin_can_update_transaction_status_and_flash_session(): void
    {
        $transaction = Transaction::create([
            'invoice_code' => 'INV-2026-9999',
            'product_id' => 1,
            'product_name' => 'VOVOI Zen 2',
            'customer_name' => 'Ahmad Tester',
            'customer_phone' => '081122334455',
            'customer_address' => 'Jl. Merdeka No. 45, Bogor',
            'courier' => 'JNE Reguler',
            'quantity' => 1,
            'shipping_cost' => 15000,
            'total_amount' => 15014000,
            'status' => 'Pending',
        ]);

        // Test update to Paid
        $response = $this->from('/admin/transactions')->post('/admin/transactions/'.$transaction->id.'/status', [
            'status' => 'Paid',
        ]);

        $response->assertRedirect('/admin/transactions');
        $response->assertSessionHas('success');

        $transaction->refresh();
        $this->assertEquals('Paid', $transaction->status);

        // Test Invoice view updates dynamically to Paid
        $invoiceResponse = $this->get('/berhasil/'.$transaction->id);
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee('Paid (Pembayaran Lunas - Sedang Dikemas)');

        // Test update to Shipped
        $this->post('/admin/transactions/'.$transaction->id.'/status', [
            'status' => 'Shipped',
        ]);

        $transaction->refresh();
        $this->assertEquals('Shipped', $transaction->status);

        // Test Invoice view updates dynamically to Shipped
        $invoiceResponse2 = $this->get('/berhasil/'.$transaction->id);
        $invoiceResponse2->assertStatus(200);
        $invoiceResponse2->assertSee('Shipped (Pesanan Sedang Dikirim Kurir)');

        // Cleanup
        $transaction->delete();
    }
}

