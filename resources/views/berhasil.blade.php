@extends('layouts.master')

@section('title', 'Transaksi Berhasil - ' . $transaction->invoice_code . ' - VOVOI')

@section('konten_utama')
<section style="padding: 48px 20px 80px; min-height: 70vh; background: #FBFBFC; display: flex; align-items: center;">
  <div class="v-container" style="max-width: 680px; margin: 0 auto; width: 100%;">
    
    <div style="background-color: #FFFFFF; padding: 40px; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);">
      
      <!-- HEADER STATUS -->
      <div style="text-align: center; border-bottom: 2px dashed #E2E8F0; padding-bottom: 24px; margin-bottom: 28px;">
        <div style="width: 64px; height: 64px; background: rgba(40, 167, 69, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 32px;">
          🎉
        </div>
        <h2 style="color: #28A745; margin: 0 0 8px 0; font-size: 26px; font-weight: 800; letter-spacing: -0.02em;">
          Transaksi Berhasil Tercatat!
        </h2>
        <p style="color: #64748B; margin: 0; font-size: 14px;">
          Terima kasih <strong>{{ $transaction->customer_name }}</strong>, pesanan Anda sedang kami proses.
        </p>
      </div>

      <!-- RINCIAN INVOICE DARI TABEL TRANSACTIONS MYSQL -->
      <table style="width: 100%; border-collapse: collapse; margin-bottom: 28px; font-size: 14px;">
        <tbody>
          <tr>
            <td style="padding: 10px 0; color: #64748B;">Nomor Resi / Invoice:</td>
            <td style="padding: 10px 0; text-align: right; font-weight: 700; color: #0B5ED7; font-family: var(--font-mono, monospace);">
              {{ $transaction->invoice_code }}
            </td>
          </tr>
          <tr>
            <td style="padding: 10px 0; color: #64748B;">Waktu Transaksi:</td>
            <td style="padding: 10px 0; text-align: right; color: #1E293B; font-weight: 500;">
              {{ $transaction->created_at->format('d M Y, H:i') }} WIB
            </td>
          </tr>
          <tr>
            <td style="padding: 10px 0; color: #64748B;">Produk yang Dibeli:</td>
            <td style="padding: 10px 0; text-align: right; font-weight: 700; color: #1E293B;">
              {{ $transaction->product_name }} ({{ $transaction->quantity }}x)
            </td>
          </tr>
          <tr>
            <td style="padding: 10px 0; color: #64748B;">Penerima &amp; No. HP:</td>
            <td style="padding: 10px 0; text-align: right; color: #1E293B;">
              {{ $transaction->customer_name }} ({{ $transaction->customer_phone }})
            </td>
          </tr>
          <tr>
            <td style="padding: 10px 0; color: #64748B; vertical-align: top;">Alamat Pengiriman:</td>
            <td style="padding: 10px 0; text-align: right; color: #1E293B; max-width: 320px; line-height: 1.4;">
              {{ $transaction->customer_address }}
            </td>
          </tr>
          <tr>
            <td style="padding: 10px 0; color: #64748B;">Ekspedisi &amp; Ongkos Kirim:</td>
            <td style="padding: 10px 0; text-align: right; color: #1E293B; font-weight: 500;">
              {{ $transaction->courier }} (Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }})
            </td>
          </tr>
          <tr>
            <td style="padding: 10px 0; color: #64748B;">Status Pesanan:</td>
            <td style="padding: 10px 0; text-align: right;">
              <span style="background-color: #FFF3CD; color: #856404; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; display: inline-block;">
                {{ $transaction->status }}
              </span>
            </td>
          </tr>
          <tr style="border-top: 2px solid #F1F5F9;">
            <td style="padding: 18px 0 0 0; font-size: 16px; font-weight: 800; color: #0F172A;">
              TOTAL PEMBAYARAN:
            </td>
            <td style="padding: 18px 0 0 0; text-align: right; font-size: 24px; font-weight: 800; color: #E63946;">
              Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
            </td>
          </tr>
        </tbody>
      </table>

      <!-- BUTTON KEMBALI KE BERANDA -->
      <div style="text-align: center; margin-top: 32px; display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
        <a href="/" style="display: inline-block; background-color: #0B5ED7; color: white; padding: 12px 28px; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; transition: background 0.2s;">
          &larr; Kembali Belanja ke Beranda
        </a>
        <a href="/katalog" style="display: inline-block; background-color: #F1F5F9; color: #1E293B; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; transition: background 0.2s;">
          Lihat Produk Lainnya
        </a>
      </div>

    </div>

  </div>
</section>
@endsection
