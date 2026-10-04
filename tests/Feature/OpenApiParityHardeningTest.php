<?php

namespace Tests\Feature;

use Illuminate\Routing\Route as IlluminateRoute;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class OpenApiParityHardeningTest extends TestCase
{
    /** @return array<string, mixed> */
    private function spec(): array
    {
        return json_decode(file_get_contents(base_path('docs/openapi.json')), true, 512, JSON_THROW_ON_ERROR);
    }

    /** @return array<string, true> */
    private function runtimeOperations(): array
    {
        $operations = [];

        /** @var IlluminateRoute $route */
        foreach (Route::getRoutes() as $route) {
            if (! str_starts_with($route->uri(), 'api/v1/')) {
                continue;
            }

            $path = '/'.substr($route->uri(), 7);
            foreach ($route->methods() as $method) {
                if ($method === 'HEAD') {
                    continue;
                }

                $operations[strtoupper($method).' '.$path] = true;
            }
        }

        return $operations;
    }

    public function test_every_openapi_operation_maps_to_a_runtime_route(): void
    {
        $runtime = $this->runtimeOperations();
        $spec = $this->spec();
        $httpMethods = ['get', 'post', 'put', 'patch', 'delete'];

        foreach ($spec['paths'] as $path => $pathItem) {
            foreach ($httpMethods as $method) {
                if (! isset($pathItem[$method])) {
                    continue;
                }

                $this->assertArrayHasKey(strtoupper($method).' '.$path, $runtime, 'OpenAPI operation has no matching Laravel route: '.strtoupper($method).' '.$path);
            }
        }
    }

    public function test_protected_operations_explicitly_declare_bearer_security(): void
    {
        $spec = $this->spec();
        $publicOperations = [
            'POST /tokens',
            'GET /products',
            'GET /products/{product}',
        ];
        $httpMethods = ['get', 'post', 'put', 'patch', 'delete'];

        foreach ($spec['paths'] as $path => $pathItem) {
            foreach ($httpMethods as $method) {
                if (! isset($pathItem[$method])) {
                    continue;
                }

                $key = strtoupper($method).' '.$path;
                if (in_array($key, $publicOperations, true)) {
                    continue;
                }

                $security = $pathItem[$method]['security'] ?? [];
                $hasBearer = collect($security)->contains(fn (array $requirement): bool => array_key_exists('bearerAuth', $requirement));
                $this->assertTrue($hasBearer, 'Protected OpenAPI operation must declare bearerAuth: '.$key);
            }
        }
    }

    public function test_admin_openapi_operations_document_authorization_failure(): void
    {
        $spec = $this->spec();
        $httpMethods = ['get', 'post', 'put', 'patch', 'delete'];

        foreach ($spec['paths'] as $path => $pathItem) {
            if (! str_starts_with($path, '/admin/')) {
                continue;
            }

            foreach ($httpMethods as $method) {
                if (! isset($pathItem[$method])) {
                    continue;
                }

                $operation = $pathItem[$method];
                $this->assertContains('Administration', $operation['tags'] ?? [], strtoupper($method).' '.$path.' must use the Administration tag.');
                $this->assertArrayHasKey('403', $operation['responses'] ?? [], strtoupper($method).' '.$path.' must document insufficient-role responses.');
            }
        }
    }

    public function test_openapi_declares_the_expected_bearer_scheme(): void
    {
        $scheme = $this->spec()['components']['securitySchemes']['bearerAuth'] ?? null;

        $this->assertIsArray($scheme);
        $this->assertSame('http', $scheme['type'] ?? null);
        $this->assertSame('bearer', $scheme['scheme'] ?? null);
        $this->assertSame('JWT', strtoupper((string) ($scheme['bearerFormat'] ?? 'JWT')));
    }
}
