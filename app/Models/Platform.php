<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $table = 'platforms';

    protected $fillable = [
        'name', 'host', 'login',
    ];

    protected $casts = [
        'login' => 'json',
    ];

    protected $attributes = [
        'login' => '{}'
    ];
}
