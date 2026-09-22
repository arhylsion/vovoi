@extends('layouts.master')

@section('title', 'Order Confirmed - VOVOI')

@section('konten_utama')
<section style="padding: 80px 20px; min-height: 60vh; display: flex; align-items: center;">
  <div class="v-container" style="max-width: 580px; text-align: center;">
    
    <div style="width: 72px; height: 72px; background: rgba(16, 185, 129, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: #059669;">
      <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
      </svg>
    </div>

    <h1 style="font-size: 32px; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 12px;">
      Order Confirmed!
    </h1>
    <p style="font-size: 15px; color: var(--text-secondary); margin-bottom: 32px;">
      Thank you for choosing VOVOI. Your order has been placed and is currently being prepared for dispatch.
    </p>

    <!-- Order Metadata Box -->
    <div style="background: #F8F9FA; border: 1px solid var(--border-light); border-radius: var(--radius-lg); padding: 24px; margin-bottom: 36px; text-align: left;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-family: var(--font-mono); font-size: 12px;">
        <span style="color: var(--text-secondary);">INVOICE NUMBER:</span>
        <strong style="color: var(--text-primary);">INV-2026-VOV9921</strong>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-family: var(--font-mono); font-size: 12px;">
        <span style="color: var(--text-secondary);">DIGITAL SERIAL:</span>
        <span class="v-tag-mono green" style="padding: 2px 8px; font-size: 10px;">
          <span class="v-dot-indicator green"></span>
          SN-9284-AX
        </span>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; font-family: var(--font-mono); font-size: 12px;">
        <span style="color: var(--text-secondary);">ESTIMATED DELIVERY:</span>
        <span style="color: var(--text-primary); font-weight: 600;">2 - 3 Business Days</span>
      </div>
    </div>

    <!-- Actions -->
    <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
      <a href="/katalog" class="v-btn v-btn-primary">
        Continue Shopping
      </a>
      <a href="/" class="v-btn v-btn-secondary">
        Back to Home
      </a>
    </div>

  </div>
</section>
@endsection
