@extends('layouts.site')

@section('title', 'Your bag — ORIGINA')

@section('content')
  <section class="site-shell commerce-page" aria-labelledby="bag-title">
    <div class="commerce-header">
      <div class="commerce-kicker"><span>The collection</span><span>Your bag</span></div>
      <h1 id="bag-title">A considered selection.</h1>
      <p class="commerce-header__lede">Review quantities and availability before continuing. Product pricing and stock are checked again when the order is placed.</p>
    </div>

    <x-flash />

    <div class="commerce-split">
      <div>
        @forelse($products as $product)
          <article class="bag-line">
            @if($product->image_path)
              <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" width="120" height="150" loading="lazy">
            @endif

            <div>
              <p class="eyebrow">{{ strtoupper($product->division) }}</p>
              <h2><a href="{{ route('shop.product', $product->slug) }}">{{ $product->name }}</a></h2>
              <p class="bag-line__meta">TZS {{ number_format($product->price) }} each · SKU {{ $product->sku }}</p>

              @if(! $product->published || $product->stock < $cart[$product->id])
                <span class="bag-line__warning">Availability changed. Update this item before checkout.</span>
              @endif

              <form method="post" action="{{ route('cart.update', $product) }}" class="purchase-row">
                @csrf
                @method('patch')
                <x-field :name="'quantity'" :id="'quantity-'.$product->id" :label="'Quantity for '.$product->name" type="number" :value="$cart[$product->id]" min="0" max="99" />
                <button class="text-button">Update quantity</button>
              </form>
              <small>Set the quantity to 0 to remove this item.</small>
            </div>

            <strong>TZS {{ number_format($product->price * $cart[$product->id]) }}</strong>
          </article>
        @empty
          <div class="empty-state">
            <h2>Your bag is empty.</h2>
            <p>Explore the collection when you are ready to begin.</p>
            <a href="{{ route('shop') }}" class="button">Explore products →</a>
          </div>
        @endforelse
      </div>

      @if($products->isNotEmpty())
        <aside class="order-summary" aria-labelledby="bag-summary-title">
          <p class="eyebrow">Order summary</p>
          <h2 id="bag-summary-title">Current selection</h2>
          <dl>
            <div><dt>Subtotal</dt><dd>TZS {{ number_format($subtotal) }}</dd></div>
            <div><dt>Delivery</dt><dd>Confirmed at checkout</dd></div>
          </dl>
          <p>Stock and final totals are confirmed server-side when you place the order.</p>
          <div class="order-summary__actions">
            <a href="{{ route('checkout') }}" class="button">Continue to checkout →</a>
            <a href="{{ route('shop') }}">Continue exploring</a>
          </div>
          <p class="commerce-security-note">No payment is taken from this bag page. Never send payment to details that are not confirmed by ORIGINA.</p>
        </aside>
      @endif
    </div>
  </section>
@endsection
