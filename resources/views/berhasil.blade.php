@extends('layouts.master')

@section('title', 'E-Invoice ' . $transaction->invoice_code . ' - VOVOI')

@section('extra_css')
<style>
  .invoice-card {
    background: #FFFFFF;
    border: 1px solid var(--border-light, #E2E8F0);
    border-radius: 16px;
    box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
    padding: 40px;
    position: relative;
    overflow: hidden;
  }

  .invoice-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #0B5ED7 0%, #10B981 100%);
  }

  .receipt-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    background: #F8FAFC;
    border: 1px solid var(--border-light, #E2E8F0);
    border-radius: 10px;
    padding: 18px 22px;
    margin-bottom: 24px;
  }

  .receipt-detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .receipt-detail-label {
    font-family: monospace;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.06em;
    color: var(--text-muted, #94A3B8);
    text-transform: uppercase;
  }

  .receipt-detail-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary, #0F172A);
  }

  .copy-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #FFFFFF;
    border: 1px solid var(--border-medium, #CBD5E1);
    border-radius: 6px;
    padding: 3px 8px;
    font-family: monospace;
    font-size: 11px;
    font-weight: 600;
    color: var(--text-secondary, #64748B);
    cursor: pointer;
  }

  .order-breakdown-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 24px;
    font-size: 14px;
  }

  .order-breakdown-table td {
    padding: 10px 0;
    border-bottom: 1px solid var(--border-light, #E2E8F0);
  }

  /* MEDIA PRINT: E-INVOICE CETAK BERSIH (FITUR INOVASI P12) */
  @media print {
    .store-header,
    .store-footer,
    .no-print,
    .action-buttons-box,
    .review-section-box,
    .cancel-order-box,
    nav,
    button,
    a.v-btn {
      display: none !important;
    }

    body {
      background: #FFFFFF !important;
      color: #000000 !important;
      padding: 0 !important;
    }

    .store-main {
      padding: 0 !important;
      margin: 0 !important;
      max-width: 100% !important;
    }

    .invoice-card {
      box-shadow: none !important;
      border: 1px solid #94A3B8 !important;
      padding: 24px !important;
      border-radius: 0 !important;
    }
  }
</style>
@endsection

@section('konten_utama')
<section style="padding: 24px 0 80px;">
  <div style="max-width: 820px; margin: 0 auto;">

    <!-- 1. Breadcrumb Navigation -->
    <nav class="no-print" style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748b; margin-bottom: 24px;">
      <a href="/" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Beranda</a>
      <span>&rsaquo;</span>
      <a href="/katalog" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Katalog</a>
      <span>&rsaquo;</span>
      <span style="color: #0f172a; font-weight: 700;">E-Invoice #{{ $transaction->invoice_code }}</span>
    </nav>

    <!-- Flash Alert -->
    @if(session('success'))
      <div class="no-print" style="background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; color: #065F46; font-size: 14px; font-weight: 600;">
        ✅ {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="no-print" style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; color: #991B1B; font-size: 14px; font-weight: 600;">
        ⚠️ {{ session('error') }}
      </div>
    @endif

    <!-- 2. Header Status Banner -->
    <div class="no-print" style="text-align: center; margin-bottom: 28px;">
      <div style="margin-bottom: 10px;">
        <span class="v-tag-mono green">
          <span class="v-dot-indicator green"></span>
          TRANSACTION VERIFIED &bull; OFFICIAL E-INVOICE
        </span>
      </div>

      <h1 style="font-size: 26px; font-weight: 800; letter-spacing: -0.03em; margin: 0 0 8px 0; color: #0F172A;">
        Transaksi Tercatat di Sistem VOVOI
      </h1>

      <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.5;">
        Terima kasih, <strong>{{ $transaction->customer_name }}</strong>. Pesanan Anda telah tersimpan dan siap diproses oleh gudang resmi VOVOI.
      </p>
    </div>

    <!-- 3. Digital Invoice Card (E-Invoice Cetak) -->
    <div class="invoice-card" id="printableInvoice">

      <!-- Top Header: Logo & Status Badge -->
      <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; padding-bottom: 20px; border-bottom: 1px solid var(--border-light, #E2E8F0); margin-bottom: 20px;">
        <div>
          <div style="font-size: 24px; font-weight: 800; letter-spacing: -0.04em; color: #0F172A; line-height: 1;">
            VOVOI
          </div>
          <div style="font-family: monospace; font-size: 11px; letter-spacing: 0.1em; color: #64748B; margin-top: 4px; text-transform: uppercase;">
            OFFICIAL DIGITAL INVOICE &bull; GARANSI RESMI
          </div>
        </div>

        <div>
          @if($transaction->status == 'Pending')
            <span style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
              <span>⏳</span> Pending (Menunggu Konfirmasi Seller)
            </span>
          @elseif($transaction->status == 'Paid')
            <span style="background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
              <span>💳</span> Paid (Lunas - Sedang Dikemas)
            </span>
          @elseif($transaction->status == 'Shipped')
            <span style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
              <span>🚚</span> Shipped (Pesanan Sedang Dikirim)
            </span>
          @elseif($transaction->status == 'Cancelled')
            <span style="background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
              <span>❌</span> Cancelled (Pesanan Dibatalkan)
            </span>
          @else
            <span class="v-tag-mono">
              {{ $transaction->status }}
            </span>
          @endif
        </div>
      </div>

      <!-- Quick Metadata Grid -->
      <div class="receipt-meta-grid">
        <div class="receipt-detail-item">
          <span class="receipt-detail-label">Nomor Invoice</span>
          <div style="display: flex; align-items: center; gap: 8px;">
            <span class="receipt-detail-value" style="font-family: monospace; color: #0B5ED7;">
              {{ $transaction->invoice_code }}
            </span>
            <button type="button" class="copy-btn no-print" onclick="copyInvoice('{{ $transaction->invoice_code }}')" title="Salin Kode Invoice">
              <span id="copyText">Salin</span>
            </button>
          </div>
        </div>

        <div class="receipt-detail-item">
          <span class="receipt-detail-label">Waktu Transaksi</span>
          <span class="receipt-detail-value" style="font-family: monospace;">
            {{ $transaction->created_at ? $transaction->created_at->format('d M Y, H:i') : '-' }} WIB
          </span>
        </div>

        <div class="receipt-detail-item">
          <span class="receipt-detail-label">Layanan Ekspedisi</span>
          <span class="receipt-detail-value">
            🚚 {{ $transaction->courier }}
          </span>
          @if($transaction->tracking_number)
            <div style="font-family: monospace; font-size: 12px; color: #047857; font-weight: 800; background: #ecfdf5; padding: 2px 6px; border-radius: 4px; border: 1px solid #a7f3d0; margin-top: 4px; display: inline-block;">
              Resi: {{ $transaction->tracking_number }}
            </div>
          @endif
        </div>
      </div>

      <!-- Customer & Shipping Information -->
      <div style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: 10px; padding: 18px 22px; margin-bottom: 20px;">
        <div style="font-family: monospace; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; color: #64748B; text-transform: uppercase; margin-bottom: 10px;">
          TUJUAN PENGIRIMAN
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
          <div>
            <div style="font-size: 15px; font-weight: 700; color: #0F172A; margin-bottom: 4px;">
              {{ $transaction->customer_name }}
            </div>
            <div style="font-size: 13px; color: #64748B;">
              📞 {{ $transaction->customer_phone }}
            </div>
          </div>

          <div>
            <div style="font-size: 13px; color: #0F172A; line-height: 1.5;">
              📍 {{ $transaction->customer_address }}
            </div>
          </div>
        </div>
      </div>

      <!-- Item Details Table (Multi-Product or Single Product) -->
      <div style="border: 1px solid var(--border-light, #E2E8F0); border-radius: 10px; overflow: hidden; margin-bottom: 24px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
          <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left; color: #475569;">
              <th style="padding: 12px 16px;">Produk Dipesan</th>
              <th style="padding: 12px 16px; text-align: center;">Qty</th>
              <th style="padding: 12px 16px; text-align: right;">Harga Satuan</th>
              <th style="padding: 12px 16px; text-align: right;">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @if($transaction->items && $transaction->items->count() > 0)
              @foreach($transaction->items as $item)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                  <td style="padding: 12px 16px; font-weight: 700; color: #0f172a;">
                    {{ $item->product_name }}
                  </td>
                  <td style="padding: 12px 16px; text-align: center;">
                    {{ $item->quantity }}x
                  </td>
                  <td style="padding: 12px 16px; text-align: right;">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                  </td>
                  <td style="padding: 12px 16px; text-align: right; font-weight: 700;">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td style="padding: 12px 16px; font-weight: 700; color: #0f172a;">
                  {{ $transaction->product_name }}
                </td>
                <td style="padding: 12px 16px; text-align: center;">
                  {{ $transaction->quantity }}x
                </td>
                <td style="padding: 12px 16px; text-align: right;">
                  Rp {{ number_format(($transaction->total_amount - $transaction->shipping_cost + $transaction->discount_amount) / max(1, $transaction->quantity), 0, ',', '.') }}
                </td>
                <td style="padding: 12px 16px; text-align: right; font-weight: 700;">
                  Rp {{ number_format($transaction->total_amount - $transaction->shipping_cost + $transaction->discount_amount, 0, ',', '.') }}
                </td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>

      <!-- Payment Breakdown Table -->
      <table class="order-breakdown-table">
        <tbody>
          <tr>
            <td style="color: #64748B;">Subtotal Produk:</td>
            <td style="text-align: right; font-weight: 600; color: #0F172A;">
              Rp {{ number_format($transaction->total_amount - $transaction->shipping_cost + $transaction->discount_amount, 0, ',', '.') }}
            </td>
          </tr>
          <tr>
            <td style="color: #64748B;">Ongkos Kirim ({{ $transaction->courier }}):</td>
            <td style="text-align: right; font-weight: 600; color: #0F172A;">
              Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}
            </td>
          </tr>

          @if($transaction->discount_amount > 0)
          <tr>
            <td style="color: #059669; font-weight: 600;">
              🏷️ Diskon Voucher ({{ $transaction->voucher_code ?: 'PROMO' }}):
            </td>
            <td style="text-align: right; font-weight: 700; color: #059669;">
              - Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}
            </td>
          </tr>
          @endif

          <tr style="border-top: 2px solid #0F172A;">
            <td style="padding-top: 14px; font-size: 15px; font-weight: 800; color: #0F172A;">
              TOTAL PEMBAYARAN:
            </td>
            <td style="padding-top: 14px; text-align: right; font-size: 22px; font-weight: 800; color: #0F172A;">
              Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
            </td>
          </tr>
        </tbody>
      </table>

      <!-- VOVOI Digital Warranty Note -->
      <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; font-size: 12px; color: #475569; line-height: 1.5;">
        🔒 <strong>Garansi Resmi VOVOI Care:</strong> Simpan E-Invoice ini sebagai bukti registrasi garansi resmi pabrik. Klaim unit dapat dilakukan di seluruh jaringan authorized service center dengan menunjukkan nomor invoice <strong>{{ $transaction->invoice_code }}</strong>.
      </div>

      <!-- FITUR INOVASI P12: PEMBATALAN PESANAN OLEH PEMBELI SELAMA STATUS PENDING -->
      @if($transaction->status === 'Pending')
        <div class="no-print cancel-order-box" style="margin-top: 24px; padding: 18px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
          <div>
            <strong style="color: #92400e; font-size: 14px; display: block;">Ingin membatalkan pesanan ini?</strong>
            <span style="font-size: 12px; color: #b45309;">Pesanan dapat dibatalkan selama status masih Pending. Stok barang akan otomatis dikembalikan.</span>
          </div>
          <form action="{{ route('order.cancel', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan {{ $transaction->invoice_code }}? Stok barang akan dikembalikan ke etalase.');" style="margin: 0;">
            @csrf
            <button type="submit" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 9px 16px; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer;">
              ✕ Batalkan Pesanan Ini
            </button>
          </form>
        </div>
      @endif

      <!-- FITUR INOVASI P12: ULASAN & RATING BINTANG 1-5 OLEH PEMBELI (JIKA SHIPPED) -->
      @if($transaction->status === 'Shipped')
        <div class="no-print review-section-box" style="margin-top: 28px; padding: 24px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px;">
          <h3 style="margin-top: 0; margin-bottom: 6px; font-size: 16px; font-weight: 800; color: #166534;">
            ⭐ Berikan Ulasan &amp; Rating Produk
          </h3>
          <p style="margin: 0 0 16px 0; font-size: 13px; color: #15803d;">
            Pesanan Anda telah dikirim! Bantu calon pembeli lain dengan memberikan penilaian pengalaman Anda.
          </p>

          @php
            $existingReview = $transaction->reviews->first();
          @endphp

          @if($existingReview)
            <div style="background: white; border: 1px solid #86efac; border-radius: 8px; padding: 16px;">
              <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                <span style="font-size: 13px; font-weight: 700; color: #166534;">✓ Ulasan Anda Telah Terkirim</span>
                <span style="color: #f59e0b; font-size: 16px;">
                  @for($i=1; $i<=5; $i++)
                    {{ $i <= $existingReview->rating ? '★' : '☆' }}
                  @endfor
                </span>
              </div>
              <p style="margin: 0; font-size: 14px; color: #334155;">
                "{{ $existingReview->comment }}"
              </p>
            </div>
          @else
            <form action="{{ route('reviews.store') }}" method="POST">
              @csrf
              <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
              <input type="hidden" name="product_id" value="{{ $transaction->product_id }}">

              <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #166534; margin-bottom: 6px;">
                  Pilih Rating Bintang:
                </label>
                <div style="display: flex; gap: 14px; align-items: center;">
                  @for($star = 5; $star >= 1; $star--)
                    <label style="display: flex; align-items: center; gap: 4px; font-size: 14px; font-weight: 700; color: #f59e0b; cursor: pointer;">
                      <input type="radio" name="rating" value="{{ $star }}" {{ $star == 5 ? 'checked' : '' }}>
                      {{ $star }} ★
                    </label>
                  @endfor
                </div>
              </div>

              <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #166534; margin-bottom: 6px;">
                  Tulis Ulasan &amp; Pengalaman Produk:
                </label>
                <textarea name="comment" rows="3" placeholder="Ceritakan kepuasan Anda mengenai performa barang, kecepatan pengiriman, dan layanan VOVOI..." required style="width: 100%; box-sizing: border-box; padding: 10px 14px; border: 1px solid #86efac; border-radius: 8px; font-size: 13px; font-family: inherit;"></textarea>
              </div>

              <button type="submit" style="background: #16a34a; color: white; border: none; padding: 10px 22px; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer;">
                Kirim Ulasan Bintang &rarr;
              </button>
            </form>
          @endif
        </div>
      @endif

      <!-- FITUR INOVASI P12: TOMBOL AKSI CETAK E-INVOICE & KEMBALI (HIDDEN SAAT PRINT) -->
      <div class="no-print action-buttons-box" style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-light, #E2E8F0);">
        <a href="/" class="v-btn v-btn-primary">
          Kembali ke Beranda
        </a>

        <!-- Tombol Cetak window.print() (Header & Tombol Tersembunyi saat Cetak) -->
        <button type="button" class="v-btn v-btn-secondary" onclick="window.print()" style="font-weight: 700; background: #0f172a; color: #ffffff; border: none;">
          🖨️ Cetak E-Invoice (Print PDF)
        </button>

        <a href="/pesanan-saya" class="v-btn v-btn-secondary">
          📦 Riwayat Pesanan Saya
        </a>

        <a href="/katalog" class="v-btn v-btn-secondary">
          Lihat Katalog Lainnya
        </a>
      </div>

    </div>

  </div>
</section>
@endsection

@section('extra_js')
<script>
  function copyInvoice(code) {
    if (navigator.clipboard) {
      navigator.clipboard.writeText(code).then(() => {
        const textSpan = document.getElementById('copyText');
        if (textSpan) {
          textSpan.textContent = 'Tersalin!';
          setTimeout(() => {
            textSpan.textContent = 'Salin';
          }, 2000);
        }
      });
    }
  }
</script>
@endsection
