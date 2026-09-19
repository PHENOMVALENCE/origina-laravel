<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicPageController extends Controller
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

    public function sitemap(): Response
    {
        $urls = collect(config('origina_content.pages', []))
            ->merge(config('origina_content.divisions', []))
            ->merge(config('origina_content.future', []))
            ->pluck('path')
            ->prepend('/divisions/b-melanox')
            ->prepend('/labs')
            ->prepend('/about')
            ->prepend('/')
            ->filter()
            ->unique()
            ->sort()
            ->values();

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
