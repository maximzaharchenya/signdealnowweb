<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('layouts.index');
    }

    public function account()
    {
        return view('layouts.account');
    }
}
