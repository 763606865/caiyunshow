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

    public function get(string $url = '', array $reqData = [], array $heads = [], bool $encrypt = true)
    {
        if (!is_url($url)) {
            $url = $this->host . $url;
        }
        /** -------接口加密------- **/
        if ($encrypt) {
            // 数据加密
            $reqData = $this->encrypt($url, $reqData);
            // head加签
            $signature = $this->signature($url, $reqData);
            $heads = array_merge($heads, $signature);
            $url .= '?' . http_build_query(['access_token' => $this->getToken()]);
        }
        $response = $this->request($url, 'GET', $reqData, $heads, $encrypt);
        /** -------接口解密------- **/
        if ($encrypt) {
            $response = $this->decrypt($url, $response);
        }
        return $response;
    }

    public function post(string $url = '', array $reqData = [], array $heads = [], bool $encrypt = true)
    {
        if (!is_url($url)) {
            $url = $this->host . $url;
        }
        Log::info('=======wechat request====== Method GET, uri: ' . $url . ', reqData:', $reqData);
        /** -------接口加密------- **/
        if ($encrypt) {
            // 数据加密
            $reqData = $this->encrypt($url, $reqData);
            // head加签
            $signature = $this->signature($url, $reqData);
            $heads = array_merge($heads, $signature);
            $url .= '?' . http_build_query(['access_token' => $this->getToken()]);
        }
        $response = $this->request($url, 'POST', $reqData, $heads, $encrypt);
        /** -------接口解密------- **/
        if ($encrypt) {
            $response = $this->decrypt($url, $response);
        }
        if (isset($response['errcode']) && (int)$response['errcode'] === 42001) {
            $this->setToken();
            try {
                $response = retry(1, fn() => $this->request($url, 'POST', $reqData, $heads, $encrypt), 100);
            } catch (\Exception $e) {
                Log::error("Retry Error:". $e->getMessage());
            }
        }
        return $response;
    }

    public function request(string $url = '', string $method = 'GET', array $reqData = [], array $heads = [], bool $encrypt = true)
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

        $response = $client->request($method, $url, $body);
        $responseArr = json_decode($response->getBody()->getContents(), true);
        Log::info('=======wechat response====== Status:' . $response->getStatusCode() . ', body:' . $response->getBody());
        return $responseArr;
    }

    public function setToken()
    {
        $response = $this->request($this->host. '/cgi-bin/token','GET', [
            'grant_type' => 'client_credential',
            'appid' => config('wechat.weapp.business_card.app_id'),
            'secret' => config('wechat.weapp.business_card.app_secret'),
        ]);
        Redis::set('wechat_token', $response['access_token'], $response['expires_in']);
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
        $publicKey = file_get_contents(config('wechat.weapp.business_card.signature.public_key'));
        openssl_public_encrypt($paramStr, $signature, $publicKey, OPENSSL_ALGO_SHA256);
        return [
            'Wechatmp-Appid' => config('wechat.weapp.business_card.app_id'),
            'Wechatmp-TimeStamp' => $timestamp,
            'Wechatmp-Signature' => base64_encode($signature)
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
