<?php

return [
    'weapp' => [
        'business_card' => [
            'app_id' => env('WECHAT_BUSINESS_APP_ID'),
            'app_secret' => env('WECHAT_BUSINESS_APP_SECRET'),
            'crypt' => [
                'sn' => env('WECHAT_BUSINESS_CRYPT_SN'),
            ],
        ],
    ],
    'biz' => [

    ],
];
