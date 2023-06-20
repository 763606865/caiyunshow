<?php

namespace App\Api\BusinessCard\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function guard(string $guard = 'wechat'): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return Auth::guard($guard);
    }

    /**
     * @throws \Exception
     */
    protected function user(): \Illuminate\Http\JsonResponse|Authenticatable
    {
        $user = $this->guard()->user();
        if (!$user) {
            return api_response(['message' => 'Unauthorized'], 401);
        }
        return $user;
    }
}
