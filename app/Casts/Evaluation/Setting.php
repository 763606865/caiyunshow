<?php

declare(strict_types=1);

namespace App\Casts\Evaluation;

use App\Libs\Model\JsonField;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * 测评设置
 *
 * @property bool $generate_reports_when_finished 是否允许受测者直接查看报告
 */
class Setting implements CastsAttributes
{
    protected array $attributes = [
        'generate_reports_when_finished' => false,
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
            'generate_reports_when_finished' => $this->generate_reports_when_finished,
        ];
    }
}
