@extends('layouts.master')

@section('title', $product->name . ' - VOVOI Flagship Store')

@section('konten_utama')
<style>
  .detail-layout {
    display: grid;
    grid-template-columns: 400px 1fr 320px;
    gap: 32px;
    align-items: start;
    margin-bottom: 48px;
  }
  @media (max-width: 1100px) {
    .detail-layout {
      grid-template-columns: 360px 1fr;
    }
    .detail-buy-box {
      grid-column: 1 / -1;
      max-width: 500px;
    }
  }
  @media (max-width: 768px) {
    .detail-layout {
      grid-template-columns: 1fr;
    }
    .detail-buy-box {
      max-width: 100%;
    }
  }
  .detail-cat-badge {
    display: inline-block;
    background: #eff6ff;
    color: #0B5ED7;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 10px;
    border: 1px solid #bfdbfe;
    letter-spacing: 0.5px;
  }
  .detail-img-box {
    width: 100%;
    height: 380px;
    background: #FFFFFF;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    padding: 24px;
    margin-bottom: 16px;
    position: relative;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.02);
  }
  .detail-buy-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    position: sticky;
    top: 96px;
  }
  .qty-btn {
    width: 34px;
    height: 34px;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;
  }
  .qty-btn:hover {
    background: #e2e8f0;
    border-color: #94a3b8;
  }
  .btn-buy-now {
    width: 100%;
    padding: 13px;
    font-size: 14px;
    border-radius: 8px;
    background-color: #0B5ED7;
    color: #ffffff;
    font-weight: 700;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: none;
    cursor: pointer;
    transition: background-color 0.15s ease;
  }
  .btn-buy-now:hover {
    background-color: #084298;
  }
  .btn-cart-secondary {
    width: 100%;
    padding: 13px;
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid #0B5ED7;
    background: #eff6ff;
    color: #0B5ED7;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .btn-cart-secondary:hover {
    background: #dbeafe;
  }
</style>

