@extends('layouts.portal')

@section('title', 'Your overview')
@section('heading', 'Welcome, '.auth()->user()->name.'.')
@section('subtitle', 'Your products, your orders and the next useful actions in one place.')
@section('actions')
  <a href="{{ route('shop') }}" class="button">Explore the collection ↗</a>
@endsection

@section('content')
  <div class="operations-health" aria-label="Account guidance">
    <div><strong>Review before purchase</strong><span>Read product information, usage guidance and evidence notes before ordering.</span></div>
    <div><strong>Track every order</strong><span>Use your order history for payment, fulfilment and delivery status.</span></div>
    <div><strong>Verify product records</strong><span>Serialized product labels can be checked through ORIGINA verification records.</span></div>
  </div>

  <div class="stat-grid">
    <article class="stat"><p>Total orders</p><strong>{{ $orderCount }}</strong><small>Your ORIGINA order history</small></article>
    <article class="stat"><p>In progress</p><strong>{{ $activeCount }}</strong><small>Orders awaiting completion</small></article>
    <article class="stat"><p>Confirmed payments</p><strong><small>TZS</small> {{ number_format($totalSpent) }}</strong><small>Across confirmed paid orders</small></article>
  </div>

  <section class="workspace-panel workspace-panel--accent">
    <div class="section-top">
      <div>
        <p class="eyebrow">Order history</p>
        <h2>Recent orders</h2>
      </div>
      <a href="{{ route('account.orders') }}">View all →</a>
    </div>
    <x-order-table :orders="$orders" />
  </section>

  <div class="workspace-grid">
    <section class="workspace-panel">
      <p class="eyebrow">Confidence in the details</p>
      <h2>Understand your product.</h2>
      <p class="workspace-panel__intro">Read ingredients, usage guidance and evidence notes before making a selection. ORIGINA separates scientific context from marketing language.</p>
      <a href="/science/evidence">Explore our evidence principles ↗</a>
    </section>

    <section class="workspace-panel">
      <p class="eyebrow">Your product record</p>
      <h2>Verify a package.</h2>
      <p class="workspace-panel__intro">Scan the serialized QR label on your product to review its recorded batch information. Contact ORIGINA if a code is missing, revoked or uncertain.</p>
      <a href="{{ route('enquire') }}">Customer support ↗</a>
    </section>
  </div>
@endsection
