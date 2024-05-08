<?php

namespace App\Services;

use App\Libs\Wechat\BusinessCard\Encryptor;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RequestService extends Service
{
    private string $host = '';

    public function get(string $uri = '', array $reqData = [], array $heads = [])
    {
        return $this->request($uri, 'GET', $reqData, $heads);
    }

    public function post(string $uri = '', array $reqData = [], array $heads = [])
    {
        return $this->request($uri, 'POST', $reqData, $heads);
    }

    public function request(string $uri = '', string $method = 'GET', array $reqData = [], array $heads = [], bool $encrypt = false)
    {
        Log::info('=======request====== Uri :' . $uri . ', Params:', $reqData);

        /** -------url拼接------- **/
        $url = is_url($uri) ? $uri : $this->host . $uri;

        /** -------接口加密------- **/
        if ($encrypt) {
            $timestamp = time();
            // 数据加密
            $reqData = (new Encryptor)->encrypt($url, $reqData, $timestamp);
            // head加签
            $signature = (new Encryptor)->signature($url, $reqData, $timestamp);
            $heads = array_merge($heads, $signature);
        }

        $client = new Client();

        $body = match ($method) {
            'GET' => [
                'headers' => $heads,
                'query' => $reqData
            ],
            default => [
                'headers' => $heads,
                'form_params' => $reqData
            ],
        };
        Log::info("\nMethod:" . $method . "\nUrl: ".$url . "\nBody: ", $body);
        $response = $client->request($method, $url, $body);
        $responseArr = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        /** -------接口解密------- **/
        if ($encrypt) {
            $responseArr = (new Encryptor)->decrypt($url, $responseArr, $timestamp);
        }

        Log::info('=======response====== Status:' . $response->getStatusCode() . ', body:', $responseArr);
        return $responseArr;
    }

    public function setHost(string $host): RequestService
    {
        $this->host = $host;
        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }
}
