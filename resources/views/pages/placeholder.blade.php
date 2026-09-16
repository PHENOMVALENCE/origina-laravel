@extends('layouts.site')

@section('title', $title.' — ORIGINA')
@section('body-class', !empty($dark) ? 'page-dark' : '')

@section('content')
  <section class="page-hero {{ !empty($dark) ? 'page-hero--dark' : '' }}">
    <div class="site-shell page-hero__inner">
      <p class="eyebrow {{ !empty($dark) ? 'eyebrow--dark' : '' }}">{{ $eyebrow }}</p>
      <h1>{{ $title }}</h1>
      <p class="page-hero__lead">This surface is prepared for the Laravel frontend migration. Approved ORIGINA content and final imagery will be ported here during the institutional frontend phase.</p>
      <a class="text-link {{ !empty($dark) ? 'text-link--dark' : '' }}" href="/">Return to the institutional overview</a>
    </div>
  </section>
@endsection
