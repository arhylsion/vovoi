@extends('layouts.master')

@section('title', 'Checkout Pesanan - VOVOI')

@section('konten_utama')
<section style="padding: 24px 0 80px;">
  <div>
    
    <!-- 1. Breadcrumb Checkout -->
    <nav style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748b; margin-bottom: 24px;">
      <a href="/" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Beranda</a>
      <span>&rsaquo;</span>
      @if($isCart)
        <a href="/keranjang" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Keranjang Belanja</a>
      @else
        <a href="/detail/{{ $product->id }}" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">{{ $product->name }}</a>
      @endif
      <span>&rsaquo;</span>
      <span style="color: #0f172a; font-weight: 700;">Checkout Pesanan</span>
    </nav>

    <!-- Alert / Error message -->
    @if(session('error'))
      <div style="background-color: #fef2f2; color: #991b1b; padding: 14px 18px; border-radius: 8px; border: 1px solid #fecaca; margin-bottom: 24px; font-size: 14px; font-weight: 600;">
        ⚠️ {{ session('error') }}
      </div>
    @endif

    <div style="margin-bottom: 30px;">
      <h1 style="font-size: 28px; font-weight: 800; letter-spacing: -0.03em; margin: 0 0 8px 0; color: #0f172a;">
        Formulir Pengiriman &amp; Pembayaran
      </h1>
      <p style="font-size: 14px; color: #64748b; margin: 0;">
        @if($isCart)
          Menyelesaikan pesanan sekaligus untuk <strong>{{ count($items) }} jenis produk</strong> dari keranjang belanja Anda.
        @else
          Lengkapi detail penerima dan pilih ekspedisi kurir untuk menyelesaikan pemesanan produk ini.
        @endif
      </p>
    </div>

    <!-- Main Grid -->
    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 36px; align-items: start;">
      
      <!-- KOLOM KIRI: FORMULIR INPUT DATA PEMBELI & VOUCHER -->
      <div style="background-color: #FFFFFF; padding: 32px; border-radius: 12px; border: 1px solid var(--border-light, #E2E8F0); box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        <h2 style="font-size: 18px; font-weight: 800; margin-top: 0; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 1px solid #F1F5F9; color: #0f172a; display: flex; align-items: center; justify-content: space-between;">
          <span>Data Penerima Pengiriman</span>
          @auth
            <span style="font-size: 11px; font-weight: 600; color: #059669; background: #ecfdf5; padding: 3px 8px; border-radius: 4px;">
              ✓ Data Terisi Otomatis dari Profil
            </span>
          @endauth
        </h2>

        <form id="checkoutForm" action="/checkout/proses" method="POST">
          @csrf

          @if($isCart)
            <input type="hidden" name="is_cart" value="1">
            <input type="hidden" name="checkout_mode" value="cart">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
          @else
            <input type="hidden" name="is_cart" value="0">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
          @endif

          <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px; font-size: 14px; color: #1e293b;">
              Nama Lengkap Penerima: <span style="color: #E63946;">*</span>
            </label>
            <input type="text" name="customer_name" value="{{ old('customer_name', $user?->name) }}" placeholder="Contoh: Budi Santoso" 
              style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; outline: none;" 
              required>
          </div>

          <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px; font-size: 14px; color: #1e293b;">
              Nomor WhatsApp / HP Aktif: <span style="color: #E63946;">*</span>
            </label>
            <input type="text" name="customer_phone" value="{{ old('customer_phone', $user?->phone) }}" placeholder="Contoh: 081234567890" 
              style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; outline: none;" 
              required>
          </div>

          <div style="margin-bottom: 24px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px; font-size: 14px; color: #1e293b;">
              Alamat Lengkap Pengiriman: <span style="color: #E63946;">*</span>
            </label>
            <textarea name="customer_address" rows="3" placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, dan kota..." 
              style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; outline: none; font-family: inherit; line-height: 1.5; resize: vertical;" 
              required>{{ old('customer_address', $user?->address) }}</textarea>
          </div>

          <div style="display: grid; grid-template-columns: {{ $isCart ? '1fr' : '2fr 1fr' }}; gap: 16px; margin-bottom: 24px;">
            <div>
              <label style="font-weight: 600; display: block; margin-bottom: 8px; font-size: 14px; color: #1e293b;">
                Pilih Ekspedisi Kurir: <span style="color: #E63946;">*</span>
              </label>
              <select id="courierSelect" name="courier" onchange="updateLiveCalculation()" 
                style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 8px; background: white; font-size: 14px; outline: none; cursor: pointer;" 
                required>
                <option value="JNE Reguler" data-cost="15000">JNE Reguler (Ongkir Rp 15.000)</option>
                <option value="J&T Express" data-cost="20000">J&T Express (Ongkir Rp 20.000)</option>
                <option value="SiCepat BEST" data-cost="25000">SiCepat BEST (Ongkir Rp 25.000)</option>
              </select>
            </div>
            
            @if(!$isCart)
            <div>
              <label style="font-weight: 600; display: block; margin-bottom: 8px; font-size: 14px; color: #1e293b;">
                Jumlah Beli (Qty): <span style="color: #E63946;">*</span>
              </label>
              <input type="number" id="qtyInput" name="quantity" value="1" min="1" max="{{ $product->stock ?: 99 }}" onchange="updateLiveCalculation()" onkeyup="updateLiveCalculation()" 
                style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; outline: none;" 
                required>
            </div>
            @endif
          </div>

          <!-- FITUR INOVASI P12: KODE VOUCHER DISKON SAAT CHECKOUT -->
          <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px; padding: 20px; margin-bottom: 28px;">
            <label style="font-weight: 700; display: block; margin-bottom: 6px; font-size: 14px; color: #0f172a;">
              🏷️ Punya Kode Voucher Diskon?
            </label>
            <p style="font-size: 12px; color: #64748b; margin: 0 0 12px 0;">
              Masukkan kode diskon untuk mendapatkan potongan harga langsung (Coba: <strong>VOVOIHEMAT</strong> atau <strong>DISKON10</strong>).
            </p>
            <div style="display: flex; gap: 8px;">
              <input type="text" id="voucherInput" name="voucher_code" placeholder="Ketik kode promo (misal: VOVOIHEMAT)" 
                style="flex: 1; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; text-transform: uppercase; font-family: monospace; font-weight: 700; outline: none;">
              <button type="button" onclick="checkVoucherCode()" style="background-color: #0f172a; color: #ffffff; border: none; padding: 11px 20px; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer;">
                Gunakan
              </button>
            </div>
            <div id="voucherFeedback" style="display: none; font-size: 12px; font-weight: 600; margin-top: 8px;"></div>
          </div>

          <button type="submit" 
            style="background-color: #FFC107; color: #000000; padding: 16px 24px; width: 100%; border: none; border-radius: 8px; font-weight: 800; font-size: 16px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);">
            Konfirmasi &amp; Buat Pesanan Sekarang &rarr;
          </button>
        </form>
      </div>

      <!-- KOLOM KANAN: RINGKASAN PRODUK YANG DIPILIH -->
      <div style="background-color: #FFFFFF; padding: 28px; border-radius: 12px; border: 1px solid var(--border-light, #E2E8F0); box-shadow: 0 2px 10px rgba(0,0,0,0.02); position: sticky; top: 96px;">
        <h3 style="margin-top: 0; border-bottom: 1px solid #F1F5F9; padding-bottom: 12px; font-size: 17px; font-weight: 800; color: #0f172a;">
          Ringkasan Pesanan ({{ count($items) }} Produk)
        </h3>

        <!-- Daftar Produk -->
        <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 20px; max-height: 260px; overflow-y: auto; padding-right: 4px;">
          @foreach($items as $item)
            <div style="display: flex; gap: 12px; align-items: center; border-bottom: 1px solid #f8fafc; padding-bottom: 12px;">
              <div style="width: 50px; height: 50px; background: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; flex-shrink: 0; padding: 4px;">
                @if(!empty($item['image']))
                  <img src="{{ asset('assets/images/' . $item['image']) }}" alt="{{ $item['name'] }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @else
                  <img src="{{ asset('assets/images/phone-x-pro.svg') }}" alt="{{ $item['name'] }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                @endif
              </div>
              <div style="flex: 1;">
                <div style="font-size: 13px; font-weight: 700; color: #0f172a; line-height: 1.3;">{{ $item['name'] }}</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                  {{ $item['quantity'] }}x &bull; Rp {{ number_format($item['price'], 0, ',', '.') }}
                </div>
              </div>
              <div style="font-size: 13px; font-weight: 700; color: #0f172a; text-align: right;">
                Rp {{ number_format($item['subtotal'] ?? ($item['price'] * $item['quantity']), 0, ',', '.') }}
              </div>
            </div>
          @endforeach
        </div>

        <!-- Live Estimate Breakdown -->
        <div style="background: #F8FAFC; border-radius: 8px; padding: 16px; margin-bottom: 16px; font-size: 13px;">
          <div style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #64748B;">
            <span>Subtotal Produk:</span>
            <span id="calcSubtotal" style="font-weight: 600; color: #1E293B;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
          </div>

          <div style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #64748B;">
            <span>Ongkos Kirim:</span>
            <span id="calcShipping" style="font-weight: 600; color: #1E293B;">Rp 15.000</span>
          </div>

          <div id="voucherRow" style="display: none; justify-content: space-between; margin-bottom: 8px; color: #059669; font-weight: 600;">
            <span>Potongan Voucher:</span>
            <span id="calcDiscount">- Rp 0</span>
          </div>

          <hr style="margin: 12px 0; border: 0; border-top: 1px dashed #CBD5E1;">

          <div style="display: flex; justify-content: space-between; align-items: baseline;">
            <span style="font-size: 14px; font-weight: 800; color: #0F172A;">Total Tagihan:</span>
            <span id="calcTotal" style="color: #E63946; font-size: 20px; font-weight: 800; letter-spacing: -0.02em;">
              Rp {{ number_format($subtotal + 15000, 0, ',', '.') }}
            </span>
          </div>
        </div>

        <p style="font-size: 12px; color: #64748b; line-height: 1.5; margin: 0;">
          *Semua transaksi tersinkronisasi otomatis dengan gudang resmi VOVOI dan dilindungi garansi produk asli.
        </p>
      </div>

    </div>

  </div>
