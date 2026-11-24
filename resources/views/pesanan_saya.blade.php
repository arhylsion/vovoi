@extends('layouts.master')

@section('title', 'Pesanan Saya - VOVOI Flagship Store')

@section('konten_utama')
<div style="max-width: 960px; margin: 0 auto;">

    <!-- Breadcrumb -->
    <nav style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748b; margin-bottom: 24px;">
      <a href="/" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Beranda</a>
      <span>&rsaquo;</span>
      <span style="color: #0f172a; font-weight: 700;">Pesanan Saya</span>
    </nav>

    <!-- 1. HEADER SECTION -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="font-size: 13px; font-weight: 700; color: #0B5ED7; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                PORTAL PELANGGAN
            </div>
            <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0;">
                Pesanan Saya
            </h1>
            <p style="font-size: 14px; color: #64748b; margin: 6px 0 0 0;">
                Pantau status pengiriman, resi kurir, dan riwayat belanja akun Anda.
            </p>
        </div>
        <div>
            <a href="/katalog" class="v-btn v-btn-primary" style="font-size: 13px; padding: 9px 18px;">
                Belanja Produk Baru &rarr;
            </a>
        </div>
    </div>

    <!-- 2. FLASH NOTIFICATION -->
    @if(session('success'))
        <div style="background-color: #ecfdf5; color: #065f46; padding: 14px 18px; border-radius: 10px; border: 1px solid #a7f3d0; margin-bottom: 24px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 18px;">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #fef2f2; color: #991b1b; padding: 14px 18px; border-radius: 10px; border: 1px solid #fecaca; margin-bottom: 24px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 18px;">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- 3. STATUS FILTER TABS -->
    @php
        $currentStatus = request('status', 'all');
    @endphp
    <div style="display: flex; gap: 8px; margin-bottom: 24px; overflow-x: auto; padding-bottom: 6px;">
        <a href="{{ route('orders.mine') }}" 
           style="text-decoration: none; padding: 8px 18px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; transition: all 0.15s ease; {{ $currentStatus === 'all' ? 'background-color: #0B5ED7; color: #ffffff;' : 'background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            Semua Pesanan
        </a>
        <a href="{{ route('orders.mine', ['status' => 'Pending']) }}" 
           style="text-decoration: none; padding: 8px 18px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; transition: all 0.15s ease; {{ $currentStatus === 'Pending' ? 'background-color: #f59e0b; color: #ffffff;' : 'background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            Menunggu Pembayaran (Pending)
        </a>
        <a href="{{ route('orders.mine', ['status' => 'Paid']) }}" 
           style="text-decoration: none; padding: 8px 18px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; transition: all 0.15s ease; {{ $currentStatus === 'Paid' ? 'background-color: #0B5ED7; color: #ffffff;' : 'background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            Diproses (Paid)
        </a>
        <a href="{{ route('orders.mine', ['status' => 'Shipped']) }}" 
           style="text-decoration: none; padding: 8px 18px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; transition: all 0.15s ease; {{ $currentStatus === 'Shipped' ? 'background-color: #10b981; color: #ffffff;' : 'background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            Dikirim (Shipped)
        </a>
        <a href="{{ route('orders.mine', ['status' => 'Cancelled']) }}" 
           style="text-decoration: none; padding: 8px 18px; border-radius: 20px; font-size: 13px; font-weight: 700; white-space: nowrap; transition: all 0.15s ease; {{ $currentStatus === 'Cancelled' ? 'background-color: #ef4444; color: #ffffff;' : 'background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            Dibatalkan
        </a>
    </div>

    <!-- 4. DAFTAR PESANAN PELANGGAN -->
    @if($transactions->isEmpty())
        <!-- EMPTY STATE (Sesuai Syarat Modul 5) -->
        <div style="background-color: #ffffff; border: 1px dashed #cbd5e1; border-radius: 16px; padding: 60px 24px; text-align: center; margin-top: 10px;">
            <div style="font-size: 48px; margin-bottom: 16px;">📦</div>
            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 8px 0;">
                Belum Ada Pesanan Ditemukan
            </h3>
            <p style="font-size: 14px; color: #64748b; max-width: 440px; margin: 0 auto 24px auto; line-height: 1.5;">
                @if($currentStatus !== 'all')
                    Tidak ada pesanan dengan status "{{ $currentStatus }}". Silakan pilih tab status lainnya atau jelajahi katalog.
                @else
                    Anda belum pernah melakukan pemesanan perangkat teknologi di VOVOI Official Store.
                @endif
            </p>
            <a href="/katalog" class="v-btn v-btn-primary">
                Mulai Belanja Sekarang &rarr;
            </a>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach($transactions as $t)
                <div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.02); transition: transform 0.15s ease, box-shadow 0.15s ease;">
                    
                    <!-- Card Top Header -->
                    <div style="background-color: #f8fafc; padding: 14px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                            <span style="font-family: monospace; font-size: 13px; font-weight: 800; color: #0f172a; background-color: #ffffff; padding: 4px 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                {{ $t->invoice_code }}
                            </span>
                            <span style="font-size: 13px; color: #64748b;">
                                {{ $t->created_at ? $t->created_at->format('d M Y, H:i') : '-' }} WIB
                            </span>
                        </div>

                        <!-- Badge Status -->
                        <div>
                            @if($t->status === 'Pending')
                                <span style="background-color: #fef9c3; color: #854d0e; border: 1px solid #fde047; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #eab308;"></span>
                                    Menunggu Pembayaran
                                </span>
                            @elseif($t->status === 'Paid')
                                <span style="background-color: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #3b82f6;"></span>
                                    Diproses Penjual
                                </span>
                            @elseif($t->status === 'Shipped')
                                <span style="background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #10b981;"></span>
                                    Dalam Pengiriman
                                </span>
                            @elseif($t->status === 'Cancelled')
                                <span style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #ef4444;"></span>
                                    Pesanan Dibatalkan
                                </span>
                            @else
                                <span style="background-color: #f1f5f9; color: #475569; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px;">
                                    {{ $t->status }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div style="padding: 20px;">
                        <div style="display: flex; gap: 20px; align-items: flex-start; flex-wrap: wrap;">
                            
                            <!-- Thumbnail / Product icon -->
                            <div style="width: 72px; height: 72px; border-radius: 10px; background-color: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0;">
                                @if(str_contains(strtolower($t->product_name), 'watch'))
                                    ⌚
                                @elseif(str_contains(strtolower($t->product_name), 'tab') || str_contains(strtolower($t->product_name), 'pad'))
                                    📱
                                @elseif(str_contains(strtolower($t->product_name), 'buds') || str_contains(strtolower($t->product_name), 'audio') || str_contains(strtolower($t->product_name), 'hub'))
                                    🎧
                                @else
                                    📱
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div style="flex: 1; min-width: 250px;">
                                <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0;">
                                    {{ $t->product_name }}
                                </h3>
                                <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
                                    Jumlah: <strong>{{ $t->quantity }} unit</strong> &bull; Ekspedisi: <strong>{{ $t->courier }}</strong>
                                </div>

                                <!-- Resi Pengiriman (Khusus Shipped) -->
                                @if($t->tracking_number)
                                    <div style="display: inline-flex; align-items: center; gap: 8px; background-color: #ecfdf5; border: 1px solid #a7f3d0; padding: 6px 12px; border-radius: 8px; margin-top: 4px;">
                                        <span style="font-size: 12px; color: #065f46; font-weight: 600;">Nomor Resi:</span>
                                        <span style="font-family: monospace; font-size: 13px; font-weight: 800; color: #047857; letter-spacing: 0.5px;">
                                            {{ $t->tracking_number }}
                                        </span>
                                    </div>
                                @elseif($t->status === 'Shipped')
                                    <div style="font-size: 12px; color: #64748b; font-style: italic;">
                                        Resi sedang diperbarui oleh kurir.
                                    </div>
                                @endif

                                @if($t->voucher_code)
                                    <div style="font-size: 12px; color: #059669; font-weight: 600; margin-top: 6px;">
                                        🎟️ Hemat voucher <strong>{{ $t->voucher_code }}</strong> (-Rp {{ number_format($t->discount_amount, 0, ',', '.') }})
                                    </div>
                                @endif
                            </div>

                            <!-- Price Column -->
                            <div style="text-align: right; min-width: 160px;">
                                <div style="font-size: 12px; color: #64748b; margin-bottom: 2px;">Total Pembayaran</div>
                                <div style="font-size: 18px; font-weight: 800; color: #0B5ED7;">
                                    Rp {{ number_format($t->total_amount, 0, ',', '.') }}
                                </div>
                                <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">
                                    Termasuk Ongkir Rp {{ number_format($t->shipping_cost, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Actions Footer -->
                    <div style="background-color: #f8fafc; padding: 12px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; align-items: center; gap: 12px; flex-wrap: wrap;">
                        
                        <!-- 1. Tombol Batalkan Pesanan (Khusus Status Pending - Fitur Inovasi P12) -->
                        @if($t->status === 'Pending')
                            <form action="{{ route('order.cancel', $t->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Stok produk akan dikembalikan.');" style="margin: 0;">
                                @csrf
                                <button type="submit" class="v-btn" style="background-color: #ffffff; color: #dc2626; border: 1px solid #fecaca; font-size: 13px; padding: 8px 14px;">
                                    Batalkan Pesanan
                                </button>
                            </form>
                        @endif

                        <!-- 2. Tombol Beri Ulasan Bintang (Khusus Status Shipped - Fitur Inovasi P12) -->
                        @if($t->status === 'Shipped')
                            @if($t->reviews()->where('user_id', Auth::id())->exists())
                                <span style="font-size: 12px; color: #059669; font-weight: 700; background-color: #ecfdf5; padding: 6px 12px; border-radius: 6px; border: 1px solid #a7f3d0;">
                                    ⭐ Ulasan Terkirim
                                </span>
                            @else
                                <a href="/berhasil/{{ $t->id }}" class="v-btn" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 13px; padding: 8px 14px;">
                                    ⭐ Beri Rating &amp; Ulasan
                                </a>
                            @endif
                        @endif

                        <!-- 3. Tombol Lihat E-Invoice -->
                        <a href="/berhasil/{{ $t->id }}" class="v-btn v-btn-secondary" style="font-size: 13px; padding: 8px 16px;">
                            📄 Lihat E-Invoice
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
