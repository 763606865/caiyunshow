<?php

namespace App\Services;

use App\Models\User;
use App\Services\Service;
use App\Services\UserService;
use App\Services\Wechat\RequestService;

class AuthService extends Service
{
    public function login(string $code)
    {
    }

    public function loginByUserName(string $userName = '', string $password = '')
    {

    }

    public function loginByMobile(string $mobile = '', string $code = '')
    {

    }

    public function loginByEmail(string $email = '', string $code = '')
    {

    }
}
