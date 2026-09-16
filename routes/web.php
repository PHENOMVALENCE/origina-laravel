<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');

$pages = [
    '/about' => ['About ORIGINA', 'Institution'],
    '/founder' => ['Dr. Elizabeth Consoli', 'Founder'],
    '/africa' => ['Africa Originating', 'Institution'],
    '/biology-first' => ['Biology First™', 'Science'],
    '/culture' => ['Culture & Talent', 'Institution'],
    '/science' => ['Science', 'Science'],
    '/labs' => ['ORIGINA Labs™', 'Science'],
    '/platforms' => ['Scientific Platforms', 'Science'],
    '/science/evidence' => ['Scientific Evidence', 'Evidence & Quality'],
    '/science/regulatory' => ['Regulatory Science', 'Evidence & Quality'],
    '/science/quality' => ['Quality & Safety', 'Evidence & Quality'],
    '/science/responsible-science' => ['Responsible Science', 'Evidence & Quality'],
    '/intellectual-property' => ['Intellectual Property', 'Institution'],
    '/divisions' => ['Divisions', 'Institution'],
    '/future' => ['The Institutional Horizon', 'Future'],
    '/contact' => ['Enquire with ORIGINA', 'Connect'],
    '/updates' => ['Updates', 'Institution'],
    '/privacy' => ['Privacy', 'Legal'],
    '/terms' => ['Terms', 'Legal'],
];

foreach ($pages as $uri => [$title, $eyebrow]) {
    Route::get($uri, fn () => view('pages.placeholder', compact('title', 'eyebrow')));
}

foreach (config('origina.divisions', []) as $division) {
    Route::get('/divisions/'.$division['slug'], fn () => view('pages.placeholder', [
        'title' => $division['name'],
        'eyebrow' => 'ORIGINA Division',
        'dark' => true,
    ]));
}

foreach (['academy', 'ventures', 'research-institute', 'foundation', 'product-divisions', 'unnamed'] as $future) {
    Route::get('/future/'.$future, fn () => view('pages.placeholder', [
        'title' => str($future)->replace('-', ' ')->title(),
        'eyebrow' => 'Future',
    ]));
}

Route::get('/robots.txt', function () {
    $body = app()->environment('production')
        ? "User-agent: *\nAllow: /\n"
        : "User-agent: *\nDisallow: /\n";

    return response($body, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
});
