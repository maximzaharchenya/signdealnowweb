<?php

namespace App\Http\Controllers\API\SkidSolutions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MobileIdController extends Controller
{
    public function check(): \Illuminate\Http\JsonResponse
    {
        return response()->json(true);
    }

    public function send(): \Illuminate\Http\JsonResponse
    {
        return response()->json(true);
    }
}
