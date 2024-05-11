<?php

declare(strict_types=1);

namespace App\Libs\Model;

class JsonField implements FieldInterface
{
    use HasAttribute;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
}
