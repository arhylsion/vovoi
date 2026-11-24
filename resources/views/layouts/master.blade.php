<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VOVOI - Official Flagship Store')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0B5ED7;
            --primary-dark: #084298;
            --primary-light: #eff6ff;
            --accent: #FFC107;
            --text-primary: #0F172A;
            --text-secondary: #475569;
            --text-muted: #94A3B8;
            --border-light: #E2E8F0;
            --border-medium: #CBD5E1;
            --bg-body: #F8FAFC;
            --bg-card: #FFFFFF;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 20px;
            --font-main: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-main);
            margin: 0;
            background-color: var(--bg-body);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
        }

        .store-header {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-light);
            padding: 0 40px;
            height: 74px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 28px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(15, 23, 42, 0.03);
        }

        .store-brand {
            text-decoration: none;
            color: var(--text-primary);
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .store-brand-badge {
            background: linear-gradient(135deg, #0B5ED7 0%, #1D4ED8 100%);
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 7px;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }

        .header-search-form {
            flex: 1;
            max-width: 520px;
            display: flex;
            border: 1px solid var(--border-medium);
            border-radius: var(--radius-md);
            overflow: hidden;
            background-color: #f8fafc;
            transition: all 0.15s ease;
        }

        .header-search-form:focus-within {
            border-color: var(--primary);
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(11, 94, 215, 0.1);
        }

        .header-search-input {
            width: 100%;
            padding: 10px 16px;
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 14px;
            color: var(--text-primary);
            outline: none;
        }

        .header-search-btn {
            background-color: var(--primary);
            color: #ffffff;
            border: none;
            padding: 0 20px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.15s ease;
        }

        .header-search-btn:hover {
            background-color: var(--primary-dark);
        }

        .store-nav {
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
        }

        .nav-item {
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .nav-item:hover {
            background-color: #f1f5f9;
            color: var(--text-primary);
        }

        .nav-cart-badge {
            background-color: #EF4444;
            color: #FFFFFF;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 9999px;
            line-height: 1;
        }

        .nav-seller-btn {
            text-decoration: none;
            color: var(--text-primary);
            background-color: #f8fafc;
            border: 1px solid var(--border-medium);
            font-size: 13px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            transition: all 0.15s ease;
        }

        .nav-seller-btn:hover {
            background-color: #f1f5f9;
            border-color: #94a3b8;
        }

        .store-main {
            max-width: 1220px;
            margin: 0 auto;
            padding: 32px 24px 64px;
            min-height: calc(100vh - 150px);
        }

        .store-footer {
            background-color: #ffffff;
            border-top: 1px solid var(--border-light);
            color: var(--text-muted);
            padding: 28px 24px;
            text-align: center;
            font-size: 13px;
        }

        /* Utility buttons & tags */
        .v-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s ease;
            border: none;
        }

        .v-btn-primary {
            background-color: #0B5ED7;
            color: #ffffff;
        }

        .v-btn-primary:hover {
            background-color: #084298;
        }

        .v-btn-secondary {
            background-color: #f1f5f9;
            color: #0f172a;
            border: 1px solid #cbd5e1;
        }

        .v-btn-secondary:hover {
            background-color: #e2e8f0;
        }

        .v-tag-mono {
            font-family: monospace;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            padding: 4px 10px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #f1f5f9;
            color: #475569;
        }

        .v-tag-mono.green {
            background-color: #ecfdf5;
            color: #059669;
        }

        .v-dot-indicator {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #10b981;
        }

        /* Responsive Breakpoints (Matriks QA No. 14) */
        @media (max-width: 992px) {
            .store-header {
                padding: 12px 20px;
                height: auto;
                flex-wrap: wrap;
                gap: 14px;
            }
            .header-search-form {
                order: 3;
                max-width: 100%;
                width: 100%;
            }
            .store-nav {
                gap: 8px;
                overflow-x: auto;
                max-width: 100%;
            }
            .store-main {
                padding: 20px 16px 48px;
            }
        }
        @media (max-width: 576px) {
            .store-brand {
                font-size: 20px;
            }
            .nav-item {
                font-size: 13px;
                padding: 6px 10px;
            }
            .nav-seller-btn {
                font-size: 12px;
                padding: 6px 12px;
            }
        }

        /* Print media styling */
        @media print {
            .store-header,
            .store-footer,
            .no-print,
            nav,
            button,
            .v-btn {
                display: none !important;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .store-main {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>

<body>
    <header class="store-header">
        <a href="/" class="store-brand">
            <span>VOVOI</span>
            <span class="store-brand-badge">OFFICIAL</span>
        </a>

        <form action="/" method="GET" class="header-search-form">
            @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari smartphone, spesifikasi, atau seri VOVOI..." class="header-search-input">
            <button type="submit" class="header-search-btn">Cari</button>
        </form>
        <nav class="store-nav">
            <a href="/" class="nav-item">Katalog Utama</a>
            <a href="/keranjang" class="nav-item">
                <span>Keranjang</span>
                @php
                    $cartCount = count(session('cart', []));
                @endphp
                @if($cartCount > 0)
                    <span class="nav-cart-badge">{{ $cartCount }}</span>
                @endif
            </a>

            @auth
                @if(Auth::user()->isAdmin())
                    <span class="nav-item" style="color: #475569; font-weight: 700;">
                        Seller: {{ Auth::user()->name }}
                    </span>
                    <a href="/admin/transactions" class="nav-seller-btn"
                        style="background-color: #eff6ff; color: #0B5ED7; border-color: #bfdbfe;">
                        Panel Seller Center &rarr;
                    </a>
                @else
                    <a href="/pesanan-saya" class="nav-item" style="font-weight: 700; color: #0B5ED7;">
                        Pesanan Saya
                    </a>
                    <a href="/profile" class="nav-item" style="color: #475569; font-weight: 600;">
                        Halo, {{ Auth::user()->name }}
                    </a>
                @endif
                <form action="/logout" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; font-family: inherit; font-size: 13px; font-weight: 600; color: #dc2626; cursor: pointer; padding: 6px 10px;">
                        Keluar
                    </button>
                </form>
            @else
                <a href="/register" class="nav-item" style="font-size: 13px; font-weight: 600; color: #475569; text-decoration: none; padding: 6px 10px;">
                    Daftar
                </a>
                <a href="/login" class="nav-seller-btn">
                    Masuk &rarr;
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
