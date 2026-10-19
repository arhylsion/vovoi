@extends('layouts.master')

@section('title', 'Checkout - VOVOI')

@section('konten_utama')
<section style="padding: 40px 0 80px;">
  <div class="v-container">
    
    <!-- Top Header -->
    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 40px;">
      <h1 style="font-size: 36px; font-weight: 800; letter-spacing: -0.04em;">Checkout</h1>
      <a href="/katalog" style="font-family: var(--font-mono); font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">
        Continue Shopping &rarr;
      </a>
    </div>

    <!-- Main 2-Column Grid -->
    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 48px; align-items: start;">
      
      <!-- Left Column: Cart, Fulfillment method, Shipping Form -->
      <div>
        
        <!-- 1. Your Cart Section -->
        <div style="margin-bottom: 40px;">
          <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px;">Your Cart</h2>
          
          <div style="background: #FFFFFF; border: 1px solid var(--border-light); border-radius: var(--radius-lg); padding: 24px; display: flex; gap: 24px; align-items: center; position: relative;">
            <div style="width: 88px; height: 88px; background: #F8F9FA; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; padding: 8px; flex-shrink: 0;">
              <img src="{{ asset('assets/images/zen2-phone.svg') }}" alt="VOVOI Zen 2" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>

            <div style="flex: 1;">
              <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px;">
                <h3 style="font-size: 18px; font-weight: 700;">VOVOI Zen 2</h3>
                <span style="font-size: 16px; font-weight: 700;">$999.00</span>
              </div>
              <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 14px;">256GB, Obsidian Black</p>

              <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <!-- Quantity selector -->
                <div class="v-qty-selector">
                  <button type="button" class="v-qty-btn" onclick="updateCheckoutQty(-1)">&minus;</button>
                  <span id="checkoutQty" class="v-qty-val">1</span>
                  <button type="button" class="v-qty-btn" onclick="updateCheckoutQty(1)">&#43;</button>
                </div>

                <!-- Allocated Serial Badge -->
                <span class="v-tag-mono" style="background: #F1F5F9; color: #475569; font-size: 10px;">
                  <span class="v-dot-indicator green"></span>
                  ALLOCATED: SN-9284-AX
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- 2. Fulfillment Method -->
        <div style="margin-bottom: 40px;">
          <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px;">
            How would you like to get your order?
          </h2>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            
            <!-- Option: Delivery (Selected) -->
            <label id="deliveryCard" style="border: 2px solid var(--text-primary); border-radius: var(--radius-lg); padding: 20px; cursor: pointer; display: flex; flex-direction: column; gap: 8px; background: #FFFFFF; transition: all var(--transition-fast);">
              <input type="radio" name="fulfillment" value="delivery" checked style="display: none;" onchange="toggleFulfillment('delivery')">
              <div style="display: flex; align-items: center; gap: 10px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="1" y="3" width="15" height="13"></rect>
                  <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                  <circle cx="5.5" cy="18.5" r="2.5"></circle>
                  <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
                <span style="font-size: 15px; font-weight: 700;">Delivery</span>
              </div>
              <span style="font-size: 12px; color: var(--text-secondary);">Direct to your home</span>
            </label>

            <!-- Option: Pickup -->
            <label id="pickupCard" style="border: 1px solid var(--border-light); border-radius: var(--radius-lg); padding: 20px; cursor: pointer; display: flex; flex-direction: column; gap: 8px; background: #FFFFFF; transition: all var(--transition-fast);">
              <input type="radio" name="fulfillment" value="pickup" style="display: none;" onchange="toggleFulfillment('pickup')">
              <div style="display: flex; align-items: center; gap: 10px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span style="font-size: 15px; font-weight: 700;">Pickup</span>
              </div>
              <span style="font-size: 12px; color: var(--text-secondary);">Collect at retail store</span>
            </label>

          </div>
        </div>

        <!-- 3. Shipping Details Form -->
        <div>
          <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px;">Shipping Details</h2>

          <form id="checkoutForm" action="/berhasil" method="GET" style="display: flex; flex-direction: column; gap: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <div class="v-form-group" style="margin: 0;">
                <label class="v-form-label">First Name</label>
                <input type="text" class="v-input" name="first_name" value="Joni" required>
              </div>

              <div class="v-form-group" style="margin: 0;">
                <label class="v-form-label">Last Name</label>
                <input type="text" class="v-input" name="last_name" value="Doe" required>
              </div>
            </div>

            <div class="v-form-group" style="margin: 0;">
              <label class="v-form-label">Street Address</label>
              <input type="text" class="v-input" name="address" value="Jl. Ciriung Jaya no 441" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
              <div class="v-form-group" style="margin: 0;">
                <label class="v-form-label">City</label>
                <input type="text" class="v-input" name="city" value="Cibinong" required>
              </div>

              <div class="v-form-group" style="margin: 0;">
                <label class="v-form-label">Zip Code</label>
                <input type="text" class="v-input" name="zip" value="16996" required>
              </div>
            </div>
          </form>
        </div>

      </div>

      <!-- Right Column: Order Summary & Digital Warranty Preview -->
      <div style="display: flex; flex-direction: column; gap: 24px; position: sticky; top: 96px;">
        
        <!-- Summary Box -->
        <div style="background: #FFFFFF; border: 1px solid var(--border-light); border-radius: var(--radius-lg); padding: 28px; box-shadow: var(--shadow-sm);">
          <h2 style="font-size: 22px; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 24px;">
            Summary
          </h2>

          <div style="display: flex; flex-direction: column; gap: 12px; font-size: 14px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between;">
              <span style="color: var(--text-secondary);">Subtotal</span>
              <span id="summarySubtotal" style="font-weight: 600;">$999.00</span>
            </div>
            
            <div style="display: flex; justify-content: space-between;">
              <span style="color: var(--text-secondary);">Shipping</span>
              <span style="font-weight: 600; color: #059669;">Free</span>
            </div>

            <div style="display: flex; justify-content: space-between;">
              <span style="color: var(--text-secondary);">Estimated Tax</span>
              <span id="summaryTax" style="font-weight: 600;">$72.43</span>
            </div>
          </div>

          <hr style="border: none; border-top: 1px solid var(--border-light); margin-bottom: 20px;">

          <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 24px;">
            <span style="font-size: 15px; font-weight: 700;">Total</span>
            <span id="summaryTotal" style="font-size: 26px; font-weight: 800; letter-spacing: -0.03em;">$1,071.43</span>
          </div>

          <button type="button" class="v-btn v-btn-primary v-btn-block v-btn-lg" onclick="document.getElementById('checkoutForm').submit();" style="margin-bottom: 16px;">
            Place Order
          </button>

          <div style="text-align: center; font-family: var(--font-mono); font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; display: flex; align-items: center; justify-content: center; gap: 6px;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            Secure SSL Encrypted Checkout
          </div>
        </div>

        <!-- Warranty Box Reusable Component -->
        <x-warranty-card 
          device="VOVOI Zen 2"
          serial="SN-9284-AX"
          coverage="1 Year Standard"
          :showNote="true"
        />

      </div>

    </div>

  </div>
</section>
@endsection

@section('extra_js')
<script>
  let checkoutQty = 1;
  const unitPrice = 999.00;
  const taxRate = 0.0725;

  function updateCheckoutQty(delta) {
    checkoutQty = Math.max(1, checkoutQty + delta);
    document.getElementById('checkoutQty').innerText = checkoutQty;

    const subtotal = unitPrice * checkoutQty;
    const tax = subtotal * taxRate;
    const total = subtotal + tax;

    document.getElementById('summarySubtotal').innerText = '$' + subtotal.toFixed(2);
    document.getElementById('summaryTax').innerText = '$' + tax.toFixed(2);
    document.getElementById('summaryTotal').innerText = '$' + total.toFixed(2);
  }

  function toggleFulfillment(mode) {
    const delivery = document.getElementById('deliveryCard');
    const pickup = document.getElementById('pickupCard');

    if (mode === 'delivery') {
      delivery.style.border = '2px solid var(--text-primary)';
      pickup.style.border = '1px solid var(--border-light)';
    } else {
      pickup.style.border = '2px solid var(--text-primary)';
      delivery.style.border = '1px solid var(--border-light)';
    }
  }
</script>
@endsection
