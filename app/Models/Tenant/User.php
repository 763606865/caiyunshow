<?php

declare(strict_types=1);

namespace App\Models\Tenant;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password'];

    protected $attributes = [
        'user_id',
    ];
}
