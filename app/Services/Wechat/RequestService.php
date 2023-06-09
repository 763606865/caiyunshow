<?php

namespace App\Services\Wechat;

use App\Services\RequestServiceInterface;
use App\Services\Service;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;
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

    public function encrypt(string $url = '', array $reqData = [])
    {
        try {
            $iv = base64_encode(generation_random_string(12));
        } catch (\Exception $e) {
            Log::error("【Wechat】generation iv error, message:". $e->getMessage());
        }
        $data = array_merge($reqData, [
            '_n' => base64_encode(generation_random_string(12)),
            '_appid' => config('wechat.weapp.business_card.app_id'),
            '_timestamp' => time()
        ]);
        // 加密
        $data = Crypt::encrypt($data);
        $data = base64_encode($data);
        $aad = [
            'urlpath' => $url,
            'appid' => config('wechat.weapp.business_card.app_id'),
            'timestamp' => time(),
            'sn' => config('wechat.weapp.business_card.crypt.sn')
        ];
        $aad = implode('|', $aad);

        $authtag = base64_encode($aad);
        return [
            'iv' => $iv ?? '',
            'data' => $data,
            'authtag' => $authtag
        ];
    }

    public function decrypt()
    {

    }

    public function signature()
    {

    }

    public function verify()
    {

    }
}
