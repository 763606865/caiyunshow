<?php

namespace App\Api\BusinessCard\Controllers;

use App\Services\AuthService;
use App\Services\Wechat\AuthService as WechatAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['nullable'],
            'mobile' => ['nullable'],
            'email' => ['nullable'],
            'wechat_open_id' => ['nullable'],
            'password' => ['nullable'],
            'verify_code' => ['nullable'],
        ],[],[
            'username' => '账号',
            'mobile' => '手机号',
            'email' => '邮箱',
            'password' => '密码',
            'verify_code' => '验证码',
        ]);
        $validated = $validator->validated();
        // 账号密码登录
        if (isset($validated['username'])) {
            $access_token = AuthService::getInstance()->loginByUserName($validated['username'], $validated['password']);
            if(!$access_token) {
                return api_response('登录失败！');
            }
            return api_response([
                'access_token' => $access_token
            ]);
        }

        if (isset($validated['mobile'])) {
            $access_token = AuthService::getInstance()->loginByMobile($validated['mobile'], $validated['verify_code']);
            if(!$access_token) {
                return api_response('登录失败！');
            }
            return api_response([
                'access_token' => $access_token
            ]);
        }

        if (isset($validated['email'])) {
            $access_token = AuthService::getInstance()->loginByEmail($validated['email'], $validated['verify_code']);
            if(!$access_token) {
                return api_response('登录失败！');
            }
            return api_response([
                'access_token' => $access_token
            ]);
        }
        return api_response('登录失败！');
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
        $access_token = $this->guard()->login($user);

        return api_response([
            'access_token' => $access_token
        ]);
    }
}
