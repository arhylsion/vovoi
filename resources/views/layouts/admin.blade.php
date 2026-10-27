<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ruang Kendali Admin - VOVOI Operations')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vovoi.css') }}">
    <style>
        .admin-nav-item {
            font-size: 13px;
            font-weight: 600;
            color: #94A3B8;
            padding: 8px 16px;
            border-radius: var(--radius-full, 9999px);
            transition: all var(--transition-fast, 0.15s ease);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .admin-nav-item:hover, .admin-nav-item.active {
            color: #FFFFFF;
            background: rgba(255, 255, 255, 0.08);
        }
        .admin-nav-btn-store {
            font-size: 13px;
            font-weight: 600;
            color: #FFFFFF;
            background: #1E293B;
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 8px 18px;
            border-radius: var(--radius-full, 9999px);
            transition: all var(--transition-fast, 0.15s ease);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .admin-nav-btn-store:hover {
            background: #334155;
            border-color: rgba(255, 255, 255, 0.3);
        }
    </style>
    @yield('extra_css')
</head>
<body style="min-height: 100vh; display: flex; flex-direction: column; background-color: #F8F9FA; color: var(--text-primary, #0F172A); font-family: var(--font-sans);">

    <!-- 1. HEADER KHUSUS ADMIN (VOVOI BACK-OFFICE CONSOLE) -->
    <header style="background-color: #0A0B0D; border-bottom: 1px solid #1E2024; position: sticky; top: 0; z-index: 100;">
        <div class="v-container" style="display: flex; justify-content: space-between; align-items: center; height: 72px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <a href="/admin/transactions" class="v-logo" style="color: #FFFFFF;" title="VOVOI Back-Office">
                    <span style="letter-spacing: -0.05em; font-weight: 800; font-size: 24px;">VOVOI</span>
                </a>
            </div>

            <nav style="display: flex; align-items: center; gap: 12px;">
                <a href="/admin/transactions" class="admin-nav-item {{ request()->is('admin/transactions*') ? 'active' : '' }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    Pesanan Masuk
                </a>
                <a href="/" target="_blank" class="admin-nav-btn-store" title="Buka Toko di Tab Baru">
                    Lihat Toko
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="7" y1="17" x2="17" y2="7"></line>
                        <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                </a>
            </nav>
        </div>
    </header>

    <!-- 2. AREA KONTEN DINAMIS ADMIN -->
    <main style="flex: 1; padding: 36px 0 60px;">
        <div class="v-container">
            @yield('konten_admin')
        </div>
    </main>

    <!-- 3. FOOTER ADMIN -->
    <footer style="background-color: #0A0B0D; border-top: 1px solid #1E2024; padding: 24px 0; margin-top: auto; color: #64748B; font-size: 13px;">
        <div class="v-container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <strong style="color: #FFFFFF; font-weight: 800;">VOVOI</strong>
                <span>&bull;</span>
                <span>Internal Operations &amp; Transaction Console</span>
            </div>
        </div>
    </footer>

    @yield('extra_js')
</body>
</html>