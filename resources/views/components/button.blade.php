@props(['href', 'variant' => 'primary'])

<a href="{{ $href }}" {{ $attributes->class(['button', 'button--secondary' => $variant === 'secondary']) }}>
  {{ $slot }}
</a>
