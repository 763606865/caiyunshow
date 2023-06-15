<?php

namespace App\Libs\Wechat;

interface EncryptorInterface
{
    public function encrypt();

    public function decrypt();
}
