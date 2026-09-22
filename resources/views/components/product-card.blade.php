@props([
  'image' => asset('assets/images/zen2-phone.svg'),
  'badge' => 'MANGGARAI',
  'badgeType' => 'green',
  'title' => 'VOVOI Zen 2',
  'price' => '$999',
  'desc' => 'Studio-grade wireless fidelity.',
  'serial' => 'SM-8829-A',
  'url' => '/detail',
  'inStock' => true,
])

<article class="v-product-card">
  <div class="v-product-card-top">
    @if($inStock)
      <span class="v-tag-mono green">
        <span class="v-dot-indicator green"></span>
        {{ $badge }}
      </span>
    @else
      <span class="v-tag-mono red">
        <span class="v-dot-indicator red"></span>
        {{ $badge }}
      </span>
    @endif
  </div>

  <a href="{{ $url }}" class="v-product-img-box" aria-label="{{ $title }}">
    <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
  </a>

  <div class="v-product-info">
    <h3 class="v-product-title">
      <a href="{{ $url }}">{{ $title }}</a>
    </h3>
    <div class="v-product-price">{{ $price }}</div>
  </div>

  <p class="v-product-desc">{{ $desc }}</p>

  <div class="v-product-card-footer">
    <div class="v-product-serial">
      <span>SERIAL</span>
      {{ $serial }}
    </div>

    @if($inStock)
      <a href="{{ $url }}" class="v-btn v-btn-primary v-btn-sm">
        View
      </a>
    @else
      <button type="button" class="v-btn v-btn-secondary v-btn-sm" style="opacity: 0.85;">
        Notify
      </button>
    @endif
  </div>
</article>
