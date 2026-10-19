<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'VOVOI Zen 2',
                'description' => 'Smartphone flagship dengan audio fidelity kelas studio dan layar Super AMOLED 120Hz.',
                'price' => 14999000,
                'image' => 'zen2-phone.svg',
            ],
            [
                'name' => 'VOVOI Watch Plus',
                'description' => 'Smartwatch pemantau biometrik canggih dengan bodi stainless steel elegan.',
                'price' => 4899000,
                'image' => 'watch-plus.svg',
            ],
            [
                'name' => 'VOVOI Tab Ultra',
                'description' => 'Tablet produktivitas bertenaga tinggi untuk desainer dan profesional kreatif.',
                'price' => 12499000,
                'image' => 'tab-ultra.svg',
            ],
            [
                'name' => 'VOVOI Phone X Pro',
                'description' => 'Smartphone flagship titanium dengan kamera sensor besar 108MP dan chip V1X Pro.',
                'price' => 18999000,
                'image' => 'phone-x-pro.svg',
            ],
            [
                'name' => 'VOVOI Watch Ultra',
                'description' => 'Jam tangan ekspedisi tangguh berdaya tahan baterai 72 jam tahan air 100m.',
                'price' => 6299000,
                'image' => 'watch-plus.svg',
            ],
            [
                'name' => 'VOVOI Studio Max',
                'description' => 'Smartphone lipat layar ganda ultra untuk produktivitas multitasking tanpa batas.',
                'price' => 21999000,
                'image' => 'flagship-phone.svg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
