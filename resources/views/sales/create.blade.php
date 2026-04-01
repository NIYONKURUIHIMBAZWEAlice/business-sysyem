@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .sale-page {
        min-height: 100vh;
        background: #f4f3ef;
        font-family: 'DM Sans', sans-serif;
        padding: 2rem 1rem;
    }

    .sale-container {
        max-width: 780px;
        margin: 0 auto;
    }

    /* Header */
    .sale-header {
        margin-bottom: 2rem;
    }
    .sale-header .breadcrumb {
        font-size: 0.75rem;
        color: #9e9b91;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    .sale-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: #1a1916;
        letter-spacing: -0.02em;
    }
    .sale-header p {
        font-size: 0.875rem;
        color: #7a776e;
        margin-top: 0.25rem;
    }

    /* Card */
    .card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e8e6e0;
        overflow: hidden;
        margin-bottom: 1rem;
    }
    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0ede7;
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }
    .card-header .icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #1a1916;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .card-header .icon svg {
        width: 16px;
        height: 16px;
        stroke: #f4f3ef;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .card-header h2 {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #1a1916;
        letter-spacing: -0.01em;
    }
    .card-header .badge {
        margin-left: auto;
        font-size: 0.75rem;
        font-weight: 500;
        color: #7a776e;
        background: #f4f3ef;
        padding: 0.2rem 0.6rem;
        border-radius: 99px;
        border: 1px solid #e8e6e0;
    }

    /* Search */
    .search-wrap {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0ede7;
    }
    .search-input-wrap {
        position: relative;
    }
    .search-input-wrap svg {
        position: absolute;
        left: 0.875rem;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        stroke: #b0ada4;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        pointer-events: none;
    }
    #productSearch {
        width: 100%;
        padding: 0.625rem 1rem 0.625rem 2.5rem;
        border: 1.5px solid #e8e6e0;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        color: #1a1916;
        background: #faf9f7;
        outline: none;
        transition: border-color 0.15s, background 0.15s;
    }
    #productSearch:focus {
        border-color: #1a1916;
        background: #fff;
    }
    #productSearch::placeholder { color: #b0ada4; }

    /* Product list */
    .product-list {
        max-height: 360px;
        overflow-y: auto;
    }
    .product-list::-webkit-scrollbar { width: 4px; }
    .product-list::-webkit-scrollbar-track { background: transparent; }
    .product-list::-webkit-scrollbar-thumb { background: #e0ddd7; border-radius: 99px; }

    .product-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.875rem 1.5rem;
        border-bottom: 1px solid #f7f6f2;
        transition: background 0.12s;
        cursor: pointer;
    }
    .product-row:last-child { border-bottom: none; }
    .product-row:hover { background: #faf9f7; }
    .product-row.selected { background: #f0ede7; }

    .product-row input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        border: 1.5px solid #ccc9c0;
        border-radius: 5px;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.15s;
        position: relative;
    }
    .product-row input[type="checkbox"]:checked {
        background: #1a1916;
        border-color: #1a1916;
    }
    .product-row input[type="checkbox"]:checked::after {
        content: '';
        position: absolute;
        left: 4px;
        top: 1.5px;
        width: 7px;
        height: 11px;
        border: 2px solid #fff;
        border-top: none;
        border-left: none;
        transform: rotate(45deg);
    }

    .product-info { flex: 1; min-width: 0; }
    .product-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #1a1916;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .product-meta {
        font-size: 0.75rem;
        color: #9e9b91;
        margin-top: 0.125rem;
    }
    .product-stock {
        font-size: 0.75rem;
        padding: 0.15rem 0.5rem;
        border-radius: 99px;
        font-weight: 500;
        flex-shrink: 0;
    }
    .stock-ok { background: #e8f5e9; color: #2e7d32; }
    .stock-low { background: #fff3e0; color: #e65100; }
    .stock-out { background: #fce4e4; color: #c62828; }

    .product-price {
        font-family: 'DM Mono', monospace;
        font-size: 0.875rem;
        font-weight: 500;
        color: #1a1916;
        flex-shrink: 0;
        min-width: 80px;
        text-align: right;
    }

    .qty-wrap {
        display: flex;
        align-items: center;
        gap: 0;
        flex-shrink: 0;
        opacity: 0.35;
        pointer-events: none;
        transition: opacity 0.15s;
    }
    .qty-wrap.active {
        opacity: 1;
        pointer-events: auto;
    }
    .qty-btn {
        width: 28px;
        height: 28px;
        border: 1.5px solid #e0ddd7;
        background: #faf9f7;
        color: #1a1916;
        cursor: pointer;
        font-size: 1rem;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.12s;
        border-radius: 0;
        font-family: inherit;
    }
    .qty-btn:first-child { border-radius: 7px 0 0 7px; }
    .qty-btn:last-child  { border-radius: 0 7px 7px 0; }
    .qty-btn:hover { background: #f0ede7; }
    .qty-input {
        width: 40px;
        height: 28px;
        border: 1.5px solid #e0ddd7;
        border-left: none;
        border-right: none;
        text-align: center;
        font-family: 'DM Mono', monospace;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #1a1916;
        background: #fff;
        outline: none;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-inner-spin-button,
    .qty-input::-webkit-outer-spin-button { -webkit-appearance: none; }

    /* No results */
    .no-results {
        padding: 2.5rem 1.5rem;
        text-align: center;
        color: #9e9b91;
        font-size: 0.875rem;
        display: none;
    }
    .no-results svg {
        width: 32px;
        height: 32px;
        stroke: #ccc9c0;
        fill: none;
        stroke-width: 1.5;
        stroke-linecap: round;
        stroke-linejoin: round;
        margin-bottom: 0.75rem;
    }

    /* Selected summary */
    .selected-summary {
        padding: 1rem 1.5rem;
        background: #f7f6f2;
        border-top: 1px solid #e8e6e0;
        display: none;
    }
    .selected-summary.visible { display: block; }
    .summary-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #9e9b91;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    .selected-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
    }
    .selected-tag {
        font-size: 0.8125rem;
        font-weight: 500;
        color: #1a1916;
        background: #fff;
        border: 1.5px solid #e0ddd7;
        border-radius: 8px;
        padding: 0.2rem 0.6rem;
    }

    /* Payment method */
    .payment-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        padding: 1.25rem 1.5rem;
    }
    .payment-option {
        position: relative;
    }
    .payment-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    .payment-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        border: 1.5px solid #e8e6e0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.15s;
        background: #faf9f7;
    }
    .payment-label:hover { border-color: #b0ada4; background: #fff; }
    .payment-option input:checked + .payment-label {
        border-color: #1a1916;
        background: #fff;
        box-shadow: inset 0 0 0 1px #1a1916;
    }
    .payment-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #f0ede7;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background 0.15s;
    }
    .payment-option input:checked + .payment-label .payment-icon {
        background: #1a1916;
    }
    .payment-icon svg {
        width: 18px;
        height: 18px;
        stroke: #7a776e;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        transition: stroke 0.15s;
    }
    .payment-option input:checked + .payment-label .payment-icon svg {
        stroke: #f4f3ef;
    }
    .payment-text strong {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #1a1916;
    }
    .payment-text span {
        font-size: 0.75rem;
        color: #9e9b91;
    }

    /* Notes */
    .notes-wrap { padding: 0 1.5rem 1.25rem; }
    .notes-wrap label {
        display: block;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #4a4740;
        margin-bottom: 0.4rem;
    }
    .notes-wrap textarea {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1.5px solid #e8e6e0;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        color: #1a1916;
        background: #faf9f7;
        resize: none;
        outline: none;
        height: 72px;
        transition: border-color 0.15s;
    }
    .notes-wrap textarea:focus { border-color: #1a1916; background: #fff; }
    .notes-wrap textarea::placeholder { color: #b0ada4; }

    /* Order summary */
    .order-summary { padding: 1.25rem 1.5rem; }
    .order-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.375rem 0;
        font-size: 0.875rem;
        color: #7a776e;
    }
    .order-divider {
        height: 1px;
        background: #f0ede7;
        margin: 0.625rem 0;
    }
    .order-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0 0;
    }
    .order-total .label {
        font-size: 1rem;
        font-weight: 600;
        color: #1a1916;
    }
    .order-total .amount {
        font-family: 'DM Mono', monospace;
        font-size: 1.375rem;
        font-weight: 500;
        color: #1a1916;
        letter-spacing: -0.02em;
    }
    .empty-total {
        font-size: 0.8125rem;
        color: #b0ada4;
        text-align: center;
        padding: 0.5rem 0;
        font-style: italic;
    }

    /* Submit */
    .submit-wrap {
        display: flex;
        gap: 0.75rem;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #f0ede7;
    }
    .btn-cancel {
        flex: 1;
        padding: 0.75rem;
        border: 1.5px solid #e8e6e0;
        border-radius: 10px;
        background: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9375rem;
        font-weight: 500;
        color: #4a4740;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-cancel:hover { background: #f4f3ef; border-color: #ccc9c0; }
    .btn-submit {
        flex: 2;
        padding: 0.75rem;
        border: none;
        border-radius: 10px;
        background: #1a1916;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9375rem;
        font-weight: 600;
        color: #f4f3ef;
        cursor: pointer;
        transition: all 0.15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        letter-spacing: -0.01em;
    }
    .btn-submit:hover { background: #2e2c27; }
    .btn-submit:disabled { opacity: 0.45; cursor: not-allowed; }
    .btn-submit svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2.5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* Validation */
    .alert-warn {
        background: #fff8e1;
        border: 1px solid #ffe082;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: #7a5800;
        margin: 0.5rem 1.5rem 0;
        display: none;
    }
    .alert-warn.visible { display: block; }

    @media (max-width: 500px) {
        .payment-grid { grid-template-columns: 1fr; }
        .product-row { padding: 0.75rem 1rem; }
        .sale-page { padding: 1rem 0.75rem; }
        .submit-wrap { flex-direction: column; }
        .btn-cancel { flex: none; }
        .btn-submit { flex: none; }
    }
</style>

<div class="sale-page">
  <div class="sale-container">

    <!-- Header -->
    <div class="sale-header">
      <div class="breadcrumb">Sales &rsaquo; New transaction</div>
      <h1>Record Sale</h1>
      <p>Select products, set quantities, and confirm payment</p>
    </div>

    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
      @csrf

      {{-- ── STEP 1: PRODUCTS ── --}}
      <div class="card" style="margin-bottom:1rem">
        <div class="card-header">
          <div class="icon">
            <svg viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
          </div>
          <h2>Products</h2>
          <span class="badge" id="selectedCount">0 selected</span>
        </div>

        <div class="search-wrap">
          <div class="search-input-wrap">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" id="productSearch" placeholder="Search products by name…" autocomplete="off">
          </div>
        </div>

        <div class="product-list" id="productList">
          @forelse($products as $product)
            @php
              $stock = $product->stock_quantity ?? 0;
              $stockClass = $stock > 10 ? 'stock-ok' : ($stock > 0 ? 'stock-low' : 'stock-out');
              $stockLabel = $stock > 10 ? 'In stock' : ($stock > 0 ? 'Low stock' : 'Out of stock');
            @endphp
            <div class="product-row" data-name="{{ strtolower($product->name) }}" data-id="{{ $product->id }}">
              <input type="checkbox"
                     name="products[{{ $loop->index }}][id]"
                     value="{{ $product->id }}"
                     class="product-checkbox"
                     data-price="{{ $product->price }}"
                     data-name="{{ $product->name }}"
                     data-index="{{ $loop->index }}"
                     id="chk_{{ $product->id }}">

              <div class="product-info">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-meta">
                  {{ $product->description ?? 'No description' }}
                </div>
              </div>

              <span class="product-stock {{ $stockClass }}">{{ $stockLabel }}</span>

              <div class="product-price">
                {{ $product->price }}
                <input type="hidden" name="products[{{ $loop->index }}][unit_price]" value="{{ $product->price }}">
              </div>

              <div class="qty-wrap" id="qty_wrap_{{ $product->id }}">
                <button type="button" class="qty-btn qty-minus" data-id="{{ $product->id }}">−</button>
                <input type="number"
                       class="qty-input"
                       name="products[{{ $loop->index }}][quantity]"
                       id="qty_{{ $product->id }}"
                       value="1"
                       min="1"
                       max="{{ $stock ?: 999 }}"
                       data-price="{{ $product->price }}"
                       disabled>
                <button type="button" class="qty-btn qty-plus" data-id="{{ $product->id }}">+</button>
              </div>
            </div>
          @empty
            <div style="padding:2rem 1.5rem;text-align:center;color:#9e9b91;font-size:0.875rem">
              No products found in stock. Please add products first.
            </div>
          @endforelse

          <div class="no-results" id="noResults">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <div>No products match your search</div>
          </div>
        </div>

        <div class="selected-summary" id="selectedSummary">
          <div class="summary-label">Selected items</div>
          <div class="selected-tags" id="selectedTags"></div>
        </div>
      </div>

      <div class="alert-warn" id="noProductWarn">
        ⚠ Please select at least one product before saving the sale.
      </div>

      {{-- ── STEP 2: PAYMENT METHOD ── --}}
      <div class="card" style="margin-bottom:1rem">
        <div class="card-header">
          <div class="icon">
            <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          </div>
          <h2>Payment method</h2>
        </div>
        <div class="payment-grid">
          <div class="payment-option">
            <input type="radio" name="payment_method" value="cash" id="pay_cash" checked>
            <label class="payment-label" for="pay_cash">
              <div class="payment-icon">
                <svg viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
              </div>
              <div class="payment-text">
                <strong>Cash</strong>
                <span>Physical payment</span>
              </div>
            </label>
          </div>
          <div class="payment-option">
            <input type="radio" name="payment_method" value="mobile_money" id="pay_momo">
            <label class="payment-label" for="pay_momo">
              <div class="payment-icon">
                <svg viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
              </div>
              <div class="payment-text">
                <strong>Mobile Money</strong>
                <span>MoMo / digital</span>
              </div>
            </label>
          </div>
          <div class="payment-option">
            <input type="radio" name="payment_method" value="bank_transfer" id="pay_bank">
            <label class="payment-label" for="pay_bank">
              <div class="payment-icon">
                <svg viewBox="0 0 24 24"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 10v11M12 10v11M16 10v11"/></svg>
              </div>
              <div class="payment-text">
                <strong>Bank transfer</strong>
                <span>Wire / account</span>
              </div>
            </label>
          </div>
          <div class="payment-option">
            <input type="radio" name="payment_method" value="credit" id="pay_credit">
            <label class="payment-label" for="pay_credit">
              <div class="payment-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2z"/><path d="M12 6v6l4 2"/></svg>
              </div>
              <div class="payment-text">
                <strong>Credit</strong>
                <span>Pay later</span>
              </div>
            </label>
          </div>
        </div>
      </div>

      {{-- ── STEP 3: NOTES (optional) ── --}}
      <div class="card" style="margin-bottom:1rem">
        <div class="card-header">
          <div class="icon">
            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          </div>
          <h2>Notes <span style="font-weight:400;color:#9e9b91;font-size:0.8125rem">(optional)</span></h2>
        </div>
        <div class="notes-wrap">
          <label for="customer_name">Customer name</label>
          <input type="text" name="customer_name" id="customer_name"
                 placeholder="e.g. John Doe"
                 style="width:100%;padding:0.625rem 0.875rem;border:1.5px solid #e8e6e0;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:0.875rem;color:#1a1916;background:#faf9f7;outline:none;margin-bottom:0.75rem;transition:border-color 0.15s;"
                 onfocus="this.style.borderColor='#1a1916';this.style.background='#fff'"
                 onblur="this.style.borderColor='#e8e6e0';this.style.background='#faf9f7'">
          <label for="saleNotes">Additional notes</label>
          <textarea name="notes" id="saleNotes" placeholder="e.g. Discount applied, customer reference…"></textarea>
        </div>
      </div>

      {{-- ── ORDER SUMMARY ── --}}
      <div class="card">
        <div class="card-header">
          <div class="icon">
            <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
          </div>
          <h2>Order summary</h2>
        </div>

        <div class="order-summary">
          <div id="summaryLines">
            <div class="empty-total">No products selected yet</div>
          </div>
          <div class="order-divider"></div>
          <div class="order-total">
            <span class="label">Total</span>
            <span class="amount" id="totalAmount">—</span>
          </div>
        </div>

        <div class="submit-wrap">
          <a href="{{ url()->previous() }}" class="btn-cancel">Cancel</a>
          <button type="submit" class="btn-submit" id="submitBtn">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            Save sale
          </button>
        </div>
      </div>

    </form>
  </div>
</div>

<script>
(function () {
    const checkboxes   = document.querySelectorAll('.product-checkbox');
    const searchInput  = document.getElementById('productSearch');
    const productRows  = document.querySelectorAll('.product-row');
    const noResults    = document.getElementById('noResults');
    const selectedCount= document.getElementById('selectedCount');
    const selectedSummary = document.getElementById('selectedSummary');
    const selectedTags = document.getElementById('selectedTags');
    const summaryLines = document.getElementById('summaryLines');
    const totalEl      = document.getElementById('totalAmount');
    const submitBtn    = document.getElementById('submitBtn');
    const noProductWarn= document.getElementById('noProductWarn');

    // Currency symbol — change 'RWF' to match your currency
    const CURRENCY = '{{ $currency ?? "RWF" }}';

    function fmt(n) {
        return CURRENCY + ' ' + Number(n).toLocaleString('en-US', { minimumFractionDigits: 0 });
    }

    function getSelected() {
        return Array.from(checkboxes).filter(c => c.checked);
    }

    function updateUI() {
        const selected = getSelected();
        let total = 0;
        const lines = [];

        selected.forEach(chk => {
            const id    = chk.dataset.id ?? chk.value;
            const name  = chk.dataset.name;
            const price = parseFloat(chk.dataset.price);
            const qtyEl = document.getElementById('qty_' + id);
            const qty   = parseInt(qtyEl ? qtyEl.value : 1) || 1;
            const sub   = price * qty;
            total += sub;
            lines.push({ name, price, qty, sub });
        });

        // Count badge
        selectedCount.textContent = selected.length + ' selected';

        // Selected tags strip
        if (selected.length > 0) {
            selectedSummary.classList.add('visible');
            selectedTags.innerHTML = lines.map(l =>
                `<span class="selected-tag">${l.name} ×${l.qty}</span>`
            ).join('');
        } else {
            selectedSummary.classList.remove('visible');
        }

        // Summary lines
        if (lines.length === 0) {
            summaryLines.innerHTML = '<div class="empty-total">No products selected yet</div>';
            totalEl.textContent = '—';
        } else {
            summaryLines.innerHTML = lines.map(l =>
                `<div class="order-row">
                    <span>${l.name} <span style="color:#b0ada4">×${l.qty}</span></span>
                    <span style="font-family:'DM Mono',monospace;font-weight:500;color:#1a1916">${fmt(l.sub)}</span>
                </div>`
            ).join('');
            totalEl.textContent = fmt(total);
        }

        submitBtn.disabled = selected.length === 0;
    }

    // Checkbox toggle
    checkboxes.forEach(chk => {
        const id = chk.dataset.id ?? chk.value;
        const wrap = document.getElementById('qty_wrap_' + id);
        const qtyEl = document.getElementById('qty_' + id);
        const row = chk.closest('.product-row');

        chk.addEventListener('change', function () {
            if (this.checked) {
                wrap && wrap.classList.add('active');
                qtyEl && (qtyEl.disabled = false);
                row  && row.classList.add('selected');
            } else {
                wrap && wrap.classList.remove('active');
                qtyEl && (qtyEl.disabled = true);
                row  && row.classList.remove('selected');
            }
            noProductWarn.classList.remove('visible');
            updateUI();
        });

        // Click row = toggle checkbox
        row && row.addEventListener('click', function (e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON') return;
            chk.checked = !chk.checked;
            chk.dispatchEvent(new Event('change'));
        });
    });

    // Qty +/- buttons
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const id    = this.dataset.id;
            const input = document.getElementById('qty_' + id);
            if (!input || input.disabled) return;
            let val = parseInt(input.value) || 1;
            if (this.classList.contains('qty-plus'))  val = Math.min(val + 1, parseInt(input.max) || 999);
            if (this.classList.contains('qty-minus')) val = Math.max(val - 1, 1);
            input.value = val;
            updateUI();
        });
    });

    // Qty input change
    document.querySelectorAll('.qty-input').forEach(inp => {
        inp.addEventListener('input', updateUI);
    });

    // Search filter
    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        let visible = 0;
        productRows.forEach(row => {
            const match = row.dataset.name.includes(q);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        noResults.style.display = visible === 0 ? 'flex' : 'none';
        if (noResults.style.display === 'flex') {
            noResults.style.flexDirection = 'column';
            noResults.style.alignItems    = 'center';
        }
    });

    // Form submit validation
    document.getElementById('saleForm').addEventListener('submit', function (e) {
        if (getSelected().length === 0) {
            e.preventDefault();
            noProductWarn.classList.add('visible');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    updateUI();
})();
</script>
@endsection