<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    public function test_homepage_renders_the_institutional_positioning(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Beginning in Africa.')
            ->assertSee('Serving the world.')
            ->assertSee('Biology First™')
            ->assertSee('rel="canonical"', false)
            ->assertSee('property="og:site_name"', false);
    }

    public function test_about_page_renders_institutional_identity(): void
    {
        $this->get('/about')
            ->assertOk()
            ->assertSee('Created for what')
            ->assertSee('does not yet exist.')
            ->assertSee('What ORIGINA is.')
            ->assertSee('Emerge from Africa.');
    }

    public function test_labs_page_renders_research_architecture(): void
    {
        $this->get('/labs')
            ->assertOk()
            ->assertSee('The scientific engine')
            ->assertSee('Six connected capabilities.')
            ->assertSee('From question to repeatable output.')
            ->assertSee('Research in active development.');
    }

    public function test_b_melanox_page_renders_scientific_product_positioning(): void
    {
        $this->get('/divisions/b-melanox')
            ->assertOk()
            ->assertSee('Pigmentation is')
            ->assertSee('BMX-24™')
            ->assertSee('The current expression.')
            ->assertSee('Scientific & regulatory notice', false);
    }

    public function test_all_configured_institutional_pages_render_without_placeholders(): void
    {
        foreach (config('origina_content.pages', []) as $page) {
            $this->get($page['path'])
                ->assertOk()
                ->assertSee($page['hero']['title'])
                ->assertDontSee('This surface is prepared for the Laravel frontend migration.');
        }
    }

    public function test_all_configured_division_pages_render_without_placeholders(): void
    {
        foreach (config('origina_content.divisions', []) as $page) {
            $this->get($page['path'])
                ->assertOk()
                ->assertSee($page['hero']['title'])
                ->assertDontSee('This surface is prepared for the Laravel frontend migration.');
        }
    }

    public function test_all_future_horizon_pages_render_without_placeholders(): void
    {
        foreach (config('origina_content.future', []) as $page) {
            $this->get($page['path'])
                ->assertOk()
                ->assertSee($page['hero']['title'])
                ->assertDontSee('This surface is prepared for the Laravel frontend migration.');
        }
    }

    public function test_content_model_has_required_public_metadata(): void
    {
        foreach (['pages', 'divisions', 'future'] as $collection) {
            foreach (config('origina_content.'.$collection, []) as $page) {
                $this->assertNotEmpty($page['path'] ?? null);
                $this->assertNotEmpty($page['title'] ?? null);
                $this->assertNotEmpty($page['description'] ?? null);
                $this->assertNotEmpty($page['hero']['title'] ?? null);
            }
        }
    }

    public function test_sitemap_contains_core_and_content_driven_routes(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee(url('/'), false)
            ->assertSee(url('/science'), false)
            ->assertSee(url('/divisions/novia'), false)
            ->assertSee(url('/future/research-institute'), false);
    }

    public function test_non_production_robots_policy_blocks_indexing(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('User-agent: *')
            ->assertSee('Disallow: /');
    }

    public function test_custom_not_found_page_preserves_the_institutional_shell(): void
    {
        $this->get('/this-route-does-not-exist')
            ->assertNotFound()
            ->assertSee('This page is outside the current map.')
            ->assertSee('Return to ORIGINA');
    }

    public function test_reference_public_routes_render_without_backend_dependencies(): void
    {
        foreach ([
            '/about',
            '/science',
            '/labs',
            '/divisions',
            '/divisions/b-melanox',
            '/divisions/novia',
            '/founder',
            '/future',
            '/contact',
            '/privacy',
        ] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_security_headers_are_present(): void
    {
        $this->get('/')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()')
            ->assertHeader('Cross-Origin-Opener-Policy', 'same-origin')
            ->assertHeader('X-Permitted-Cross-Domain-Policies', 'none');
    }
}
