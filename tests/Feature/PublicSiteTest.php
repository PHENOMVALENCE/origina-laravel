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

    public function test_reference_public_routes_render_without_backend_dependencies(): void
    {
        foreach (['/about', '/science', '/labs', '/divisions', '/founder', '/future', '/contact'] as $uri) {
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
