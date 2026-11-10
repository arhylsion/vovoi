<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;

class DiscoveryEngineTest extends TestCase
{
    public function test_catalog_page_loads_with_global_search_bar_and_sorting_dropdown(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('VOVOI');
        $response->assertSee('name="search"', false);
        $response->assertSee('name="sort"', false);
        $response->assertSee('onchange="this.form.submit()"', false);
        $response->assertSee('Paling Baru Ditambahkan');
        $response->assertSee('Harga: Rendah ke Tinggi (Termurah)');
        $response->assertSee('Harga: Tinggi ke Rendah (Termahal)');
    }

    public function test_search_by_product_name_filters_results_using_like(): void
    {
        $response = $this->get('/?search=Zen');

        $response->assertStatus(200);
        $response->assertSee('VOVOI Zen 2');
        $response->assertSee('Menampilkan hasil pencarian untuk', false);
        $response->assertSee('Reset Pencarian');
    }

    public function test_search_by_product_description_filters_results_using_like(): void
    {
        // One of seeded products has 'titanium' in description (VOVOI Phone X Pro)
        $response = $this->get('/?search=titanium');

        $response->assertStatus(200);
        $response->assertSee('VOVOI Phone X Pro');
    }

    public function test_sorting_termurah_orders_by_price_ascending(): void
    {
        $response = $this->get('/?sort=termurah');

        $response->assertStatus(200);
        $products = $response->viewData('products');
        $this->assertNotEmpty($products);

        // Check prices are ascending
        $prices = $products->pluck('price')->toArray();
        $sortedPrices = $prices;
        sort($sortedPrices);
        $this->assertEquals($sortedPrices, $prices);
    }

    public function test_sorting_termahal_orders_by_price_descending(): void
    {
        $response = $this->get('/?sort=termahal');

        $response->assertStatus(200);
        $products = $response->viewData('products');
        $this->assertNotEmpty($products);

        // Check prices are descending
        $prices = $products->pluck('price')->toArray();
        $sortedPrices = $prices;
        rsort($sortedPrices);
        $this->assertEquals($sortedPrices, $prices);
    }

    public function test_combined_search_and_sort_persists_parameters(): void
    {
        $response = $this->get('/?search=VOVOI&sort=termurah');

        $response->assertStatus(200);
        $response->assertSee('value="VOVOI"', false);
        $response->assertSee('value="termurah"', false);
        $response->assertSee('selected', false);

        $products = $response->viewData('products');
        $this->assertNotEmpty($products);
        $prices = $products->pluck('price')->toArray();
        $sortedPrices = $prices;
        sort($sortedPrices);
        $this->assertEquals($sortedPrices, $prices);
    }

    public function test_empty_search_state_when_no_product_matches(): void
    {
        $response = $this->get('/?search=Pesawat+Terbang+XYZ');

        $response->assertStatus(200);
        $response->assertSee('Produk Tidak Ditemukan');
        $response->assertSee('Pesawat Terbang XYZ');
        $response->assertSee('Tampilkan Semua Produk');
    }
}

