<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $menus = tree(Menu::orderBy('sort', 'asc')->get()->toArray());
        return view('web.home')
            ->with('menus', $menus);
    }
}
