<header class="site-header" data-site-header>
  <div class="site-shell site-header__inner">
    <a class="wordmark" href="/" aria-label="ORIGINA home">
      <span class="wordmark__seal" aria-hidden="true">O</span>
      <span class="wordmark__text">ORIGINA</span>
    </a>

    <nav class="desktop-nav" aria-label="Primary navigation">
      @foreach(config('origina.navigation', []) as $item)
        <a href="{{ $item['href'] }}" @class(['desktop-nav__link', 'is-active' => request()->is(ltrim($item['href'], '/'))])>
          {{ $item['label'] }}
        </a>
      @endforeach
    </nav>

    <div class="site-header__actions">
      <a class="button button--compact" href="/contact">Enquiries</a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-navigation" data-menu-toggle>
        <span class="sr-only">Open navigation</span>
        <span aria-hidden="true" data-menu-icon>Menu</span>
      </button>
    </div>
  </div>

  <div class="mobile-nav" id="mobile-navigation" hidden data-mobile-nav>
    <nav class="site-shell mobile-nav__inner" aria-label="Mobile navigation">
      @foreach(config('origina.navigation', []) as $item)
        <a href="{{ $item['href'] }}" class="mobile-nav__link">{{ $item['label'] }}</a>
      @endforeach
      <a href="/contact" class="button mobile-nav__cta">Contact ORIGINA</a>
    </nav>
  </div>
</header>
