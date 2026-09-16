@props(['items' => []])

@if(count($items))
  <nav class="section-nav" aria-label="Page sections">
    <div class="site-shell section-nav__track">
      @foreach($items as $item)
        <a href="#{{ $item['id'] }}">{{ $item['label'] }}</a>
      @endforeach
    </div>
  </nav>
@endif
