@extends('layouts.site')

@section('title', 'Page not found — ORIGINA')
@section('description', 'The requested ORIGINA page could not be found.')

@section('content')
  <section class="error-page">
    <div class="site-shell error-page__grid">
      <div>
        <p class="error-page__code">404</p>
        <p class="eyebrow">ORIGINA / Navigation</p>
        <h1>This page is outside the current map.</h1>
        <p>The address may have changed, the page may not yet exist, or the link may be incomplete. Continue through the institutional architecture below.</p>
      </div>
      <div class="error-page__actions">
        <a class="button" href="/">Return to ORIGINA</a>
        <a class="text-link" href="/science">Explore science</a>
        <a class="text-link" href="/divisions">View divisions</a>
        <a class="text-link" href="/contact">Contact ORIGINA</a>
      </div>
    </div>
  </section>
@endsection
