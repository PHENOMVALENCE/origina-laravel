<?php

namespace Tests\Feature;

use Tests\TestCase;

class RuntimeCompatibilityTest extends TestCase
{
    public function test_runtime_stays_on_supported_php_82_line(): void
    {
        $this->assertGreaterThanOrEqual(80212, PHP_VERSION_ID, 'ORIGINA requires PHP 8.2.12 or newer.');
        $this->assertLessThan(80300, PHP_VERSION_ID, 'ORIGINA is currently pinned to the PHP 8.2 runtime line.');
    }

    public function test_composer_declares_the_php_82_platform_baseline(): void
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true, 512, JSON_THROW_ON_ERROR);

        $this->assertSame('>=8.2.12 <8.3', $composer['require']['php'] ?? null);
        $this->assertSame('8.2.12', $composer['config']['platform']['php'] ?? null);
    }
}
