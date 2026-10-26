@extends('layouts.admin')

@section('title', 'Manajemen Transaksi Masuk - VOVOI Operations')

@section('extra_css')
<style>
    .admin-kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .admin-kpi-card {
        background: #FFFFFF;
        border: 1px solid var(--border-light, #E2E8F0);
        border-radius: var(--radius-lg, 18px);
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform var(--transition-fast, 0.15s ease), box-shadow var(--transition-fast, 0.15s ease);
    }

    .admin-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
    }

    .admin-kpi-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .admin-kpi-label {
        font-family: var(--font-mono, monospace);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: var(--text-muted, #94A3B8);
        text-transform: uppercase;
    }

    .admin-kpi-value {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--text-primary, #0F172A);
        margin: 0;
    }

    .admin-table-card {
        background: #FFFFFF;
        border: 1px solid var(--border-light, #E2E8F0);
        border-radius: var(--radius-lg, 18px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .admin-table-header {
        padding: 24px 28px;
        border-bottom: 1px solid var(--border-light, #E2E8F0);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .admin-table th {
        background: #F8F9FA;
        color: var(--text-secondary, #64748B);
        font-family: var(--font-mono, monospace);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 14px 20px;
        text-align: left;
        border-bottom: 1px solid var(--border-light, #E2E8F0);
    }

    .admin-table td {
        padding: 18px 20px;
        border-bottom: 1px solid var(--border-light, #E2E8F0);
        vertical-align: top;
    }

    .admin-table tr:hover td {
        background-color: #FAFAFB;
    }

    .admin-table tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: var(--radius-full, 9999px);
        font-size: 11px;
        font-weight: 700;
        font-family: var(--font-mono, monospace);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-badge.pending {
        background: rgba(245, 158, 11, 0.1);
        color: #B45309;
        border: 1px solid rgba(245, 158, 11, 0.25);
    }

    .status-badge.paid {
        background: rgba(37, 99, 235, 0.08);
        color: #1D4ED8;
        border: 1px solid rgba(37, 99, 235, 0.25);
    }

    .status-badge.shipped {
        background: rgba(16, 185, 129, 0.1);
        color: #047857;
        border: 1px solid rgba(16, 185, 129, 0.25);
    }

    .btn-action-status {
        border: 1px solid var(--border-light, #E2E8F0);
        background: #FFFFFF;
        padding: 5px 10px;
        border-radius: var(--radius-sm, 6px);
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition-fast, 0.15s ease);
        font-family: var(--font-mono, monospace);
    }

    .btn-action-status:hover {
        transform: translateY(-1px);
    }

    .btn-action-status.paid {
        color: #1D4ED8;
        background: rgba(37, 99, 235, 0.05);
        border-color: rgba(37, 99, 235, 0.3);
    }

    .btn-action-status.paid:hover {
        background: #1D4ED8;
        color: #FFFFFF;
    }

    .btn-action-status.shipped {
        color: #047857;
        background: rgba(16, 185, 129, 0.06);
        border-color: rgba(16, 185, 129, 0.3);
    }

    .btn-action-status.shipped:hover {
        background: #047857;
        color: #FFFFFF;
    }

    .btn-action-status.pending {
        color: #64748B;
        background: #F1F3F5;
        border-color: #CBD5E1;
    }

    .btn-action-status.pending:hover {
        background: #64748B;
        color: #FFFFFF;
    }
</style>
@endsection

@section('konten_admin')
    <!-- 1. Page Header -->
    <div style="margin-bottom: 28px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
            <span class="v-tag-mono green">
                <span class="v-dot-indicator green"></span>
                SYSTEM ACTIVE &bull; LIVE SYNC
            </span>
        </div>
        <h1 style="font-size: 28px; font-weight: 800; letter-spacing: -0.03em; margin: 0 0 6px 0; color: var(--text-primary, #0F172A);">
            Daftar Pesanan &amp; Transaksi Toko
        </h1>
        <p style="font-size: 14px; color: var(--text-secondary, #64748B); margin: 0;">
            Kelola status pesanan pembeli secara real-time dan pantau ringkasan performa penjualan VOVOI.
        </p>
    </div>

    <!-- 2. Kotak Notifikasi Flash Session -->
    @if(session('success'))
        <div style="background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: var(--radius-md, 12px); padding: 14px 20px; margin-bottom: 28px; color: #065F46; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 3. KPI Metrics Dashboard -->
    <div class="admin-kpi-grid">
        <div class="admin-kpi-card" style="border-top: 3px solid #0F172A;">
            <div class="admin-kpi-top">
                <span class="admin-kpi-label">TOTAL PRODUK DI ETALASE</span>
                <span class="v-tag-mono">CATALOG</span>
            </div>
            <div class="admin-kpi-value">{{ $totalProducts }} Produk</div>
            <div style="font-size: 12px; color: var(--text-muted, #94A3B8); margin-top: 8px;">
                Tersinkronisasi dari inventaris aktif
            </div>
        </div>

        <div class="admin-kpi-card" style="border-top: 3px solid #D97706;">
            <div class="admin-kpi-top">
                <span class="admin-kpi-label">TOTAL PESANAN MASUK</span>
                <span class="v-tag-mono">ORDERS</span>
            </div>
            <div class="admin-kpi-value">{{ $totalTransactions }} Transaksi</div>
            <div style="font-size: 12px; color: var(--text-muted, #94A3B8); margin-top: 8px;">
                Total akumulasi transaksi tercatat
            </div>
        </div>

        <div class="admin-kpi-card" style="border-top: 3px solid #10B981;">
            <div class="admin-kpi-top">
                <span class="admin-kpi-label">TOTAL OMZET PENJUALAN</span>
                <span class="v-tag-mono green">
                    <span class="v-dot-indicator green"></span>
                    REVENUE
                </span>
            </div>
            <div class="admin-kpi-value" style="color: #047857;">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
            <div style="font-size: 12px; color: var(--text-muted, #94A3B8); margin-top: 8px;">
                Total nilai kotor seluruh pesanan
            </div>
        </div>
    </div>

    <!-- 4. Tabel Manajemen Transaksi -->
    <div class="admin-table-card">
        <div class="admin-table-header">
            <div>
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 4px 0; color: var(--text-primary, #0F172A);">
                    Daftar Pesanan Pembeli (Terbaru)
                </h3>
                <span style="font-size: 13px; color: var(--text-secondary, #64748B);">
                    Menampilkan seluruh riwayat transaksi yang masuk ke toko.
                </span>
            </div>

            <!-- Client-side Fast Filter -->
            <div style="position: relative; min-width: 260px;">
                <input type="text" id="orderSearchInput" placeholder="Cari invoice atau nama pembeli..." onkeyup="filterOrdersTable()"
                    style="width: 100%; padding: 8px 14px 8px 34px; border: 1px solid var(--border-light, #E2E8F0); border-radius: var(--radius-full, 9999px); font-size: 12px; font-family: inherit; outline: none; background: #F8F9FA;"
                >
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted, #94A3B8);">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table" id="transactionsTable">
                <thead>
                    <tr>
                        <th style="min-width: 170px;">Invoice &amp; Waktu</th>
                        <th style="min-width: 220px;">Identitas &amp; Pengiriman</th>
                        <th style="min-width: 180px;">Rincian Barang</th>
                        <th style="min-width: 140px;">Total Bayar</th>
                        <th style="min-width: 130px; text-align: center;">Status Pesanan</th>
                        <th style="min-width: 190px; text-align: center;">Ubah Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $item)
                        <tr class="order-row">
                            <!-- Kolom 1: Kode Invoice & Nota -->
                            <td>
                                <div style="font-family: var(--font-mono, monospace); font-weight: 700; color: #0F172A; font-size: 14px;">
                                    {{ $item->invoice_code }}
                                </div>
                                <div style="font-family: var(--font-mono, monospace); font-size: 11px; color: var(--text-muted, #94A3B8); margin: 3px 0 8px 0;">
                                    {{ $item->created_at->format('d M Y, H:i') }} WIB
                                </div>
                                <a href="/berhasil/{{ $item->id }}" target="_blank"
                                    style="font-size: 11px; font-family: var(--font-mono, monospace); color: #0F172A; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; background: #F1F3F5; padding: 4px 8px; border-radius: var(--radius-sm, 6px); border: 1px solid var(--border-light, #E2E8F0);"
                                    title="Buka Halaman Nota Digital Pembeli">
                                    Lihat Nota Pembeli
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="7" y1="17" x2="17" y2="7"></line>
                                        <polyline points="7 7 17 7 17 17"></polyline>
                                    </svg>
                                </a>
                            </td>

                            <!-- Kolom 2: Penerima -->
                            <td>
                                <div style="font-weight: 700; color: var(--text-primary, #0F172A); font-size: 14px;">
                                    {{ $item->customer_name }}
                                </div>
                                <div style="font-size: 12px; color: #047857; font-weight: 600; margin: 4px 0; display: flex; align-items: center; gap: 5px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    {{ $item->customer_phone }}
                                </div>
                                <div style="font-size: 12px; color: var(--text-secondary, #64748B); max-width: 250px; line-height: 1.4;">
                                    📍 {{ $item->customer_address }}
                                </div>
                            </td>

                            <!-- Kolom 3: Rincian Produk -->
                            <td>
                                <div style="font-weight: 700; color: var(--text-primary, #0F172A);">
                                    {{ $item->product_name }}
                                </div>
                                <div style="font-size: 12px; color: var(--text-secondary, #64748B); margin-top: 4px;">
                                    Jumlah: <strong>{{ $item->quantity }}x</strong> unit
                                </div>
                                <div style="font-size: 12px; color: var(--text-primary, #0F172A); margin-top: 2px; font-weight: 600;">
                                    🚚 {{ $item->courier }} (Rp {{ number_format($item->shipping_cost, 0, ',', '.') }})
                                </div>
                            </td>

                            <!-- Kolom 4: Total Bayar -->
                            <td>
                                <div style="font-size: 15px; font-weight: 800; color: var(--text-primary, #0F172A); font-family: var(--font-sans);">
                                    Rp {{ number_format($item->total_amount, 0, ',', '.') }}
                                </div>
                            </td>

                            <!-- Kolom 5: Status Pesanan -->
                            <td style="text-align: center;">
                                @if($item->status == 'Pending')
                                    <span class="status-badge pending">
                                        ⏳ Pending
                                    </span>
                                @elseif($item->status == 'Paid')
                                    <span class="status-badge paid">
                                        💳 Paid (Lunas)
                                    </span>
                                @elseif($item->status == 'Shipped')
                                    <span class="status-badge shipped">
                                        🚚 Shipped (Dikirim)
                                    </span>
                                @else
                                    <span class="v-tag-mono">{{ $item->status }}</span>
                                @endif
                            </td>

                            <!-- Kolom 6: Form Ubah Status -->
                            <td style="text-align: center;">
                                <form action="/admin/transactions/{{ $item->id }}/status" method="POST" style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                                    @csrf
                                    <button type="submit" name="status" value="Paid" class="btn-action-status paid" title="Tandai pesanan lunas">
                                        Set Lunas
                                    </button>
                                    <button type="submit" name="status" value="Shipped" class="btn-action-status shipped" title="Tandai pesanan sudah dikirim">
                                        Set Dikirim
                                    </button>
                                    <button type="submit" name="status" value="Pending" class="btn-action-status pending" title="Kembalikan status menjadi pending">
                                        Reset
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 48px 20px; color: var(--text-muted, #94A3B8);">
                                <div style="font-size: 32px; margin-bottom: 8px;">📦</div>
                                <div style="font-size: 15px; font-weight: 700; color: var(--text-primary, #0F172A);">
                                    Belum Ada Data Pesanan
                                </div>
                                <p style="font-size: 13px; margin: 6px 0 0 0;">
                                    Lakukan simulasi checkout di etalase toko untuk melihat pesanan tercatat di sini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('extra_js')
<script>
    function filterOrdersTable() {
        const query = document.getElementById('orderSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#transactionsTable tbody tr.order-row');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    }
</script>
@endsection