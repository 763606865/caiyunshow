<?php

namespace App\Api\BusinessCard\Controllers;

use App\Services\Wechat\AuthService as WechatAuthService;
use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Illuminate\Http\Request;

class AuthController extends BaseAuthController
{
    public function login()
    {
        return response()->json(111);
    }

    public function wechatLogin(Request $request)
    {
        $code = $request->post('code');
        $response = WechatAuthService::getInstance()->login($code);
        return response()->json([
            'code' => $response['errcode'],
            'message' => $response['errmsg']
        ]);
    }
}
