<?php

declare(strict_types=1);

namespace App\Libs\Model;

interface FieldInterface
{
    public function fill(array $attributes);
    public function setAttribute($key, $value);
    public function getAttribute($key);
    public function toArray();
}
