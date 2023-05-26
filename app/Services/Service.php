<?php

namespace App\Services;

class Service
{
    private static $instance;
    private function __construct(){}
    private function __clone(){}
    public static function getInstance()
    {
        if (!static::$instance instanceof static) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}
