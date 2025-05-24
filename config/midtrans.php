<?php

return [
    'serverKey' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_Production' => env('MIDTRANS_PRODUCTION', false),
    'isSanitized' => true,
    'is3ds' => true,
];
