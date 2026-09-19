@props([
  'kicker',
  'title',
  'accent' => null,
  'intro' => null,
  'image' => null,
  'alt' => '',
  'caption' => null,
  'dark' => false,
  'crumb' => null,
])

<section class="page-hero {{ $dark ? 'page-hero--dark' : 'page-hero--editorial' }}" aria-labelledby="page-title">
  <div class="site-shell {{ $image ? 'page-hero__grid' : 'page-hero__inner' }}">
    <div class="page-hero__copy reveal">
      @if($crumb)
        <p class="page-hero__crumb"><a href="/">ORIGINA</a><span>/</span>{{ $crumb }}</p>
      @endif

      <p class="eyebrow {{ $dark ? 'eyebrow--dark' : '' }}">{{ $kicker }}</p>
      <h1 id="page-title">
        {{ $title }}
        @if($accent)
          <span>{{ $accent }}</span>
        @endif
      </h1>

      @if($intro)
        <p class="page-hero__lead">{{ $intro }}</p>
      @endif
    </div>

    @if($image)
      <figure class="page-hero__media reveal">
        <img src="{{ $image }}" alt="{{ $alt }}" width="1200" height="1500" fetchpriority="high">
        @if($caption)
          <figcaption>{{ $caption }}</figcaption>
        @endif
      </figure>
    @endif
  </div>
</section>
