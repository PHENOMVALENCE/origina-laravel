@extends('layouts.site')

@section('title', $product->name.' — ORIGINA')
@section('description', Str::limit(strip_tags($product->description), 155))

@section('content')
  <section class="site-shell product-detail" aria-labelledby="product-title">
    <div class="product-detail__image">
      @if($product->image_path)
        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" width="900" height="1200" fetchpriority="high">
      @else
        <div class="product-card__mark">ORIGINA</div>
      @endif
    </div>

    <div class="product-detail__panel">
      <a href="{{ route('shop') }}" class="product-detail__back">← Back to the collection</a>
      <p class="eyebrow">{{ strtoupper($product->division) }}</p>
      <h1 id="product-title">{{ $product->name }}</h1>
      <p class="product-price">TZS {{ number_format($product->price) }}</p>
      <p class="product-detail__summary preserve-lines">{{ $product->description }}</p>

      <div class="product-detail__availability" aria-label="Product availability">
        <span><strong>{{ $product->stock > 0 ? 'Available' : 'Out of stock' }}</strong></span>
        <span>SKU {{ $product->sku }}</span>
        <span>Delivery reviewed at checkout</span>
      </div>

      <x-flash />

      <form method="post" action="{{ route('cart.add', $product) }}" class="purchase-row">
        @csrf
        <x-field name="quantity" label="Quantity" type="number" value="1" required min="1" :max="min($product->stock, 99)" />
        <button class="button" @disabled($product->stock < 1)>{{ $product->stock > 0 ? 'Add to bag →' : 'Out of stock' }}</button>
      </form>

      <div class="product-detail__assurance" aria-label="Order principles">
        <div><strong>Clear information</strong><span>Approved product details are presented without inflated claims.</span></div>
        <div><strong>Stock checked</strong><span>Availability is validated again when the order is placed.</span></div>
        <div><strong>Payment separated</strong><span>Payment is only handled according to the current checkout instructions.</span></div>
      </div>

      @foreach(['ingredients' => 'Ingredients', 'usage' => 'How to use', 'evidence_note' => 'Evidence & responsible use'] as $field => $label)
        @if($product->$field)
          <details class="product-disclosure">
            <summary>{{ $label }}</summary>
            <p class="preserve-lines">{{ $product->$field }}</p>
          </details>
        @endif
      @endforeach

      <p class="product-note">Product information does not replace individual medical advice. <a href="/science/responsible-science">Read our scientific principles.</a></p>
    </div>
  </section>
@endsection
