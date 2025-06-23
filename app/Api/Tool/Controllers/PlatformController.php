<?php

namespace App\Api\Tool\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlatformController extends Controller
{
    /**
     * 登录
     *
     * POST /api/tool/platform/login
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function postLogin(Request $request): JsonResponse
    {
        $validated = $this->validate($request, [
            'platform_code' => ['required', 'string', Rule::exists('platforms', 'code')],
            'username' => ['required'],
            'login_type' => ['required'],
            'ticket' => ['required'],
        ], [], [
            'platform_code' => '平台code',
            'login_type' => '登录方式',
            'username' => '用户名',
            'ticket' => '验证码',
        ]);

        return api_response();
    }
}
