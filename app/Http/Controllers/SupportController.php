<?php

namespace App\Http\Controllers;

class SupportController extends Controller
{
    public function php()
    {
        return phpinfo();
    }
}
