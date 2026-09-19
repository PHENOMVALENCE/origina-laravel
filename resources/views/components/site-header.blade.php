@php
  $navigation = config('origina.navigation', []);
  $panels = config('origina.panels', []);
@endphp

<header class="site-header" data-site-header>
  <div class="site-shell site-header__inner">
    <a class="wordmark" href="/" aria-label="ORIGINA home">
      <span class="wordmark__seal" aria-hidden="true">
        <img src="{{ asset('img/brand/origina-mark.png') }}" alt="" width="24" height="24">
      </span>
      <span class="wordmark__text">ORIGINA</span>
    </a>

    <nav class="desktop-nav" aria-label="Primary navigation" data-desktop-nav>
      @foreach($navigation as $item)
        @php
          $panelKey = $item['panel'] ?? null;
          $panelLinks = $panelKey ? ($panels[$panelKey] ?? []) : [];
          $path = parse_url($item['href'], PHP_URL_PATH) ?: '/';
          $active = request()->path() === ltrim($path, '/') || ($path !== '/' && request()->is(ltrim($path, '/').'/*'));
        @endphp

        @if($panelKey && count($panelLinks))
          <div class="desktop-nav__item" data-nav-item>
            <button
              type="button"
              @class(['desktop-nav__link', 'is-active' => $active])
              aria-haspopup="true"
              aria-expanded="false"
              aria-controls="panel-{{ $panelKey }}"
              data-nav-trigger
            >
              <span>{{ $item['label'] }}</span>
              <span class="desktop-nav__chevron" aria-hidden="true">⌄</span>
            </button>
            <div class="nav-panel" id="panel-{{ $panelKey }}" hidden data-nav-panel>
              @foreach($panelLinks as $link)
                <a class="nav-panel__link" href="{{ $link['href'] }}">{{ $link['label'] }}</a>
              @endforeach
            </div>
          </div>
        @else
          <a href="{{ $item['href'] }}" @class(['desktop-nav__link', 'is-active' => $active])>
            {{ $item['label'] }}
          </a>
        @endif
      @endforeach
    </nav>

    <div class="site-header__actions">
      <a class="button button--compact" href="/contact">Enquiries</a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-navigation" aria-label="Open menu" data-menu-toggle>
        <span class="sr-only" data-menu-label>Open navigation</span>
        <span aria-hidden="true" data-menu-icon>☰</span>
      </button>
    </div>
  </div>

  <div class="mobile-nav" id="mobile-navigation" role="dialog" aria-modal="true" aria-label="ORIGINA navigation" hidden data-mobile-nav>
    <div class="mobile-nav__bar">
      <span class="mobile-nav__brand">ORIGINA</span>
      <button type="button" class="mobile-nav__close" aria-label="Close menu" data-menu-close>✕</button>
    </div>
    <nav class="mobile-nav__inner" aria-label="Mobile navigation">
      @foreach($navigation as $item)
        @php
          $panelKey = $item['panel'] ?? null;
          $panelLinks = $panelKey ? ($panels[$panelKey] ?? []) : [];
        @endphp

        @if($panelKey && count($panelLinks))
          <section class="mobile-nav__group" aria-labelledby="mobile-nav-{{ $panelKey }}">
            <p class="mobile-nav__label" id="mobile-nav-{{ $panelKey }}">{{ $item['label'] }}</p>
            <div class="mobile-nav__links">
              @foreach($panelLinks as $link)
                <a href="{{ $link['href'] }}" class="mobile-nav__link">{{ $link['label'] }}</a>
              @endforeach
            </div>
          </section>
        @else
          <a href="{{ $item['href'] }}" class="mobile-nav__direct">{{ $item['label'] }}</a>
        @endif
      @endforeach
      <a href="/contact" class="button mobile-nav__cta">Contact ORIGINA</a>
    </nav>
  </div>
</header>
