<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class OpenApiContractTest extends TestCase
{
    public function test_every_api_route_has_an_openapi_operation(): void
    {
        $spec = json_decode(file_get_contents(base_path('docs/openapi.json')), true, 512, JSON_THROW_ON_ERROR);
        foreach (Route::getRoutes() as $route) {
            if (! str_starts_with($route->uri(), 'api/v1/')) {
                continue;
            }
            $path = '/'.substr($route->uri(), 7);
            foreach ($route->methods() as $method) {
                if ($method === 'HEAD') {
                    continue;
                } $this->assertArrayHasKey(strtolower($method), $spec['paths'][$path] ?? [], $method.' '.$path);
            }
        }
    }
}
