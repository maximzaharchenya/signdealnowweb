<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Services\LanguageService;

class LanguageController extends Controller
{
    public function index(LanguageService $languageService)
    {
        $result = [];
        foreach ($languageService->languages() as $key => $country) {
            array_push($result, ['name' => $country['name'], 'nativeName' => $country['nativeName'], 'value' => $key]);
        }
        return LanguageResource::collection($result);
    }
}
