<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\TestCase;

class MySqlConcurrencyTest extends TestCase
{
    use DatabaseMigrations;

    public function test_simultaneous_customers_cannot_oversell_one_unit(): void
    {
        if (config('database.default') !== 'mysql') {
            $this->markTestSkipped('MySQL row-locking check; executed in the MySQL CI job.');
        }
        $users = [];
        for ($i = 0; $i < 2; $i++) {
            $u = User::create(['name' => 'Concurrency fixture', 'email' => Str::uuid().'@example.com', 'password' => 'StrongPassword123']);
            $u->forceFill(['email_verified_at' => now()])->save();
            $users[] = $u;
        }
        $p = Product::create(['name' => 'Concurrency fixture', 'slug' => 'concurrency-fixture', 'sku' => 'CONCURRENT', 'division' => 'novia', 'description' => 'Test only', 'price' => 1000, 'stock' => 1, 'published' => true]);
        $env = getenv();
        $env['APP_ENV'] = 'testing';
        $env['MAIL_MAILER'] = 'array';
        $env['DB_CONNECTION'] = 'mysql';
        foreach (['host' => 'DB_HOST', 'port' => 'DB_PORT', 'database' => 'DB_DATABASE', 'username' => 'DB_USERNAME', 'password' => 'DB_PASSWORD'] as $key => $name) {
            $env[$name] = (string) config('database.connections.mysql.'.$key);
        }
        $jobs = [];
        foreach ($users as $u) {
            $pipes = [];
            $process = proc_open([PHP_BINARY, base_path('tests/Support/checkout-worker.php'), (string) $u->id, (string) $p->id], [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, base_path(), $env);
            $this->assertIsResource($process);
            fclose($pipes[0]);
            $jobs[] = [$process, $pipes];
        }
        $results = [];
        foreach ($jobs as [$process,$pipes]) {
            $results[] = stream_get_contents($pipes[1]);
            $error = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $code = proc_close($process);
            $this->assertSame(0, $code, $error);
        }
        sort($results);
        $this->assertSame(['OUT_OF_STOCK', 'SUCCESS'], $results);
        $this->assertSame(1, Order::count());
        $this->assertSame(0, $p->fresh()->stock);
    }
}
