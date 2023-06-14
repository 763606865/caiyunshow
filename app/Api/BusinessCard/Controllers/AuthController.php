<?php

namespace App\Api\BusinessCard\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Wechat\AuthService as WechatAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        $data['access_token'] = WechatAuthService::getInstance()->token();
        return api_response($data);
    }

    public function wechatLogin(Request $request): \Illuminate\Http\JsonResponse
    {
        $code = $request->post('code');
        // 获取openId
        $response = WechatAuthService::getInstance()->login($code);

        if (isset($response['errcode'])) {
            return api_response([
                'code' => $response['errcode'],
                'message' => $response['errmsg']
            ]);
        }
        /** 获取用户信息同步本地数据库 **/
        $wechatResponse = [
            'open_id' => $response['openid'] ?? '',
            'union_id' => $response['union_id'] ?? ''
        ];
        $user = WechatAuthService::getInstance()->attach($wechatResponse);

        return api_response([
            'session_key' => $response['session_key'],
            'user' => $user
        ]);
    }

    public function user(Request $request)
    {
        $sessionId = $request->header('X-Wechat-SessionId');
        $user = session($sessionId);
    }
}
