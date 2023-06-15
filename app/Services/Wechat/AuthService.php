<?php

namespace App\Services\Wechat;

use App\Models\User;
use App\Services\Service;
use App\Services\UserService;

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

    public function attach(array $data = []): User
    {
        if (!isset($data['open_id']))
        {
            return new User();
        }
        $user = User::where('wechat_open_id', $data['open_id'])->first();
        if(!$user) {
            $user = User::query()->forceCreate([
                'username' => UserService::getInstance()->generateUserName('wechat', $data),
                'wechat_open_id' => $data['open_id'],
                'wechat_union_id' => $data['union_id'] ?? '',
            ]);
        } else {
            $fill = [
                'wechat_open_id' => $data['open_id'],
                'wechat_union_id' => $data['union_id'] ?? '',
            ];
            $user->forceFill($fill);
            $user->save();
        }

        return $user;
    }
}
