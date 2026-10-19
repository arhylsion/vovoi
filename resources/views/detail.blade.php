@extends('layouts.master')

@section('title', 'VOVOI Phone X Pro - VOVOI')

@section('konten_utama')
<section style="padding: 28px 0 64px;">
  <div class="v-container">
    
    <!-- Breadcrumbs -->
    <nav style="display: flex; align-items: center; gap: 8px; font-family: var(--font-mono); font-size: 12px; color: var(--text-muted); margin-bottom: 32px;">
      <a href="/katalog" style="color: var(--text-secondary);">Store</a>
      <span>&rsaquo;</span>
      <a href="/katalog" style="color: var(--text-secondary);">Smartphone</a>
      <span>&rsaquo;</span>
      <span style="color: var(--text-primary); font-weight: 700;">VOVOI Phone X Pro</span>
    </nav>

    <!-- Product Main Grid (Gallery, Info, Sticky Buy Box) -->
    <div style="display: grid; grid-template-columns: 440px 1fr 300px; gap: 40px; align-items: start; margin-bottom: 72px;">
      
      <!-- 1. Left Gallery Column -->
      <div>
        <div style="width: 100%; height: 420px; background: #F8F9FA; border-radius: var(--radius-lg); border: 1px solid var(--border-light); display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 24px; margin-bottom: 16px;">
          <img id="mainProductImg" src="{{ asset('assets/images/phone-x-pro.svg') }}" alt="VOVOI Phone X Pro" style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform var(--transition-normal);">
        </div>

        <!-- Thumbnails -->
        <div style="display: flex; gap: 10px; justify-content: flex-start;">
          <button type="button" class="v-thumb-btn active" onclick="switchThumb(this, '{{ asset('assets/images/phone-x-pro.svg') }}')" style="width: 60px; height: 60px; border-radius: var(--radius-sm); border: 2px solid var(--text-primary); background: #F8F9FA; padding: 4px; cursor: pointer;">
            <img src="{{ asset('assets/images/phone-thumb1.svg') }}" alt="Angle 1" style="width: 100%; height: 100%; object-fit: contain;">
          </button>
          
          <button type="button" class="v-thumb-btn" onclick="switchThumb(this, '{{ asset('assets/images/flagship-phone.svg') }}')" style="width: 60px; height: 60px; border-radius: var(--radius-sm); border: 1px solid var(--border-light); background: #F8F9FA; padding: 4px; cursor: pointer;">
            <img src="{{ asset('assets/images/phone-thumb2.svg') }}" alt="Angle 2" style="width: 100%; height: 100%; object-fit: contain;">
          </button>
          
          <button type="button" class="v-thumb-btn" onclick="switchThumb(this, '{{ asset('assets/images/phone-thumb3.svg') }}')" style="width: 60px; height: 60px; border-radius: var(--radius-sm); border: 1px solid var(--border-light); background: #F8F9FA; padding: 4px; cursor: pointer;">
            <img src="{{ asset('assets/images/phone-thumb3.svg') }}" alt="Angle 3" style="width: 100%; height: 100%; object-fit: contain;">
          </button>
          
          <button type="button" class="v-thumb-btn" onclick="switchThumb(this, '{{ asset('assets/images/phone-thumb4.svg') }}')" style="width: 60px; height: 60px; border-radius: var(--radius-sm); border: 1px solid var(--border-light); background: #F8F9FA; padding: 4px; cursor: pointer;">
            <img src="{{ asset('assets/images/phone-thumb4.svg') }}" alt="Angle 4" style="width: 100%; height: 100%; object-fit: contain;">
          </button>
          
          <button type="button" class="v-thumb-btn" onclick="switchThumb(this, '{{ asset('assets/images/phone-thumb5.svg') }}')" style="width: 60px; height: 60px; border-radius: var(--radius-sm); border: 1px solid var(--border-light); background: #F8F9FA; padding: 4px; cursor: pointer;">
            <img src="{{ asset('assets/images/phone-thumb5.svg') }}" alt="Angle 5" style="width: 100%; height: 100%; object-fit: contain;">
          </button>
        </div>
      </div>

      <!-- 2. Center Product Details Column -->
      <div>
        <h1 style="font-size: 36px; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 8px;">
          VOVOI Phone X Pro
        </h1>

        <!-- Rating & Sales -->
        <div style="display: flex; align-items: center; gap: 12px; font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">
          <span>Sold 1k+</span>
          <span>&bull;</span>
          <span style="display: flex; align-items: center; gap: 4px; color: var(--text-primary); font-weight: 700;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="#F59E0B" stroke="#F59E0B">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
            4.9 <span style="color: var(--text-secondary); font-weight: 400;">(450 reviews)</span>
          </span>
        </div>

        <!-- Price -->
        <div id="productPriceDisplay" style="font-size: 32px; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 24px;">
          $844
        </div>

        <hr style="border: none; border-top: 1px solid var(--border-light); margin-bottom: 24px;">

        <!-- Availability -->
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
          <span style="font-size: 14px; font-weight: 600; color: var(--text-primary);">Availability:</span>
          <span class="v-tag-mono green">
            <span class="v-dot-indicator green"></span>
            In Stock at Manggarai
          </span>
        </div>

        <!-- Color Selector -->
        <div style="margin-bottom: 24px;">
          <div style="font-size: 14px; font-weight: 600; margin-bottom: 10px;">
            Color: <span id="selectedColorName" style="color: var(--text-secondary); font-weight: 500;">Titanium Silver</span>
          </div>
          <div style="display: flex; gap: 12px; align-items: center;">
            <button type="button" class="v-color-dot active" onclick="selectColor(this, 'Titanium Silver')" 
              style="width: 32px; height: 32px; border-radius: 50%; background: #D4D4D8; border: 2px solid #FFFFFF; outline: 2px solid var(--text-primary); cursor: pointer; transition: all var(--transition-fast);">
            </button>
            <button type="button" class="v-color-dot" onclick="selectColor(this, 'Obsidian Black')" 
              style="width: 32px; height: 32px; border-radius: 50%; background: #27272A; border: 2px solid #FFFFFF; outline: 1px solid var(--border-medium); cursor: pointer; transition: all var(--transition-fast);">
            </button>
          </div>
        </div>

        <!-- Storage Selector -->
        <div style="margin-bottom: 32px;">
          <div style="font-size: 14px; font-weight: 600; margin-bottom: 10px;">
            Storage:
          </div>
          <div style="display: flex; gap: 12px;">
            <button type="button" class="v-storage-btn active" onclick="selectStorage(this, 844)" 
              style="padding: 10px 24px; border-radius: var(--radius-sm); border: 2px solid var(--text-primary); background: #FFFFFF; font-size: 14px; font-weight: 700; color: var(--text-primary); cursor: pointer;">
              256GB
            </button>
            <button type="button" class="v-storage-btn" onclick="selectStorage(this, 944)" 
              style="padding: 10px 24px; border-radius: var(--radius-sm); border: 1px solid var(--border-light); background: #FFFFFF; font-size: 14px; font-weight: 500; color: var(--text-secondary); cursor: pointer;">
              512GB
            </button>
            <button type="button" class="v-storage-btn" onclick="selectStorage(this, 1144)" 
              style="padding: 10px 24px; border-radius: var(--radius-sm); border: 1px solid var(--border-light); background: #FFFFFF; font-size: 14px; font-weight: 500; color: var(--text-secondary); cursor: pointer;">
              1TB
            </button>
          </div>
        </div>

        <hr style="border: none; border-top: 1px solid var(--border-light); margin-bottom: 24px;">

        <!-- Tabs: Detail Produk / Spesifikasi -->
        <div>
          <div style="display: flex; gap: 24px; border-bottom: 1px solid var(--border-light); margin-bottom: 16px;">
            <button type="button" id="tabDetailBtn" onclick="switchTab('detail')" 
              style="background: none; border: none; font-size: 14px; font-weight: 700; color: var(--text-primary); padding: 8px 0; border-bottom: 2px solid var(--text-primary); cursor: pointer;">
              Detail Produk
            </button>
            <button type="button" id="tabSpecBtn" onclick="switchTab('spec')" 
              style="background: none; border: none; font-size: 14px; font-weight: 500; color: var(--text-muted); padding: 8px 0; border-bottom: 2px solid transparent; cursor: pointer;">
              Spesifikasi
            </button>
          </div>

          <div id="tabDetailContent">
            <p style="font-size: 14px; line-height: 1.6; color: var(--text-secondary); margin-bottom: 16px;">
              Experience the beyond ordinary with the VOVOI Phone X Pro. Forged in aerospace-grade titanium, it delivers unprecedented durability in our lightest pro model ever.
            </p>
            <ul style="padding-left: 20px; font-size: 13px; line-height: 1.8; color: var(--text-secondary);">
              <li>A17 Pro chip for next-level performance</li>
              <li>48MP Main camera with advanced computational photography</li>
              <li>Always-On display with ProMotion technology</li>
              <li>USB-C with USB 3 speeds</li>
            </ul>
          </div>

          <div id="tabSpecContent" style="display: none;">
            <div style="display: grid; grid-template-columns: 140px 1fr; gap: 8px; font-size: 13px; color: var(--text-secondary);">
              <span style="font-weight: 600; color: var(--text-primary);">Dimensions:</span>
              <span>146.6 x 70.6 x 8.25 mm</span>
              <span style="font-weight: 600; color: var(--text-primary);">Weight:</span>
              <span>187 grams</span>
              <span style="font-weight: 600; color: var(--text-primary);">Display:</span>
              <span>6.1-inch Super Retina XDR OLED</span>
              <span style="font-weight: 600; color: var(--text-primary);">Water Resistance:</span>
              <span>IP68 (6 meters up to 30 mins)</span>
            </div>
          </div>
        </div>

      </div>

      <!-- 3. Right Sticky Buy Box Card -->
      <aside style="background: #FFFFFF; border: 1px solid var(--border-light); border-radius: var(--radius-lg); padding: 24px; position: sticky; top: 96px; box-shadow: var(--shadow-md);">
        <h2 style="font-size: 14px; font-weight: 700; margin-bottom: 16px;">
          Atur jumlah dan catatan
        </h2>

        <!-- Quantity Counter -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border: 1px solid var(--border-light); border-radius: var(--radius-sm); padding: 6px 12px;">
          <button type="button" onclick="adjustQty(-1)" style="background: none; border: none; font-size: 18px; cursor: pointer; color: var(--text-secondary); width: 24px; height: 24px;">&minus;</button>
          <span id="buyQty" style="font-size: 14px; font-weight: 700;">1</span>
          <button type="button" onclick="adjustQty(1)" style="background: none; border: none; font-size: 18px; cursor: pointer; color: var(--text-secondary); width: 24px; height: 24px;">&#43;</button>
        </div>

        <!-- Subtotal -->
        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 20px;">
          <span style="font-size: 13px; color: var(--text-secondary);">Subtotal</span>
          <span id="subtotalDisplay" style="font-size: 22px; font-weight: 800; letter-spacing: -0.02em;">$844</span>
        </div>

        <!-- Buttons -->
        <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
          <button type="button" class="v-btn v-btn-primary v-btn-block" onclick="addToCartNotification()">
            + Keranjang
          </button>
          <a href="/checkout" class="v-btn v-btn-secondary v-btn-block">
            Beli Langsung
          </a>
        </div>

        <!-- Social / Action Links -->
        <div style="display: flex; justify-content: space-around; align-items: center; padding-top: 16px; border-top: 1px solid var(--border-light); font-size: 12px; font-weight: 600; color: var(--text-secondary);">
          <button type="button" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 4px; color: inherit;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
            Chat
          </button>
          <button type="button" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 4px; color: inherit;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
            Wishlist
          </button>
          <button type="button" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 4px; color: inherit;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
            Share
          </button>
        </div>

      </aside>

    </div>

    <!-- Bottom Feature Banners (Serial Tag Tracking & Paperless Warranty) -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; padding-top: 32px; border-top: 1px solid var(--border-light);">
      
      <!-- Banner 1: Serial Tag Tracking -->
      <div class="v-feature-card light">
        <div class="v-feature-card-header">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
          </svg>
          <span class="v-tag-mono" style="background: #E2E8F0; color: #475569;">
            O2O_READY
          </span>
        </div>
        <div>
          <h3>Serial Tag Tracking</h3>
          <p>
            Verify authenticity instantly. Every VOVOI product carries a cryptographic tag synchronizing physical ownership with our immutable ledger.
          </p>
        </div>
        <a href="#" class="v-feature-link">
          Explore verification &rarr;
        </a>
      </div>

      <!-- Banner 2: Paperless Warranty -->
      <div class="v-feature-card dark">
        <div class="v-feature-card-header">
          <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            <polyline points="9 12 11 14 15 10"></polyline>
          </svg>
          <span class="v-tag-mono dark">
            DIGITAL_SHIELD
          </span>
        </div>
        <div>
          <h3>Paperless Warranty</h3>
          <p>
            Your coverage is activated the moment you purchase. Access diagnostics, support, and claim status directly through your VOVOI ID.
          </p>
        </div>
        <a href="#" class="v-feature-link">
          View coverage terms &rarr;
        </a>
      </div>

    </div>

  </div>
