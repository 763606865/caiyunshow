<?php

namespace App\Api\BusinessCard\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Wechat\AuthService as WechatAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        $data['code'] = 200;
        $data['token'] = WechatAuthService::getInstance()->token();
        return response()->json($data);
    }

    public function wechatLogin(Request $request)
    {
        $code = $request->post('code');
        // 获取session
        $response = WechatAuthService::getInstance()->login($code);

        if (isset($response['errcode'])) {
            $data = [
                'code' => $response['errcode'],
                'message' => $response['errmsg']
            ];
        } else {
            // 设置session
            session($response['session_key'], ['openid' => $response['openid']]);
            $data = [
                'code' => 200,
                'data' => [
                    'session' => $response['session_key']
                ]
            ];
        }

        return response()->json($data);
    }
}
