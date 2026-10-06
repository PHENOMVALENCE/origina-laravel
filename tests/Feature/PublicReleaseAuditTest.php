<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicReleaseAuditTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<int, string> */
    private function publicSurfaces(): array
    {
        $paths = ['/', '/shop', '/updates', '/enquire'];

        foreach (['pages', 'divisions', 'future'] as $collection) {
            foreach (config('origina_content.'.$collection, []) as $page) {
                if (is_array($page) && isset($page['path']) && is_string($page['path'])) {
                    $paths[] = $page['path'];
                }
            }
        }

        $paths[] = '/labs';
        $paths[] = '/divisions/b-melanox';

        return array_values(array_unique($paths));
    }

    public function test_public_surfaces_have_release_metadata_and_one_primary_heading(): void
    {
        foreach ($this->publicSurfaces() as $path) {
            $response = $this->get($path)->assertOk();
            $html = $response->getContent();

            $this->assertSame(1, preg_match_all('/<h1(?:\s|>)/i', $html), $path.' must render exactly one h1.');
            $this->assertMatchesRegularExpression('/<meta\s+name="description"\s+content="[^"]+"/i', $html, $path.' must render a non-empty meta description.');
            $this->assertStringContainsString('rel="canonical"', $html, $path.' must render a canonical link.');
            $this->assertStringContainsString('property="og:title"', $html, $path.' must render Open Graph title metadata.');
            $this->assertStringContainsString('property="og:description"', $html, $path.' must render Open Graph description metadata.');
            $this->assertStringNotContainsString('href="#"', $html, $path.' contains a placeholder link.');
            $this->assertStringNotContainsString('javascript:', strtolower($html), $path.' contains an executable URL.');
            $this->assertStringNotContainsString('This surface is prepared for the Laravel frontend migration.', $html, $path.' still contains migration placeholder copy.');
        }
    }

    public function test_rendered_public_internal_links_resolve_without_not_found_or_server_errors(): void
    {
        $links = [];

        foreach ($this->publicSurfaces() as $path) {
            $html = $this->get($path)->assertOk()->getContent();
            preg_match_all('/href="([^"]+)"/i', $html, $matches);

            foreach ($matches[1] ?? [] as $href) {
                if (! str_starts_with($href, '/')) {
                    continue;
                }

                $target = explode('#', $href, 2)[0];
                if ($target !== '') {
                    $links[$target] = true;
                }
            }
        }

        foreach (array_keys($links) as $target) {
            $response = $this->get($target);
            $this->assertLessThan(400, $response->getStatusCode(), 'Broken internal GET link: '.$target);
        }
    }

    public function test_production_robots_allows_public_site_and_blocks_private_namespaces(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Allow: /')
            ->assertSee('Disallow: /admin')
            ->assertSee('Disallow: /account')
            ->assertSee('Disallow: /cart')
            ->assertSee('Disallow: /checkout')
            ->assertSee('Disallow: /api')
            ->assertSee('Disallow: /verify')
            ->assertSee('Sitemap: '.url('/sitemap.xml'));
    }
}
