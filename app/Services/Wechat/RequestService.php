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
        Log::info('=======wechat request====== Method' . $method . ', uri: ' . $url . ', body:', $body);
        $response = $client->request($method, $url, $body);
        $responseArr = json_decode($response->getBody()->getContents(), true);
        Log::info('=======wechat response====== Status:' . $response->getStatusCode() . ', body:' . $response->getBody()->getContents());
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

    /**
     * @throws \Exception
     */
    public function encrypt(string $url = '', array $reqData = [])
    {
        if (!is_url($url)) {
            $url = $this->host . $url;
        }
        $iv = openssl_random_pseudo_bytes(12);
        $data = array_merge($reqData, [
            '_n' => base64_encode(openssl_random_pseudo_bytes(16)),
            '_appid' => config('wechat.weapp.business_card.app_id'),
            '_timestamp' => time()
        ]);
        // 加密
        $aad = [
            'urlpath' => $url,
            'appid' => config('wechat.weapp.business_card.app_id'),
            'timestamp' => time(),
            'sn' => config('wechat.weapp.business_card.crypt.sn')
        ];
        $aad = implode('|', $aad);

        // 计算data
        $encrypt = openssl_encrypt(
            json_encode($data, JSON_THROW_ON_ERROR),
            'aes-256-gcm',
            config('wechat.weapp.business_card.crypt.key'),
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            $aad
        );

        return [
            'iv' => base64_encode($iv),
            'data' => base64_encode($encrypt),
            'authtag' => base64_encode($tag)
        ];
    }

    /**
     * @throws \JsonException
     */
    public function decrypt(string $url = '', array $responseData = [])
    {
        if (!is_url($url)) {
            $url = $this->host . $url;
        }
        $iv = base64_decode($responseData['iv']);
        $authtag = base64_decode($responseData['authtag']);
        $data = base64_decode($responseData['data']);

        $aad = [
            'urlpath' => $url,
            'appid' => config('wechat.weapp.business_card.app_id'),
            'timestamp' => time(),
            'sn' => config('wechat.weapp.business_card.crypt.sn')
        ];
        $aad = implode('|', $aad);

        $result = openssl_decrypt(
            $data,
            'aes-256-gcm',
            config('wechat.weapp.business_card.crypt.key'),
            OPENSSL_RAW_DATA,
            $iv,
            $authtag,
            $aad
        );
        // 校验
        $result = json_decode($result, true);

        if ((string)$result['_appid'] !== config('wechat.weapp.business_card.app_id')) {
            Log::error("【wechat】校验失败：appId校验失败:", (array)$result);
            return [];
        }

        if ($result["_timestamp"] !== time()) {
            Log::error("【wechat】校验失败：时间戳对不上:", (array)$result);
            return [];
        }
        unset($result['_appid'], $result['_timestamp'], $result['_n']);

        return $result;
    }

    public function signature()
    {

    }

    public function verify()
    {

    }
}
