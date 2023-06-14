<?php

namespace App\Services\Wechat;

use App\Services\Service;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RequestService extends Service
{
    private string $host = 'https://api.weixin.qq.com';

    public function getToken()
    {
        if (!$token = Redis::get('wechat_token')) {
            $token = $this->setToken();
        }
        return $token;
    }

    public function get(string $uri = '', array $reqData = [], array $heads = [], bool $encrypt = true)
    {
        return $this->request($uri, 'GET', $reqData, $heads, $encrypt);
    }

    public function post(string $uri = '', array $reqData = [], array $heads = [], bool $encrypt = true)
    {
        return $this->request($uri, 'POST', $reqData, $heads, $encrypt);
    }

    public function request(string $uri = '', string $method = 'GET', array $reqData = [], array $heads = [], bool $encrypt = true)
    {
        Log::info('=======wechat request====== Uri :' . $uri . ', Params:', $reqData);

        /** -------url拼接------- **/
        $url = is_url($uri) ? $uri : $this->host . $uri;

        /** -------接口加密------- **/
        if ($encrypt) {
            // 数据加密
            $reqData = $this->encrypt($url, $reqData);
            // head加签
            $signature = $this->signature($url, $reqData);
            $heads = array_merge($heads, $signature);
        }

        $client = new Client();

        /** -------token拼接------- **/
        if (!in_array($uri, config('wechat.weapp.skip_token_url'), true)) {
            if ($method === 'GET') {
                $reqData = array_merge($reqData, ['access_token' => $this->getToken()]);
            } else {
                $url .= '?' . http_build_query(['access_token' => $this->getToken()]);
            }
        }

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
        $response = $client->request($method, $url, $body);
        $responseArr = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        /** -------接口解密------- **/
        if ($encrypt) {
            $responseArr = $this->decrypt($url, $responseArr);
        }

        Log::info('=======wechat response====== Status:' . $response->getStatusCode() . ', body:', $responseArr);
        return $responseArr;
    }

    public function setToken()
    {
        $response = $this->get('/cgi-bin/token', [
            'grant_type' => 'client_credential',
            'appid' => config('wechat.weapp.business_card.app_id'),
            'secret' => config('wechat.weapp.business_card.app_secret'),
        ], [], false);
        Redis::connection()->set('wechat_token', $response['access_token'])->expire('wechat_token', (int)$response['expires_in']-10);
        return $response['access_token'];
    }

    /**
     * 接口加密
     *
     * @throws \Exception
     */
    public function encrypt(string $url = '', array $reqData = [])
    {
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
     * 接口解密
     *
     * @throws \JsonException
     */
    public function decrypt(string $url = '', array $responseData = [])
    {
        if (!isset($responseData['iv'])) {
            return $responseData;
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

    /**
     * 加签
     *
     * @param string $url
     * @param array $encrypt
     * @return array
     * @throws \JsonException
     */
    public function signature(string $url = '', array $encrypt = [])
    {
        $timestamp = time();
        $params = [
            'urlpath' => $url,
            'appid' => config('wechat.weapp.business_card.app_id'),
            'timestamp' => $timestamp,
            'postdata' => json_encode($encrypt, JSON_THROW_ON_ERROR)
        ];
        $paramStr = implode("\n", $params);
        $privateKey = file_get_contents(config('wechat.weapp.business_card.signature.private_key'));
        $publicKey = file_get_contents(config('wechat.weapp.business_card.signature.public_key'));
        openssl_sign($paramStr, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        return [
            'Wechatmp-Appid' => config('wechat.weapp.business_card.app_id'),
            'Wechatmp-TimeStamp' => $timestamp,
            'Wechatmp-Signature' => base64_encode($signature),
            'Wechatmp-Serial' => config('wechat.weapp.business_card.signature.serial'),
        ];
    }

    /**
     * 验签
     *
     */
    public function verify(string $url = '', array $responseData = [])
    {
        return true;
    }
}
