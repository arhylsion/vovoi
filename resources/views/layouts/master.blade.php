<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Store - E-Commerce Kelas XII</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;5
00;600;700;800&display=swap"
        rel="stylesheet">
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

        .store-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 48px;
            height: 76px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 32px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .store-brand {
            text-decoration: none;
            color: #0B5ED7;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            white-space: nowrap;
        }

        .header-search-form {
            flex: 1;
            max-width: 560px;
            display: flex;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            overflow: hidden;
            background-color: #f8fafc;
            transition: border-color 0.15s ease;
        }

        .header-search-form:focus-within {
            border-color: #0B5ED7;
            background-color: #ffffff;
        }

        .header-search-input {
            width: 100%;
            padding: 10px 16px;
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 14px;
            color: #0f172a;
            outline: none;
        }

        .header-search-btn {
            background-color: #0B5ED7;
            color: #ffffff;
            border: none;
            padding: 0 20px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .store-nav {
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
        }

        .nav-item {
            text-decoration: none;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 8px;
        }

        .nav-item:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .nav-seller-btn {
            text-decoration: none;
            color: #0f172a;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
        }

        .store-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px;
            min-height: calc(100vh - 150px);
        }

        .store-footer {
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            padding: 24px;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <header class="store-header">
        <!-- Sesuaikan teks TECHZONE dengan Nama Toko Kelompok Kalian -->
        <a href="/" class="store-brand">TECHZONE</a>
        <form action="/" method="GET" class="header-search-form">
            @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama produk atau spesifikasi di sini..." class="header-search-input">
            <button type="submit" class="header-search-btn">Cari</button>
        </form>
        <nav class="store-nav">
            <a href="/" class="nav-item">Katalog Utama</a>

            <!-- TAMBAHAN P12: Tombol Pintar Pendeteksi Status Login Admin
-->
            @auth
                <a href="/admin/transactions" class="nav-seller-btn"
                    style="background-color: #eff6ff; color: #0B5ED7; border-color: #bfdbfe;">
                    Panel Seller ({{ Auth::user()->name }}) &rarr;
                </a>
            @else
                <a href="/login" class="nav-seller-btn">
                    Login Seller &rarr;
                </a>
            @endauth
        </nav>
    </header>
    <main class="store-main">
        @yield('konten_utama')
    </main>
    <footer class="store-footer">
        &copy; 2026 Official Store &bull; Rekayasa Perangkat Lunak - SMK
        Plus Pelita Nusantara Bogor
    </footer>
</body>

</html>
