<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
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
        // 0. Ensure initial products exist
        if (Product::count() === 0) {
            $this->call(ProductSeeder::class);
        }

        // 1. Admin Users
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

        // Sample Customer User 1
        $customer = User::updateOrCreate(
            ['email' => 'customer@vovoi.com'],
            [
                'name' => 'Budi Galaxy',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '08888221281',
                'address' => 'Jl. Pajajaran No. 45, Baranangsiang, Kota Bogor',
            ]
        );

        // Sample Customer User 2 (Untuk simulasi pengujian antar-pembeli)
        $customer2 = User::updateOrCreate(
            ['email' => 'customer2@vovoi.com'],
            [
                'name' => 'Siti Rahmawati',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '081345678901',
                'address' => 'Jl. Ir. H. Juanda No. 12, Paledang, Kota Bogor',
            ]
        );

        // 2. Categories
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
            ['name' => 'Audio & Aksesoris', 'description' => 'TWS, headphone, dan aksesoris original VOVOI.']
        );

        // 3. Update Existing Products with Categories and Stock
        $phone1 = Product::where('name', 'like', '%Zen 2%')->first();
        if ($phone1) {
            $phone1->update(['category_id' => $catSmartphone->id, 'stock' => 15]);
        }

        $phone2 = Product::where('name', 'like', '%Phone X Pro%')->first();
        if ($phone2) {
            $phone2->update(['category_id' => $catSmartphone->id, 'stock' => 10]);
        }

        $watch1 = Product::where('name', 'like', '%Watch Plus%')->first();
        if ($watch1) {
            $watch1->update(['category_id' => $catSmartwatch->id, 'stock' => 8]);
        }

        $watch2 = Product::where('name', 'like', '%Watch Ultra%')->first();
        if ($watch2) {
            // Set 0 to demonstrate out-of-stock badge and disabled button!
            $watch2->update(['category_id' => $catSmartwatch->id, 'stock' => 0]);
        }

        $tab1 = Product::where('name', 'like', '%Tab Ultra%')->first();
        if ($tab1) {
            $tab1->update(['category_id' => $catTablet->id, 'stock' => 12]);
        }

        $studio1 = Product::where('name', 'like', '%Studio Max%')->first();
        if ($studio1) {
            $studio1->update(['category_id' => $catTablet->id, 'stock' => 5]);
        }

        // Set remaining products default stock and category
        Product::whereNull('category_id')->update(['category_id' => $catSmartphone->id, 'stock' => 10]);

        // 4. Seed Vouchers
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

        // 5. Seed sample review for a Shipped transaction
        $shippedTx = Transaction::where('status', 'Shipped')->first();
        if ($shippedTx && $phone1) {
            Review::updateOrCreate(
                ['transaction_id' => $shippedTx->id, 'product_id' => $phone1->id],
                [
                    'customer_name' => $shippedTx->customer_name ?: 'Felix Gunawan',
                    'user_id' => $customer->id,
                    'rating' => 5,
                    'comment' => 'Kualitas produk sangat mantap! Pengiriman cepat, build quality solid dan garansi langsung aktif.',
                ]
            );
        }
    }
}
