@props([
  'tone' => 'paper',
  'eyebrow' => null,
  'title' => null,
  'intro' => null,
  'id' => null,
])

<section @if($id) id="{{ $id }}" @endif class="section section--{{ $tone }}">
  <div class="site-shell">
    @if($eyebrow || $title || $intro)
      <header class="section__header">
        @if($eyebrow)
          <p class="eyebrow {{ in_array($tone, ['noir', 'deep']) ? 'eyebrow--dark' : '' }}">{{ $eyebrow }}</p>
        @endif
        @if($title)
          <h2 class="section__title">{{ $title }}</h2>
        @endif
        @if($intro)
          <p class="section__intro">{{ $intro }}</p>
        @endif
      </header>
    @endif

    {{ $slot }}
  </div>
</section>
