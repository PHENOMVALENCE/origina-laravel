<?php

namespace App\Services\Messaging;

use App\Contracts\Messaging\SmsGateway;
use LogicException;

class DisabledSmsGateway implements SmsGateway
{
    public function ready(): bool
    {
        return false;
    }

    public function send(string $to, string $message): void
    {
        throw new LogicException('SMS delivery is disabled.');
    }
}
