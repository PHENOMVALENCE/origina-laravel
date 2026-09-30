<?php

use App\Models\User;
use App\Services\Checkout;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
config(['commerce.checkout_enabled' => true]);
try {
    $user = User::findOrFail((int) $argv[1]);
    app(Checkout::class)->place($user, [(int) $argv[2] => 1], ['name' => 'Concurrency fixture', 'phone' => '123', 'address' => 'Test only', 'city' => 'Dar es Salaam'], (string) Str::uuid());
    echo 'SUCCESS';
} catch (ValidationException) {
    echo 'OUT_OF_STOCK';
}
