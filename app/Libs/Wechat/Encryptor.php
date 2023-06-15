<?php

namespace App\Libs\Wechat;

class Encryptor implements EncryptorInterface
{
    protected array $config;
    protected string $appId;
    protected string $encryptKey;
    protected string $encryptSn;
    protected string $privateKey;
    protected string $publicKey;
    protected string $serial;

    public function __construct(mixed $config = '')
    {
        $this->config = [];
        if (is_string($config)) {
            $this->config = config($config) ?? config('wechat.weapp.business_card');
        }
        if (is_array($config)) {
            $this->config = $config;
        }
        $this->appId = $this->config['app_id'];
        $this->encryptKey = $this->config['crypt']['key'] ?? '';
        $this->encryptSn = $this->config['crypt']['sn'] ?? '';
        $this->privateKey = $this->config['signature']['private_key'] ?? '';
        $this->publicKey = $this->config['signature']['public_key'] ?? '';
        $this->serial = $this->config['signature']['serial'] ?? '';
    }

    public function encrypt()
    {

    }

    public function decrypt()
    {

    }
}
