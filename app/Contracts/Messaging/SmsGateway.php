<?php

namespace App\Contracts\Messaging;

interface SmsGateway
{
    public function ready(): bool;

    public function send(string $to, string $message): void;
}
