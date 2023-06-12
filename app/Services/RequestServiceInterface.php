<?php

namespace App\Services;

interface RequestServiceInterface
{
    public function request(string $url = '', string $method = 'GET', array $reqData = [], array $heads = []);

    public function encrypt(string $url, array $reqData);

    public function decrypt(string $url, array $reqData);

    public function signature();

    public function verify();
}
