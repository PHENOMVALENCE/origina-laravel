<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontendArchitectureTest extends TestCase
{
    public function test_modern_design_layer_exists_and_is_loaded_after_legacy_layers(): void
    {
        $modern = resource_path('css/modern.css');
        $site = file_get_contents(resource_path('views/layouts/site.blade.php'));
        $portal = file_get_contents(resource_path('views/layouts/portal.blade.php'));

        $this->assertFileExists($modern);
        $this->assertStringContainsString("@vite('resources/css/modern.css')", $site);
        $this->assertStringContainsString("@vite('resources/css/modern.css')", $portal);

        $this->assertGreaterThan(
            strpos($site, 'production-refinement.css'),
            strpos($site, "@vite('resources/css/modern.css')")
        );
        $this->assertGreaterThan(
            strpos($portal, 'portal-refinement.css'),
            strpos($portal, "@vite('resources/css/modern.css')")
        );
    }

    public function test_modern_layer_covers_all_primary_surface_families(): void
    {
        $css = file_get_contents(resource_path('css/modern.css'));

        foreach ([
            '.site-header',
            '.home-hero',
            '.section',
            '.collection-hero',
            '.product-grid',
            '.commerce-page',
            '.auth-scene',
            '.portal-sidebar',
            '.portal-content',
            '.data-table',
        ] as $selector) {
            $this->assertStringContainsString($selector, $css, "Missing design coverage for {$selector}");
        }
    }
}
