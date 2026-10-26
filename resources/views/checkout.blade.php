@extends('layouts.master')

@section('title', 'Checkout Pesanan - ' . $product->name . ' - VOVOI')

@section('konten_utama')
<section style="padding: 32px 0 80px; background: #FBFBFC;">
  <div class="v-container">
    
    <!-- 1. Navigasi Breadcrumb Checkout -->
    <nav style="display: flex; align-items: center; gap: 8px; font-family: var(--font-mono, monospace); font-size: 13px; color: var(--text-muted, #666); margin-bottom: 28px;">
      <a href="/" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Katalog Utama</a>
      <span style="color: #999;">/</span>
      <a href="/detail/{{ $product->id }}" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">{{ $product->name }}</a>
      <span style="color: #999;">/</span>
      <span style="color: #111; font-weight: 700;">Checkout Pesanan</span>
    </nav>

    <div style="margin-bottom: 32px;">
      <h1 style="font-size: 32px; font-weight: 800; letter-spacing: -0.03em; margin: 0 0 8px 0; color: #111;">
        Formulir Pengiriman &amp; Pembayaran
      </h1>
      <p style="font-size: 14px; color: #666; margin: 0;">
        Lengkapi detail penerima dan pilih ekspedisi kurir untuk menyelesaikan pesanan Anda.
      </p>
    </div>

    <!-- Main Grid -->
    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 36px; align-items: start;">
      
      <!-- KOLOM KIRI: FORMULIR INPUT DATA PEMBELI -->
      <div style="background-color: #FFFFFF; padding: 32px; border-radius: 12px; border: 1px solid var(--border-light, #E2E8F0); box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
        <h2 style="font-size: 20px; font-weight: 700; margin-top: 0; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 1px solid #F1F5F9; color: #111;">
          Data Pengiriman Penerima
        </h2>

        <!-- PENTING: Gunakan method="POST" dan arahkan action ke "/checkout/proses" -->
        <form id="checkoutForm" action="/checkout/proses" method="POST">
          <!-- WAJIB ADA: Token pengaman CSRF Laravel -->
          @csrf

          <!-- INPUT TERSEMBUNYI: Mengirimkan ID Produk yang sedang dibeli ke Controller -->
          <input type="hidden" name="product_id" value="{{ $product->id }}">

          <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px; font-size: 14px; color: #222;">
              Nama Lengkap Penerima: <span style="color: #E63946;">*</span>
            </label>
            <input type="text" name="customer_name" placeholder="Contoh: Budi Santoso" 
              style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s;" 
              required>
          </div>

          <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px; font-size: 14px; color: #222;">
              Nomor WhatsApp / HP Aktif: <span style="color: #E63946;">*</span>
            </label>
            <input type="text" name="customer_phone" placeholder="Contoh: 081234567890" 
              style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s;" 
              required>
          </div>

          <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; display: block; margin-bottom: 8px; font-size: 14px; color: #222;">
              Alamat Lengkap Pengiriman: <span style="color: #E63946;">*</span>
            </label>
            <textarea name="customer_address" rows="3" placeholder="Tuliskan Nama Jalan, RT/RW, Kecamatan, dan Kota/Kabupaten..." 
              style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; outline: none; font-family: inherit; line-height: 1.5; resize: vertical;" 
              required></textarea>
          </div>

          <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 28px;">
            <div>
              <label style="font-weight: 600; display: block; margin-bottom: 8px; font-size: 14px; color: #222;">
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
            
            <div>
              <label style="font-weight: 600; display: block; margin-bottom: 8px; font-size: 14px; color: #222;">
                Jumlah Beli (Qty): <span style="color: #E63946;">*</span>
              </label>
              <input type="number" id="qtyInput" name="quantity" value="1" min="1" max="99" onchange="updateLiveCalculation()" onkeyup="updateLiveCalculation()" 
                style="width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; outline: none;" 
                required>
            </div>
          </div>

          <button type="submit" 
            style="background-color: #FFC107; color: #000000; padding: 16px 24px; width: 100%; border: none; border-radius: 8px; font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);">
            Konfirmasi &amp; Buat Pesanan Sekarang
          </button>
        </form>
      </div>

      <!-- KOLOM KANAN: RINGKASAN PRODUK YANG DIPILIH DARI P6 -->
      <div style="background-color: #FFFFFF; padding: 28px; border-radius: 12px; border: 1px solid var(--border-light, #E2E8F0); box-shadow: 0 2px 10px rgba(0,0,0,0.03); position: sticky; top: 96px;">
        <h3 style="margin-top: 0; border-bottom: 1px solid #F1F5F9; padding-bottom: 12px; font-size: 18px; font-weight: 700; color: #111;">
          Ringkasan Pesanan
        </h3>
        
        @if($product->image)
        <div style="width: 100%; height: 180px; background: #F8F9FA; border-radius: 8px; border: 1px solid #F1F5F9; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 16px; padding: 12px;">
          <img src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
        </div>
        @endif

        <h3 style="margin: 0 0 6px 0; color: #111; font-size: 18px; font-weight: 700;">{{ $product->name }}</h3>
        
        <p style="color: #64748B; font-size: 13px; margin: 0 0 4px 0;">Harga Satuan Produk:</p>
        <h2 style="color: #E63946; margin: 0 0 16px 0; font-size: 24px; font-weight: 800;">
          Rp {{ number_format($product->price, 0, ',', '.') }}
        </h2>

        <!-- Live Estimate Breakdown -->
        <div style="background: #F8FAFC; border-radius: 8px; padding: 14px; margin-bottom: 16px; font-size: 13px;">
          <div style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #64748B;">
            <span>Subtotal (<span id="calcQty">1</span> barang):</span>
            <span id="calcSubtotal" style="font-weight: 600; color: #1E293B;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #64748B;">
            <span>Ongkos Kirim:</span>
            <span id="calcShipping" style="font-weight: 600; color: #1E293B;">Rp 15.000</span>
          </div>
          <hr style="margin: 10px 0; border: 0; border-top: 1px dashed #CBD5E1;">
          <div style="display: flex; justify-content: space-between; font-size: 14px; font-weight: 700; color: #0F172A;">
            <span>Estimasi Total:</span>
            <span id="calcTotal" style="color: #E63946; font-size: 16px;">Rp {{ number_format($product->price + 15000, 0, ',', '.') }}</span>
          </div>
        </div>

        <p style="font-size: 12px; color: #64748B; line-height: 1.5; margin: 0;">
          *Total tagihan akhir (Harga Produk dikali Jumlah Beli ditambah Ongkos Kirim) akan dihitung secara otomatis oleh sistem pada halaman Invoice setelah Anda menekan tombol Konfirmasi.
        </p>
      </div>

    </div>

  </div>
</section>
@endsection

@section('extra_js')
<script>
  const basePrice = {{ $product->price }};

  function updateLiveCalculation() {
    const qtyInput = document.getElementById('qtyInput');
    const courierSelect = document.getElementById('courierSelect');
    
    let qty = parseInt(qtyInput.value) || 1;
    if (qty < 1) qty = 1;

    let shippingCost = 15000;
    if (courierSelect.value === 'J&T Express') {
      shippingCost = 20000;
    } else if (courierSelect.value === 'SiCepat BEST') {
      shippingCost = 25000;
    }

    const subtotal = basePrice * qty;
    const total = subtotal + shippingCost;

    document.getElementById('calcQty').innerText = qty;
    document.getElementById('calcSubtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('calcShipping').innerText = 'Rp ' + shippingCost.toLocaleString('id-ID');
    document.getElementById('calcTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
  }
</script>
@endsection
