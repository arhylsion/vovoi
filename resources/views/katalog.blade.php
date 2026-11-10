@extends('layouts.master')

@section('title', 'VOVOI - Beyond Ordinary Catalog')

@section('konten_utama')
<style>
    .catalog-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        color: #ffffff;
        padding: 28px 36px;
        border-radius: 14px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.08);
    }
    .filter-bar {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 14px 20px;
        border-radius: 10px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }
    .product-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.06);
        border-color: #cbd5e1;
    }
    .product-img-wrap {
        width: 100%;
        height: 190px;
        background-color: #f1f5f9;
        overflow: hidden;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 12px;
        display: block;
        transition: transform 0.2s ease;
    }
    .product-card:hover .product-img {
        transform: scale(1.04);
    }
    .product-body {
        padding: 14px 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .product-title {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        margin: 0 0 8px 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-price {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 10px 0;
    }
    .product-meta {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-detail {
        display: block;
        text-align: center;
        background-color: #eff6ff;
        color: #0B5ED7;
        border: 1px solid #bfdbfe;
        padding: 9px 12px;
        text-decoration: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        transition: all 0.15s ease;
    }
    .btn-detail:hover {
        background-color: #0B5ED7;
        color: #ffffff;
    }
</style>

<!-- 1. BANNER HEADER KATALOG -->
<div class="catalog-banner">
    <div>
        <span style="background-color: rgba(255, 255, 255, 0.15); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px;">
            VOVOI OFFICIAL STORE GUARANTEE
        </span>
        <h1 style="margin: 8px 0 4px 0; font-size: 24px; font-weight: 800;">Katalog Produk Pilihan</h1>
        <p style="margin: 0; font-size: 14px; color: #cbd5e1;">
            Jaminan produk original dengan pengiriman cepat ke seluruh Indonesia.
        </p>
    </div>
    <div style="text-align: right;">
        <span style="font-size: 12px; color: #94a3b8; display: block;">Total Koleksi Tersedia</span>
        <strong style="font-size: 28px; color: #ffffff;">{{ $products->count() }} Produk</strong>
    </div>
</div>

<!-- 2. BAR KONTROL FILTER & STATUS PENCARIAN -->
<div class="filter-bar">
    <div style="font-size: 14px; color: #475569;">
        @if(request('search'))
            Menampilkan hasil pencarian untuk <strong style="color: #0f172a;">"{{ request('search') }}"</strong> 
            ({{ $products->count() }} barang ditemukan)
            <a href="/" style="color: #dc2626; text-decoration: none; font-weight: 600; font-size: 13px; margin-left: 10px; background: #fef2f2; padding: 4px 10px; border-radius: 6px; border: 1px solid #fecaca;">
                Reset Pencarian &times;
            </a>
        @else
            Menampilkan seluruh koleksi produk siap kirim
        @endif
    </div>

    <!-- Dropdown Pengurutan Harga Otomatis Submit -->
    <form action="/" method="GET" style="display: flex; align-items: center; gap: 10px; margin: 0;">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        <label style="font-size: 13px; font-weight: 600; color: #475569;">Urutkan:</label>
        <select name="sort" onchange="this.form.submit()" style="padding: 8px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 13px; font-weight: 600; color: #0f172a; background-color: #f8fafc; cursor: pointer; outline: none;">
            <option value="terbaru" {{ request('sort') == 'terbaru' || !request('sort') ? 'selected' : '' }}>Paling Baru Ditambahkan</option>
            <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga: Rendah ke Tinggi (Termurah)</option>
            <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga: Tinggi ke Rendah (Termahal)</option>
        </select>
    </form>
</div>

<!-- 3. GRID KARTU PRODUK MARKETPLACE -->
<div class="product-grid">
    @forelse($products as $product)
        <div class="product-card">
            <!-- Foto Produk -->
            <div class="product-img-wrap">
                @if($product->image)
                    <img src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                @else
                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 12px; font-weight: 600;">
                        Foto Belum Tersedia
                    </div>
                @endif
            </div>

            <!-- Informasi & Harga -->
            <div class="product-body">
                <div>
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <div class="product-meta">
                        <span style="color: #f59e0b; font-weight: 700;">&#9733; 5.0</span>
                        <span>&bull;</span>
                        <span style="color: #16a34a; font-weight: 600;">Stok Tersedia</span>
                    </div>
                </div>
                <a href="/detail/{{ $product->id }}" class="btn-detail">
                    Lihat Detail Produk
                </a>
            </div>
        </div>
    @empty
        <!-- TAMPILAN JIKA BARANG YANG DICARI TIDAK DITEMUKAN -->
        <div style="grid-column: 1 / -1; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 60px 20px; text-align: center;">
            <h3 style="margin: 0 0 8px 0; font-size: 18px; color: #0f172a;">Produk Tidak Ditemukan</h3>
            <p style="margin: 0 0 20px 0; font-size: 14px; color: #64748b;">
                @if(request('search'))
                    Maaf, kami tidak menemukan barang yang cocok dengan kata kunci <strong>"{{ request('search') }}"</strong>.
                @else
                    Mohon maaf, produk belum tersedia di etalase kami.
                @endif
            </p>
            <a href="/" style="display: inline-block; background-color: #0B5ED7; color: #ffffff; text-decoration: none; padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600;">
                Tampilkan Semua Produk
            </a>
        </div>
    @endforelse
</div>
@endsection
