VOVOI E-COMMERCE - ENTITY RELATIONSHIP DIAGRAM (ERD)
======================================================

File di dalam arsip ZIP ini:
1. erd_vovoi.png
   - Format: PNG Resolusi Tinggi (300 DPI)
   - Ukuran: 1960 x 1600 piksel
   - Cocok untuk: Dokumen Word, PDF, Laporan Tugas Akhir / Skripsi, dan Presentasi PowerPoint.

2. erd_vovoi.svg
   - Format: Scalable Vector Graphics (SVG)
   - Kualitas: Resolusi Vektor Tanpa Batas (tidak pecah saat di-zoom)
   - Cocok untuk: Dibuka langsung di Web Browser, diedit di Figma, Adobe Illustrator, atau Inkscape.

Daftar 7 Entitas Bisnis Utama:
- users: Akun pengguna, customer, admin, dan autentikasi.
- categories: Pengelompokan taksonomi produk.
- products: Master data barang, harga, deskripsi, dan stok real-time.
- vouchers: Kupon diskon potongan harga (nominal fixed maupun persen).
- transactions: Header pesanan, invoice code, ekspedisi pengiriman, dan status order.
- transaction_items: Detail rincian keranjang belanja (order line items) dengan data snapshot harga & nama.
- reviews: Ulasan pembeli dan rating bintang (1-5) setelah paket pesanan diterima.

Dibuat otomatis dari skema basis data Laravel 11 (PHP 8.4).
