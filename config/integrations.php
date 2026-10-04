<?php

return [
    'payments' => [
        'driver' => env('PAYMENTS_DRIVER', 'disabled'),
        'stripe' => [
            'secret' => env('STRIPE_SECRET'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
            'minor_unit_multiplier' => env('STRIPE_MINOR_UNIT_MULTIPLIER'),
            'api_base' => env('STRIPE_API_BASE', 'https://api.stripe.com'),
        ],
    ],

    'sms' => [
        'driver' => env('SMS_DRIVER', 'disabled'),
        'from' => env('SMS_FROM'),
        'endpoint' => env('SMS_ENDPOINT'),
        'token' => env('SMS_TOKEN'),
    ],
];
