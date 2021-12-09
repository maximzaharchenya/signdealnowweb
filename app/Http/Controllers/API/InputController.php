<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Input;
use Illuminate\Http\JsonResponse;

class InputController extends Controller
{
    public function store(): JsonResponse
    {
        $document = Document::where('id', request()->document_id)->with('users')->first();
        if (!empty($document)) {
            foreach ($document->users as $user) {
                if ($user['id'] == request()->user_id) {
                    Input::create(request()->all());
                    return response()->json(['success' => true]);
                }
            }
        }

    }
}
