@extends('layouts.master')

@section('title', 'Katalog Produk Resmi - VOVOI Flagship Store')

@section('konten_utama')
<style>
    .catalog-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        color: #ffffff;
        padding: 32px 36px;
        border-radius: 16px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08);
        flex-wrap: wrap;
        gap: 20px;
    }
    .catalog-banner-tag {
        background-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        display: inline-block;
        margin-bottom: 8px;
    }
    .category-pills {
        display: flex;
        gap: 10px;
        margin-bottom: 24px;
        overflow-x: auto;
        padding-bottom: 6px;
    }
    .cat-pill {
        padding: 9px 18px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        white-space: nowrap;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .cat-pill:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }
    .cat-pill.active {
        background: #0B5ED7;
        color: #ffffff;
        border-color: #0B5ED7;
        box-shadow: 0 2px 8px rgba(11, 94, 215, 0.25);
    }
    .cat-pill.active .cat-count {
        background-color: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }
    .cat-count {
        font-size: 11px;
        background-color: #f1f5f9;
        color: #64748b;
        padding: 2px 7px;
        border-radius: 9999px;
        font-weight: 700;
    }
    .filter-bar {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 22px;
    }
    .product-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
        border-color: #cbd5e1;
    }
    .product-img-wrap {
        width: 100%;
        height: 200px;
        background-color: #f8fafc;
        overflow: hidden;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 16px;
        display: block;
        transition: transform 0.25s ease;
    }
    .product-card:hover .product-img {
        transform: scale(1.05);
    }
    .product-body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .product-cat-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        color: #0B5ED7;
        background-color: #eff6ff;
        padding: 3px 8px;
        border-radius: 6px;
        border: 1px solid #bfdbfe;
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 0.4px;
    }
    .product-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 6px 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 42px;
    }
    .product-price {
        font-size: 18px;
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
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-align: center;
        background-color: #eff6ff;
        color: #0B5ED7;
        border: 1px solid #bfdbfe;
        padding: 10px 14px;
        text-decoration: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        transition: all 0.15s ease;
    }
    .btn-detail:hover {
        background-color: #0B5ED7;
        color: #ffffff;
        border-color: #0B5ED7;
    }
    .btn-disabled {
        background-color: #f1f5f9 !important;
        color: #94a3b8 !important;
        border-color: #cbd5e1 !important;
        cursor: not-allowed !important;
    }
</style>

<!-- 1. BANNER HEADER KATALOG -->
<div class="catalog-banner">
    <div>
        <span class="catalog-banner-tag">
            VOVOI OFFICIAL STORE GUARANTEE
        </span>
        <h1 style="margin: 0 0 6px 0; font-size: 26px; font-weight: 800; letter-spacing: -0.02em;">
            Katalog Produk Pilihan
        </h1>
        <p style="margin: 0; font-size: 14px; color: #cbd5e1; max-width: 520px; line-height: 1.5;">
            Jaminan 100% perangkat original bergaransi resmi dengan dukungan jaringan servis seluruh Indonesia.
        </p>
    </div>
    <div style="text-align: right; background: rgba(255, 255, 255, 0.08); padding: 12px 20px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.12);">
        <span style="font-size: 12px; color: #94a3b8; display: block; font-weight: 600;">Total Koleksi Tersedia</span>
        <strong style="font-size: 26px; color: #ffffff;">{{ $totalProductCount ?? $products->count() }} Produk</strong>
    </div>
</div>

<!-- 2. FILTER KATEGORI PRODUK (FITUR INOVASI P12 & RELASI DATABASE) -->
<div class="category-pills">
    <a href="{{ route('catalog', array_merge(request()->except(['category', 'page']))) }}" 
       class="cat-pill {{ !request('category') ? 'active' : '' }}">
        <span>Semua Kategori</span>
        <span class="cat-count">{{ $totalProductCount ?? $products->count() }}</span>
    </a>
    @foreach($categories as $category)
        <a href="{{ route('catalog', array_merge(request()->except(['page']), ['category' => $category->slug])) }}" 
           class="cat-pill {{ request('category') == $category->slug ? 'active' : '' }}">
            <span>{{ $category->name }}</span>
            <span class="cat-count">{{ $category->products_count }}</span>
        </a>
    @endforeach
</div>

