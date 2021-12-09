<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Services\CountryService;

class CountryController extends Controller
{
    public function index(CountryService $countryService)
    {
        $result = [];
        foreach ($countryService->countries() as $key => $country) {
            array_push($result, $country);
        }
        return $result;
    }
}
