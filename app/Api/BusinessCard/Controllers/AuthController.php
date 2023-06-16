<?php

namespace App\Api\BusinessCard\Controllers;

use App\Http\Controllers\Controller;
use App\Libs\Jwt\TokenBuilder;
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

        /** 生成token **/
        $access_token = (new TokenBuilder)->generate($user->id, $response['session_key']);

        return api_response([
            'access_token' => $access_token
        ]);
    }

    public function user(Request $request)
    {
        $access_token = $request->header('X-Wechat-Authorization');
        $user = (new TokenBuilder)->parse($access_token);
        return api_response($user);
    }
}
