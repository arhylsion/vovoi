@extends('layouts.master')

@section('title', 'VOVOI - Beyond Ordinary Catalog')

@section('konten_utama')
<!-- Hero Header Section -->
<section style="text-align: center; padding: 56px 20px 36px;">
  <div class="v-container" style="max-width: 820px;">
    <h1 style="font-size: clamp(38px, 6vw, 56px); font-weight: 800; letter-spacing: -0.04em; margin-bottom: 16px; color: var(--text-primary);">
      Beyond Ordinary.
    </h1>
    <p style="font-size: clamp(16px, 2.5vw, 20px); font-weight: 500; color: var(--text-secondary); line-height: 1.5; margin-bottom: 36px;">
      Explore our curated collection of premium electronics, synced in real-time across all locations.
    </p>

    <!-- Search Bar -->
    <div style="max-width: 580px; margin: 0 auto; position: relative;">
      <div style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; gap: 8px; color: var(--text-secondary);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </div>
      <input type="text" placeholder="Search Vovoi Products" 
        style="width: 100%; padding: 14px 48px 14px 48px; border-radius: var(--radius-full); border: 1px solid var(--border-light); background: #F1F3F5; font-size: 14px; font-weight: 500; color: var(--text-primary); transition: all var(--transition-fast); outline: none;"
        onfocus="this.style.background='#FFFFFF'; this.style.borderColor='var(--text-primary)'; this.style.boxShadow='var(--shadow-md)';"
        onblur="this.style.background='#F1F3F5'; this.style.borderColor='var(--border-light)'; this.style.boxShadow='none';"
      >
      <div style="position: absolute; right: 18px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </div>
    </div>
  </div>
</section>

<!-- Meta Bar & Filter Controls -->
<section style="padding: 16px 0 28px;">
  <div class="v-container">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; border-bottom: 1px solid var(--border-light); padding-bottom: 20px;">
      <div style="font-size: 14px; font-weight: 600; color: var(--text-secondary);">
        Showing {{ $products->count() }} products
      </div>

      <div>
        <span class="v-tag-mono green">
          <span class="v-dot-indicator green"></span>
          LIVE INVENTORY SYNC ACTIVE
        </span>
      </div>

      <div style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; color: var(--text-primary);">
        <span>Sort by:</span>
        <select style="border: none; background: transparent; font-size: 14px; font-weight: 700; color: var(--text-primary); cursor: pointer; outline: none;">
          <option value="featured">Featured</option>
          <option value="price-low">Price: Low to High</option>
          <option value="price-high">Price: High to Low</option>
          <option value="newest">Newest Arrivals</option>
        </select>
      </div>
    </div>
  </div>
</section>

