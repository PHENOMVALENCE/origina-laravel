<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\OrderReceived;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Checkout
{
    /**
     * @param  array<int, int>  $cart
     * @param  array<string, string>  $address
     */
    public function place(User $user, array $cart, array $address, string $key): Order
    {
        if (! config('commerce.checkout_enabled')) {
            throw ValidationException::withMessages(['checkout' => 'Ordering is not available yet. Please contact ORIGINA.']);
        }

        return DB::transaction(function () use ($user, $cart, $address, $key): Order {
            // User lock serializes retries of this customer's idempotency key.
            User::whereKey($user->id)->lockForUpdate()->firstOrFail();
            $existing = Order::where('checkout_key', $key)->first();
            if ($existing) {
                abort_unless($existing->user_id === $user->id, 403);

                return $existing;
            }
            if (! $cart || count($cart) > 50) {
                throw ValidationException::withMessages(['cart' => 'Add between 1 and 50 products before checkout.']);
            }
            ksort($cart);
            $lines = [];
            $subtotal = 0;
            foreach ($cart as $id => $quantity) {
                $product = Product::whereKey($id)->lockForUpdate()->first();
                if (! $product || ! $product->published || $quantity < 1 || $quantity > 99 || $product->stock < $quantity) {
                    throw ValidationException::withMessages(['cart' => 'A product is unavailable or has insufficient stock. Review your bag.']);
                }
                $subtotal += $product->price * $quantity;
                $lines[] = ['product_id' => $product->id, 'name' => $product->name, 'sku' => $product->sku, 'quantity' => $quantity, 'unit_price' => $product->price];
                $product->decrement('stock', $quantity);
            }
            $shipping = max(0, (int) config('commerce.shipping_fee'));
            $order = Order::create(['number' => (string) Str::uuid(), 'user_id' => $user->id, 'checkout_key' => $key, 'subtotal' => $subtotal, 'shipping_fee' => $shipping, 'total' => $subtotal + $shipping, 'currency' => 'TZS', 'shipping_address' => $address]);
            foreach ($lines as $line) {
                OrderItem::create($line + ['order_id' => $order->id]);
            }
            Audit::record('order.placed', $order, ['total' => $order->total]);
            DB::afterCommit(function () use ($user, $order): void {
                try {
                    $user->notify(new OrderReceived($order));
                } catch (\Throwable $exception) {
                    report($exception);
                }
            });

            return $order->load('items');
        }, 3);
    }
}
