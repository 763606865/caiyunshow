<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntroductionController extends Controller
{
    public function about()
    {
        return view('web.about');
    }

    public function project()
    {
        return view('web.project');
    }

    public function price()
    {
        return view('web.price');
    }
}
