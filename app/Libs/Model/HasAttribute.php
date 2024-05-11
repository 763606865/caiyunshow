<?php

declare(strict_types=1);

namespace App\Libs\Model;

trait HasAttribute
{
    protected array $attributes = [];

    /**
     * Fill the model with an array of attributes.
     *
     * @return $this
     */
    public function fill(array $attributes): static
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Set a given attribute on the model.
     */
    public function setAttribute($key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Get an attribute from the model.
     */
    public function getAttribute($key)
    {
        if (!$key) {
            return null;
        }
        return $this->attributes[$key];
    }

    /**
     * Get an attribute from the model.
     */
    public function toArray(): array
    {
        $data = [];
        foreach ($this->attributes as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }
}
