<?php

namespace App\Services\Wechat;

use App\Services\Service;

class AuthService extends Service
{
    public function login(string $code)
    {
        $config = config('wechat.weapp.business_card');
        $reqData = [
            'appid' => $config['app_id'],
            'secret' => $config['app_secret'],
            'js_code' => $code,
            'grant_type' => 'authorization_code'
        ];
        return RequestService::getInstance()->get('/sns/jscode2session', $reqData);
    }

    public function token()
    {
        return RequestService::getInstance()->getToken();
    }
}
