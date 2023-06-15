<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    use HasFactory;

    public const TYPE_WECHAT = 1;

    protected $fillable = [
        'access_token', 'expired_ts'
    ];

    protected $attributes = [
        'type' => self::TYPE_WECHAT
    ];

    /**
     * wechat() scopes
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWechat(Builder $query): Builder
    {
        return $query->where('access_tokens.type', static::TYPE_WECHAT);
    }
}
