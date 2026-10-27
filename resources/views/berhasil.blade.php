@extends('layouts.master')

@section('title', 'Bukti Transaksi - ' . $transaction->invoice_code . ' - VOVOI')

@section('extra_css')
<style>
  .invoice-card {
    background: #FFFFFF;
    border: 1px solid var(--border-light, #E2E8F0);
    border-radius: var(--radius-xl, 24px);
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
    background: linear-gradient(90deg, #0F172A 0%, #10B981 100%);
  }

  .receipt-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    background: var(--bg-secondary, #F8F9FA);
    border: 1px solid var(--border-light, #E2E8F0);
    border-radius: var(--radius-md, 12px);
    padding: 20px 24px;
    margin-bottom: 28px;
  }

  .receipt-detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .receipt-detail-label {
    font-family: var(--font-mono, monospace);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.06em;
    color: var(--text-muted, #94A3B8);
    text-transform: uppercase;
  }

  .receipt-detail-value {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary, #0F172A);
  }

  .copy-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #FFFFFF;
    border: 1px solid var(--border-medium, #CBD5E1);
    border-radius: var(--radius-sm, 6px);
    padding: 3px 8px;
    font-family: var(--font-mono, monospace);
    font-size: 11px;
    font-weight: 600;
    color: var(--text-secondary, #64748B);
    cursor: pointer;
    transition: all var(--transition-fast, 0.15s ease);
  }

  .copy-btn:hover {
    border-color: var(--text-primary, #0F172A);
    color: var(--text-primary, #0F172A);
    background: var(--bg-tertiary, #F1F3F5);
  }

  .order-breakdown-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 24px;
    font-size: 14px;
  }

  .order-breakdown-table td {
    padding: 12px 0;
    border-bottom: 1px solid var(--border-light, #E2E8F0);
  }

  .order-breakdown-table tr:last-child td {
    border-bottom: none;
  }

  @media print {
    .v-navbar, .v-footer, .no-print, .v-breadcrumb {
      display: none !important;
    }
    body {
      background: #FFFFFF !important;
    }
    .invoice-card {
      box-shadow: none !important;
      border: 1px solid #CBD5E1 !important;
      padding: 24px !important;
    }
    section {
      padding: 0 !important;
    }
  }
</style>
@endsection

@section('konten_utama')
<section style="padding: 40px 20px 80px; background: #FBFBFC; min-height: 85vh;">
  <div class="v-container" style="max-width: 780px;">

    <!-- 1. Breadcrumb Navigation -->
    <nav class="v-breadcrumb no-print" style="display: flex; align-items: center; gap: 8px; font-family: var(--font-mono, monospace); font-size: 12px; color: var(--text-muted, #94A3B8); margin-bottom: 28px;">
      <a href="/" style="color: var(--text-secondary, #64748B); text-decoration: none;">Beranda</a>
      <span>&rsaquo;</span>
      <a href="/katalog" style="color: var(--text-secondary, #64748B); text-decoration: none;">Katalog</a>
      <span>&rsaquo;</span>
      <span style="color: var(--text-primary, #0F172A); font-weight: 700;">Invoice #{{ $transaction->invoice_code }}</span>
    </nav>

    <!-- 2. Header Status Banner -->
    <div style="text-align: center; margin-bottom: 32px;">
      <div style="margin-bottom: 14px;">
        <span class="v-tag-mono green">
          <span class="v-dot-indicator green"></span>
          TRANSACTION VERIFIED • ORDER DISPATCH QUEUED
        </span>
      </div>

      <h1 style="font-size: clamp(26px, 4vw, 34px); font-weight: 800; letter-spacing: -0.03em; margin: 0 0 10px 0; color: var(--text-primary, #0F172A);">
        Transaksi Berhasil Tercatat
      </h1>

      <p style="font-size: 15px; color: var(--text-secondary, #64748B); margin: 0; line-height: 1.6;">
        Terima kasih, <strong>{{ $transaction->customer_name }}</strong>. Pesanan Anda telah tersinkronisasi dengan sistem gudang pusat VOVOI.
      </p>
    </div>

    <!-- 3. Digital Invoice Card (VOVOI Key Design) -->
    <div class="invoice-card">

      <!-- Top Header: Logo & Status Badge -->
      <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; padding-bottom: 24px; border-bottom: 1px solid var(--border-light, #E2E8F0); margin-bottom: 24px;">
        <div>
          <div style="font-size: 22px; font-weight: 800; letter-spacing: -0.04em; color: var(--text-primary, #0F172A); line-height: 1;">
            VOVOI
          </div>
          <div style="font-family: var(--font-mono, monospace); font-size: 11px; letter-spacing: 0.1em; color: var(--text-muted, #94A3B8); margin-top: 4px; text-transform: uppercase;">
            OFFICIAL DIGITAL INVOICE
          </div>
        </div>

        <div>
          @if($transaction->status == 'Pending')
            <span style="background: rgba(245, 158, 11, 0.1); color: #B45309; border: 1px solid rgba(245, 158, 11, 0.25); padding: 6px 14px; border-radius: var(--radius-full, 9999px); font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; font-family: var(--font-mono, monospace);">
              <span>⏳</span> Pending (Menunggu Konfirmasi Admin)
            </span>
          @elseif($transaction->status == 'Paid')
            <span style="background: rgba(37, 99, 235, 0.08); color: #1D4ED8; border: 1px solid rgba(37, 99, 235, 0.25); padding: 6px 14px; border-radius: var(--radius-full, 9999px); font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; font-family: var(--font-mono, monospace);">
              <span>💳</span> Paid (Pembayaran Lunas - Sedang Dikemas)
            </span>
          @elseif($transaction->status == 'Shipped')
            <span style="background: rgba(16, 185, 129, 0.1); color: #047857; border: 1px solid rgba(16, 185, 129, 0.25); padding: 6px 14px; border-radius: var(--radius-full, 9999px); font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; font-family: var(--font-mono, monospace);">
              <span>🚚</span> Shipped (Pesanan Sedang Dikirim Kurir)
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
            <span class="receipt-detail-value" style="font-family: var(--font-mono, monospace); font-weight: 700; color: #0F172A;">
              {{ $transaction->invoice_code }}
            </span>
            <button type="button" class="copy-btn no-print" onclick="copyInvoice('{{ $transaction->invoice_code }}')" title="Salin Kode Invoice">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
              </svg>
              <span id="copyText">Salin</span>
            </button>
          </div>
        </div>

        <div class="receipt-detail-item">
          <span class="receipt-detail-label">Waktu Transaksi</span>
          <span class="receipt-detail-value" style="font-family: var(--font-mono, monospace);">
            {{ $transaction->created_at->format('d M Y, H:i') }} WIB
          </span>
        </div>

        <div class="receipt-detail-item">
          <span class="receipt-detail-label">Layanan Ekspedisi</span>
          <span class="receipt-detail-value" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-secondary, #64748B);">
              <rect x="1" y="3" width="15" height="13"></rect>
              <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
              <circle cx="5.5" cy="18.5" r="2.5"></circle>
              <circle cx="18.5" cy="18.5" r="2.5"></circle>
            </svg>
            {{ $transaction->courier }}
          </span>
        </div>
      </div>

      <!-- Customer & Shipping Information -->
      <div style="background: #FFFFFF; border: 1px solid var(--border-light, #E2E8F0); border-radius: var(--radius-md, 12px); padding: 20px 24px; margin-bottom: 24px;">
        <div style="font-family: var(--font-mono, monospace); font-size: 11px; font-weight: 700; letter-spacing: 0.08em; color: var(--text-muted, #94A3B8); text-transform: uppercase; margin-bottom: 12px;">
          TUJUAN PENGIRIMAN
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
          <div>
            <div style="font-size: 15px; font-weight: 700; color: var(--text-primary, #0F172A); margin-bottom: 4px;">
              {{ $transaction->customer_name }}
            </div>
            <div style="font-size: 13px; color: var(--text-secondary, #64748B); display: flex; align-items: center; gap: 6px;">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
              </svg>
              {{ $transaction->customer_phone }}
            </div>
          </div>

          <div>
            <div style="font-size: 13px; color: var(--text-primary, #0F172A); line-height: 1.5; display: flex; align-items: flex-start; gap: 8px;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-secondary, #64748B); flex-shrink: 0; margin-top: 2px;">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
              </svg>
              <span>{{ $transaction->customer_address }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Purchased Item Summary Box -->
      <div style="border: 1px solid var(--border-light, #E2E8F0); border-radius: var(--radius-md, 12px); padding: 20px 24px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
          <div style="font-family: var(--font-mono, monospace); font-size: 10px; font-weight: 700; letter-spacing: 0.08em; color: var(--text-muted, #94A3B8); text-transform: uppercase; margin-bottom: 4px;">
            PRODUK DIPESAN
          </div>
          <div style="font-size: 16px; font-weight: 700; color: var(--text-primary, #0F172A);">
            {{ $transaction->product_name }}
          </div>
          <div style="font-size: 13px; color: var(--text-secondary, #64748B); margin-top: 2px;">
            Kuantitas: <strong>{{ $transaction->quantity }}x</strong> unit
          </div>
        </div>

        <div style="text-align: right;">
          <span class="v-tag-mono green">
            <span class="v-dot-indicator green"></span>
            ALLOCATED IN STOCK
          </span>
        </div>
      </div>

      <!-- VOVOI Digital Warranty Card (Embedded) -->
      <div class="v-warranty-box" style="margin-bottom: 28px;">
        <div class="v-warranty-header">
          <div class="v-warranty-title">VOVOI OFFICIAL DIGITAL WARRANTY</div>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #94A3B8;">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            <polyline points="9 12 11 14 15 10"></polyline>
          </svg>
        </div>

        <div class="v-warranty-row">
          <span class="v-warranty-label">DEVICE HARDWARE</span>
          <span class="v-warranty-val">{{ $transaction->product_name }}</span>
        </div>

        <div class="v-warranty-row">
          <span class="v-warranty-label">SECURITY SERIAL</span>
          <span class="v-warranty-val">SN-{{ strtoupper(substr(md5($transaction->invoice_code), 0, 8)) }}-VO</span>
        </div>

        <div class="v-warranty-row" style="margin-bottom: 0;">
          <span class="v-warranty-label">COVERAGE LEVEL</span>
          <span class="v-warranty-val green">2 Years VOVOI Official Care (Active)</span>
        </div>

        <div class="v-warranty-note">
          Garansi resmi VOVOI ini telah teregistrasi secara otomatis di sistem cloud. Klaim garansi hardware, layanan tukar unit, atau servis gratis dapat dilakukan di seluruh Authorized Experience Store.
        </div>
      </div>

      <!-- Payment Breakdown Table -->
      <table class="order-breakdown-table">
        <tbody>
          <tr>
            <td style="color: var(--text-secondary, #64748B);">Subtotal Produk:</td>
            <td style="text-align: right; font-weight: 600; color: var(--text-primary, #0F172A);">
              Rp {{ number_format($transaction->total_amount - $transaction->shipping_cost, 0, ',', '.') }}
            </td>
          </tr>
          <tr>
            <td style="color: var(--text-secondary, #64748B);">
              Ongkos Kirim ({{ $transaction->courier }}):
            </td>
            <td style="text-align: right; font-weight: 600; color: var(--text-primary, #0F172A);">
              Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}
            </td>
          </tr>
          <tr style="border-top: 2px solid var(--text-primary, #0F172A);">
            <td style="padding-top: 16px; font-size: 15px; font-weight: 800; color: var(--text-primary, #0F172A); letter-spacing: -0.01em;">
              TOTAL PEMBAYARAN:
            </td>
            <td style="padding-top: 16px; text-align: right; font-size: 22px; font-weight: 800; color: var(--text-primary, #0F172A); letter-spacing: -0.02em;">
              Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Bottom Interactive Action Buttons -->
      <div class="no-print" style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-light, #E2E8F0);">
        <a href="/" class="v-btn v-btn-primary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
          </svg>
          Kembali ke Beranda
        </a>

        <button type="button" class="v-btn v-btn-secondary" onclick="window.print()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
          </svg>
          Cetak Bukti Transaksi
        </button>

        <a href="/katalog" class="v-btn v-btn-secondary">
          Lihat Produk Lainnya
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