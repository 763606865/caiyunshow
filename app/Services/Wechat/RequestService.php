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

    public function get(string $uri = '', array $reqData = [], array $heads = [])
    {
        $encrypt = env('WECHAT_BUSINESS_CRYPT_ENABLE', true);
        return $this->request($uri, 'GET', $reqData, $heads, $encrypt);
    }

    public function post(string $uri = '', array $reqData = [], array $heads = [])
    {
        $encrypt = env('WECHAT_BUSINESS_CRYPT_ENABLE', true);
        return $this->request($uri, 'POST', $reqData, $heads, $encrypt);
    }

    public function request(string $uri = '', string $method = 'GET', array $reqData = [], array $heads = [], bool $encrypt = true)
    {
        Log::info('=======wechat request====== Uri :' . $uri . ', Params:', $reqData);

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
            $responseArr = (new Encryptor)->decrypt($url, $responseArr, $timestamp);
        }

        Log::info('=======wechat response====== Status:' . $response->getStatusCode() . ', body:', $responseArr);
        return $responseArr;
    }
}
