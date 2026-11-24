<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Center - Panel Pengelola Toko VOVOI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system,
                BlinkMacSystemFont, sans-serif;
            margin: 0;
            background-color: #f8fafc;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }

        .topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 40px;
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
            padding: 8px 14px;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .nav-link:hover, .nav-link.active {
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
            margin-left: 8px;
        }

        .container-admin {
            max-width: 1240px;
            margin: 0 auto;
            padding: 32px 24px 64px;
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

        @media (max-width: 992px) {
            .topbar {
                padding: 12px 20px;
                height: auto;
                flex-wrap: wrap;
                gap: 12px;
            }
            .nav-menu {
                overflow-x: auto;
                max-width: 100%;
                gap: 6px;
            }
            .container-admin {
                padding: 20px 16px 48px;
            }
        }

        @media print {
            .topbar, .footer-admin, .no-print, button, form {
                display: none !important;
            }
            .container-admin {
                max-width: 100% !important;
                padding: 0 !important;
            }
        }
    </style>
    @yield('extra_css')
</head>

<body>
    <header class="topbar">
        <div class="brand-area">
            <span class="brand-badge">SELLER CENTER</span>
            <h1 class="brand-title">Portal Manajemen Toko VOVOI</h1>
        </div>
        <nav class="nav-menu">
            <a href="/admin/transactions" class="nav-link {{ request()->is('admin/transactions*') ? 'active' : '' }}">Pesanan Masuk</a>
            <a href="/admin/products" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">Katalog Produk</a>
            <a href="/admin/categories" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">Kategori</a>
            <a href="/admin/products/create" class="nav-link" style="color: #0B5ED7; font-weight: 700;">+ Tambah Produk</a>
            <a href="/" target="_blank" class="nav-link-store">Lihat Toko Depan &nearr;</a>
            
            @auth
                <div style="display: flex; align-items: center; gap: 12px; margin-left: 12px; padding-left: 16px; border-left: 1px solid #e2e8f0;">
                    <div style="text-align: right;">
                        <span style="display: block; font-size: 11px; color: #64748b; font-weight: 600;">Admin Aktif</span>
                        <strong style="font-size: 13px; color: #0f172a;">{{ Auth::user()->name }}</strong>
                    </div>
                    <form action="/logout" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit"
                            style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 8px 14px; border-radius: 8px; font-family: inherit; font-size: 13px; font-weight: 700; cursor: pointer;">
                            Keluar
                        </button>
                    </form>
                </div>
            @endauth
        </nav>
    </header>

    <main class="container-admin">
        @yield('konten_admin')
    </main>

    <footer class="footer-admin">
        Portal Seller Center &bull; Kompetensi Keahlian Rekayasa Perangkat
        Lunak - SMK Plus Pelita Nusantara
    </footer>

    @yield('extra_js')
</body>

</html>
