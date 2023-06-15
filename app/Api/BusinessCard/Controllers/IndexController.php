<?php

namespace App\Api\BusinessCard\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Wechat\RequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * @throws \Exception
     */
    public function wechatEncrypt(Request $request): JsonResponse
    {
        $reqData = $request->all();
        $response = RequestService::getInstance()->get('/cgi-bin/message/wxopen/activityid/create', $reqData, [], true);
        return api_response($response);
    }

    /**
     * @throws \Exception
     */
    public function wechatDecrypt(Request $request): JsonResponse
    {
        $data = $request->all();
        $response = RequestService::getInstance()->decrypt('/wxa/getuserriskrank', $data);
        return api_response($response);
    }

    /**
     * @throws \Exception
     */
    public function test(Request $request): JsonResponse
    {
        $data = $request->all();
        $response = RequestService::getInstance()->post('/wxa/getpaidunionid', $data);
//        $response = UserService::getInstance()->store($data);
        return api_response($response);
    }
}
