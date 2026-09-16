@php
  $footerGroups = config('origina.footer', []);
  $legalLinks = config('origina.footer_legal', []);
@endphp

<footer class="site-footer">
  <div class="site-shell">
    <div class="site-footer__statement">
      <p class="eyebrow eyebrow--dark">ORIGINA™ · Biology First™</p>
      <h2>Beginning in Africa.<br><span>Serving the world.</span></h2>
    </div>

    <div class="site-footer__grid site-footer__grid--expanded">
      @foreach($footerGroups as $group)
        <div>
          <p class="footer-label">{{ $group['title'] }}</p>
          @foreach($group['links'] as $link)
            <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
          @endforeach
        </div>
      @endforeach
    </div>

    <nav class="site-footer__legal" aria-label="Legal and governance">
      @foreach($legalLinks as $link)
        <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
      @endforeach
    </nav>

    <div class="site-footer__bottom">
      <span>Dar es Salaam, Tanzania</span>
      <span>© {{ date('Y') }} ORIGINA. All rights reserved.</span>
    </div>
  </div>
</footer>
