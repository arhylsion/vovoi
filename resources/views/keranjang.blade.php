@extends('layouts.master')

@section('title', 'Keranjang Belanja - VOVOI')

@section('extra_css')
<style>
  .cart-layout {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 32px;
    align-items: start;
  }
  @media (max-width: 992px) {
    .cart-layout {
      grid-template-columns: 1fr;
    }
  }
</style>
@endsection

@section('konten_utama')
<section style="padding: 24px 0 80px; min-height: 80vh;">
  <div>

    <!-- Breadcrumbs -->
    <nav style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-muted); margin-bottom: 24px;">
      <a href="/" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Beranda</a>
      <span>&rsaquo;</span>
      <a href="/katalog" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Katalog</a>
      <span>&rsaquo;</span>
      <span style="color: #0F172A; font-weight: 700;">Keranjang Belanja</span>
    </nav>

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 28px; border-bottom: 1px solid var(--border-light, #E2E8F0); padding-bottom: 18px;">
      <div>
        <h1 style="font-size: 28px; font-weight: 800; letter-spacing: -0.03em; margin: 0 0 6px 0; color: #0F172A; display: flex; align-items: center; gap: 12px;">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color: #0B5ED7;">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          Keranjang Belanja
        </h1>
        <p style="font-size: 14px; color: #64748B; margin: 0;">
          Kelola seluruh barang pilihan Anda untuk melakukan sekali checkout multi-produk secara praktis.
        </p>
      </div>

      <a href="/katalog" style="font-size: 13px; font-weight: 600; color: #0B5ED7; text-decoration: none; display: flex; align-items: center; gap: 6px;">
        &larr; Lanjut Belanja Produk Lain
      </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div style="background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; color: #065F46; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
      ✅ {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; color: #991B1B; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
      ⚠️ {{ session('error') }}
    </div>
    @endif

    @if(session('info'))
    <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; color: #1E40AF; font-size: 14px; font-weight: 600;">
      ℹ️ {{ session('info') }}
    </div>
    @endif

    @if(count($cart) > 0)
    <!-- Main Cart Layout Grid -->
    <div class="cart-layout">

      <!-- Left Column: Cart Items -->
      <div>
        
        <!-- Header Controls -->
        <div style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: 12px; padding: 16px 20px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
          <div style="font-size: 14px; font-weight: 700; color: #1E293B;">
            Daftar Produk di Keranjang ({{ count($cart) }} Macam Barang)
          </div>
          <span style="font-size: 13px; color: #64748B;">Harga Satuan &amp; Subtotal</span>
        </div>

        <!-- List of Items -->
        <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 40px;">
          @foreach($cart as $item)
          <div class="cart-item-card" id="cart-item-{{ $item['id'] }}" data-id="{{ $item['id'] }}" data-price="{{ $item['price'] }}" 
            style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: 12px; padding: 22px; display: flex; gap: 20px; align-items: center; box-shadow: 0 1px 4px rgba(0,0,0,0.02);">
            
            <!-- Product Thumbnail -->
            <div style="width: 86px; height: 86px; background: #F8F9FA; border-radius: 10px; border: 1px solid #F1F5F9; display: flex; align-items: center; justify-content: center; padding: 8px; flex-shrink: 0;">
              @if(!empty($item['image']))
                <img src="{{ asset('assets/images/' . $item['image']) }}" alt="{{ $item['name'] }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
              @else
                <img src="{{ asset('assets/images/zen2-phone.svg') }}" alt="{{ $item['name'] }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
              @endif
            </div>

            <!-- Product Details -->
            <div style="flex: 1;">
              <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                <a href="/detail/{{ $item['id'] }}" style="font-size: 15px; font-weight: 700; color: #0F172A; text-decoration: none;">
                  {{ $item['name'] }}
                </a>
                <span style="font-size: 15px; font-weight: 800; color: #0F172A; letter-spacing: -0.02em;">
                  Rp {{ number_format($item['price'], 0, ',', '.') }}
                </span>
              </div>

              <!-- Tags / Spec -->
              <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 14px; flex-wrap: wrap;">
                <span style="font-size: 11px; color: #64748B; background: #F1F5F9; padding: 3px 8px; border-radius: 4px; font-family: monospace;">
                  VOVOI-{{ str_pad($item['id'], 4, '0', STR_PAD_LEFT) }}
                </span>
                <span style="font-size: 11px; color: #059669; background: #ECFDF5; padding: 3px 8px; border-radius: 4px; font-weight: 600;">
                  ● Garansi Resmi VOVOI Care
                </span>
              </div>

              <!-- Controls: Qty Selector and Actions -->
              <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                  <!-- Qty Button Box -->
                  <div style="display: inline-flex; align-items: center; border: 1px solid #CBD5E1; border-radius: 6px; background: #FFFFFF; overflow: hidden;">
                    <button type="button" onclick="changeQty({{ $item['id'] }}, -1)" style="background: none; border: none; padding: 6px 12px; font-size: 16px; font-weight: 700; cursor: pointer; color: #64748B; line-height: 1;">&minus;</button>
                    <span id="qty-val-{{ $item['id'] }}" style="min-width: 32px; text-align: center; font-size: 14px; font-weight: 700; color: #0F172A;">
                      {{ $item['quantity'] }}
                    </span>
                    <button type="button" onclick="changeQty({{ $item['id'] }}, 1)" style="background: none; border: none; padding: 6px 12px; font-size: 16px; font-weight: 700; cursor: pointer; color: #64748B; line-height: 1;">&#43;</button>
                  </div>
                  
                  <span style="font-size: 13px; color: #64748B;">
                    Subtotal: <strong id="item-subtotal-{{ $item['id'] }}" style="color: #0F172A;">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</strong>
                  </span>
                </div>

                <!-- Action Links -->
                <div style="display: flex; align-items: center; gap: 14px;">
                  <a href="/checkout/{{ $item['id'] }}" style="font-size: 12px; font-weight: 700; color: #0B5ED7; text-decoration: none;">
                    Beli Barang Ini Saja &rarr;
                  </a>
                  <a href="/keranjang/hapus/{{ $item['id'] }}" onclick="return confirm('Hapus barang ini dari keranjang?')" 
                    style="color: #94A3B8; text-decoration: none; padding: 6px; border-radius: 4px; display: inline-flex; align-items: center;" title="Hapus dari keranjang">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="3 6 5 6 21 6"></polyline>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                  </a>
                </div>
              </div>

            </div>

          </div>
          @endforeach
        </div>

      </div>

      <!-- Right Column: Sticky Summary & Checkout Action -->
      <aside style="position: sticky; top: 96px;">
        <div style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: 12px; padding: 28px; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
          
          <h2 style="font-size: 18px; font-weight: 800; letter-spacing: -0.02em; margin-top: 0; margin-bottom: 20px; color: #0F172A; border-bottom: 1px solid #F1F5F9; padding-bottom: 12px;">
            Ringkasan Belanja
          </h2>

          <!-- Breakdown -->
          <div style="display: flex; flex-direction: column; gap: 14px; font-size: 14px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; color: #64748B;">
              <span>Total Barang:</span>
              <span id="summaryItemCount" style="font-weight: 700; color: #0F172A;">
                {{ count($cart) }} Macam Produk
              </span>
            </div>

            <div style="display: flex; justify-content: space-between; color: #64748B;">
              <span>Total Subtotal:</span>
              <span id="summarySubtotal" style="font-weight: 700; color: #0F172A;">
                Rp {{ number_format($subtotal, 0, ',', '.') }}
              </span>
            </div>

            <div style="display: flex; justify-content: space-between; color: #64748B;">
              <span>Ongkos Kirim &amp; Voucher:</span>
              <span style="font-size: 12px; color: #0B5ED7; font-weight: 600;">Dihitung di Checkout</span>
            </div>
          </div>

          <hr style="border: 0; border-top: 1px dashed #CBD5E1; margin: 0 0 20px 0;">

          <!-- Total Calculation -->
          <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 24px;">
            <span style="font-size: 15px; font-weight: 800; color: #0F172A;">Estimasi Total:</span>
            <span id="summaryGrandTotal" style="font-size: 22px; font-weight: 800; color: #E63946; letter-spacing: -0.02em;">
              Rp {{ number_format($subtotal, 0, ',', '.') }}
            </span>
          </div>

          <!-- Checkout CTA Button: FITUR INOVASI MULTI-PRODUK SEKALI CHECKOUT -->
          <a id="checkoutButton" href="/checkout" 
            style="display: block; text-align: center; background-color: #0B5ED7; color: #FFFFFF; padding: 16px; border-radius: 8px; font-weight: 700; font-size: 15px; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 12px rgba(11, 94, 215, 0.25);">
            Lanjut ke Checkout ({{ count($cart) }} Barang) &rarr;
          </a>

          <!-- Trust Badges -->
          <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid #F1F5F9; display: flex; flex-direction: column; gap: 8px; font-size: 12px; color: #64748B;">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span>✓</span> 100% Produk Original &amp; Tersegel
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
              <span>✓</span> Garansi Resmi VOVOI Indonesia
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
              <span>✓</span> Sekali Checkout untuk Seluruh Keranjang
            </div>
          </div>

        </div>
      </aside>

    </div>
    @else
    <!-- Empty Cart State -->
    <div style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: 16px; padding: 64px 24px; text-align: center; max-width: 560px; margin: 40px auto; box-shadow: 0 2px 12px rgba(0,0,0,0.03);">
      <div style="width: 72px; height: 72px; background: #F1F5F9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #64748B;">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="9" cy="21" r="1"></circle>
          <circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
      </div>
      <h2 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0 0 10px 0;">
        Keranjang Belanja Anda Kosong
      </h2>
      <p style="font-size: 14px; color: #64748B; margin: 0 0 28px 0; line-height: 1.6;">
        Belum ada produk yang dimasukkan ke dalam keranjang belanja.
      </p>
      <a href="/katalog" class="v-btn v-btn-primary" style="padding: 13px 28px; font-size: 14px; font-weight: 700; border-radius: 8px; text-decoration: none;">
        Mulai Belanja Sekarang &rarr;
      </a>
    </div>
    @endif

  </div>
</section>
@endsection

@section('extra_js')
<script>
  function changeQty(id, delta) {
    const qtySpan = document.getElementById('qty-val-' + id);
    let currentQty = parseInt(qtySpan.innerText) || 1;
    currentQty = Math.max(1, currentQty + delta);
    qtySpan.innerText = currentQty;

    const card = document.getElementById('cart-item-' + id);
    const unitPrice = parseFloat(card.getAttribute('data-price')) || 0;
    const itemSubtotal = unitPrice * currentQty;
    document.getElementById('item-subtotal-' + id).innerText = 'Rp ' + itemSubtotal.toLocaleString('id-ID');

    recalculateCart();
  }

  function recalculateCart() {
    let subtotal = 0;
    const cards = document.querySelectorAll('.cart-item-card');
    cards.forEach(card => {
      const id = card.getAttribute('data-id');
      const unitPrice = parseFloat(card.getAttribute('data-price')) || 0;
      const qtySpan = document.getElementById('qty-val-' + id);
      const qty = parseInt(qtySpan ? qtySpan.innerText : 1) || 1;
      subtotal += unitPrice * qty;
    });

    document.getElementById('summarySubtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('summaryGrandTotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
  }
</script>
@endsection
