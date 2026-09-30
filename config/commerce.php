<?php

return [
    'currency' => 'TZS',
    'shipping_fee' => (int) env('COMMERCE_SHIPPING_FEE', 0),
    'checkout_enabled' => (bool) env('COMMERCE_CHECKOUT_ENABLED', false),
    'payment_instructions' => env('COMMERCE_PAYMENT_INSTRUCTIONS', 'Our team will contact you to arrange payment. Do not send payment without confirmed instructions.'),
    'api_docs_enabled' => (bool) env('API_DOCS_ENABLED', false),
];
