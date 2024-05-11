<?php

declare(strict_types=1);

namespace App\Models\Evaluation;

use App\Casts\Evaluation\Setting;

/**
 * 测评表
 *
 * @property string $code
 * @property string $setting
 */
class Evaluation extends Model
{
    protected $table = 'ev_evaluations';

    protected $attributes = [
        'setting' => '{}',
    ];

    protected $casts = [
        'setting' => 'json',
    ];
}
