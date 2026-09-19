@extends('layouts.site')

@section('title', 'Temporarily unavailable — ORIGINA')
@section('description', 'ORIGINA is temporarily unavailable while maintenance is in progress.')

@section('content')
  <section class="error-page">
    <div class="site-shell error-page__grid">
      <div>
        <p class="error-page__code">503</p>
        <p class="eyebrow">ORIGINA / Maintenance</p>
        <h1>Quiet work is happening behind the institution.</h1>
        <p>The public platform is temporarily unavailable while maintenance is in progress. Please return shortly.</p>
      </div>
      <div class="error-page__actions">
        <a class="button" href="/">Try the homepage</a>
        <a class="text-link" href="mailto:info@origina.co">info@origina.co</a>
      </div>
    </div>
  </section>
@endsection
