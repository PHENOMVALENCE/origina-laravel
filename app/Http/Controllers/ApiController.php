<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\Audit;
use App\Services\Checkout;
use App\Services\OrderWorkflow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApiController
{
    public function products(): JsonResponse
    {
        return response()->json(Product::where('published', true)->orderBy('name')->paginate(20));
    }

    public function product(Product $product): JsonResponse
    {
        abort_unless($product->published, 404);

        return response()->json(['data' => $product]);
    }

    public function orders(Request $request): JsonResponse
    {
        return response()->json(Order::with('items')->where('user_id', $request->user()->id)->latest()->paginate(20));
    }

    public function order(Request $request, Order $order): JsonResponse
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        return response()->json(['data' => $order->load('items')]);
    }

    public function checkout(Request $request, Checkout $service): JsonResponse
    {
        $data = $request->validate(['items' => 'required|array|min:1|max:50', 'items.*.product_id' => 'required|integer|distinct|exists:products,id', 'items.*.quantity' => 'required|integer|min:1|max:99', 'shipping_address' => 'required|array:name,phone,address,city', 'shipping_address.name' => 'required|string|max:100', 'shipping_address.phone' => 'required|string|max:30', 'shipping_address.address' => 'required|string|max:500', 'shipping_address.city' => 'required|string|max:100', 'checkout_key' => 'required|uuid', 'consent' => 'accepted']);
        $cart = [];
        foreach ($data['items'] as $item) {
            $cart[(int) $item['product_id']] = (int) $item['quantity'];
        }
        /** @var User $user */ $user = $request->user();

        return response()->json(['data' => $service->place($user, $cart, $data['shipping_address'], $data['checkout_key'])], 201);
    }

    public function cancel(Request $request, Order $order, OrderWorkflow $service): JsonResponse
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        return response()->json(['data' => $service->transition($order, 'cancelled')]);
    }

    public function adminOrders(): JsonResponse
    {
        return response()->json(Order::with('items', 'user')->latest()->paginate(20));
    }

    public function adminProducts(): JsonResponse
    {
        return response()->json(Product::latest()->paginate(20));
    }

    public function saveProduct(ProductRequest $request, ?Product $product = null): JsonResponse
    {
        $data = $request->validated();
        unset($data['image']);
        if (empty($data['image_path'])) {
            unset($data['image_path']);
        }
        if (! empty($data['image_path']) && ! is_file(public_path($data['image_path']))) {
            throw ValidationException::withMessages(['image_path' => 'Select an existing product image.']);
        }
        $product = DB::transaction(function () use ($product, $data): Product {
            if ($product?->exists) {
                $product = Product::whereKey($product->id)->lockForUpdate()->firstOrFail();
                $product->update($data);
            } else {
                $product = Product::create($data);
            }
            Audit::record('product.api_saved', $product, ['stock' => $product->stock, 'price' => $product->price]);

            return $product;
        }, 3);

        return response()->json(['data' => $product]);
    }

    public function transition(Request $request, Order $order, OrderWorkflow $service): JsonResponse
    {
        $data = $request->validate(['status' => 'required|in:confirmed,processing,shipped,delivered,cancelled', 'tracking_reference' => 'nullable|string|max:150']);

        return response()->json(['data' => $service->transition($order, $data['status'], $data['tracking_reference'] ?? null)]);
    }

    public function payment(Request $request, Order $order, OrderWorkflow $service): JsonResponse
    {
        $data = $request->validate(['payment_reference' => 'required|string|max:150|unique:orders,payment_reference', 'confirm' => 'accepted']);

        return response()->json(['data' => $service->confirmPayment($order, $data['payment_reference'])]);
    }
}
