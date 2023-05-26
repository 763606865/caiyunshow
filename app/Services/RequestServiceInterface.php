<?php

namespace App\Services;

interface RequestServiceInterface
{
    public function request(string $url = '', string $method = 'GET', array $reqData = [], array $heads = []);
}
