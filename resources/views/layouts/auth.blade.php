@extends('layouts.site')
@section('content')<section class="auth-scene"><div class="auth-story"><p class="eyebrow">ORIGINA · Biology First™</p><h1>@yield('heading')</h1><p>@yield('intro')</p><div class="auth-story__rule"></div><p>Beginning in Africa.<br>Serving the world.</p></div><div class="auth-panel"><x-flash />@yield('form')</div></section>@endsection
