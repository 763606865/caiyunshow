<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';

    protected $attributes = [
        'parent_id' => 0,
        'sort' => 0,
        'name' => '',
        'link' => '',
    ];

    public function scopeFirstLevel(Builder $query): Builder
    {
        return $query->where('parent_id', 0);
    }

    public function setAttribute($key, $value)
    {
        if ($key == 'parent_id' && is_null($value)) {
            $value = 0;
        }
        if ($key == 'sort' && is_null($value)) {
            $value = 0;
        }
        if ($key == 'link' && is_null($value)) {
            $value = 'javescript(0);';
        }
        return parent::setAttribute($key, $value);
    }
}
