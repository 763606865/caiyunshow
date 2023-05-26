<?php

namespace App\Api\BusinessCard\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Wechat\AuthService as WechatAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return response()->json(111);
    }

    public function wechatLogin(Request $request)
    {
        $code = $request->post('code');
        $response = WechatAuthService::getInstance()->login($code);

        if(isset($response['errcode'])) {
            $data = [
                'code' => $response['errcode'],
                'message' => $response['errmsg']
            ];
        } else {
            $data = [
                'code' => 200,
                'data' => [
                    'session' => $response['session_key'],
                    'openid' => $response['openid']
                ]
            ];
        }
        return response()->json($data);
    }
}