<section style="padding: 12px 0 64px;">
  <div>
    
    <!-- Flash Notification -->
    @if(session('error'))
      <div style="background-color: #fef2f2; color: #991b1b; padding: 14px 18px; border-radius: 8px; border: 1px solid #fecaca; margin-bottom: 24px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
        <span>⚠️</span> {{ session('error') }}
      </div>
    @endif

    @if(session('success'))
      <div style="background-color: #ecfdf5; color: #065f46; padding: 14px 18px; border-radius: 8px; border: 1px solid #a7f3d0; margin-bottom: 24px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
        <span>✅</span> {{ session('success') }}
      </div>
    @endif

    <!-- Breadcrumbs -->
    <nav style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748b; margin-bottom: 24px; flex-wrap: wrap;">
      <a href="/" style="color: #0B5ED7; text-decoration: none; font-weight: 600;">Beranda</a>
      <span>&rsaquo;</span>
      <a href="/katalog" style="color: #0B5ED7; text-decoration: none; font-weight: 600;">Katalog</a>
      @if($product->category)
        <span>&rsaquo;</span>
        <a href="/katalog?category={{ $product->category->slug }}" style="color: #0B5ED7; text-decoration: none; font-weight: 600;">{{ $product->category->name }}</a>
      @endif
      <span>&rsaquo;</span>
      <span style="color: #0f172a; font-weight: 700;">{{ $product->name }}</span>
    </nav>

    <!-- Product Main Grid (Gallery, Info, Sticky Buy Box) -->
    <div class="detail-layout">
      
      <!-- 1. Left Gallery Column -->
      <div>
        <div class="detail-img-box">
          @if($product->image)
            <img id="mainProductImg" src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
          @else
            <img id="mainProductImg" src="{{ asset('assets/images/phone-x-pro.svg') }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
          @endif

          @if($product->isOutOfStock())
            <span style="position: absolute; top: 16px; left: 16px; background: #dc2626; color: #ffffff; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 800; letter-spacing: 0.5px; box-shadow: 0 2px 6px rgba(220, 38, 38, 0.3);">
              STOK HABIS
            </span>
          @endif
        </div>

        <!-- Thumbnails -->
        <div style="display: flex; gap: 10px; justify-content: flex-start;">
          <div style="width: 60px; height: 60px; border-radius: 8px; border: 2px solid #0B5ED7; background: #FFFFFF; padding: 4px; display: flex; align-items: center; justify-content: center;">
            <img src="{{ $product->image ? asset('assets/images/' . $product->image) : asset('assets/images/phone-x-pro.svg') }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
          </div>
        </div>
      </div>

      <!-- 2. Center Product Details Column -->
      <div>
        @if($product->category)
          <span class="detail-cat-badge">
            {{ $product->category->name }}
          </span>
        @endif

        <h1 style="font-size: 28px; font-weight: 800; letter-spacing: -0.02em; margin: 0 0 10px 0; color: #0f172a; line-height: 1.3;">
          {{ $product->name }}
        </h1>

        <!-- Rating & Sales -->
        <div style="display: flex; align-items: center; gap: 12px; font-size: 13px; color: #475569; margin-bottom: 18px; flex-wrap: wrap;">
          <span style="display: flex; align-items: center; gap: 4px; color: #0f172a; font-weight: 700;">
            <span style="color: #f59e0b; font-size: 15px;">⭐</span>
            {{ number_format($product->averageRating(), 1) }}
            <span style="color: #64748b; font-weight: 500;">({{ $product->reviews->count() }} Ulasan Pembeli)</span>
          </span>
          <span>&bull;</span>
          <span style="color: #059669; font-weight: 600;">100% Produk Original VOVOI</span>
        </div>

        <!-- Price -->
        <div id="productPriceDisplay" style="font-size: 28px; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 20px; color: #0f172a;">
          Rp {{ number_format($product->price, 0, ',', '.') }}
        </div>

        <hr style="border: none; border-top: 1px solid #e2e8f0; margin-bottom: 20px;">

        <!-- Availability / Stock Status (P12 REQUIREMENT) -->
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
          <div style="font-size: 13px; font-weight: 700; color: #334155;">Status Ketersediaan:</div>
          <div>
            @if($product->isOutOfStock())
              <span style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #ef4444;"></span>
                Stok Habis (0 Unit)
              </span>
            @else
              <span style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #10b981;"></span>
                Stok Tersedia (Sisa {{ $product->stock }} unit)
              </span>
            @endif
          </div>
        </div>

        <!-- Description -->
        <div style="margin-bottom: 28px;">
          <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin: 0 0 10px 0;">Deskripsi &amp; Spesifikasi Produk</h3>
          <p style="font-size: 14px; line-height: 1.7; color: #475569; margin: 0;">
            {{ $product->description }}
          </p>
        </div>

        <!-- Keunggulan Toko -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 20px;">🛡️</span>
            <div>
              <strong style="font-size: 12px; color: #0f172a; display: block;">Garansi Resmi 1 Tahun</strong>
              <span style="font-size: 11px; color: #64748b;">Ganti unit baru &amp; servis resmi</span>
            </div>
          </div>
          <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 20px;">🚚</span>
            <div>
              <strong style="font-size: 12px; color: #0f172a; display: block;">Pengiriman Berasuransi</strong>
              <span style="font-size: 11px; color: #64748b;">JNE, J&amp;T, &amp; SiCepat BEST</span>
            </div>
          </div>
        </div>

      </div>

      <!-- 3. Right Sticky Action / Buy Box -->
      <aside class="detail-buy-box">
        <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0 0 16px 0;">
          Ringkasan Pembelian
        </h3>

        <!-- Counter Pengaturan Kuantitas -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
          <span style="font-size: 13px; font-weight: 600; color: #475569;">Atur Jumlah:</span>
          <div style="display: flex; align-items: center; gap: 10px;">
            <button type="button" class="qty-btn" onclick="adjustQty(-1)" {{ $product->isOutOfStock() ? 'disabled' : '' }}>-</button>
            <span id="buyQty" style="font-size: 15px; font-weight: 800; min-width: 28px; text-align: center; color: #0f172a;">1</span>
            <button type="button" class="qty-btn" onclick="adjustQty(1)" {{ $product->isOutOfStock() ? 'disabled' : '' }}>+</button>
          </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 22px; padding-top: 14px; border-top: 1px dashed #e2e8f0;">
          <span style="font-size: 13px; color: #64748b;">Subtotal:</span>
          <strong id="subtotalDisplay" style="font-size: 20px; color: #0B5ED7; font-weight: 800;">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </strong>
        </div>

        @if(!$product->isOutOfStock())
          <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
            <!-- Tombol Tambah ke Keranjang Belanja (Fitur Inovasi P12) -->
            <form action="{{ route('cart.add') }}" method="POST" style="margin: 0;">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <input type="hidden" name="quantity" id="cartFormQty" value="1">
              <button type="submit" class="btn-cart-secondary">
                🛒 + Keranjang Belanja
              </button>
            </form>

            <!-- Tombol Beli Langsung ke Checkout (Modul 4 & 5) -->
            <a href="/checkout/{{ $product->id }}" class="btn-buy-now">
              ⚡ Beli Langsung
            </a>
            
            <a href="/keranjang?add={{ $product->id }}" style="display: none;">keranjang-add</a>
          </div>
        @else
          <!-- Tombol Disabled Saat Stok 0 (Fitur Inovasi P12) -->
          <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
            <button type="button" disabled style="width: 100%; padding: 13px; font-size: 14px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f1f5f9; color: #94a3b8; font-weight: 700; cursor: not-allowed;">
              + Keranjang (Nonaktif)
            </button>
            <button type="button" disabled style="width: 100%; padding: 13px; font-size: 14px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f1f5f9; color: #94a3b8; font-weight: 700; cursor: not-allowed;">
              Beli Langsung (Stok Habis)
            </button>
          </div>
        @endif

        <div style="border-top: 1px solid #e2e8f0; padding-top: 14px; font-size: 12px; color: #64748b; line-height: 1.6;">
          🛡️ <strong>Jaminan VOVOI:</strong> Pengiriman berasuransi, serial tag otentik, dan garansi resmi pabrik.
        </div>
      </aside>

    </div>

    <!-- 4. SECTION ULASAN & RATING PEMBELI (FITUR INOVASI P12) -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 32px; margin-bottom: 48px; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);">
      <div style="display: flex; justify-content: space-between; align-items: baseline; border-bottom: 1px solid #f1f5f9; padding-bottom: 18px; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
          <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">
            ⭐ Ulasan dan Penilaian Pembeli
          </h2>
          <p style="font-size: 13px; color: #64748b; margin: 0;">
            Ulasan nyata dari pembeli yang pesanan produknya telah berstatus dikirim (Shipped).
          </p>
        </div>
        <div style="text-align: right;">
          <span style="font-size: 28px; font-weight: 800; color: #0f172a;">{{ number_format($product->averageRating(), 1) }}</span>
          <span style="font-size: 14px; color: #f59e0b;">/ 5.0</span>
          <div style="font-size: 12px; color: #64748b;">{{ $product->reviews->count() }} Total Ulasan</div>
        </div>
      </div>

      @if($product->reviews->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 16px;">
          @foreach($product->reviews as $rev)
            <div style="padding: 18px 20px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-wrap: wrap; gap: 8px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                  <div style="width: 34px; height: 34px; border-radius: 50%; background: #0B5ED7; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px;">
                    {{ strtoupper(substr($rev->customer_name, 0, 1)) }}
                  </div>
                  <div>
                    <strong style="font-size: 14px; color: #0f172a;">{{ $rev->customer_name }}</strong>
                    <span style="font-size: 11px; color: #059669; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 2px 8px; border-radius: 4px; font-weight: 600; margin-left: 6px;">Pembeli Terverifikasi</span>
                  </div>
                </div>
                <div style="color: #f59e0b; font-size: 15px; letter-spacing: 2px;">
                  @for($i = 1; $i <= 5; $i++)
                    {{ $i <= $rev->rating ? '★' : '☆' }}
                  @endfor
                </div>
              </div>
              <p style="font-size: 14px; color: #334155; margin: 0; line-height: 1.6;">
                "{{ $rev->comment }}"
              </p>
              <div style="font-size: 11px; color: #94a3b8; margin-top: 8px;">
                Diverifikasi via Invoice #{{ $rev->transaction?->invoice_code }} &bull; {{ $rev->created_at ? $rev->created_at->format('d M Y') : 'Terbaru' }}
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div style="text-align: center; padding: 40px; color: #64748b; background: #f8fafc; border-radius: 10px; border: 1px dashed #cbd5e1;">
          <div style="font-size: 32px; margin-bottom: 8px;">💬</div>
          <p style="margin: 0; font-size: 14px;">
            Belum ada ulasan untuk produk ini. Pembeli dengan status pesanan <strong>Shipped</strong> dapat memberikan penilaian di halaman E-Invoice!
          </p>
        </div>
      @endif
    </div>

  </div>
</section>
@endsection

@section('extra_js')
<script>
  const basePrice = {{ $product->price }};
  const maxStock = {{ $product->stock }};
  let currentQty = 1;

  function adjustQty(delta) {
    if (maxStock <= 0) return;
    currentQty = Math.max(1, Math.min(maxStock, currentQty + delta));
    document.getElementById('buyQty').innerText = currentQty;
    document.getElementById('cartFormQty').value = currentQty;
    
    const subtotal = basePrice * currentQty;
    document.getElementById('subtotalDisplay').innerText = 'Rp ' + Number(subtotal).toLocaleString('id-ID');
  }
</script>
@endsection
