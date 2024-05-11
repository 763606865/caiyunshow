<?php

declare(strict_types=1);

namespace App\Casts\Evaluation;

use App\Libs\Model\JsonField;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * 测评设置
 *
 * @property double $min 最小值
 * @property double $max 最大值
 * @property string $description 描述
 * @property string $text 区间
 */
class Suggestion implements CastsAttributes
{
    protected array $attributes = [
        'min' => 0,
        'max' => 0,
        'description' => '',
        'text' => '',
    ];

    public function get($model, string $key, $value, array $attributes)
    {
        if (! isset($attributes[$key])) {
            return;
        }

        $data = json_decode($attributes[$key], true);

        return is_array($data) ? new JsonField($data) : null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        return json_encode($value->toArray(), JSON_UNESCAPED_UNICODE);
    }

    public function toArray()
    {
        return [
            'min' => $this->min,
            'max' => $this->max,
            'description' => $this->description,
            'text' => $this->text,
        ];
    }
}
