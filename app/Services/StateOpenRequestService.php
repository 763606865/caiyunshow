<?php

namespace App\Services;

use App\Libs\Wechat\BusinessCard\Encryptor;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class StateOpenRequestService extends RequestService
{
    protected string $host = 'https://lms.ouchn.cn';

    protected array $defaultHeader = [
        'priority' => 'u=1, i',
        'origin' => 'https://lms.ouchn.cn',
        'sec-ch-ua' => '"Google Chrome";v="129", "Not=A?Brand";v="8", "Chromium";v="129"',
        'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
        'content-type' => 'application/json',
        'sec-ch-ua-mobile' => '?0',
        'sec-ch-ua-platform' => 'macOS',
        'sec-fetch-dest' => 'empty',
        'sec-fetch-mode' => 'cors',
        'sec-fetch-site' => 'same-origin',
        'accept' => 'application/json',
        'accept-language' => 'zh-CN,zh;q=0.9,en;q=0.8'
    ];

    public function get(string $uri = '', array $reqData = [], array $heads = [])
    {
        return $this->setHost($this->host)->request($uri, 'GET', $reqData, array_merge($this->defaultHeader, $heads));
    }

    public function post(string $uri = '', array $reqData = [], array $heads = [])
    {
        return $this->setHost($this->host)->request($uri, 'POST', $reqData, array_merge($this->defaultHeader, $heads));
    }
}
