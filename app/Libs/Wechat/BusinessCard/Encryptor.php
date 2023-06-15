<?php

namespace App\Libs\Wechat\BusinessCard;

use App\Libs\Wechat\Encryptor as BaseEncryptor;
use Illuminate\Support\Facades\Log;

class Encryptor extends BaseEncryptor
{
    public function encrypt(string $url = '', array $reqData = [])
    {
        $iv = generation_random_string(12);
        $data = array_merge($reqData, [
            '_n' => base64_encode(generation_random_string(16)),
            '_appid' => $this->appId,
            '_timestamp' => time()
        ]);
        // 加密
        $aad = [
            'urlpath' => $url,
            'appid' => $this->appId,
            'timestamp' => time(),
            'sn' => $this->encryptSn
        ];
        $aad = implode('|', $aad);
        // 计算data
        $encrypt = openssl_encrypt(
            json_encode($data, JSON_THROW_ON_ERROR),
            'aes-256-gcm',
            $this->encryptKey,
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
            'appid' => $this->appId,
            'timestamp' => time(),
            'sn' => $this->encryptSn
        ];
        $aad = implode('|', $aad);

        $result = openssl_decrypt(
            $data,
            'aes-256-gcm',
            $this->encryptKey,
            OPENSSL_RAW_DATA,
            $iv,
            $authtag,
            $aad
        );
        // 校验
        $result = json_decode($result, true);

        if ((string)$result['_appid'] !== $this->appId) {
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
}
