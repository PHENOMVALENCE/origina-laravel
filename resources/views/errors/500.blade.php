@extends('layouts.site')

@section('title', 'Temporary system issue — ORIGINA')
@section('description', 'ORIGINA encountered a temporary system issue.')

@section('content')
  <section class="error-page">
    <div class="site-shell error-page__grid">
      <div>
        <p class="error-page__code">500</p>
        <p class="eyebrow">ORIGINA / System</p>
        <h1>The institution is here. This request failed.</h1>
        <p>A temporary application issue prevented this page from loading correctly. No action is required from you.</p>
      </div>
      <div class="error-page__actions">
        <a class="button" href="/">Return to ORIGINA</a>
        <a class="text-link" href="/contact">Contact ORIGINA</a>
      </div>
    </div>
  </section>
@endsection
