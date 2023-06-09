<?php

namespace App\Api\BusinessCard\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Wechat\RequestService;

class IndexController extends Controller
{
    /**
     * @throws \Exception
     */
    public function test()
    {
        $data = RequestService::getInstance()->encrypt('https://api.weixin.qq.com/wxa/getuserriskrank', [
            "appid" => "wxba6223c06417af7b",
            "openid" =>  "oEWzBfmdLqhFS2mTXCo2E4Y9gJAM",
            "scene" => 0,
            "client_ip" => "127.0.0.1",
        ]);
        return api_response($data);
    }
}
