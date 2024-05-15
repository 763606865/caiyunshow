<?php

declare(strict_types=1);

namespace App\Models\Evaluation;

use Encore\Admin\Admin;

class Measure extends Model
{
    protected $table = 'ev_measures';

    protected $attributes = [
        'creator_id' => 1,
        'z_score' => 0,
        'sd_score' => 0,
        'description' => '',
        'auto_ratio' => false,
        'ratio' => 0.0,
        'weight' => 99,
        'path' => '',
        'depth' => 0
    ];
}
