<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TraceabilityController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.product');
Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
Route::post('/cart/{product}', [ShopController::class, 'add'])->middleware('throttle:60,1')->name('cart.add');
Route::patch('/cart/{product}', [ShopController::class, 'update'])->name('cart.update');
Route::get('/verify/{token}', [TraceabilityController::class, 'verify'])->where('token', '[a-f0-9]{64}')->middleware('throttle:30,1')->name('verify');
Route::view('/enquire', 'shop.enquiry')->name('enquire');
Route::post('/enquire', [EnquiryController::class, 'store'])->middleware('throttle:5,1')->name('enquire.store');
Route::middleware('guest')->group(function (): void {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:identity');
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
    Route::view('/forgot-password', 'auth.forgot')->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgot'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/reset-password/{token}', fn (Request $request, string $token) => view('auth.reset', ['token' => $token, 'email' => $request->query('email')]))->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->middleware('throttle:5,1')->name('password.update');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::middleware(['auth', 'active'])->group(function (): void {
    Route::view('/email/verify', 'auth.verify')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('account.dashboard');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Verification link sent.');
    })->middleware('throttle:6,1')->name('verification.send');
});
Route::middleware(['auth', 'auth.session', 'active', 'verified'])->group(function (): void {
    Route::get('/checkout', [ShopController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [ShopController::class, 'place'])->middleware('throttle:10,1')->name('checkout.store');
    Route::get('/account', [AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/orders/{order}', [AccountController::class, 'order'])->name('account.orders.show');
    Route::post('/account/orders/{order}/cancel', [AccountController::class, 'cancel'])->name('account.orders.cancel');
    Route::view('/account/profile', 'account.profile')->name('account.profile');
    Route::patch('/account/profile', [AccountController::class, 'profile'])->name('account.profile.update');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', 'auth.session', 'active', 'verified', 'admin'])->group(function (): void {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'productForm'])->name('products.create');
    Route::get('/products/{product}/edit', [AdminController::class, 'productForm'])->name('products.edit');
    Route::post('/products', [AdminController::class, 'productSave'])->name('products.store');
    Route::put('/products/{product}', [AdminController::class, 'productSave'])->name('products.update');
    Route::post('/products/{product}/archive', [AdminController::class, 'archive'])->name('products.archive');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'order'])->name('orders.show');
    Route::patch('/orders/{order}', [AdminController::class, 'transition'])->name('orders.update');
    Route::post('/orders/{order}/payment', [AdminController::class, 'payment'])->name('orders.payment');
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::patch('/customers/{user}', [AdminController::class, 'user'])->name('customers.update');
    Route::get('/enquiries', [AdminController::class, 'enquiries'])->name('enquiries');
    Route::patch('/enquiries/{enquiry}', [AdminController::class, 'enquiry'])->name('enquiries.update');
    Route::get('/publications', [PublicationController::class, 'admin'])->name('publications');
    Route::get('/publications/create', [PublicationController::class, 'form'])->name('publications.create');
    Route::get('/publications/{publication}/edit', [PublicationController::class, 'form'])->name('publications.edit');
    Route::post('/publications', [PublicationController::class, 'save'])->name('publications.store');
    Route::put('/publications/{publication}', [PublicationController::class, 'save'])->name('publications.update');
    Route::get('/audit', [AdminController::class, 'audit'])->name('audit');
    Route::get('/batches', [AdminController::class, 'batches'])->name('batches');
    Route::post('/batches', [TraceabilityController::class, 'create'])->name('batches.store');
    Route::get('/batches/{batch}', [AdminController::class, 'batch'])->name('batches.show');
    Route::patch('/batches/{batch}', [TraceabilityController::class, 'transition'])->name('batches.update');
    Route::post('/batches/{batch}/units', [TraceabilityController::class, 'generate'])->name('batches.units');
    Route::get('/batches/{batch}/export', [TraceabilityController::class, 'export'])->name('batches.export');
    Route::get('/units/{unit}/label', [TraceabilityController::class, 'label'])->name('units.label');
    Route::post('/units/{unit}/revoke', [TraceabilityController::class, 'revoke'])->name('units.revoke');
    Route::get('/api-docs', function () {
        abort_unless(! app()->environment('production') || config('commerce.api_docs_enabled'), 404);

        return view('admin.api-docs');
    })->name('api-docs');
    Route::get('/openapi.json', function () {
        abort_unless(! app()->environment('production') || config('commerce.api_docs_enabled'), 404);

        return response()->file(base_path('docs/openapi.json'));
    })->name('openapi');
});

Route::get('/updates/{publication:slug}', [PublicationController::class, 'show'])->name('updates.show');
