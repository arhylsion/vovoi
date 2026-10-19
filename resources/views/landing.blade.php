@extends('layouts.master')

@section('title', 'VOVOI - Meet The Ultimate VOVOI Flagship')

@section('konten_utama')
<section class="v-landing-hero" style="text-align: center; padding: 60px 20px 0; background: linear-gradient(180deg, #FFFFFF 0%, #FAFAFA 100%);">
  <div class="v-container">
    <h1 style="font-size: clamp(64px, 12vw, 120px); font-weight: 800; letter-spacing: -0.06em; line-height: 0.9; margin-bottom: 20px;">
      VOVOI
    </h1>
    <p style="font-size: clamp(18px, 3vw, 24px); font-weight: 600; color: var(--text-primary); margin-bottom: 40px; letter-spacing: -0.02em;">
      Meet The Ultimate VOVOI Flagship
    </p>

    <div style="max-width: 480px; margin: 0 auto -40px; position: relative; z-index: 1;">
      <img src="{{ asset('assets/images/hp-vovoi.png') }}" alt="VOVOI Phone X Pro Flagship" style="width: 100%; height: auto; display: block;">
    </div>
  </div>
</section>

<!-- Flagship Specs & Action Section -->
<section style="background: #F8F9FA; border-top: 1px solid var(--border-light); padding: 80px 0; position: relative; z-index: 2;">
  <div class="v-container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 48px; align-items: start;">
      
      <!-- Left: Specs & Overview -->
      <div>
        <h2 style="font-size: 32px; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 8px;">
          Vovoi Phone X Pro
        </h2>
        <p style="font-size: 15px; color: var(--text-secondary); margin-bottom: 28px;">
          Liquid Metal. So strong. So light. So Pro.
        </p>

        <hr style="border: none; border-top: 1px solid var(--border-light); margin-bottom: 32px;">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 28px;">
          <div>
            <div style="font-family: var(--font-mono); font-size: 10px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 4px;">
              CHIP
            </div>
            <div style="font-size: 14px; font-weight: 700; color: var(--text-primary);">
              V1X Pro chip
            </div>
          </div>

          <div>
            <div style="font-family: var(--font-mono); font-size: 10px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 4px;">
              CAMERA
            </div>
            <div style="font-size: 14px; font-weight: 700; color: var(--text-primary);">
              108MP Main | Ultra Wide
            </div>
          </div>

          <div>
            <div style="font-family: var(--font-mono); font-size: 10px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 4px;">
              BATTERY
            </div>
            <div style="font-size: 14px; font-weight: 700; color: var(--text-primary);">
              Up to 29 hrs video playback
            </div>
          </div>

          <div>
            <div style="font-family: var(--font-mono); font-size: 10px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 4px;">
              MATERIAL
            </div>
            <div style="font-size: 14px; font-weight: 700; color: var(--text-primary);">
              Aerospace-grade liquid metal
            </div>
          </div>
        </div>
      </div>

      <!-- Right: O2O Store Sync & Buy Card -->
      <div style="background: #FFFFFF; border: 1px solid var(--border-light); border-radius: var(--radius-lg); padding: 32px; box-shadow: var(--shadow-lg);">
        <div style="font-size: 28px; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 20px;">
          From $844
        </div>

        <!-- Real-Time Stock Sync Box -->
        <div style="background: var(--bg-secondary); border-radius: var(--radius-md); padding: 16px; margin-bottom: 24px; border: 1px solid var(--border-light);">
          <div style="display: flex; align-items: center; gap: 6px; font-family: var(--font-mono); font-size: 10px; font-weight: 700; letter-spacing: 0.08em; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 12px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"></path>
              <circle cx="12" cy="10" r="3"></circle>
            </svg>
            REAL-TIME STOCK SYNC
          </div>

          <div style="display: flex; justify-content: space-between; align-items: center; font-family: var(--font-mono); font-size: 12px; margin-bottom: 8px;">
            <span style="color: var(--text-secondary);">Online:</span>
            <span style="color: #059669; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
              <span class="v-dot-indicator green"></span> In Stock
            </span>
          </div>

          <div style="display: flex; justify-content: space-between; align-items: center; font-family: var(--font-mono); font-size: 12px;">
            <span style="color: var(--text-secondary);">Nearest Store (Cakung):</span>
            <span style="color: #059669; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
              <span class="v-dot-indicator green"></span> 12 Units Available
            </span>
          </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
          <a href="/checkout" class="v-btn v-btn-primary v-btn-block">
            Add to Cart
          </a>
          <a href="/detail" class="v-btn v-btn-secondary v-btn-block">
            Reserve in Store (O2O)
          </a>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
