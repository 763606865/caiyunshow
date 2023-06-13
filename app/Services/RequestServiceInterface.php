<?php

namespace App\Services;

interface RequestServiceInterface
{
    public function request(string $url, string $method, array $reqData, array $heads, bool $encrypt);

    public function encrypt(string $url, array $reqData);

    public function decrypt(string $url, array $responseData);

    public function signature(string $url, array $encrypt);

    public function verify();
}
