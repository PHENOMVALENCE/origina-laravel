<?php

use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/labs', 'pages.labs')->name('labs');
Route::view('/divisions/b-melanox', 'pages.divisions.b-melanox')->name('divisions.b-melanox');

$institutionalPages = [
    '/founder' => ['founder', 'founder'],
    '/africa' => ['africa', 'africa'],
    '/biology-first' => ['biology-first', 'biology-first'],
    '/culture' => ['culture', 'culture'],
    '/science' => ['science', 'science'],
    '/platforms' => ['platforms', 'platforms'],
    '/science/evidence' => ['evidence', 'science.evidence'],
    '/science/regulatory' => ['regulatory', 'science.regulatory'],
    '/science/quality' => ['quality', 'science.quality'],
    '/science/responsible-science' => ['responsible-science', 'science.responsible'],
    '/intellectual-property' => ['intellectual-property', 'intellectual-property'],
    '/divisions' => ['divisions', 'divisions'],
    '/future' => ['future', 'future'],
    '/contact' => ['contact', 'contact'],
    '/updates' => ['updates', 'updates'],
    '/privacy' => ['privacy', 'privacy'],
    '/terms' => ['terms', 'terms'],
];

foreach ($institutionalPages as $uri => [$contentKey, $routeName]) {
    Route::get($uri, [PublicPageController::class, 'page'])
        ->defaults('contentKey', $contentKey)
        ->name($routeName);
}

$divisionRoutes = [
    'bettyworld' => 'divisions.bettyworld',
    'bvalence' => 'divisions.bvalence',
    'divine' => 'divisions.divine',
    'novia' => 'divisions.novia',
    'skin-safari' => 'divisions.skin-safari',
];

foreach ($divisionRoutes as $contentKey => $routeName) {
    Route::get('/divisions/'.$contentKey, [PublicPageController::class, 'division'])
        ->defaults('contentKey', $contentKey)
        ->name($routeName);
}

foreach (array_keys(config('origina_content.future', [])) as $contentKey) {
    Route::get('/future/'.$contentKey, [PublicPageController::class, 'future'])
        ->defaults('contentKey', $contentKey)
        ->name('future.'.$contentKey);
}

Route::get('/robots.txt', [PublicPageController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [PublicPageController::class, 'sitemap'])->name('sitemap');
