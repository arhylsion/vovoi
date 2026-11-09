@extends('layouts.admin')

@section('konten_admin')
    <!-- 1. KOTAK NOTIFIKASI FLASH SESSION (Muncul setelah Admin menekan tombol ubah status) -->
    @if(session('success'))
        <div style="background-color: #d1e7dd; color: #0f5132; padding: 15px 20px; border-radius: 8px; border: 1px solid #badbcc; margin-bottom: 25px; font-weight: bold;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- 2. DERETAN KARTU RINGKASAN STATISTIK BISNIS -->
    <div style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div style="flex: 1; background-color: white; padding: 20px 25px; border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid #0B5ED7;">
            <span style="font-size: 12px; color: #64748b; font-weight: bold;">TOTAL PRODUK DI ETALASE</span>
            <h2 style="margin: 8px 0 0 0; font-size: 28px; color: #0f172a;">{{ $totalProducts }} Produk</h2>
        </div>
        <div style="flex: 1; background-color: white; padding: 20px 25px; border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid #FFC107;">
            <span style="font-size: 12px; color: #64748b; font-weight: bold;">TOTAL PESANAN MASUK</span>
            <h2 style="margin: 8px 0 0 0; font-size: 28px; color: #0f172a;">{{ $totalTransactions }} Transaksi</h2>
        </div>
        <div style="flex: 1; background-color: white; padding: 20px 25px; border-radius: 8px; border: 1px solid #cbd5e1; border-left: 6px solid #28A745;">
            <span style="font-size: 12px; color: #64748b; font-weight: bold;">TOTAL OMZET PENJUALAN</span>
            <h2 style="margin: 8px 0 0 0; font-size: 28px; color: #28A745;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        </div>
    </div>

    <!-- 3. TABEL MANAJEMEN PESANAN MASUK -->
    <div style="background-color: white; padding: 25px; border-radius: 8px; border: 1px solid #cbd5e1;">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
            📋 Daftar Pesanan Pembeli (Diurutkan dari yang Terbaru)
        </h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
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
                        </td>

                        <!-- Kolom 4: Total Pembayaran -->
                        <td style="padding: 14px 12px; vertical-align: top; font-weight: bold; color: #E63946; font-size: 15px;">
                            Rp {{ number_format($item->total_amount, 0, ',', '.') }}
                        </td>

                        <!-- Kolom 5: Indikator Warna Status (Badge Dinamis) -->
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
@endsection

