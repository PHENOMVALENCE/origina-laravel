@extends('layouts.site')

@section('title', 'The ORIGINA collection — Biology First™')
@section('description', 'Explore the available ORIGINA product collection, with clear product information and considered care.')

@section('content')
  <section class="collection-hero site-shell" aria-labelledby="collection-title">
    <div class="collection-hero__copy">
      <div class="commerce-kicker" aria-label="Collection principles">
        <span>ORIGINA / The collection</span>
        <span>Evidence-led information</span>
        <span>Clear availability</span>
      </div>
      <h1 id="collection-title">Science informs.<br>Care follows.</h1>
      <p class="collection-hero__intro">Explore products from ORIGINA divisions with the formulation context, usage guidance and evidence language needed to make a considered choice.</p>
      <a href="/science/evidence" class="text-link">Our approach to evidence</a>

      <div class="collection-trust" aria-label="Collection standards">
        <div><strong>Transparent information</strong><small>Ingredients, usage and evidence notes are shown when approved.</small></div>
        <div><strong>Server-priced orders</strong><small>Final totals are calculated by ORIGINA at checkout.</small></div>
        <div><strong>Availability checked</strong><small>Stock is confirmed again when an order is placed.</small></div>
      </div>
    </div>

    <figure>
      <img src="{{ asset('img/products/bmelanox-01.jpeg') }}" alt="B-Melanox product photography" width="900" height="1200" fetchpriority="high">
      <figcaption>B-Melanox™ · An expression of Biology First™</figcaption>
    </figure>
  </section>

  <section class="site-shell collection" aria-labelledby="collection-products-title">
    <div class="section-top">
      <div>
        <p class="eyebrow">Available catalogue</p>
        <h2 id="collection-products-title">The collection</h2>
      </div>
      <span>{{ $products->total() }} {{ Str::plural('product', $products->total()) }}</span>
    </div>

    <form method="get" class="collection-toolbar" aria-label="Filter the ORIGINA collection">
      <x-field name="q" label="Find a product" :value="request('q')" maxlength="100" />
      <div class="field">
        <label for="division">Division</label>
        <select name="division" id="division">
          <option value="">All divisions</option>
          @foreach(['b-melanox' => 'B-Melanox', 'bettyworld' => 'BettyWorld', 'bvalence' => 'BValence', 'divine' => 'DIVINE', 'novia' => 'NOVIA', 'skin-safari' => 'Skin Safari'] as $key => $label)
            <option value="{{ $key }}" @selected(request('division') === $key)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <button class="button">Apply filters</button>
    </form>

    <div class="product-grid">
      @forelse($products as $product)
        <article class="product-card">
          <a href="{{ route('shop.product', $product->slug) }}" class="product-card__media" aria-label="View {{ $product->name }}">
            @if($product->image_path)
              <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" width="700" height="900" loading="lazy">
            @else
              <span class="product-card__mark">ORIGINA</span>
            @endif
          </a>

          <span class="product-card__status {{ $product->stock > 0 ? 'product-card__status--available' : '' }}">
            {{ $product->stock > 0 ? 'Available' : 'Out of stock' }}
          </span>
          <p class="eyebrow">{{ strtoupper($product->division) }}</p>
          <h3><a href="{{ route('shop.product', $product->slug) }}">{{ $product->name }}</a></h3>
          <div class="product-card__footer">
            <strong>TZS {{ number_format($product->price) }}</strong>
            <span>{{ $product->stock > 0 ? 'View details →' : 'View product' }}</span>
          </div>
        </article>
      @empty
        <div class="empty-state">
          <h3>{{ request()->filled('q') || request()->filled('division') ? 'No matching products.' : 'The collection is being prepared.' }}</h3>
          <p>Only approved products with confirmed pricing appear here. Adjust the filters or contact ORIGINA for availability.</p>
          @if(request()->filled('q') || request()->filled('division'))
            <a href="{{ route('shop') }}" class="text-link">Clear filters</a>
          @else
            <a href="{{ route('enquire') }}" class="button">Enquire with ORIGINA</a>
          @endif
        </div>
      @endforelse
    </div>

    {{ $products->links() }}
  </section>
@endsection
