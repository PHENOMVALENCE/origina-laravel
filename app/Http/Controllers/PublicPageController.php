<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class PublicPageController
{
    public function page(Request $request): View
    {
        return $this->renderFromCollection('pages', (string) $request->route('contentKey'));
    }

    public function division(Request $request): View
    {
        return $this->renderFromCollection('divisions', (string) $request->route('contentKey'));
    }

    public function future(Request $request): View
    {
        return $this->renderFromCollection('future', (string) $request->route('contentKey'));
    }

    public function robots(): Response
    {
        $body = app()->environment('production')
            ? "User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n"
            : "User-agent: *\nDisallow: /\n";

        return response($body, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function sitemap(): Response
    {
        $urls = ['/', '/about', '/labs', '/divisions/b-melanox'];

        foreach (['pages', 'divisions', 'future'] as $collection) {
            $pages = config('origina_content.'.$collection, []);

            if (! is_array($pages)) {
                continue;
            }

            foreach ($pages as $page) {
                if (! is_array($page) || ! isset($page['path']) || ! is_string($page['path'])) {
                    continue;
                }

                $urls[] = $page['path'];
            }
        }

        $urls = array_values(array_unique($urls));
        sort($urls);

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    private function renderFromCollection(string $collection, string $key): View
    {
        $page = config("origina_content.{$collection}.{$key}");

        abort_if(! is_array($page), 404);

        return view('pages.content', [
            'page' => $page,
            'directories' => config('origina_content.directories', []),
        ]);
    }
}
