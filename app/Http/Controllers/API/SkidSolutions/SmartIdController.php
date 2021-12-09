<?php

namespace App\Http\Controllers\API\SkidSolutions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmartIdController extends Controller
{
    public function check(): \Illuminate\Http\JsonResponse
    {
        return response()->json(true);
    }

    public function getCode(): \Illuminate\Http\JsonResponse
    {
        return response()->json(random_int(1000, 9999));
    }
}
