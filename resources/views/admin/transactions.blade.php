@extends('layouts.admin')

@section('konten_admin')
    <!-- 1. KOTAK NOTIFIKASI FLASH SESSION -->
    @if(session('success'))
        <div style="background-color: #d1e7dd; color: #0f5132; padding: 15px 20px; border-radius: 8px; border: 1px solid #badbcc; margin-bottom: 25px; font-weight: bold;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- 2. DERETAN 4 KARTU RINGKASAN STATISTIK BISNIS (SESUAI SPESIFIKASI MODUL 6) -->
    <div style="display: flex; gap: 16px; margin-bottom: 30px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 200px; background-color: white; padding: 20px; border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid #0B5ED7;">
            <span style="font-size: 11px; color: #64748b; font-weight: 800; letter-spacing: 0.5px;">TOTAL PRODUK DI ETALASE</span>
            <h2 style="margin: 8px 0 0 0; font-size: 26px; color: #0f172a;">{{ $totalProducts }} Produk</h2>
        </div>
        <div style="flex: 1; min-width: 200px; background-color: white; padding: 20px; border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid #f59e0b;">
            <span style="font-size: 11px; color: #64748b; font-weight: 800; letter-spacing: 0.5px;">TOTAL PESANAN MASUK</span>
            <h2 style="margin: 8px 0 0 0; font-size: 26px; color: #b45309;">{{ $totalTransactions }} Transaksi</h2>
            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">Pending: {{ $pendingOrders }} &bull; Paid+Shipped: {{ $paidShippedOrders }}</div>
        </div>
        <div style="flex: 1; min-width: 200px; background-color: white; padding: 20px; border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid #0284c7;">
            <span style="font-size: 11px; color: #64748b; font-weight: 800; letter-spacing: 0.5px;">PESANAN PAID + SHIPPED</span>
            <h2 style="margin: 8px 0 0 0; font-size: 26px; color: #0369a1;">{{ $paidShippedOrders }} Transaksi</h2>
        </div>
        <div style="flex: 1.2; min-width: 240px; background-color: white; padding: 20px; border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid #16a34a;">
            <span style="font-size: 11px; color: #64748b; font-weight: 800; letter-spacing: 0.5px;">TOTAL OMZET PENJUALAN</span>
            <h2 style="margin: 8px 0 0 0; font-size: 26px; color: #15803d;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            <div style="font-size: 11px; color: #16a34a; font-weight: 600; margin-top: 4px;">*Pesanan Pending tidak terhitung</div>
        </div>
    </div>

    <!-- 3. BAR AKSI EKSPOR LAPORAN PENJUALAN (FITUR INOVASI P12) -->
    <div style="background-color: white; padding: 18px 24px; border-radius: 8px; border: 1px solid #cbd5e1; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">📊 Ekspor Rekap Data Penjualan</h4>
            <p style="margin: 2px 0 0 0; font-size: 12px; color: #64748b;">
                Unduh rekap transaksi untuk keperluan akuntansi, audit, dan arsip cetak resmi.
            </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('admin.transactions.export.csv') }}" style="background-color: #f8fafc; color: #0f172a; border: 1px solid #cbd5e1; padding: 8px 14px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <span>📄</span> Ekspor CSV
            </a>
            <a href="{{ route('admin.transactions.export.excel') }}" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 8px 14px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <span>📗</span> Ekspor Excel (.xlsx)
            </a>
            <a href="{{ route('admin.transactions.export.pdf') }}" target="_blank" style="background-color: #0f172a; color: #ffffff; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <span>🖨️</span> Ekspor PDF / Cetak Laporan
            </a>
        </div>
    </div>

    <!-- 4. FILTER STATUS PESANAN (MODUL 6 & MATRIKS QA NO. 10 & 11) -->
    @php
        $currFilter = request('status', 'all');
    @endphp
    <div style="display: flex; gap: 8px; margin-bottom: 18px; overflow-x: auto; padding-bottom: 4px;">
        <a href="{{ route('admin.transactions') }}" style="text-decoration: none; padding: 7px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; {{ $currFilter === 'all' ? 'background-color: #0B5ED7; color: #ffffff;' : 'background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            Semua Pesanan ({{ $totalTransactions }})
        </a>
        <a href="{{ route('admin.transactions', ['status' => 'Pending']) }}" style="text-decoration: none; padding: 7px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; {{ $currFilter === 'Pending' ? 'background-color: #f59e0b; color: #ffffff;' : 'background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            ⏳ Pending ({{ $pendingOrders }})
        </a>
        <a href="{{ route('admin.transactions', ['status' => 'Paid']) }}" style="text-decoration: none; padding: 7px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; {{ $currFilter === 'Paid' ? 'background-color: #0284c7; color: #ffffff;' : 'background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            💳 Paid
        </a>
        <a href="{{ route('admin.transactions', ['status' => 'Shipped']) }}" style="text-decoration: none; padding: 7px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; {{ $currFilter === 'Shipped' ? 'background-color: #16a34a; color: #ffffff;' : 'background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            🚚 Shipped
        </a>
        <a href="{{ route('admin.transactions', ['status' => 'Cancelled']) }}" style="text-decoration: none; padding: 7px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; {{ $currFilter === 'Cancelled' ? 'background-color: #ef4444; color: #ffffff;' : 'background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            ❌ Cancelled
        </a>
    </div>

    <!-- 5. TABEL MANAJEMEN PESANAN MASUK -->
    <div style="background-color: white; padding: 22px; border-radius: 8px; border: 1px solid #cbd5e1;">
        <h3 style="margin-top: 0; margin-bottom: 18px; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; font-size: 17px;">
            📋 Daftar Pesanan Pembeli (Diurutkan dari yang Terbaru)
        </h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 980px;">
                <thead>
                    <tr style="background-color: #f8fafc; color: #334155; text-align: left; border-bottom: 2px solid #cbd5e1;">
                        <th style="padding: 12px 10px;">No. Invoice & Waktu</th>
                        <th style="padding: 12px 10px;">Identitas & Alamat Pembeli</th>
                        <th style="padding: 12px 10px;">Rincian Barang, Kurir & Resi</th>
                        <th style="padding: 12px 10px;">Total Bayar</th>
                        <th style="padding: 12px 10px; text-align: center;">Status</th>
                        <th style="padding: 12px 10px; text-align: center;">Aksi Status & Resi</th>
                        <th style="padding: 12px 10px; text-align: center;">Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $item)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <!-- Kolom 1: Kode Invoice & Tautan Cek Nota Pembeli -->
                            <td style="padding: 14px 10px; vertical-align: top;">
                                <strong style="color: #0B5ED7; font-size: 14px; font-family: monospace;">{{ $item->invoice_code }}</strong>
                                <div style="font-size: 12px; color: #64748b; margin: 4px 0 8px 0;">
                                    {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }} WIB
                                </div>
                                <a href="/berhasil/{{ $item->id }}" target="_blank" style="font-size: 11px; color: #0B5ED7; text-decoration: none; font-weight: bold; background-color: #eff6ff; padding: 3px 8px; border-radius: 4px; border: 1px solid #bfdbfe; display: inline-block;">
                                    Lihat Nota Pembeli &nearr;
                                </a>
                            </td>

                            <!-- Kolom 2: Data Penerima -->
                            <td style="padding: 14px 10px; vertical-align: top;">
                                <strong style="color: #0f172a;">{{ $item->customer_name }}</strong>
                                <div style="font-size: 12px; color: #0f5132; font-weight: bold; margin: 4px 0;">
                                    📞 {{ $item->customer_phone }}
                                </div>
                                <div style="font-size: 12px; color: #475569; max-width: 220px; line-height: 1.4;">
                                    📍 {{ $item->customer_address }}
                                </div>
                            </td>

                            <!-- Kolom 3: Produk, Qty, Kurir, & Resi -->
                            <td style="padding: 14px 10px; vertical-align: top;">
                                <strong style="color: #0f172a;">{{ $item->product_name }}</strong>
                                <div style="font-size: 12px; color: #475569; margin-top: 2px;">
                                    Jumlah: <strong>{{ $item->quantity }} pcs</strong> &bull; {{ $item->courier }}
                                </div>
                                
                                <!-- Nomor Resi Pengiriman -->
                                @if($item->tracking_number)
                                    <div style="margin-top: 6px; display: inline-flex; align-items: center; gap: 4px; background-color: #ecfdf5; border: 1px solid #a7f3d0; padding: 3px 8px; border-radius: 4px; font-size: 11px;">
                                        <span style="color: #065f46; font-weight: 600;">Resi:</span>
                                        <strong style="color: #047857; font-family: monospace;">{{ $item->tracking_number }}</strong>
                                    </div>
                                @elseif($item->status === 'Shipped')
                                    <div style="font-size: 11px; color: #dc2626; margin-top: 4px;">
                                        *Resi belum diinput
                                    </div>
                                @endif

                                @if($item->voucher_code)
                                    <div style="font-size: 11px; color: #059669; font-weight: 600; margin-top: 4px;">
                                        🏷️ Kupon: {{ $item->voucher_code }} (-Rp {{ number_format($item->discount_amount, 0, ',', '.') }})
                                    </div>
                                @endif
                            </td>

                            <!-- Kolom 4: Total Pembayaran -->
                            <td style="padding: 14px 10px; vertical-align: top; font-weight: bold; color: #0f172a; font-size: 14px;">
                                Rp {{ number_format($item->total_amount, 0, ',', '.') }}
                                <div style="font-size: 11px; color: #64748b; font-weight: normal;">
                                    (Ongkir: Rp {{ number_format($item->shipping_cost, 0, ',', '.') }})
                                </div>
                            </td>

                            <!-- Kolom 5: Indikator Warna Status -->
                            <td style="padding: 14px 10px; vertical-align: top; text-align: center;">
                                @if($item->status == 'Pending')
                                    <span style="background-color: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; border: 1px solid #ffeeba;">
                                        ⏳ Pending
                                    </span>
                                @elseif($item->status == 'Paid')
                                    <span style="background-color: #cfe2ff; color: #084298; padding: 5px 10px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; border: 1px solid #b6d4fe;">
                                        💳 Paid
                                    </span>
                                @elseif($item->status == 'Shipped')
                                    <span style="background-color: #d1e7dd; color: #0f5132; padding: 5px 10px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; border: 1px solid #badbcc;">
                                        🚚 Shipped
                                    </span>
                                @elseif($item->status == 'Cancelled')
                                    <span style="background-color: #fee2e2; color: #dc2626; padding: 5px 10px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; border: 1px solid #fecaca;">
                                        ❌ Batal
                                    </span>
                                @else
                                    <span style="background-color: #e2e8f0; color: #475569; padding: 5px 10px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block;">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>

                            <!-- Kolom 6: Form Ubah Status & Nomor Resi (Modul 6 & Matriks QA No. 11) -->
                            <td style="padding: 14px 10px; vertical-align: top;">
                                <form action="/admin/transactions/{{ $item->id }}/status" method="POST" style="margin: 0;">
                                    @csrf
                                    <!-- Input Resi Cepat saat Dikirim -->
                                    <div style="margin-bottom: 6px;">
                                        <input type="text" name="tracking_number" value="{{ $item->tracking_number }}" placeholder="No. Resi pengiriman..." style="width: 100%; box-sizing: border-box; padding: 4px 8px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 11px;">
                                    </div>
                                    <div style="display: flex; gap: 4px; justify-content: center; flex-wrap: wrap;">
                                        <button type="submit" name="status" value="Paid" style="background-color: #0B5ED7; color: white; border: none; padding: 5px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; cursor: pointer;">
                                            Set Paid
                                        </button>
                                        <button type="submit" name="status" value="Shipped" style="background-color: #16a34a; color: white; border: none; padding: 5px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; cursor: pointer;">
                                            Set Shipped
                                        </button>
                                        <button type="submit" name="status" value="Pending" style="background-color: #64748b; color: white; border: none; padding: 5px 8px; border-radius: 4px; font-size: 11px; cursor: pointer;">
                                            Pending
                                        </button>
                                    </div>
                                </form>
                            </td>

                            <!-- Kolom 7: Hapus Pesanan Palsu / Batal (Modul 6) -->
                            <td style="padding: 14px 10px; vertical-align: top; text-align: center;">
                                <form action="{{ route('admin.transactions.delete', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan {{ $item->invoice_code }} ini secara permanen?');" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="background-color: #ffffff; border: 1px solid #fecaca; color: #dc2626; padding: 5px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; cursor: pointer; transition: background-color 0.15s ease;">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #64748b; font-weight: bold;">
                                📭 Tidak ada data pesanan untuk filter status "{{ $currFilter }}".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
