<?php

declare(strict_types=1);

namespace App\Api\Tenant;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Stancl\Tenancy\Facades\Tenancy;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $tenant = Tenant::find('huixiaoyou');

        Tenancy::setTenant($tenant);
        return api_response();
    }
}
