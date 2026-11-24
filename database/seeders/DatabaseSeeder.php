<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 0. Ensure initial categories & products exist (minimal 9 produk sesuai Modul 2)
        $this->call(ProductSeeder::class);

        // 1. Akun Admin Resmi
        User::updateOrCreate(
            ['email' => 'admin@vovoi.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '081299887766',
                'address' => 'VOVOI Headquarters, Jakarta Pusat',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@toko.com'],
            [
                'name' => 'Admin VOVOI',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '081299887766',
                'address' => 'VOVOI Headquarters, Jakarta Pusat',
            ]
        );

        // 2. Akun Customer Uji 1 (Budi Galaxy)
        $customer1 = User::updateOrCreate(
            ['email' => 'budi@vovoi.com'],
            [
                'name' => 'Budi Galaxy',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '08888221281',
                'address' => 'Jl. Pajajaran No. 45, Baranangsiang, Kota Bogor',
            ]
        );

        // Alias customer@vovoi.com
        User::updateOrCreate(
            ['email' => 'customer@vovoi.com'],
            [
                'name' => 'Budi Galaxy',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '08888221281',
                'address' => 'Jl. Pajajaran No. 45, Baranangsiang, Kota Bogor',
            ]
        );

        // 3. Akun Customer Uji 2 (Felix Gunawan) - Wajib memiliki minimal 1 pesanan untuk uji kepemilikan 403
        $customer2 = User::updateOrCreate(
            ['email' => 'felix@vovoi.com'],
            [
                'name' => 'Felix Gunawan',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '081345678901',
                'address' => 'Jl. Ir. H. Juanda No. 12, Paledang, Kota Bogor',
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer2@vovoi.com'],
            [
                'name' => 'Felix Gunawan',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '081345678901',
                'address' => 'Jl. Ir. H. Juanda No. 12, Paledang, Kota Bogor',
            ]
        );

        // 4. Kategori Produk (Minimal 4 Kategori)
        $catSmartphone = Category::updateOrCreate(
            ['slug' => 'smartphone'],
            ['name' => 'Smartphone', 'description' => 'Smartphone flagship dan premium bergaransi resmi VOVOI.']
        );

        $catSmartwatch = Category::updateOrCreate(
            ['slug' => 'smartwatch'],
            ['name' => 'Smartwatch', 'description' => 'Arloji pintar pelacak kebugaran dan gaya hidup modern.']
        );

        $catTablet = Category::updateOrCreate(
            ['slug' => 'tablet-laptop'],
            ['name' => 'Tablet & Laptop', 'description' => 'Perangkat komputasi portabel untuk produktivitas maksimal.']
        );

        $catAudio = Category::updateOrCreate(
            ['slug' => 'audio-gadget'],
            ['name' => 'Audio & Aksesoris', 'description' => 'TWS, charger GaN, dan aksesoris original VOVOI.']
        );

        // 5. Update Kategori dan Stok Produk (Minimal 9 produk)
        $pZen2 = Product::where('name', 'like', '%Zen 2%')->first();
        if ($pZen2) {
            $pZen2->update(['category_id' => $catSmartphone->id, 'stock' => 15]);
        }

        $pPhoneX = Product::where('name', 'like', '%Phone X Pro%')->first();
        if ($pPhoneX) {
            $pPhoneX->update(['category_id' => $catSmartphone->id, 'stock' => 10]);
        }

        $pWatchPlus = Product::where('name', 'like', '%Watch Plus%')->first();
        if ($pWatchPlus) {
            $pWatchPlus->update(['category_id' => $catSmartwatch->id, 'stock' => 8]);
        }

        $pWatchUltra = Product::where('name', 'like', '%Watch Ultra%')->first();
        if ($pWatchUltra) {
            // Stok 0 untuk membuktikan fitur inovasi label Stok Habis & tombol beli nonaktif
            $pWatchUltra->update(['category_id' => $catSmartwatch->id, 'stock' => 0]);
        }

        $pTabUltra = Product::where('name', 'like', '%Tab Ultra%')->first();
        if ($pTabUltra) {
            $pTabUltra->update(['category_id' => $catTablet->id, 'stock' => 12]);
        }

        $pStudioMax = Product::where('name', 'like', '%Studio Max%')->first();
        if ($pStudioMax) {
            $pStudioMax->update(['category_id' => $catTablet->id, 'stock' => 5]);
        }

        $pBudsPro = Product::where('name', 'like', '%Buds Pro%')->first();
        if ($pBudsPro) {
            $pBudsPro->update(['category_id' => $catAudio->id, 'stock' => 20]);
        }

        $pPowerHub = Product::where('name', 'like', '%PowerHub%')->first();
        if ($pPowerHub) {
            $pPowerHub->update(['category_id' => $catAudio->id, 'stock' => 25]);
        }

        $pPadAir = Product::where('name', 'like', '%Pad Air%')->first();
        if ($pPadAir) {
            $pPadAir->update(['category_id' => $catTablet->id, 'stock' => 9]);
        }

        $pBandFit = Product::where('name', 'like', '%Band Fit%')->first();
        if ($pBandFit) {
            $pBandFit->update(['category_id' => $catSmartwatch->id, 'stock' => 14]);
        }

        Product::whereNull('category_id')->update(['category_id' => $catSmartphone->id, 'stock' => 10]);

        // 6. Seed Vouchers
        Voucher::updateOrCreate(
            ['code' => 'VOVOIHEMAT'],
            [
                'name' => 'Voucher VOVOI Hemat Rp 50.000',
                'discount_type' => 'fixed',
                'discount_amount' => 50000,
                'min_order' => 500000,
                'is_active' => true,
            ]
        );

        Voucher::updateOrCreate(
            ['code' => 'VOVOI500'],
            [
                'name' => 'Mega Cashback Rp 500.000',
                'discount_type' => 'fixed',
                'discount_amount' => 500000,
                'min_order' => 3000000,
                'is_active' => true,
            ]
        );

        Voucher::updateOrCreate(
            ['code' => 'DISKON10'],
            [
                'name' => 'Diskon Eksklusif 10%',
                'discount_type' => 'percent',
                'discount_amount' => 10,
                'min_order' => 1000000,
                'is_active' => true,
            ]
        );

        Voucher::updateOrCreate(
            ['code' => 'VOVOI'],
            [
                'name' => 'Special Coupon VOVOI Rp 500.000',
                'discount_type' => 'fixed',
                'discount_amount' => 500000,
                'min_order' => 1000000,
                'is_active' => true,
            ]
        );

        // 7. Pesanan Milik Customer 2 (Felix Gunawan) - Digunakan untuk Uji Cek Kepemilikan (403)
        if ($pZen2) {
            $txCust2 = Transaction::updateOrCreate(
                ['invoice_code' => 'INV-2026-FELIX01'],
                [
                    'user_id' => $customer2->id,
                    'product_id' => $pZen2->id,
                    'product_name' => $pZen2->name,
                    'customer_name' => 'Felix Gunawan',
                    'customer_phone' => '081345678901',
                    'customer_address' => 'Jl. Ir. H. Juanda No. 12, Paledang, Kota Bogor',
                    'courier' => 'JNE Reguler',
                    'quantity' => 1,
                    'shipping_cost' => 15000,
                    'total_amount' => $pZen2->price + 15000,
                    'status' => 'Shipped',
                    'tracking_number' => 'JNE-VOV-882199',
                ]
            );

            TransactionItem::updateOrCreate(
                ['transaction_id' => $txCust2->id, 'product_id' => $pZen2->id],
                [
                    'product_name' => $pZen2->name,
                    'price' => $pZen2->price,
                    'quantity' => 1,
                    'subtotal' => $pZen2->price,
                ]
            );

            // Review dari pesanan customer 2
            Review::updateOrCreate(
                ['transaction_id' => $txCust2->id, 'product_id' => $pZen2->id],
                [
                    'customer_name' => 'Felix Gunawan',
                    'user_id' => $customer2->id,
                    'rating' => 5,
                    'comment' => 'Kualitas produk sangat mantap! Pengiriman cepat, build quality solid dan garansi langsung aktif.',
                ]
            );
        }
    }
}
