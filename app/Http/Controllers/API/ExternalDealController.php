<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExternalDealController extends Controller
{
    public function create()
    {
        $data = request()->all();
        return view('layouts.external_deal', ['data' => json_encode($data)]);
    }
}
