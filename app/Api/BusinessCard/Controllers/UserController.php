<?php

namespace App\Api\BusinessCard\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function wechatSync(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => ['nullable', 'min:2', 'max:255'],
            'mobile' => ['nullable', 'regex:/^(1)\d{10}$/'],
            'email' => ['nullable', 'email'],
            'avatar' => ['nullable', 'url'],
        ],[],[
            'nickname' => '昵称',
            'mobile' => '手机号',
            'email' => '邮箱',
            'avatar' => '头像',
        ]);

        UserService::getInstance()->sync($this->user(), $validator->validated());

        $this->guard()->logout();

        return api_response();
    }
}
