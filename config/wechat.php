<?php

return [
    'weapp' => [
        'business_card' => [
            'app_id' => env('WECHAT_BUSINESS_APP_ID'),
            'app_secret' => env('WECHAT_BUSINESS_APP_SECRET'),
            'crypt' => [
                'sn' => env('WECHAT_BUSINESS_CRYPT_SN'),
                'key' => env('WECHAT_BUSINESS_CRYPT_KEY'),
            ],
            'signature' => [
                'sn' => env('WECHAT_BUSINESS_SIGNATURE_SN'),
                'private_key' => env('WECHAT_BUSINESS_SIGNATURE_PRIVATE_KEY'),
                'public_key' => env('WECHAT_BUSINESS_SIGNATURE_PUBLIC_KEY'),
                'auth_cer' => env('WECHAT_BUSINESS_SIGNATURE_AUTH_CER'),
            ],
        ],
    ],
    'biz' => [

    ],
];
