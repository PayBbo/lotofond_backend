<?php

return [
    'token' => env('PAYMASTER_TOKEN'),
    'merchant_id' => env('PAYMASTER_MERCHANT_ID'),
    'return_url' => env('RETURN_URL'),
    'callback_url' => env('CALLBACK_URL'),
    'test_mode'=>env('PAYMASTER_MODE'),
    'trial_period'=>env('TRIAL_PERIOD', 7)
];
