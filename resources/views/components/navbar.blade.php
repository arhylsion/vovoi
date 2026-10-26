<nav class="v-navbar">
  <div class="v-container v-navbar-inner">
    <a href="/" class="v-logo" title="VOVOI Home">
      <span style="letter-spacing: -0.05em; font-weight: 800; font-size: 26px;">vovoi</span>
    </a>

    <ul class="v-nav-links">
      <li>
        <a href="/katalog" class="v-nav-link {{ request()->is('katalog') ? 'active' : '' }}">Smartphones</a>
      </li>
      <li>
        <a href="/katalog" class="v-nav-link">Accessories</a>
      </li>
      <li>
        <a href="/katalog" class="v-nav-link">Support</a>
      </li>
    </ul>

    <div class="v-nav-actions">
      <!-- Search -->
      <a href="/katalog" class="v-icon-btn" aria-label="Search">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </a>

      <!-- Cart -->
      <a href="/keranjang" class="v-icon-btn" aria-label="Shopping Cart" title="Keranjang Belanja">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="9" cy="21" r="1"></circle>
          <circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        <span class="v-badge-dot"></span>
      </a>

      <!-- Profile -->
      <button type="button" class="v-icon-btn" aria-label="Account Profile">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
          <circle cx="12" cy="7" r="4"></circle>
        </svg>
      </button>
    </div>
  </div>
</nav>
