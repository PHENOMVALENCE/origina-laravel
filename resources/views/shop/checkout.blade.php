@extends('layouts.site')

@section('title', 'Checkout — ORIGINA')

@section('content')
  <section class="site-shell commerce-page" aria-labelledby="checkout-title">
    <div class="checkout-steps" aria-label="Checkout progress">
      <div class="checkout-step">01 · Selection</div>
      <div class="checkout-step" aria-current="step">02 · Delivery</div>
      <div class="checkout-step">03 · Order confirmation</div>
    </div>

    <div class="commerce-header">
      <p class="eyebrow">Checkout</p>
      <h1 id="checkout-title">The details matter.</h1>
      <p class="commerce-header__lede">Confirm where the order should go and review the current payment instructions before placing it.</p>
    </div>

    <x-flash />

    @unless(config('commerce.checkout_enabled'))
      <div class="notice" role="status">
        <strong>Ordering is not yet enabled.</strong>
        <p>The checkout workflow is ready, but orders remain disabled until ORIGINA completes its production commerce configuration.</p>
      </div>
    @endunless

    <div class="commerce-split">
      <form method="post" action="{{ route('checkout.store') }}" class="form-stack">
        @csrf
        <input type="hidden" name="checkout_key" value="{{ $key }}">

        <div>
          <p class="eyebrow">Delivery information</p>
          <h2>Where should this order go?</h2>
        </div>

        <div class="form-grid">
          <x-field name="name" label="Recipient name" :value="auth()->user()->name" required autocomplete="name" />
          <x-field name="phone" label="Phone number" type="tel" required autocomplete="tel" />
        </div>
        <x-field name="address" label="Street, building and delivery directions" required autocomplete="street-address" maxlength="500" />
        <x-field name="city" label="City / area in Tanzania" required autocomplete="address-level2" />

        <div class="notice">
          <strong>Payment arrangement</strong>
          <p>{{ config('commerce.payment_instructions') }}</p>
        </div>

        <label class="checkbox">
          <input type="checkbox" name="consent" value="1" required>
          <span>I accept the <a href="/terms">terms</a> and acknowledge that this order is unpaid until payment is confirmed.</span>
        </label>

        <button class="button" @disabled(! config('commerce.checkout_enabled'))>
          Place order · TZS {{ number_format($subtotal + config('commerce.shipping_fee')) }}
        </button>
      </form>

      <aside class="order-summary" aria-labelledby="checkout-summary-title">
        <p class="eyebrow">Your selection</p>
        <h2 id="checkout-summary-title">Order summary</h2>
        <dl>
          @foreach($products as $product)
            <div>
              <dt>{{ $product->name }} × {{ $cart[$product->id] }}</dt>
              <dd>TZS {{ number_format($product->price * $cart[$product->id]) }}</dd>
            </div>
          @endforeach
          <div><dt>Subtotal</dt><dd>TZS {{ number_format($subtotal) }}</dd></div>
          <div><dt>Delivery</dt><dd>TZS {{ number_format(config('commerce.shipping_fee')) }}</dd></div>
          <div class="summary-total"><dt>Total</dt><dd>TZS {{ number_format($subtotal + config('commerce.shipping_fee')) }}</dd></div>
        </dl>
        <p>Prices are in Tanzanian shillings. No payment is collected on this page under the current manual-payment workflow.</p>
        <div class="order-summary__actions">
          <a href="{{ route('cart') }}">← Edit your selection</a>
        </div>
        <p class="commerce-security-note">Only use payment instructions displayed or confirmed through official ORIGINA channels. Online card payment must not be assumed available until a provider is enabled.</p>
      </aside>
    </div>
  </section>
@endsection
