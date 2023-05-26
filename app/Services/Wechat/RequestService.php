<?php

namespace App\Services\Wechat;

use App\Services\RequestServiceInterface;
use App\Services\Service;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RequestService extends Service implements RequestServiceInterface
{
    private string $host = 'https://api.weixin.qq.com';

    public function get(string $url = '', array $reqData = [], array $heads = [])
    {
        return $this->request($url, 'GET', $reqData, $heads);
    }

    public function request(string $url = '', string $method = 'GET', array $reqData = [], array $heads = [])
    {
        $client = new Client(['base_uri' => $this->host]);

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
        Log::info('=======wechat request====== Method'. $method . ', uri: '. $url .', body:', $body);
        $response = $client->request($method, $url, $body);
        $responseArr = json_decode($response->getBody()->getContents(), true);
        Log::info('=======wechat response====== Status:'. $response->getStatusCode() . ', body:'.$response->getBody()->getContents());
        return $responseArr;
    }
}