<!-- Main Catalog Layout (Sidebar + Product Grid) -->
<section style="padding-bottom: 80px;">
  <div class="v-container">
    <div style="display: grid; grid-template-columns: 240px 1fr; gap: 40px; align-items: start;">
      
      <!-- Sidebar Filters -->
      <aside style="display: flex; flex-direction: column; gap: 32px;">
        <!-- Category Section -->
        <div>
          <div style="font-family: var(--font-mono); font-size: 11px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 14px;">
            CATEGORY
          </div>
          <div style="display: flex; flex-direction: column; gap: 10px;">
            <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 600; cursor: pointer; color: var(--text-primary);">
              <input type="checkbox" checked style="accent-color: var(--text-primary); width: 16px; height: 16px; cursor: pointer;">
              All Products
            </label>
            <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 500; cursor: pointer; color: var(--text-secondary);">
              <input type="checkbox" style="accent-color: var(--text-primary); width: 16px; height: 16px; cursor: pointer;">
              Audio
            </label>
            <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 500; cursor: pointer; color: var(--text-secondary);">
              <input type="checkbox" style="accent-color: var(--text-primary); width: 16px; height: 16px; cursor: pointer;">
              Wearables
            </label>
            <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 500; cursor: pointer; color: var(--text-secondary);">
              <input type="checkbox" style="accent-color: var(--text-primary); width: 16px; height: 16px; cursor: pointer;">
              Computing
            </label>
          </div>
        </div>

        <!-- Availability Section -->
        <div>
          <div style="font-family: var(--font-mono); font-size: 11px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 14px;">
            AVAILABILITY
          </div>
          
          <div style="margin-bottom: 16px;">
            <div style="font-size: 12px; color: var(--text-secondary); margin-bottom: 6px;">Store Location</div>
            <select style="width: 100%; padding: 10px 12px; border-radius: var(--radius-sm); border: 1px solid var(--border-light); font-size: 13px; font-weight: 600; color: var(--text-primary); background: #FFFFFF; outline: none; cursor: pointer;">
              <option>All Locations</option>
              <option>Manggarai Store</option>
              <option>Jambu Dua Store</option>
              <option>Cakung Store</option>
            </select>
          </div>

          <div>
            <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 600; cursor: pointer; color: var(--text-primary);">
              <input type="checkbox" checked style="accent-color: var(--text-primary); width: 16px; height: 16px; cursor: pointer;">
              In Stock Only
            </label>
          </div>
        </div>
      </aside>

      <!-- Product Grid -->
      <div>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; margin-bottom: 48px;">
          
          <!-- BUKA MESIN LOOPING -->
          @forelse($products as $product)
            <!-- AREA DESAIN KOTAK PRODUK KALIAN -->
            <x-product-card 
              :image="$product->image ? asset('assets/images/' . $product->image) : null"
              badge="TERSEDIA"
              badgeType="green"
              :title="$product->name"
              :price="'Rp ' . number_format($product->price, 0, ',', '.')"
              :desc="$product->description"
              :serial="'VOVOI-' . str_pad($product->id, 4, '0', STR_PAD_LEFT)"
              url="/detail/{{ $product->id }}"
              buttonText="Lihat Detail"
              :inStock="true"
            />
          @empty
            <!-- Kalau DATABASE KOSONG (Menampilkan Empty State Sesuai Ketentuan LKPD) -->
            <div style="grid-column: 1 / -1; text-align: center; width: 100%; padding: 60px 24px; background: #FFFFFF; border: 1px dashed var(--border-light); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
              <div style="width: 64px; height: 64px; border-radius: 50%; background: #F8F9FA; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; color: var(--text-secondary);">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                  <path d="m3.3 7 8.7 5 8.7-5"></path>
                  <path d="M12 22V12"></path>
                </svg>
              </div>
              <h3 style="color: #666; font-size: 20px; font-weight: 700; margin-bottom: 8px;">Mohon maaf, produk belum tersedia di etalase kami.</h3>
              <p style="color: #999; font-size: 14px; max-width: 440px; margin: 0 auto; line-height: 1.6;">
                Saat ini etalase produk belum memiliki data. Silakan lakukan proses seed database atau hubungi administrator toko.
              </p>
            </div>
          @endforelse
          <!-- TUTUP MESIN LOOPING -->

        </div>

        @if($products->isNotEmpty())
        <!-- Pagination -->
        <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
          <button type="button" style="width: 38px; height: 38px; border-radius: 50%; border: 1px solid var(--border-light); background: #FFFFFF; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-secondary); transition: all var(--transition-fast);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
          </button>
          
          <button type="button" style="width: 38px; height: 38px; border-radius: 50%; border: none; background: var(--text-primary); color: #FFFFFF; font-weight: 700; font-size: 14px; cursor: pointer;">
            1
          </button>
          
          <button type="button" style="width: 38px; height: 38px; border-radius: 50%; border: 1px solid var(--border-light); background: #FFFFFF; font-weight: 600; font-size: 14px; cursor: pointer; color: var(--text-primary); transition: all var(--transition-fast);">
            2
          </button>
          
          <button type="button" style="width: 38px; height: 38px; border-radius: 50%; border: 1px solid var(--border-light); background: #FFFFFF; font-weight: 600; font-size: 14px; cursor: pointer; color: var(--text-primary); transition: all var(--transition-fast);">
            3
          </button>

          <button type="button" style="width: 38px; height: 38px; border-radius: 50%; border: 1px solid var(--border-light); background: #FFFFFF; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; color: var(--text-secondary); transition: all var(--transition-fast);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
          </button>
        </div>
        @endif

      </div>

    </div>
  </div>
</section>
@endsection
