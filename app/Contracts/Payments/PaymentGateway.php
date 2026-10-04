<?php

namespace App\Contracts\Payments;

use App\Models\Order;

interface PaymentGateway
{
    public function ready(): bool;

    /**
     * @return array{provider: string, reference: string, checkout_url: string}
     */
    public function createCheckout(Order $order): array;
}
