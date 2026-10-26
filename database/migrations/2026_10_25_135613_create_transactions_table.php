<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code'); // Menyimpan Nomor Resi/Invoice (Contoh: INV-2026-001)
            $table->integer('product_id'); // Menyimpan ID Barang yang dibeli
            $table->string('product_name'); // Menyimpan Nama Barang saat dibeli
            $table->string('customer_name'); // Menyimpan Nama Lengkap Pembeli
            $table->string('customer_phone'); // Menyimpan Nomor HP/WA Pembeli
            $table->text('customer_address'); // Menyimpan Alamat Pengiriman
            $table->string('courier'); // Menyimpan Kurir (JNE / J&T / SiCepat)
            $table->integer('quantity'); // Menyimpan Jumlah Beli
            $table->integer('shipping_cost'); // Menyimpan Ongkos Kirim
            $table->integer('total_amount'); // Menyimpan Total Bayar (Harga x Qty + Ongkir)
            $table->string('status')->default('Pending'); // Status pesanan awal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
