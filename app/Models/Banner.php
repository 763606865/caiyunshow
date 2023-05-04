<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image', 'link', 'sort', 'background_color', 'web_weight', 'web_height', 'h5_weight', 'h5_height'
    ];

    protected $attributes = [
        'link' => ''
    ];
}
