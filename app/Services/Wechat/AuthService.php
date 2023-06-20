<?php

namespace App\Services\Wechat;

use App\Models\User;
use App\Services\AuthService as BaseAuthService;
use App\Services\UserService;

class AuthService extends BaseAuthService
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

    public function attach(array $data = []): User
    {
        if (!isset($data['open_id']))
        {
            return new User();
        }

        $params = [
            'wechat_open_id' => $data['open_id'],
            'wechat_union_id' => $data['union_id'] ?? '',
        ];

        return UserService::getInstance()->store($params);
    }
}
