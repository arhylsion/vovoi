@extends('layouts.admin')

@section('konten_admin')
    <!-- 1. KOTAK NOTIFIKASI FLASH SESSION -->
    @if(session('success'))
        <div style="background-color: #d1e7dd; color: #0f5132; padding: 15px 20px; border-radius: 8px; border: 1px solid #badbcc; margin-bottom: 25px; font-weight: bold;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- 2. DERETAN KARTU RINGKASAN STATISTIK BISNIS -->
    <div style="display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 220px; background-color: white; padding: 20px 25px; border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid #0B5ED7;">
            <span style="font-size: 12px; color: #64748b; font-weight: bold;">TOTAL PRODUK DI ETALASE</span>
            <h2 style="margin: 8px 0 0 0; font-size: 28px; color: #0f172a;">{{ $totalProducts }} Produk</h2>
        </div>
        <div style="flex: 1; min-width: 220px; background-color: white; padding: 20px 25px; border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid #FFC107;">
            <span style="font-size: 12px; color: #64748b; font-weight: bold;">TOTAL PESANAN MASUK</span>
            <h2 style="margin: 8px 0 0 0; font-size: 28px; color: #0f172a;">{{ $totalTransactions }} Transaksi</h2>
        </div>
        <div style="flex: 1; min-width: 220px; background-color: white; padding: 20px 25px; border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid #28A745;">
            <span style="font-size: 12px; color: #64748b; font-weight: bold;">TOTAL OMZET PENJUALAN</span>
            <h2 style="margin: 8px 0 0 0; font-size: 28px; color: #28A745;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            <div style="font-size: 11px; color: #16a34a; font-weight: 600; margin-top: 4px;">*Pesanan Pending tidak terhitung</div>
        </div>
    </div>

    <!-- 3. BAR AKSI EKSPOR LAPORAN PENJUALAN (FITUR INOVASI P12) -->
    <div style="background-color: white; padding: 18px 24px; border-radius: 8px; border: 1px solid #cbd5e1; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div>
            <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a;">📊 Ekspor Rekap Data Penjualan</h4>
            <p style="margin: 2px 0 0 0; font-size: 13px; color: #64748b;">
                Unduh rekap transaksi untuk keperluan akuntansi, audit, dan arsip cetak.
            </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('admin.transactions.export.csv') }}" style="background-color: #f8fafc; color: #0f172a; border: 1px solid #cbd5e1; padding: 9px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <span>📄</span> Ekspor CSV
            </a>
            <a href="{{ route('admin.transactions.export.excel') }}" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 9px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <span>📗</span> Ekspor Excel (.xlsx/.csv)
            </a>
            <a href="{{ route('admin.transactions.export.pdf') }}" target="_blank" style="background-color: #0f172a; color: #ffffff; padding: 9px 18px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <span>🖨️</span> Ekspor PDF / Cetak Laporan
            </a>
        </div>
    </div>

    <!-- 4. TABEL MANAJEMEN PESANAN MASUK -->
    <div style="background-color: white; padding: 25px; border-radius: 8px; border: 1px solid #cbd5e1;">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
            📋 Daftar Pesanan Pembeli (Diurutkan dari yang Terbaru)
        </h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px; min-width: 900px;">
                <thead>
                    <tr style="background-color: #f8fafc; color: #334155; text-align: left; border-bottom: 2px solid #cbd5e1;">
                        <th style="padding: 12px;">No. Invoice & Waktu</th>
                        <th style="padding: 12px;">Identitas & Alamat Pembeli</th>
                        <th style="padding: 12px;">Rincian Barang & Kurir</th>
                        <th style="padding: 12px;">Total Bayar</th>
                        <th style="padding: 12px; text-align: center;">Status Pesanan</th>
                        <th style="padding: 12px; text-align: center;">Aksi Ubah Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $item)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <!-- Kolom 1: Kode Invoice & Tautan Cek Nota Pembeli -->
                            <td style="padding: 14px 12px; vertical-align: top;">
                                <strong style="color: #0B5ED7; font-size: 15px;">{{ $item->invoice_code }}</strong>
                                <div style="font-size: 12px; color: #64748b; margin: 4px 0 8px 0;">
                                    {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }} WIB
                                </div>
                                <a href="/berhasil/{{ $item->id }}" target="_blank" style="font-size: 12px; color: #0B5ED7; text-decoration: none; font-weight: bold; background-color: #eff6ff; padding: 4px 8px; border-radius: 4px; border: 1px solid #bfdbfe;">
                                    Lihat Nota Pembeli &nearr;
                                </a>
                            </td>

                            <!-- Kolom 2: Data Penerima -->
                            <td style="padding: 14px 12px; vertical-align: top;">
                                <strong style="color: #0f172a;">{{ $item->customer_name }}</strong>
                                <div style="font-size: 12px; color: #0f5132; font-weight: bold; margin: 4px 0;">
                                    📞 {{ $item->customer_phone }}
                                </div>
                                <div style="font-size: 12px; color: #475569; max-width: 240px; line-height: 1.4;">
                                    📍 {{ $item->customer_address }}
                                </div>
                            </td>

                            <!-- Kolom 3: Produk, Qty, & Kurir -->
                            <td style="padding: 14px 12px; vertical-align: top;">
                                <strong style="color: #0f172a;">{{ $item->product_name }}</strong>
                                <div style="font-size: 12px; color: #475569; margin-top: 4px;">
                                    Jumlah Beli: <strong>{{ $item->quantity }}x</strong>
                                </div>
                                <div style="font-size: 12px; color: #0B5ED7; margin-top: 2px; font-weight: bold;">
                                    🚚 {{ $item->courier }} (Ongkir Rp {{ number_format($item->shipping_cost, 0, ',', '.') }})
                                </div>
                                @if($item->voucher_code)
                                    <div style="font-size: 11px; color: #059669; font-weight: 600; margin-top: 2px;">
                                        🏷️ Kupon: {{ $item->voucher_code }} (-Rp {{ number_format($item->discount_amount, 0, ',', '.') }})
                                    </div>
                                @endif
                            </td>

                            <!-- Kolom 4: Total Pembayaran -->
                            <td style="padding: 14px 12px; vertical-align: top; font-weight: bold; color: #E63946; font-size: 15px;">
                                Rp {{ number_format($item->total_amount, 0, ',', '.') }}
                            </td>

                            <!-- Kolom 5: Indikator Warna Status -->
                            <td style="padding: 14px 12px; vertical-align: top; text-align: center;">
                                @if($item->status == 'Pending')
                                    <span style="background-color: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; border: 1px solid #ffeeba;">
                                        ⏳ Pending
                                    </span>
                                @elseif($item->status == 'Paid')
                                    <span style="background-color: #cfe2ff; color: #084298; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; border: 1px solid #b6d4fe;">
                                        💳 Paid (Lunas)
                                    </span>
                                @elseif($item->status == 'Shipped')
                                    <span style="background-color: #d1e7dd; color: #0f5132; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; border: 1px solid #badbcc;">
                                        🚚 Shipped (Dikirim)
                                    </span>
                                @elseif($item->status == 'Cancelled')
                                    <span style="background-color: #fee2e2; color: #dc2626; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block; border: 1px solid #fecaca;">
                                        ❌ Cancelled (Batal)
                                    </span>
                                @else
                                    <span style="background-color: #e2e8f0; color: #475569; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 12px; display: inline-block;">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>

                            <!-- Kolom 6: Formulir Tombol Aksi Update Status -->
                            <td style="padding: 14px 12px; vertical-align: top; text-align: center;">
                                <form action="/admin/transactions/{{ $item->id }}/status" method="POST" style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                                    @csrf
                                    <button type="submit" name="status" value="Paid" style="background-color: #0B5ED7; color: white; border: none; padding: 7px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">
                                        Set Lunas
                                    </button>
                                    <button type="submit" name="status" value="Shipped" style="background-color: #28A745; color: white; border: none; padding: 7px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">
                                        Set Dikirim
                                    </button>
                                    <button type="submit" name="status" value="Pending" style="background-color: #6c757d; color: white; border: none; padding: 7px 10px; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                        Reset
                                    </button>
                                    @if($item->status === 'Pending')
                                        <button type="submit" name="status" value="Cancelled" onclick="return confirm('Batalkan pesanan ini dan kembalikan stok?')" style="background-color: #dc2626; color: white; border: none; padding: 7px 10px; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                            Batal
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #64748b; font-weight: bold;">
                                Belum ada data pesanan yang masuk. Silakan lakukan simulasi Checkout di halaman toko terlebih dahulu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
