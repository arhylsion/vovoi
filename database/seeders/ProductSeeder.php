<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pastikan 4 Kategori Resmi Tersedia
        $catSmartphone = Category::firstOrCreate(
            ['slug' => 'smartphone'],
            ['name' => 'Smartphone', 'description' => 'Smartphone flagship dan premium bergaransi resmi VOVOI.']
        );

        $catSmartwatch = Category::firstOrCreate(
            ['slug' => 'smartwatch'],
            ['name' => 'Smartwatch', 'description' => 'Arloji pintar pelacak kebugaran dan gaya hidup modern.']
        );

        $catTablet = Category::firstOrCreate(
            ['slug' => 'tablet-laptop'],
            ['name' => 'Tablet & Laptop', 'description' => 'Perangkat komputasi portabel untuk produktivitas maksimal.']
        );

        $catAudio = Category::firstOrCreate(
            ['slug' => 'audio-gadget'],
            ['name' => 'Audio & Aksesoris', 'description' => 'TWS, charger GaN, dan aksesoris original VOVOI.']
        );

        // 2. Daftar 10 Produk Resmi VOVOI dengan Kategori dan Stok Riil
        $products = [
            [
                'name' => 'VOVOI Zen 2',
                'category_id' => $catSmartphone->id,
                'description' => 'Smartphone flagship dengan audio fidelity kelas studio dan layar Super AMOLED 120Hz.',
                'price' => 14999000,
                'stock' => 15,
                'image' => 'zen2-phone.svg',
            ],
            [
                'name' => 'VOVOI Phone X Pro',
                'category_id' => $catSmartphone->id,
                'description' => 'Smartphone flagship titanium dengan kamera sensor besar 108MP dan chip V1X Pro.',
                'price' => 18999000,
                'stock' => 10,
                'image' => 'phone-x-pro.svg',
            ],
            [
                'name' => 'VOVOI Studio Max',
                'category_id' => $catSmartphone->id,
                'description' => 'Smartphone lipat layar ganda ultra untuk produktivitas multitasking tanpa batas.',
                'price' => 21999000,
                'stock' => 5,
                'image' => 'flagship-phone.svg',
            ],
            [
                'name' => 'VOVOI Watch Plus',
                'category_id' => $catSmartwatch->id,
                'description' => 'Smartwatch pemantau biometrik canggih dengan bodi stainless steel elegan.',
                'price' => 4899000,
                'stock' => 8,
                'image' => 'watch-plus.svg',
            ],
            [
                'name' => 'VOVOI Watch Ultra',
                'category_id' => $catSmartwatch->id,
                'description' => 'Jam tangan ekspedisi tangguh berdaya tahan baterai 72 jam tahan air 100m.',
                'price' => 6299000,
                'stock' => 0, // Sengaja 0 untuk menguji fitur inovasi label Stok Habis & tombol beli nonaktif
                'image' => 'watch-plus.svg',
            ],
            [
                'name' => 'VOVOI Band Fit',
                'category_id' => $catSmartwatch->id,
                'description' => 'Gelang pintar pelacak aktivitas olahraga, detak jantung 24/7, dan pemantau kualitas tidur dengan baterai 14 hari.',
                'price' => 1299000,
                'stock' => 14,
                'image' => 'watch-plus.svg',
            ],
            [
                'name' => 'VOVOI Tab Ultra',
                'category_id' => $catTablet->id,
                'description' => 'Tablet produktivitas bertenaga tinggi untuk desainer dan profesional kreatif.',
                'price' => 12499000,
                'stock' => 12,
                'image' => 'tab-ultra.svg',
            ],
            [
                'name' => 'VOVOI Pad Air',
                'category_id' => $catTablet->id,
                'description' => 'Tablet tipis 6.1mm berbobot ringan dengan layar 2.8K 144Hz dan dukungan stylus magnetik.',
                'price' => 8499000,
                'stock' => 9,
                'image' => 'tab-ultra.svg',
            ],
            [
                'name' => 'VOVOI Buds Pro',
                'category_id' => $catAudio->id,
                'description' => 'TWS nirkabel premium dengan fitur Active Noise Cancellation 45dB dan codec audio Hi-Res LDAC.',
                'price' => 2199000,
                'stock' => 20,
                'image' => 'phone-thumb1.svg',
            ],
            [
                'name' => 'VOVOI PowerHub 100W',
                'category_id' => $catAudio->id,
                'description' => 'Charger GaN multi-port ultra cepat 100W dengan proteksi suhu dan pengisian daya 4 perangkat sekaligus.',
                'price' => 899000,
                'stock' => 25,
                'image' => 'phone-thumb2.svg',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
