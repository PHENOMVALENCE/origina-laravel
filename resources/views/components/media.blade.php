@props([
  'src',
  'alt' => '',
  'caption' => null,
  'ratio' => 'editorial',
  'loading' => 'lazy',
  'fetchpriority' => 'auto',
  'width' => 1200,
  'height' => 900,
])

<figure {{ $attributes->class(['media-figure', 'media-figure--'.$ratio]) }}>
  <div class="media-figure__frame">
    <img
      src="{{ asset(ltrim($src, '/')) }}"
      alt="{{ $alt }}"
      width="{{ $width }}"
      height="{{ $height }}"
      loading="{{ $loading }}"
      decoding="async"
      fetchpriority="{{ $fetchpriority }}"
      data-image
    >
  </div>

  @if($caption)
    <figcaption>{{ $caption }}</figcaption>
  @endif
</figure>
