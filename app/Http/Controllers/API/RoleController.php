<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(RoleService $roleService)
    {
        $result = [];
        foreach ($roleService->roles() as $key => $role) {
            array_push($result, ['name' => $role, 'value' => $key]);
        }
        return RoleResource::collection($result);
    }
}
