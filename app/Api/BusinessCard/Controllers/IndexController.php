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
        $response = RequestService::getInstance()->encrypt('/wxa/getuserriskrank', $reqData);
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
}
