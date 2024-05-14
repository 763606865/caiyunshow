<?php

declare(strict_types=1);

namespace App\Models\Evaluation;

/**
 * @property string $code
 * @property string $suggestions
 */
class Indicator extends Model
{
    protected $table = 'ev_indicators';

    protected $attributes = [
        'weight' => 99
    ];

    protected $casts = [
        'suggestions' => 'array'
    ];

    /**
     * 测评类别
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evaluation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id');
    }

    /**
     * 设置suggestions
     *
     * @param $value
     * @return void
     */
    public function setSuggestionsAttribute($value): void
    {
        $this->attributes['suggestions'] = json_encode(array_values($value));
    }
}
