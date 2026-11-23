<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Penjualan - VOVOI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            margin: 0;
            padding: 32px;
            background: #f8fafc;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }
        .report-sheet {
            max-width: 1040px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 20px;
            margin-bottom: 28px;
        }
        .company-name {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin: 0;
            color: #0f172a;
        }
        .company-sub {
            font-size: 13px;
            color: #64748b;
            margin: 4px 0 0 0;
        }
        .report-meta {
            text-align: right;
            font-size: 13px;
            color: #475569;
        }
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }
        .kpi-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
        }
        .kpi-title {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .kpi-val {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-top: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 32px;
        }
        th {
            background: #0f172a;
            color: #ffffff;
            text-align: left;
            padding: 10px 12px;
            font-weight: 700;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }
        tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 11px;
        }
        .status-Pending { background: #fef3c7; color: #92400e; }
        .status-Paid { background: #dbeafe; color: #1e40af; }
        .status-Shipped { background: #dcfce7; color: #166534; }
        .status-Cancelled { background: #fee2e2; color: #991b1b; }
        .sign-grid {
            display: flex;
            justify-content: space-between;
            margin-top: 48px;
            padding-top: 24px;
        }
        .sign-box {
            text-align: center;
            width: 220px;
        }
        .action-bar {
            max-width: 1040px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .report-sheet {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            .action-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="action-bar no-print">
        <a href="/admin/transactions" class="btn-action" style="background: #e2e8f0; color: #0f172a;">
            &larr; Kembali ke Seller Center
        </a>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.transactions.export.csv') }}" class="btn-action" style="background: #10b981; color: white;">
                Unduh File CSV
            </a>
            <button onclick="window.print()" class="btn-action" style="background: #0B5ED7; color: white;">
                🖨️ Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <div class="report-sheet">
        <div class="header-section">
            <div>
                <h1 class="company-name">VOVOI OFFICIAL STORE</h1>
                <p class="company-sub">Laporan Rekapitulasi Penjualan & Transaksi Toko &bull; E-Commerce RPL</p>
                <p class="company-sub">Sektor: Elektronik & Teknologi &bull; SMKS Plus Pelita Nusantara</p>
            </div>
            <div class="report-meta">
                <div><strong>Tanggal Cetak:</strong> {{ date('d F Y, H:i') }} WIB</div>
                <div><strong>Dicetak Oleh:</strong> {{ Auth::user()?->name ?? 'Administrator' }}</div>
                <div><strong>Status Laporan:</strong> Resmi Terverifikasi</div>
            </div>
        </div>

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-title">Total Transaksi</div>
                <div class="kpi-val">{{ $totalOrders }} Pesanan</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">Pesanan Selesai / Lunas</div>
                <div class="kpi-val" style="color: #059669;">{{ $paidOrders + $shippedOrders }} Pesanan</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">Pesanan Pending</div>
                <div class="kpi-val" style="color: #d97706;">{{ $pendingOrders }} Pesanan</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">Total Omzet Bersih</div>
                <div class="kpi-val" style="color: #0B5ED7;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 35px;">No.</th>
                    <th>Invoice</th>
                    <th>Waktu</th>
                    <th>Pembeli & Kontak</th>
                    <th>Rincian Produk</th>
                    <th>Kurir</th>
                    <th>Diskon</th>
                    <th>Total Bayar</th>
                    <th style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $index => $t)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $t->invoice_code }}</strong></td>
                        <td>{{ $t->created_at ? $t->created_at->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            <strong>{{ $t->customer_name }}</strong><br>
                            <span style="font-size: 11px; color: #64748b;">{{ $t->customer_phone }}</span>
                        </td>
                        <td>
                            {{ $t->product_name }} ({{ $t->quantity }}x)
                        </td>
                        <td>{{ $t->courier }}</td>
                        <td>
                            @if($t->discount_amount > 0)
                                -Rp {{ number_format($t->discount_amount, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td><strong>Rp {{ number_format($t->total_amount, 0, ',', '.') }}</strong></td>
                        <td style="text-align: center;">
                            <span class="status-badge status-{{ $t->status }}">
                                {{ $t->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 24px; color: #64748b;">
                            Tidak ada transaksi yang tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="sign-grid">
            <div class="sign-box">
                <p style="font-size: 13px; margin: 0 0 70px 0;">Mengetahui,<br><strong>Project Manager (QC Lead)</strong></p>
                <p style="font-size: 13px; font-weight: 700; margin: 0; text-decoration: underline;">Athallah Rikza</p>
                <p style="font-size: 11px; color: #64748b; margin: 2px 0 0 0;">VOVOI Core Team</p>
            </div>

            <div class="sign-box">
                <p style="font-size: 13px; margin: 0 0 70px 0;">Disahkan Oleh,<br><strong>Guru Penguji / Pembimbing</strong></p>
                <p style="font-size: 13px; font-weight: 700; margin: 0; text-decoration: underline;">Sulthan Alawy Shihab, S.Kom</p>
                <p style="font-size: 11px; color: #64748b; margin: 2px 0 0 0;">Guru Pemrograman Web</p>
            </div>
        </div>
    </div>
</body>
</html>
