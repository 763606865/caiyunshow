<?php

namespace App\Services;

interface RequestServiceInterface
{
    public function request(string $url, string $method, array $reqData, array $heads, bool $encrypt);

    public function encrypt(string $url, array $reqData);

    public function decrypt(string $url, array $reqData);

    public function signature();

    public function verify();
}
