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
            ->assertSee('Biology First™');
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
            ->assertSee('Scientific & regulatory notice');
    }

    public function test_reference_public_routes_render_without_backend_dependencies(): void
    {
        foreach (['/about', '/science', '/labs', '/divisions', '/divisions/b-melanox', '/founder', '/future', '/contact'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_security_headers_are_present(): void
    {
        $this->get('/')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}
