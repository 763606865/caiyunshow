<?php

namespace App\Services\Wechat;

use App\Services\RequestServiceInterface;
use App\Services\Service;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RequestService extends Service implements RequestServiceInterface
{
    private string $host = 'https://api.weixin.qq.com';
    public string $token = '';

    public function token()
    {
        if (!$token = Redis::get('wechat_token')) {
            $this->setToken();
        } else {
            $this->token = $token;
        }
        return $this;
    }

    public function getToken()
    {
        $this->token();
        return $this->token;
    }

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

    public function setToken()
    {
        $response = $this->get('/cgi-bin/token', [
            'grant_type' => 'client_credential',
            'appid' => config('wechat.weapp.business_card.app_id'),
            'secret' => config('wechat.weapp.business_card.app_secret'),
        ]);
        Redis::set('wechat_token', $response['access_token'], $response['expires_in']);
    }
}