</section>
@endsection

@section('extra_js')
<script>
  const isCart = {{ $isCart ? 'true' : 'false' }};
  const initialSubtotal = {{ $subtotal }};
  const unitPrice = {{ $isCart ? 0 : $product->price }};
  let discountValue = 0;

  function updateLiveCalculation() {
    const courierSelect = document.getElementById('courierSelect');
    let subtotal = initialSubtotal;

    if (!isCart) {
      const qtyInput = document.getElementById('qtyInput');
      let qty = parseInt(qtyInput.value) || 1;
      if (qty < 1) qty = 1;
      subtotal = unitPrice * qty;
    }

    let shippingCost = 15000;
    if (courierSelect.value === 'J&T Express') {
      shippingCost = 20000;
    } else if (courierSelect.value === 'SiCepat BEST') {
      shippingCost = 25000;
    }

    const total = Math.max(0, subtotal + shippingCost - discountValue);

    document.getElementById('calcSubtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('calcShipping').innerText = 'Rp ' + shippingCost.toLocaleString('id-ID');
    document.getElementById('calcTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
  }

  function checkVoucherCode() {
    const code = document.getElementById('voucherInput').value.trim();
    const feedback = document.getElementById('voucherFeedback');

    if (!code) {
      feedback.style.display = 'block';
      feedback.style.color = '#dc2626';
      feedback.innerText = 'Silakan ketikkan kode voucher terlebih dahulu.';
      return;
    }

    fetch('{{ route("voucher.check") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        code: code,
        subtotal: initialSubtotal
      })
    })
    .then(res => res.json())
    .then(data => {
      feedback.style.display = 'block';
      if (data.valid) {
        discountValue = data.discount;
        feedback.style.color = '#059669';
        feedback.innerText = '✓ ' + data.message;
        document.getElementById('voucherRow').style.display = 'flex';
        document.getElementById('calcDiscount').innerText = '- Rp ' + discountValue.toLocaleString('id-ID');
      } else {
        discountValue = 0;
        feedback.style.color = '#dc2626';
        feedback.innerText = '✕ ' + data.message;
        document.getElementById('voucherRow').style.display = 'none';
      }
      updateLiveCalculation();
    })
    .catch(err => {
      // Fallback local check
      const upper = code.toUpperCase();
      if (upper === 'VOVOIHEMAT') {
        discountValue = 50000;
        feedback.style.display = 'block';
        feedback.style.color = '#059669';
        feedback.innerText = '✓ Kupon berhasil digunakan! Potongan Rp 50.000';
        document.getElementById('voucherRow').style.display = 'flex';
        document.getElementById('calcDiscount').innerText = '- Rp 50.000';
      } else if (upper === 'VOVOI' || upper === 'VOVOI500') {
        discountValue = 500000;
        feedback.style.display = 'block';
        feedback.style.color = '#059669';
        feedback.innerText = '✓ Kupon berhasil! Potongan Rp 500.000';
        document.getElementById('voucherRow').style.display = 'flex';
        document.getElementById('calcDiscount').innerText = '- Rp 500.000';
      } else {
        discountValue = 0;
        feedback.style.display = 'block';
        feedback.style.color = '#dc2626';
        feedback.innerText = '✕ Kode voucher tidak valid.';
        document.getElementById('voucherRow').style.display = 'none';
      }
      updateLiveCalculation();
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    updateLiveCalculation();
  });
</script>
@endsection
