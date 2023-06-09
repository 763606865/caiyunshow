<?php

namespace App\Services;

interface RequestServiceInterface
{
    public function request(string $url = '', string $method = 'GET', array $reqData = [], array $heads = []);

    public function encrypt();

    public function decrypt();

    public function signature();

    public function verify();
}
