@props([
  'device' => 'VOVOI Zen 2',
  'serial' => 'SN-9284-AX',
  'coverage' => '1 Year Standard',
  'showNote' => true
])

<div class="v-warranty-box">
  <div class="v-warranty-header">
    <div class="v-warranty-title">DIGITAL WARRANTY PREVIEW</div>
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #94A3B8;">
      <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
      <polyline points="9 12 11 14 15 10"></polyline>
    </svg>
  </div>

  <div class="v-warranty-row">
    <span class="v-warranty-label">DEVICE</span>
    <span class="v-warranty-val">{{ $device }}</span>
  </div>

  <div class="v-warranty-row">
    <span class="v-warranty-label">SERIAL</span>
    <span class="v-warranty-val">{{ $serial }}</span>
  </div>

  <div class="v-warranty-row" style="margin-bottom: 0;">
    <span class="v-warranty-label">COVERAGE</span>
    <span class="v-warranty-val green">{{ $coverage }}</span>
  </div>

  @if($showNote)
    <div class="v-warranty-note">
      Upon purchase, this warranty will be securely stored in your VOVOI account. You can access, transfer, or claim it digitally at any time.
    </div>
  @endif
</div>
