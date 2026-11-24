NAMA TOKO   : VOVOI – Flagship Store Elektronik & Teknologi
KELAS / TIM : XII RPL 2 / Tim VOVOI
ANGGOTA     : Athallah Rikza (Project Manager)
              Gonelius Felix (UI/UX Designer)
              M. Varrelian (UI/UX Designer)
              M. Azkaril (Backend Developer)
              Yoga Aditya (Backend Developer)

================================================================================
CARA MENJALANKAN SISTEM
================================================================================
1. Pastikan web server Apache & database server MySQL aktif (via Laragon / XAMPP).
2. Buat database baru bernama 'vovoi' atau impor berkas UPRAK_WEB_XIIRPL2_TIMVOVOI_DATABASE.sql.
3. Buka terminal di folder proyek dan jalankan perintah:
   composer install
4. Pastikan berkas .env telah terkonfigurasi:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=vovoi
   DB_USERNAME=root
   DB_PASSWORD=
5. Eksekusi migrasi dan seeder resmi:
   php artisan migrate
   php artisan db:seed
6. Jalankan server Laravel:
   php artisan serve
7. Buka browser di: http://127.0.0.1:8000

================================================================================
AKUN PENGUJIAN (DATABASE SEEDER)
================================================================================
1. Admin (Seller Center):
   - Email    : admin@vovoi.com (atau admin@toko.com)
   - Password : admin123
   - Akses    : http://127.0.0.1:8000/admin/transactions

2. Customer 1 (Budi Galaxy):
   - Email    : budi@vovoi.com (atau customer@vovoi.com)
   - Password : password123
   - Profil   : Pengguna pembeli aktif tanpa pesanan awal (siap uji checkout).

3. Customer 2 (Felix Gunawan):
   - Email    : felix@vovoi.com (atau customer2@vovoi.com)
   - Password : password123
   - Profil   : Memiliki pesanan Shipped (INV-2026-FELIX01) dengan No. Resi JNE-VOV-882199 & Ulasan (digunakan untuk uji coba akses 403 kepemilikan invoice).

================================================================================
VIDEO DEMO UJIAN PRAKTIK
================================================================================
Link Video YouTube : https://youtu.be/dummy-vovoi-uprak-final
Pengunggah Video   : Athallah Rikza (Project Manager)

================================================================================
FITUR PENGEMBANGAN MANDIRI (9 INOVASI TIM VOVOI)
================================================================================
1. Cetak E-Invoice (Tingkat: Mudah - 3 Poin)
   Cara mencoba: Buka invoice pesanan (/berhasil/{id}) atau melalui Pesanan Saya. Klik tombol "Cetak E-Invoice". Format print otomatis menyembunyikan header, navbar, footer, dan tombol (@media print).

2. Label "Stok Habis" & Tombol Beli Nonaktif jika Stok 0 (Tingkat: Mudah - 3 Poin)
   Cara mencoba: Buka katalog dan cari produk "VOVOI Watch Ultra" (stok 0). Muncul label merah "HABIS", dan di halaman detail tombol "Beli Langsung" serta "Tambah ke Keranjang" otomatis dinonaktifkan (disabled).

3. Halaman Profil Customer (Tingkat: Mudah - 3 Poin)
   Cara mencoba: Login sebagai customer, buka menu profil (/profile). Pelanggan dapat mengubah nama lengkap, nomor WhatsApp, alamat default, serta memperbarui kata sandi.

4. Kode Voucher Diskon saat Checkout (Tingkat: Sedang - 5 Poin)
   Cara mencoba: Di halaman checkout (/checkout), masukkan kode kupon "VOVOIHEMAT" (potongan Rp 50.000) atau "DISKON10" (diskon 10%), lalu klik "Gunakan". Sistem memvalidasi secara live via AJAX dan memotong total belanja di server.

5. Pembatalan Pesanan oleh Pembeli Selama Status Pending (Tingkat: Sedang - 5 Poin)
   Cara mencoba: Buat pesanan baru, lalu buka Pesanan Saya (/pesanan-saya) atau invoice. Klik tombol "Batalkan Pesanan". Status pesanan menjadi Cancelled dan stok barang di database otomatis kembali bertambah.

6. Ekspor Laporan Penjualan ke CSV, Excel, & PDF (Tingkat: Sedang - 5 Poin)
   Cara mencoba: Login admin di Seller Center (/admin/transactions). Klik tombol "Ekspor CSV", "Ekspor Excel", atau "Ekspor PDF / Cetak Laporan" untuk mengunduh rekapitulasi pembukuan toko.

7. Keranjang Belanja Multi-Produk dengan Sekali Checkout (Tingkat: Sulit - 8 Poin)
   Cara mencoba: Tambahkan minimal 2 produk berbeda ke keranjang belanja (/keranjang). Klik "Lanjut ke Checkout". Seluruh produk akan diproses dalam satu transaksi dan memotong stok masing-masing produk secara bersamaan.

8. Ulasan dan Rating Bintang 1–5 oleh Pembeli yang Pesanannya Sudah Shipped (Tingkat: Sulit - 8 Poin)
   Cara mencoba: Login sebagai Customer 2 (felix@vovoi.com) yang memiliki pesanan Shipped. Buka /berhasil/{id}. Tampil form rating bintang 1-5 dan ulasan testimoni. Ulasan langsung tampil pada katalog detail produk.

9. Tabel Categories dengan CRUD dan Relasi category_id (Tingkat: Sulit - 8 Poin)
   Cara mencoba: Login admin, buka menu "Kelola Kategori" (/admin/categories). Admin dapat menambah, mengedit, dan menghapus kategori. Produk berelasi melalui category_id dan dapat difilter di etalase katalog.
