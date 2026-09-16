<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#fdfbf7">
  <meta name="description" content="@yield('description', 'ORIGINA is a multi-divisional innovation institution built at the intersection of biology, clinical science, technology, and human wellbeing.')">
  @unless(app()->environment('production'))
    <meta name="robots" content="noindex,nofollow">
  @endunless
  <title>@yield('title', 'ORIGINA — Biology First™')</title>

  <link rel="icon" href="/favicon.ico" sizes="any">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600&family=Source+Serif+4:opsz,wght@8..60,400;8..60,500;8..60,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/parity.css">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="@yield('body-class')">
  <a class="skip-link" href="#main-content">Skip to content</a>
  <x-site-header />

  <main id="main-content">
    @yield('content')
  </main>

  <x-site-footer />
</body>
</html>
