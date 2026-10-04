@extends('layouts.portal')

@section('workspace', 'Operations')
@section('eyebrow', 'ORIGINA / Operations')
@section('title', 'Operations overview')
@section('heading', 'The institution, in operation.')
@section('subtitle', 'A clear view of commerce, customers, stock and the work that needs attention.')

@section('actions')
  <a href="{{ route('admin.products.create') }}" class="button">Add product</a>
@endsection

@section('content')
  <div class="operations-health" aria-label="Operational principles">
    <div><strong>Commercial accuracy</strong><span>Orders use server-side pricing and confirmed receipt records.</span></div>
    <div><strong>Traceable operations</strong><span>Catalogue, manufacturing, access and fulfilment changes remain auditable.</span></div>
    <div><strong>Release discipline</strong><span>Only approved products, information and production records should move forward.</span></div>
  </div>

  <div class="stat-grid stat-grid--four">
    <article class="stat"><p>Confirmed receipts</p><strong><small>TZS</small> {{ number_format($revenue) }}</strong><small>All-time confirmed paid orders</small></article>
    <article class="stat"><p>Awaiting confirmation</p><strong>{{ $pending }}</strong><small>Orders still pending</small></article>
    <article class="stat"><p>Customers</p><strong>{{ $customerCount }}</strong><small>Registered customer accounts</small></article>
    <article class="stat"><p>New enquiries</p><strong>{{ $enquiryCount }}</strong><a href="{{ route('admin.enquiries') }}">Open the inbox →</a></article>
  </div>

  <div class="workspace-grid">
    <section class="workspace-panel workspace-panel--accent">
      <div class="section-top">
        <div>
          <p class="eyebrow">Order movement</p>
          <h2>Fulfilment pipeline</h2>
        </div>
        <a href="{{ route('admin.orders') }}">Orders →</a>
      </div>
      <div class="pipeline">
        @foreach(['pending', 'confirmed', 'processing', 'shipped', 'delivered'] as $stage)
          <div>
            <span>{{ ucfirst($stage) }}</span>
            <strong>{{ $stages[$stage] ?? 0 }}</strong>
            <meter min="0" max="{{ max(1, $stages->sum()) }}" value="{{ $stages[$stage] ?? 0 }}" aria-label="{{ ucfirst($stage) }} orders">{{ $stages[$stage] ?? 0 }}</meter>
          </div>
        @endforeach
      </div>
    </section>

    <section class="workspace-panel">
      <div class="section-top">
        <div>
          <p class="eyebrow">Stock review</p>
          <h2>Inventory attention</h2>
        </div>
        <a href="{{ route('admin.products') }}">Catalogue →</a>
      </div>
      @forelse($lowStock as $product)
        <a class="attention-row" href="{{ route('admin.products.edit', $product) }}">
          <span>{{ $product->name }}<small class="block">{{ $product->sku }}</small></span>
          <span class="badge">{{ $product->stock }} available</span>
        </a>
      @empty
        <div class="empty-state"><p>No published products are currently below the stock threshold.</p></div>
      @endforelse
    </section>
  </div>

  <section class="workspace-panel">
    <div class="section-top">
      <div>
        <p class="eyebrow">Commerce</p>
        <h2>Recent orders</h2>
      </div>
      <a href="{{ route('admin.orders') }}">View all →</a>
    </div>
    <x-order-table :orders="$orders" admin />
  </section>

  <div class="workspace-grid">
    <a class="workspace-shortcut" href="{{ route('admin.products.create') }}">
      <div><p class="eyebrow">Catalogue</p><h2>Add a product ↗</h2></div>
      <p>Record approved information, verified pricing and available inventory before publication.</p>
    </a>
    <a class="workspace-shortcut" href="{{ route('admin.batches') }}">
      <div><p class="eyebrow">Manufacturing</p><h2>Trace every unit ↗</h2></div>
      <p>Manage batch records, quality review, release and serialized verification.</p>
    </a>
  </div>
@endsection
