<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('throttle:api')->group(function (): void {
    Route::get('/products', [ApiController::class, 'products']);
    Route::get('/products/{product}', [ApiController::class, 'product']);
    Route::post('/tokens', [AuthController::class, 'token'])->middleware('throttle:identity');
    Route::middleware(['auth:sanctum', 'active', 'verified'])->group(function (): void {
        Route::get('/me', fn (Request $request) => response()->json(['data' => $request->user()]));
        Route::delete('/tokens/current', function (Request $request) {
            $token = $request->user()->currentAccessToken();
            $token->delete();

            return response()->noContent();
        });
        Route::get('/orders', [ApiController::class, 'orders']);
        Route::get('/orders/{order}', [ApiController::class, 'order']);
        Route::post('/orders', [ApiController::class, 'checkout'])->middleware('throttle:10,1');
        Route::post('/orders/{order}/cancel', [ApiController::class, 'cancel']);
        Route::prefix('admin')->middleware('admin')->group(function (): void {
            Route::get('/products', [ApiController::class, 'adminProducts']);
            Route::post('/products', [ApiController::class, 'saveProduct']);
            Route::put('/products/{product}', [ApiController::class, 'saveProduct']);
            Route::get('/orders', [ApiController::class, 'adminOrders']);
            Route::patch('/orders/{order}', [ApiController::class, 'transition']);
            Route::post('/orders/{order}/payment', [ApiController::class, 'payment']);
        });
    });
});