<!-- 3. BAR KONTROL FILTER & STATUS PENCARIAN -->
<div class="filter-bar">
    <div style="font-size: 13px; color: #475569; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        @if(request('search'))
            <span>Menampilkan hasil pencarian untuk <strong style="color: #0f172a;">"{{ request('search') }}"</strong> ({{ $products->count() }} produk)</span>
        @elseif(request('category'))
            @php
                $activeCat = $categories->firstWhere('slug', request('category'));
            @endphp
            <span>Kategori: <strong style="color: #0B5ED7;">{{ $activeCat ? $activeCat->name : request('category') }}</strong> ({{ $products->count() }} produk)</span>
        @else
            <span>Menampilkan <strong>{{ $products->count() }}</strong> produk aktif di etalase</span>
        @endif

        @if(request('search') || request('category') || request('sort'))
            <a href="/katalog" style="color: #dc2626; text-decoration: none; font-weight: 700; font-size: 12px; background: #fef2f2; padding: 4px 10px; border-radius: 6px; border: 1px solid #fecaca; display: inline-flex; align-items: center; gap: 4px;">
                <span>&times;</span> Reset Pencarian
            </a>
        @endif
    </div>

    <!-- Dropdown Pengurutan Harga & Waktu -->
    <form action="/katalog" method="GET" style="display: flex; align-items: center; gap: 8px; margin: 0;">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        <label style="font-size: 13px; font-weight: 600; color: #475569;">Urutkan:</label>
        <select name="sort" onchange="this.form.submit()" style="padding: 8px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 13px; font-weight: 600; color: #0f172a; background-color: #f8fafc; cursor: pointer; outline: none;">
            <option value="terbaru" {{ request('sort') == 'terbaru' || !request('sort') ? 'selected' : '' }}>Paling Baru Ditambahkan</option>
            <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga: Rendah ke Tinggi (Termurah)</option>
            <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga: Tinggi ke Rendah (Termahal)</option>
        </select>
    </form>
</div>

<!-- 4. GRID KARTU PRODUK MARKETPLACE -->
<div class="product-grid">
    @forelse($products as $product)
        <div class="product-card">
            <!-- Foto Produk & Badge Out of Stock -->
            <div class="product-img-wrap">
                @if($product->image)
                    <img src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                @else
                    <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 12px; font-weight: 600;">
                        Foto Belum Tersedia
                    </div>
                @endif

                <!-- Badge Stok Habis (Fitur Inovasi P12) -->
                @if($product->isOutOfStock())
                    <span style="position: absolute; top: 12px; left: 12px; background: #dc2626; color: #ffffff; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800; letter-spacing: 0.5px; box-shadow: 0 2px 6px rgba(220, 38, 38, 0.3);">
                        STOK HABIS
                    </span>
                @endif
            </div>

            <!-- Informasi & Harga -->
            <div class="product-body">
                <div>
                    <!-- Label Kategori Asli dari Relasi Tabel categories -->
                    @if($product->category)
                        <span class="product-cat-tag">
                            {{ $product->category->name }}
                        </span>
                    @else
                        <span class="product-cat-tag" style="background-color: #f1f5f9; color: #64748b; border-color: #cbd5e1;">
                            Elektronik
                        </span>
                    @endif

                    <h3 class="product-title" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h3>

                    <p class="product-price">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <!-- Meta: Rerata Rating Riil & Sisa Stok Asli -->
                    <div class="product-meta">
                        <span style="color: #f59e0b; font-weight: 700; display: inline-flex; align-items: center; gap: 3px;">
                            ⭐ {{ number_format($product->averageRating(), 1) }}
                        </span>
                        <span>&bull;</span>
                        @if($product->isOutOfStock())
                            <span style="color: #dc2626; font-weight: 700;">Stok Habis (0)</span>
                        @else
                            <span style="color: #16a34a; font-weight: 600;">Sisa Stok: <strong>{{ $product->stock }}</strong></span>
                        @endif
                    </div>
                </div>

                <!-- Tombol Aksi Beli / Detail -->
                @if($product->isOutOfStock())
                    <a href="/detail/{{ $product->id }}" class="btn-detail btn-disabled">
                        Lihat Detail (Stok Habis)
                    </a>
                @else
                    <a href="/detail/{{ $product->id }}" class="btn-detail">
                        Lihat Detail Produk
                    </a>
                @endif
            </div>
        </div>
    @empty
        <!-- TAMPILAN JIKA BARANG TIDAK DITEMUKAN (EMPTY STATE) -->
        <div style="grid-column: 1 / -1; background-color: #ffffff; border: 1px dashed #cbd5e1; border-radius: 16px; padding: 60px 24px; text-align: center;">
            <div style="font-size: 48px; margin-bottom: 14px;">🔍</div>
            <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 800; color: #0f172a;">
                Produk Tidak Ditemukan
            </h3>
            <p style="margin: 0 0 24px 0; font-size: 14px; color: #64748b; max-width: 440px; margin-left: auto; margin-right: auto; line-height: 1.5;">
                @if(request('search'))
                    Tidak ditemukan perangkat VOVOI yang cocok dengan kata kunci <strong>"{{ request('search') }}"</strong>.
                @elseif(request('category'))
                    Kategori ini sedang kosong atau seluruh produk telah habis terjual.
                @else
                    Mohon maaf, produk belum tersedia di etalase kami.
                @endif
            </p>
            <a href="/katalog" class="v-btn v-btn-primary">
                Tampilkan Semua Produk &rarr;
            </a>
        </div>
    @endforelse
</div>
@endsection
