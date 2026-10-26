@extends('layouts.master')

@section('title', 'Keranjang Belanja - VOVOI')

@section('konten_utama')
<section style="padding: 36px 0 80px; background: #FBFBFC; min-height: 80vh;">
  <div class="v-container">

    <!-- Breadcrumbs -->
    <nav style="display: flex; align-items: center; gap: 8px; font-family: var(--font-mono, monospace); font-size: 13px; color: var(--text-muted, #64748B); margin-bottom: 28px;">
      <a href="/" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Beranda</a>
      <span style="color: #94A3B8;">&rsaquo;</span>
      <a href="/katalog" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Katalog</a>
      <span style="color: #94A3B8;">&rsaquo;</span>
      <span style="color: #0F172A; font-weight: 700;">Keranjang Belanja</span>
    </nav>

    <!-- Page Header -->
    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 32px; border-bottom: 1px solid var(--border-light, #E2E8F0); padding-bottom: 20px;">
      <div>
        <h1 style="font-size: 32px; font-weight: 800; letter-spacing: -0.03em; margin: 0 0 6px 0; color: #0F172A; display: flex; align-items: center; gap: 12px;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color: #0B5ED7;">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          Keranjang Belanja
        </h1>
        <p style="font-size: 14px; color: #64748B; margin: 0;">
          Kelola barang pilihan Anda sebelum melanjutkan ke proses checkout dan pembayaran.
        </p>
      </div>

      <a href="/katalog" style="font-size: 13px; font-weight: 600; color: #0B5ED7; text-decoration: none; display: flex; align-items: center; gap: 6px;">
        &larr; Lanjut Pilih Produk
      </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div style="background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; color: #065F46; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
      {{ session('success') }}
    </div>
    @endif

    @if(session('info'))
    <div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; color: #1E40AF; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
      {{ session('info') }}
    </div>
    @endif

    @if(count($cart) > 0)
    <!-- Main Cart Layout Grid -->
    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 36px; align-items: start;">

      <!-- Left Column: Cart Items -->
      <div>
        
        <!-- Header Controls -->
        <div style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: 12px; padding: 16px 20px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
          <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 600; color: #1E293B; cursor: pointer;">
            <input type="checkbox" id="selectAllCheckbox" checked onchange="toggleSelectAll(this)" style="width: 18px; height: 18px; accent-color: #0F172A; cursor: pointer;">
            Pilih Semua ({{ count($cart) }} Barang)
          </label>

          <span style="font-size: 13px; color: #64748B;">Harga Satuan</span>
        </div>

        <!-- List of Items -->
        <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 40px;">
          @foreach($cart as $item)
          <div class="cart-item-card" id="cart-item-{{ $item['id'] }}" data-id="{{ $item['id'] }}" data-price="{{ $item['price'] }}" 
            style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: 12px; padding: 24px; display: flex; gap: 20px; align-items: center; box-shadow: 0 1px 4px rgba(0,0,0,0.02); transition: all 0.2s;">
            
            <!-- Item Checkbox -->
            <input type="checkbox" class="item-checkbox" checked onchange="recalculateCart()" data-id="{{ $item['id'] }}" style="width: 18px; height: 18px; accent-color: #0F172A; cursor: pointer; flex-shrink: 0;">

            <!-- Product Thumbnail -->
            <div style="width: 100px; height: 100px; background: #F8F9FA; border-radius: 10px; border: 1px solid #F1F5F9; display: flex; align-items: center; justify-content: center; padding: 10px; flex-shrink: 0;">
              @if(!empty($item['image']))
                <img src="{{ asset('assets/images/' . $item['image']) }}" alt="{{ $item['name'] }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
              @else
                <img src="{{ asset('assets/images/zen2-phone.svg') }}" alt="{{ $item['name'] }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
              @endif
            </div>

            <!-- Product Details -->
            <div style="flex: 1;">
              <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                <a href="/detail/{{ $item['id'] }}" style="font-size: 16px; font-weight: 700; color: #0F172A; text-decoration: none;">
                  {{ $item['name'] }}
                </a>
                <span style="font-size: 16px; font-weight: 800; color: #0F172A; letter-spacing: -0.02em;">
                  Rp {{ number_format($item['price'], 0, ',', '.') }}
                </span>
              </div>

              <!-- Tags / Spec -->
              <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 16px; flex-wrap: wrap;">
                <span style="font-size: 12px; color: #64748B; background: #F1F5F9; padding: 3px 8px; border-radius: 4px; font-family: var(--font-mono, monospace);">
                  Serial: VOV-{{ str_pad($item['id'], 4, '0', STR_PAD_LEFT) }}
                </span>
                <span style="font-size: 12px; color: #059669; background: #ECFDF5; padding: 3px 8px; border-radius: 4px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                  <span style="width: 6px; height: 6px; border-radius: 50%; background: #10B981;"></span>
                  Ready Stock
                </span>
              </div>

              <!-- Controls: Qty Selector and Actions -->
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 8px;">
                  <!-- Qty Button Box -->
                  <div style="display: inline-flex; align-items: center; border: 1px solid #CBD5E1; border-radius: 6px; background: #FFFFFF; overflow: hidden;">
                    <button type="button" onclick="changeQty({{ $item['id'] }}, -1)" style="background: none; border: none; padding: 6px 12px; font-size: 16px; font-weight: 700; cursor: pointer; color: #64748B; line-height: 1;">&minus;</button>
                    <span id="qty-val-{{ $item['id'] }}" style="min-width: 32px; text-align: center; font-size: 14px; font-weight: 700; color: #0F172A;">
                      {{ $item['quantity'] }}
                    </span>
                    <button type="button" onclick="changeQty({{ $item['id'] }}, 1)" style="background: none; border: none; padding: 6px 12px; font-size: 16px; font-weight: 700; cursor: pointer; color: #64748B; line-height: 1;">&#43;</button>
                  </div>
                  
                  <span style="font-size: 13px; color: #64748B; margin-left: 8px;">
                    Subtotal: <strong id="item-subtotal-{{ $item['id'] }}" style="color: #0F172A;">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</strong>
                  </span>
                </div>

                <!-- Action Links -->
                <div style="display: flex; align-items: center; gap: 16px;">
                  <a href="/checkout/{{ $item['id'] }}" style="font-size: 13px; font-weight: 600; color: #0B5ED7; text-decoration: none;">
                    Beli Produk Ini Langsung &rarr;
                  </a>
                  <a href="/keranjang/hapus/{{ $item['id'] }}" onclick="return confirm('Hapus barang ini dari keranjang?')" 
                    style="color: #94A3B8; text-decoration: none; padding: 6px; border-radius: 4px; display: flex; align-items: center; transition: color 0.2s;" title="Hapus dari keranjang" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#94A3B8'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

        <!-- Recommended Products Section -->
        @if(isset($recommendedProducts) && $recommendedProducts->count() > 0)
        <div style="margin-top: 48px;">
          <h3 style="font-size: 20px; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 20px; color: #0F172A;">
            Mungkin Anda Juga Membutuhkan
          </h3>

          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            @foreach($recommendedProducts as $rec)
            <div style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: 10px; padding: 16px; display: flex; flex-direction: column; justify-content: space-between;">
              <div>
                <div style="width: 100%; height: 120px; background: #F8F9FA; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; padding: 8px;">
                  <img src="{{ asset('assets/images/' . $rec->image) }}" alt="{{ $rec->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>
                <h4 style="font-size: 14px; font-weight: 700; margin: 0 0 4px 0; color: #0F172A;">{{ $rec->name }}</h4>
                <div style="font-size: 14px; font-weight: 800; color: #E63946; margin-bottom: 12px;">
                  Rp {{ number_format($rec->price, 0, ',', '.') }}
                </div>
              </div>
              <a href="/keranjang?add={{ $rec->id }}" style="display: block; text-align: center; background: #F1F5F9; color: #0F172A; padding: 8px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">
                + Keranjang
              </a>
            </div>
            @endforeach
          </div>
        </div>
        @endif

      </div>

      <!-- Right Column: Sticky Summary & Checkout Action -->
      <aside style="position: sticky; top: 96px;">
        <div style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: 12px; padding: 28px; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
          
          <h2 style="font-size: 20px; font-weight: 800; letter-spacing: -0.02em; margin-top: 0; margin-bottom: 20px; color: #0F172A; border-bottom: 1px solid #F1F5F9; padding-bottom: 12px;">
            Ringkasan Belanja
          </h2>

          <!-- Breakdown -->
          <div style="display: flex; flex-direction: column; gap: 14px; font-size: 14px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; color: #64748B;">
              <span>Total Harga (<span id="summarySelectedCount">1</span> barang):</span>
              <span id="summarySubtotal" style="font-weight: 700; color: #0F172A;">
                Rp {{ number_format($subtotal, 0, ',', '.') }}
              </span>
            </div>

            <div style="display: flex; justify-content: space-between; color: #64748B;">
              <span>Diskon Belanja:</span>
              <span id="summaryDiscount" style="font-weight: 600; color: #059669;">Rp 0</span>
            </div>

            <div style="display: flex; justify-content: space-between; color: #64748B;">
              <span>Ongkos Kirim:</span>
              <span style="font-size: 12px; color: #64748B; font-style: italic;">Dihitung di Checkout</span>
            </div>
          </div>

          <!-- Promo Code Input -->
          <div style="margin-bottom: 24px;">
            <div style="display: flex; gap: 8px;">
              <input type="text" id="couponCode" placeholder="Kode Promo: VOVOIHEMAT" style="flex: 1; padding: 10px 12px; border: 1px solid #CBD5E1; border-radius: 6px; font-size: 13px; outline: none;">
              <button type="button" onclick="applyCoupon()" style="background: #0F172A; color: white; border: none; padding: 10px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">
                Pakai
              </button>
            </div>
            <span id="couponMsg" style="display: none; font-size: 12px; margin-top: 6px;"></span>
          </div>

          <hr style="border: 0; border-top: 1px dashed #CBD5E1; margin: 0 0 20px 0;">

          <!-- Total Calculation -->
          <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 24px;">
            <span style="font-size: 16px; font-weight: 800; color: #0F172A;">Total Tagihan:</span>
            <span id="summaryGrandTotal" style="font-size: 24px; font-weight: 800; color: #E63946; letter-spacing: -0.02em;">
              Rp {{ number_format($subtotal, 0, ',', '.') }}
            </span>
          </div>

          <!-- Checkout CTA Button -->
          @php
            $firstItemId = array_key_first($cart);
          @endphp
          <a id="checkoutButton" href="/checkout/{{ $firstItemId }}" 
            style="display: block; text-align: center; background-color: #0B5ED7; color: #FFFFFF; padding: 16px; border-radius: 8px; font-weight: 700; font-size: 16px; text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 12px rgba(11, 94, 215, 0.25);">
            Lanjut ke Checkout &rarr;
          </a>

          <!-- Trust Badges -->
          <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #F1F5F9; display: flex; flex-direction: column; gap: 10px; font-size: 12px; color: #64748B;">
            <div style="display: flex; align-items: center; gap: 8px;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span>100% Produk Original & Terverifikasi</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span>Garansi Resmi 1 Tahun VOVOI Indonesia</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span>Transaksi Aman dengan Enkripsi SSL</span>
            </div>
          </div>

        </div>
      </aside>

    </div>
    @else
    <!-- Empty Cart State -->
    <div style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: 16px; padding: 72px 24px; text-align: center; max-width: 600px; margin: 40px auto; box-shadow: 0 2px 12px rgba(0,0,0,0.03);">
      <div style="width: 80px; height: 80px; background: #F1F5F9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: #64748B;">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="9" cy="21" r="1"></circle>
          <circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
      </div>
      <h2 style="font-size: 24px; font-weight: 800; color: #0F172A; margin: 0 0 10px 0;">
        Keranjang Belanja Anda Kosong
      </h2>
      <p style="font-size: 14px; color: #64748B; margin: 0 0 32px 0; line-height: 1.6;">
        Wah, sepertinya Anda belum memilih barang apa pun. Jelajahi katalog smartphone dan gadget premium VOVOI sekarang!
      </p>
      <a href="/katalog" class="v-btn v-btn-primary" style="padding: 14px 32px; font-size: 15px; font-weight: 700; border-radius: 8px;">
        Mulai Belanja Sekarang
      </a>
    </div>
    @endif

  </div>
</section>
@endsection

@section('extra_js')
<script>
  let discountAmount = 0;

  function toggleSelectAll(masterCheckbox) {
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    itemCheckboxes.forEach(cb => cb.checked = masterCheckbox.checked);
    recalculateCart();
  }

  function changeQty(id, delta) {
    const qtySpan = document.getElementById('qty-val-' + id);
    let currentQty = parseInt(qtySpan.innerText) || 1;
    currentQty = Math.max(1, currentQty + delta);
    qtySpan.innerText = currentQty;

    // Update item subtotal
    const card = document.getElementById('cart-item-' + id);
    const unitPrice = parseFloat(card.getAttribute('data-price')) || 0;
    const itemSubtotal = unitPrice * currentQty;
    document.getElementById('item-subtotal-' + id).innerText = 'Rp ' + itemSubtotal.toLocaleString('id-ID');

    recalculateCart();
  }

  function recalculateCart() {
    let selectedCount = 0;
    let subtotal = 0;
    let firstSelectedId = null;

    const cards = document.querySelectorAll('.cart-item-card');
    cards.forEach(card => {
      const id = card.getAttribute('data-id');
      const checkbox = card.querySelector('.item-checkbox');
      const unitPrice = parseFloat(card.getAttribute('data-price')) || 0;
      const qtySpan = document.getElementById('qty-val-' + id);
      const qty = parseInt(qtySpan ? qtySpan.innerText : 1) || 1;

      if (checkbox && checkbox.checked) {
        selectedCount += qty;
        subtotal += unitPrice * qty;
        if (!firstSelectedId) {
          firstSelectedId = id;
        }
      }
    });

    const grandTotal = Math.max(0, subtotal - discountAmount);

    document.getElementById('summarySelectedCount').innerText = selectedCount;
    document.getElementById('summarySubtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('summaryGrandTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');

    const checkoutBtn = document.getElementById('checkoutButton');
    if (checkoutBtn) {
      if (selectedCount > 0 && firstSelectedId) {
        checkoutBtn.href = '/checkout/' + firstSelectedId;
        checkoutBtn.style.opacity = '1';
        checkoutBtn.style.pointerEvents = 'auto';
        checkoutBtn.innerText = 'Lanjut ke Checkout (' + selectedCount + ') \u2192';
      } else {
        checkoutBtn.style.opacity = '0.5';
        checkoutBtn.style.pointerEvents = 'none';
        checkoutBtn.innerText = 'Pilih Barang Dulu';
      }
    }
  }

  function applyCoupon() {
    const code = document.getElementById('couponCode').value.trim().toUpperCase();
    const msg = document.getElementById('couponMsg');

    if (code === 'VOVOIHEMAT' || code === 'VOVOI') {
      discountAmount = 500000;
      document.getElementById('summaryDiscount').innerText = '- Rp 500.000';
      msg.style.display = 'block';
      msg.style.color = '#059669';
      msg.innerText = '\u2713 Kupon berhasil digunakan! Potongan Rp 500.000';
    } else if (code === '') {
      msg.style.display = 'block';
      msg.style.color = '#EF4444';
      msg.innerText = 'Silakan ketikkan kode promo terlebih dahulu.';
    } else {
      discountAmount = 0;
      document.getElementById('summaryDiscount').innerText = 'Rp 0';
      msg.style.display = 'block';
      msg.style.color = '#EF4444';
      msg.innerText = 'Kode promo tidak valid atau telah kedaluwarsa.';
    }

    recalculateCart();
  }

  // Initial calculation on load
  document.addEventListener('DOMContentLoaded', function() {
    recalculateCart();
  });
</script>
@endsection
