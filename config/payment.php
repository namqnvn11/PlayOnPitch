<?php

return [
    'momo'=>[
        'redirect_url'=> env('MOMO_REDIRECT_URL'),
        'inp_url'=> env('MOMO_IPN_URL'),
        'endpoint_url'=> env('MOMO_ENDPOINT'),
        'partner_code'=> env('MOMO_PARTNER_CODE'),
        'access_key'=> env('MOMO_ACCESS_KEY'),
        'secret_key'=> env('MOMO_SECRET_KEY'),
    ],
    'stripe'=>[
        'stripe_key' => env('STRIPE_KEY'),
        'stripe_secret' => env('STRIPE_SECRET'),
    ]

];
