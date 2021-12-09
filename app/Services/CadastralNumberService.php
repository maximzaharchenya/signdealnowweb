<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;

class CadastralNumberService
{

    public function getData(string $number): ?array
    {
        $url = 'https://xgis.maaamet.ee/ky/inads/' . $number;
        $response = Http::get($url);
        if($response->successful()) return $response->json();
        else return null;
    }

}
