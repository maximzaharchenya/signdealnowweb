<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupportRequestData;
use App\Models\SupportRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupportRequestController extends Controller
{
    public function store(StoreSupportRequestData $request): JsonResponse
    {
        $user = auth('api')->user();
        $data = $request->all();
        if (empty($user)) {
            if (empty($data['email']) && empty($data['phone'])) {
                return response()->json(['error' => 'Please enter email or phone.'], 400);
            }
        }else{
            $data['user_id'] = $user['id'];
        }
        SupportRequest::create($data);
        return response()->json(['success' => true]);
    }
}
