<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    public function test_catalog_links_to_product_detail_with_id(): void
    {
        $product = Product::first();

        $response = $this->get('/katalog');

        $response->assertStatus(200);
        $response->assertSee('/detail/'.$product->id);
        $response->assertSee('Lihat Detail');
    }

    public function test_product_detail_page_loads_and_displays_product_data(): void
    {
        $product = Product::first();

        $response = $this->get('/detail/'.$product->id);

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('Rp '.number_format($product->price, 0, ',', '.'));
        $response->assertSee($product->description);
    }

    public function test_product_detail_page_returns_404_when_product_not_found(): void
    {
        $nonExistentId = 99999;

        $response = $this->get('/detail/'.$nonExistentId);

        $response->assertStatus(404);
    }
}
