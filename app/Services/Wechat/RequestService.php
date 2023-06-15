<?php

namespace App\Services\Wechat;

use App\Libs\Wechat\BusinessCard\Encryptor;
use App\Models\AccessToken;
use App\Services\Service;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RequestService extends Service
{
    private string $host = 'https://api.weixin.qq.com';

    public function getToken()
    {
        $token = AccessToken::wechat()->latest()->first();
        if (!$token) {
            return $this->setToken();
        }
        if ((int)$token->expired_ts <= Carbon::now()->timestamp) {
            return $this->setToken();
        }
        return $token->access_token;
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
            $reqData = (new Encryptor)->encrypt($url, $reqData);
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
        Log::info("\nMethod:" . $method . "\nUrl: ".$url . "\nBody: ", $body);
        $response = $client->request($method, $url, $body);
        $responseArr = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        /** -------接口解密------- **/
        if ($encrypt) {
            $responseArr = (new Encryptor)->decrypt($url, $responseArr);
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
        AccessToken::forceCreate([
            'access_token' => $response['access_token'],
            'expired_ts' => Carbon::now()->addSeconds($response['expires_in'])->timestamp,
            'type' => AccessToken::TYPE_WECHAT
        ]);
        return $response['access_token'];
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
        $payload = implode("\n", array_values($params));
        $privateKey = openssl_pkey_get_private(file_get_contents(config('wechat.weapp.business_card.signature.private_key')));
//        $publicKey = openssl_pkey_get_public(file_get_contents(config('wechat.weapp.business_card.signature.public_key')));
//        openssl_public_encrypt($payload, $signature, $publicKey);
        openssl_sign($payload, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        return [
            'Wechatmp-Appid' => config('wechat.weapp.business_card.app_id'),
            'Wechatmp-TimeStamp' => $timestamp,
            'Wechatmp-Signature' => base64_encode($signature),
            'Wechatmp-Serial' => config('wechat.weapp.business_card.signature.serial'),
        ];
    }
}
