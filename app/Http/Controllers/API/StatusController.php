<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Services\StatusService;

class StatusController extends Controller
{
    public function index(StatusService $statusService)
    {
        $result = [];
        foreach ($statusService->statuses() as $key => $status) {
            array_push($result, ['name' => $status, 'value' => $key]);
        }
        return StatusResource::collection($result);
    }
}
