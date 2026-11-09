<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Center - Panel Pengelola Toko</title>
    <!-- Memanggil Font Standar Industri Startup Indonesia: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            background-color: #f8fafc;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }
        .topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 48px;
            height: 68px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .brand-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brand-badge {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }
        .brand-title {
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        .nav-menu {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .nav-link {
            text-decoration: none;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            padding: 9px 16px;
            border-radius: 8px;
            transition: all 0.15s ease;
        }
        .nav-link:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }
        .nav-link-store {
            text-decoration: none;
            color: #0B5ED7;
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            margin-left: 12px;
            transition: all 0.15s ease;
        }
        .nav-link-store:hover {
            background-color: #dbeafe;
        }
        .container-admin {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px;
            min-height: calc(100vh - 130px);
        }
        .footer-admin {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            padding: 20px;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <!-- 1. TOPBAR SELLER CENTER -->
    <header class="topbar">
        <div class="brand-area">
            <span class="brand-badge">SELLER CENTER</span>
            <h1 class="brand-title">Portal Manajemen Toko</h1>
        </div>
        <nav class="nav-menu">
            <a href="/admin/transactions" class="nav-link">Pesanan Masuk</a>
            <a href="/admin/products" class="nav-link">Katalog Produk</a>
            <a href="/admin/products/create" class="nav-link" style="color: #0B5ED7;">+ Tambah Produk</a>
            <a href="/" target="_blank" class="nav-link-store">Lihat Toko Depan &nearr;</a>
        </nav>
    </header>

    <!-- 2. AREA KONTEN DINAMIS -->
    <main class="container-admin">
        @yield('konten_admin')
    </main>

    <!-- 3. FOOTER -->
    <footer class="footer-admin">
        Portal Seller Center &bull; Kompetensi Keahlian Rekayasa Perangkat Lunak - SMK Plus Pelita Nusantara
    </footer>
</body>
</html>

