<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderWorkflow
{
    public function transition(Order $order, string $next, ?string $tracking = null): Order
    {
        $tracking = $tracking === null ? null : trim($tracking);
        if ($tracking !== null && mb_strlen($tracking) > 150) {
            throw ValidationException::withMessages(['tracking_reference' => 'The dispatch or tracking reference may not exceed 150 characters.']);
        }

        return DB::transaction(function () use ($order, $next, $tracking): Order {
            $order = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            $allowed = ['pending' => ['confirmed', 'cancelled'], 'confirmed' => ['processing'], 'processing' => ['shipped'], 'shipped' => ['delivered'], 'delivered' => [], 'cancelled' => []];
            if (! in_array($next, $allowed[$order->status] ?? [], true)) {
                throw ValidationException::withMessages(['status' => 'This order transition is not allowed.']);
            }
            if ($next === 'confirmed' && $order->payment_status !== 'paid') {
                throw ValidationException::withMessages(['status' => 'Confirm received payment before confirming the order.']);
            }
            if ($next === 'cancelled' && $order->payment_status === 'paid') {
                throw ValidationException::withMessages(['status' => 'Paid orders require a reconciled refund; contact the operations owner.']);
            }
            if ($next === 'shipped' && ($tracking === null || $tracking === '')) {
                throw ValidationException::withMessages(['tracking_reference' => 'Provide a dispatch or tracking reference.']);
            }
            if ($next === 'cancelled') {
                foreach ($order->items()->orderBy('product_id')->get() as $item) {
                    Product::whereKey($item->product_id)->lockForUpdate()->firstOrFail()->increment('stock', $item->quantity);
                }
            }
            $from = $order->status;
            $order->update(['status' => $next, 'tracking_reference' => $tracking ?? $order->tracking_reference]);
            Audit::record('order.transitioned', $order, ['from' => $from, 'to' => $next]);

            return $order;
        }, 3);
    }

    public function confirmPayment(Order $order, string $reference): Order
    {
        $reference = trim($reference);
        if ($reference === '' || mb_strlen($reference) > 150) {
            throw ValidationException::withMessages(['payment_reference' => 'Provide a valid payment reference of up to 150 characters.']);
        }

        return DB::transaction(function () use ($order, $reference): Order {
            $order = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            if ($order->status === 'cancelled' || $order->payment_status === 'paid') {
                throw ValidationException::withMessages(['payment_reference' => 'This order cannot receive another payment confirmation.']);
            }
            $order->update(['payment_status' => 'paid', 'payment_reference' => $reference, 'paid_at' => now()]);
            Audit::record('payment.manually_confirmed', $order, ['reference' => $reference]);

            return $order;
        }, 3);
    }
}
