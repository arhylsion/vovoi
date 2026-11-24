<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    public function test_catalog_displays_products_from_database_with_formatted_price(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('VOVOI Zen 2');
        $response->assertSee('Rp 14.999.000');
        $response->assertSee('zen2-phone.svg');
    }

    public function test_catalog_displays_empty_state_when_no_products_exist(): void
    {
        try {
            Product::query()->delete();

            $response = $this->get('/');

            $response->assertStatus(200);
            $response->assertSee('Mohon maaf, produk belum tersedia di etalase kami.');
        } finally {
            // Re-seed after test to keep products available
            $this->artisan('db:seed', ['--class' => 'ProductSeeder']);
        }
    }
}
