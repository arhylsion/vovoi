@extends('layouts.master')

@section('title', $product->name . ' - VOVOI')

@section('konten_utama')
<section style="padding: 24px 0 64px;">
  <div>
    
    <!-- Flash Notification -->
    @if(session('error'))
      <div style="background-color: #fef2f2; color: #991b1b; padding: 14px 18px; border-radius: 8px; border: 1px solid #fecaca; margin-bottom: 24px; font-size: 14px; font-weight: 600;">
        ⚠️ {{ session('error') }}
      </div>
    @endif

    <!-- Breadcrumbs -->
    <nav style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-muted); margin-bottom: 28px;">
      <a href="/" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Beranda</a>
      <span>&rsaquo;</span>
      <a href="/katalog" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Katalog</a>
      @if($product->category)
        <span>&rsaquo;</span>
        <a href="/katalog?category={{ $product->category->slug }}" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">{{ $product->category->name }}</a>
      @endif
      <span>&rsaquo;</span>
      <span style="color: var(--text-primary); font-weight: 700;">{{ $product->name }}</span>
    </nav>

    <!-- Product Main Grid (Gallery, Info, Sticky Buy Box) -->
    <div style="display: grid; grid-template-columns: 420px 1fr 310px; gap: 36px; align-items: start; margin-bottom: 56px;">
      
      <!-- 1. Left Gallery Column -->
      <div>
        <div style="width: 100%; height: 380px; background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-light); display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 24px; margin-bottom: 16px; position: relative;">
          @if($product->image)
            <img id="mainProductImg" src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
          @else
            <img id="mainProductImg" src="{{ asset('assets/images/phone-x-pro.svg') }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
          @endif

          @if($product->isOutOfStock())
            <span style="position: absolute; top: 16px; left: 16px; background: #dc2626; color: #ffffff; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 800; letter-spacing: 0.5px;">
              STOK HABIS
            </span>
          @endif
        </div>

        <!-- Thumbnails -->
        <div style="display: flex; gap: 10px; justify-content: flex-start;">
          <button type="button" class="v-thumb-btn" style="width: 58px; height: 58px; border-radius: 6px; border: 2px solid #0f172a; background: #FFFFFF; padding: 4px; cursor: pointer;">
            <img src="{{ $product->image ? asset('assets/images/' . $product->image) : asset('assets/images/phone-x-pro.svg') }}" alt="Angle 1" style="width: 100%; height: 100%; object-fit: contain;">
          </button>
        </div>
      </div>

      <!-- 2. Center Product Details Column -->
      <div>
        @if($product->category)
          <div style="display: inline-block; background: #eff6ff; color: #0B5ED7; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; border: 1px solid #bfdbfe;">
            {{ $product->category->name }}
          </div>
        @endif

        <h1 style="font-size: 30px; font-weight: 800; letter-spacing: -0.03em; margin: 0 0 10px 0; color: #0f172a;">
          {{ $product->name }}
        </h1>

        <!-- Rating & Sales -->
        <div style="display: flex; align-items: center; gap: 12px; font-size: 14px; color: var(--text-secondary); margin-bottom: 18px;">
          <span style="display: flex; align-items: center; gap: 4px; color: #0f172a; font-weight: 700;">
            <span style="color: #f59e0b; font-size: 16px;">★</span>
            {{ number_format($product->averageRating(), 1) }}
            <span style="color: #64748b; font-weight: 400;">({{ $product->reviews->count() }} Ulasan Pembeli)</span>
          </span>
          <span>&bull;</span>
          <span style="color: #64748b;">Terjual 100+ Unit</span>
        </div>

        <!-- Price -->
        <div id="productPriceDisplay" style="font-size: 28px; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 20px; color: #0f172a;">
          Rp {{ number_format($product->price, 0, ',', '.') }}
        </div>

        <hr style="border: none; border-top: 1px solid var(--border-light); margin-bottom: 20px;">

        <!-- Availability / Stock Status (P12 REQUIREMENT) -->
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
          <span style="font-size: 14px; font-weight: 600; color: var(--text-primary);">Ketersediaan Stok:</span>
          @if($product->isOutOfStock())
            <span style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
              <span style="width: 8px; height: 8px; border-radius: 50%; background: #dc2626;"></span>
              Stok Habis (0 Unit)
            </span>
          @elseif($product->stock <= 5)
            <span style="background: #fef3c7; color: #d97706; border: 1px solid #fde68a; padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
              <span style="width: 8px; height: 8px; border-radius: 50%; background: #d97706;"></span>
              Stok Terbatas (Sisa {{ $product->stock }} Unit)
            </span>
          @else
            <span class="v-tag-mono green">
              <span class="v-dot-indicator green"></span>
              Stok Tersedia ({{ $product->stock }} Unit Siap Kirim)
            </span>
          @endif
        </div>

        <!-- Detail Deskripsi -->
        <div style="background: #ffffff; border: 1px solid var(--border-light); border-radius: 12px; padding: 24px; margin-bottom: 24px;">
          <h3 style="margin-top: 0; margin-bottom: 12px; font-size: 16px; font-weight: 700; color: #0f172a;">
            Deskripsi &amp; Spesifikasi Produk
          </h3>
          <p style="font-size: 14px; line-height: 1.7; color: #475569; margin: 0 0 16px 0; white-space: pre-line;">
            {{ $product->description }}
          </p>

          <ul style="padding-left: 20px; font-size: 13px; line-height: 1.8; color: #64748b; margin: 0;">
            <li>Kode Seri: VOVOI-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</li>
            <li>Garansi Resmi 2 Tahun VOVOI Care Indonesia (Active)</li>
            <li>100% Produk Original & Tersegel Pabrik</li>
            <li>Bebas Pengembalian jika cacat fisik dalam 7 hari</li>
          </ul>
        </div>

      </div>

      <!-- 3. Right Sticky Buy Box Card -->
      <aside style="background: #FFFFFF; border: 1px solid var(--border-light); border-radius: 12px; padding: 24px; position: sticky; top: 96px; box-shadow: 0 4px 16px rgba(0,0,0,0.04);">
        <h2 style="font-size: 14px; font-weight: 700; margin-top: 0; margin-bottom: 16px; color: #0f172a;">
          Atur Jumlah Pesanan
        </h2>

        <!-- Quantity Counter (only if in stock) -->
        @if(!$product->isOutOfStock())
          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border: 1px solid var(--border-light); border-radius: 8px; padding: 6px 14px; background: #f8fafc;">
            <button type="button" onclick="adjustQty(-1)" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #475569; width: 28px; height: 28px;">&minus;</button>
            <span id="buyQty" style="font-size: 15px; font-weight: 700;">1</span>
            <button type="button" onclick="adjustQty(1)" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #475569; width: 28px; height: 28px;">&#43;</button>
          </div>

          <!-- Subtotal -->
          <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 20px;">
            <span style="font-size: 13px; color: #64748b;">Subtotal:</span>
            <span id="subtotalDisplay" style="font-size: 20px; font-weight: 800; color: #0f172a;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
          </div>

          <!-- Buttons Active -->
          <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
            <a href="/keranjang?add={{ $product->id }}" class="v-btn v-btn-primary" style="width: 100%; padding: 13px; font-size: 14px; border-radius: 8px; text-decoration: none; text-align: center;">
              + Masukkan Keranjang
            </a>

            <a id="buyDirectBtn" href="/checkout/{{ $product->id }}" class="v-btn v-btn-secondary" style="width: 100%; padding: 13px; font-size: 14px; border-radius: 8px; text-decoration: none; text-align: center; background: #f8fafc; border: 1px solid #cbd5e1;">
              Beli Langsung Sekarang
            </a>
          </div>
        @else
          <!-- Out of Stock: Buttons Disabled (P12 REQUIREMENT) -->
          <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; padding: 14px; text-align: center; margin-bottom: 20px;">
            <div style="font-size: 14px; font-weight: 800; color: #dc2626; margin-bottom: 4px;">
              STOK PRODUK HABIS
            </div>
            <p style="font-size: 12px; color: #991b1b; margin: 0; line-height: 1.4;">
              Mohon maaf, saat ini unit tidak tersedia di gudang pusat. Silakan pilih produk lain di katalog.
            </p>
          </div>

          <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
            <button type="button" disabled style="width: 100%; padding: 13px; font-size: 14px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f1f5f9; color: #94a3b8; font-weight: 700; cursor: not-allowed;">
              + Keranjang (Nonaktif)
            </button>
            <button type="button" disabled style="width: 100%; padding: 13px; font-size: 14px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f1f5f9; color: #94a3b8; font-weight: 700; cursor: not-allowed;">
              Beli Langsung (Stok Habis)
            </button>
          </div>
        @endif

        <div style="border-top: 1px solid var(--border-light); padding-top: 16px; font-size: 12px; color: #64748b; line-height: 1.6;">
          🛡️ <strong>Jaminan VOVOI:</strong> Pengiriman berasuransi, serial tag otentik, dan garansi resmi pabrik.
        </div>
      </aside>

    </div>

    <!-- 4. SECTION ULASAN & RATING PEMBELI (FITUR INOVASI P12) -->
    <div style="background: #ffffff; border: 1px solid var(--border-light); border-radius: 14px; padding: 36px; margin-bottom: 48px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
      <div style="display: flex; justify-content: space-between; align-items: baseline; border-bottom: 1px solid #f1f5f9; padding-bottom: 18px; margin-bottom: 24px;">
        <div>
          <h2 style="font-size: 20px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0;">
            ⭐ Ulasan dan Penilaian Pembeli
          </h2>
          <p style="font-size: 13px; color: #64748b; margin: 0;">
            Ulasan nyata dari pembeli yang pesanan produknya telah berhasil dikirim (Shipped).
          </p>
        </div>
        <div style="text-align: right;">
          <span style="font-size: 28px; font-weight: 800; color: #0f172a;">{{ number_format($product->averageRating(), 1) }}</span>
          <span style="font-size: 14px; color: #f59e0b;">/ 5.0</span>
          <div style="font-size: 12px; color: #64748b;">{{ $product->reviews->count() }} Total Ulasan</div>
        </div>
      </div>

      @if($product->reviews->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 20px;">
          @foreach($product->reviews as $rev)
            <div style="padding: 18px 20px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                  <div style="width: 32px; height: 32px; border-radius: 50%; background: #0B5ED7; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px;">
                    {{ strtoupper(substr($rev->customer_name, 0, 1)) }}
                  </div>
                  <div>
                    <strong style="font-size: 14px; color: #0f172a;">{{ $rev->customer_name }}</strong>
                    <span style="font-size: 11px; color: #059669; background: #ecfdf5; padding: 2px 6px; border-radius: 4px; font-weight: 600; margin-left: 6px;">Pembeli Terverifikasi</span>
                  </div>
                </div>
                <div style="color: #f59e0b; font-size: 16px; letter-spacing: 2px;">
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
        <div style="text-align: center; padding: 40px; color: #64748b; background: #f8fafc; border-radius: 10px;">
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
