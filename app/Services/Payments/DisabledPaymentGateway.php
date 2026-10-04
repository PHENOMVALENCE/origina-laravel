<?php

namespace App\Services\Payments;

use App\Contracts\Payments\PaymentGateway;
use App\Models\Order;
use LogicException;

class DisabledPaymentGateway implements PaymentGateway
{
    public function ready(): bool
    {
        return false;
    }

    public function createCheckout(Order $order): array
    {
        throw new LogicException('Online payments are disabled.');
    }
}