</section>
@endsection

@section('extra_js')
<script>
  let basePrice = 844;
  let currentQty = 1;

  function switchThumb(btn, imgSrc) {
    document.querySelectorAll('.v-thumb-btn').forEach(b => {
      b.style.borderColor = 'var(--border-light)';
    });
    btn.style.borderColor = 'var(--text-primary)';
    document.getElementById('mainProductImg').src = imgSrc;
  }

  function selectColor(btn, colorName) {
    document.querySelectorAll('.v-color-dot').forEach(b => {
      b.style.outline = '1px solid var(--border-medium)';
    });
    btn.style.outline = '2px solid var(--text-primary)';
    document.getElementById('selectedColorName').innerText = colorName;
  }

  function selectStorage(btn, price) {
    document.querySelectorAll('.v-storage-btn').forEach(b => {
      b.style.borderColor = 'var(--border-light)';
      b.style.fontWeight = '500';
      b.style.color = 'var(--text-secondary)';
    });
    btn.style.borderColor = 'var(--text-primary)';
    btn.style.fontWeight = '700';
    btn.style.color = 'var(--text-primary)';
    basePrice = price;
    updatePrice();
  }

  function adjustQty(delta) {
    currentQty = Math.max(1, currentQty + delta);
    document.getElementById('buyQty').innerText = currentQty;
    updatePrice();
  }

  function updatePrice() {
    const total = basePrice * currentQty;
    document.getElementById('productPriceDisplay').innerText = '$' + basePrice;
    document.getElementById('subtotalDisplay').innerText = '$' + total.toLocaleString();
  }

  function switchTab(tab) {
    const detailBtn = document.getElementById('tabDetailBtn');
    const specBtn = document.getElementById('tabSpecBtn');
    const detailContent = document.getElementById('tabDetailContent');
    const specContent = document.getElementById('tabSpecContent');

    if (tab === 'detail') {
      detailBtn.style.color = 'var(--text-primary)';
      detailBtn.style.fontWeight = '700';
      detailBtn.style.borderBottom = '2px solid var(--text-primary)';
      specBtn.style.color = 'var(--text-muted)';
      specBtn.style.fontWeight = '500';
      specBtn.style.borderBottom = '2px solid transparent';
      detailContent.style.display = 'block';
      specContent.style.display = 'none';
    } else {
      specBtn.style.color = 'var(--text-primary)';
      specBtn.style.fontWeight = '700';
      specBtn.style.borderBottom = '2px solid var(--text-primary)';
      detailBtn.style.color = 'var(--text-muted)';
      detailBtn.style.fontWeight = '500';
      detailBtn.style.borderBottom = '2px solid transparent';
      detailContent.style.display = 'none';
      specContent.style.display = 'block';
    }
  }

  function addToCartNotification() {
    alert('Produk telah ditambahkan ke keranjang!');
  }
</script>
@endsection
