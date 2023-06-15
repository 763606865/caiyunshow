<?php

namespace App\Libs\Wechat\BusinessCard;

use App\Libs\Wechat\Encryptor as BaseEncryptor;
use Illuminate\Support\Facades\Log;

class Encryptor extends BaseEncryptor
{
    public function encrypt(string $url = '', array $reqData = [], int $timestamp = 0): array
    {
        if (!$timestamp) {
            $timestamp = time();
        }
        $iv = generation_random_string(12);
        $data = array_merge($reqData, [
            '_n' => generation_random_string(random_int(16, 32)),
            '_appid' => $this->appId,
            '_timestamp' => $timestamp
        ]);
        ksort($data);
        $data = json_encode($data, JSON_THROW_ON_ERROR);
        // 加密
        $aad = [
            'urlpath' => $url,
            'appid' => $this->appId,
            'timestamp' => $timestamp,
            'sn' => $this->encryptSn
        ];
        $aad = implode('|', $aad);
        // 计算data
        $encrypt = openssl_encrypt(
            $data,
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

    public function decrypt(string $url = '', array $responseData = [], int $timestamp = 0)
    {
        if (!$timestamp) {
            $timestamp = time();
        }

        if (!isset($responseData['iv'])) {
            return $responseData;
        }
        $iv = base64_decode($responseData['iv']);
        $authtag = base64_decode($responseData['authtag']);
        $data = base64_decode($responseData['data']);

        $aad = [
            'urlpath' => $url,
            'appid' => $this->appId,
            'timestamp' => $timestamp,
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

        if ($result["_timestamp"] !== $timestamp) {
            Log::error("【wechat】校验失败：时间戳对不上:", (array)$result);
            return [];
        }
        unset($result['_appid'], $result['_timestamp'], $result['_n']);

        return $result;
    }

    public function signature(string $url = '', array $encrypt = [], int $timestamp = 0)
    {
        if (!$timestamp) {
            $timestamp = time();
        }
        $params = [
            'urlpath' => $url,
            'appid' => $this->appId,
            'timestamp' => $timestamp,
            'postdata' => json_encode($encrypt, JSON_THROW_ON_ERROR)
        ];
        $payload = implode("\n", array_values($params));
        $privateKey = openssl_pkey_get_private(file_get_contents($this->privateKey));
        openssl_sign($payload, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        return [
            'Wechatmp-Appid' => $this->appId,
            'Wechatmp-TimeStamp' => $timestamp,
            'Wechatmp-Signature' => base64_encode($signature),
        ];
    }

    public function verify(string $url = '', array $encrypt = [], int $timestamp = 0)
    {
        if (!$timestamp) {
            $timestamp = time();
        }
        $params = [
            'urlpath' => $url,
            'appid' => $this->appId,
            'timestamp' => $timestamp,
            'postdata' => json_encode($encrypt, JSON_THROW_ON_ERROR)
        ];
        $payload = implode("\n", array_values($params));
        $publicKey = openssl_pkey_get_public(file_get_contents($this->publicKey));
        openssl_public_encrypt($payload, $signature, $publicKey);
        return [
            'Wechatmp-Appid' => $this->appId,
            'Wechatmp-TimeStamp' => $timestamp,
            'Wechatmp-Signature' => base64_encode($signature),
            'Wechatmp-Serial' => $this->serial,
        ];
    }
}
