<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Http\Resources\Chat\MessageResource;
use App\Models\Chat\Message;
use App\Services\MainService;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function index(int $document_id)
    {
        $messages = Message::where('document_id', $document_id)->get();
        return MessageResource::collection($messages);
    }

    public function store(int $document_id)
    {
        $auth_user = auth('api')->user();
        if (empty($auth_user)) return response()->json('User is not authorized', 403);
        $data = request()->all();

        if(!empty($data['file_data'])) {
            $mainService = new MainService();
            $file_name = $mainService->saveImageOrDocument($data['file_data'], 'messages');
            $extension = $data['file_data']->getClientOriginalExtension();
            if(in_array($extension, ['jpg','jpeg','png','gif'])) $data['is_image'] = true;
            else $data['is_file'] = true;

            $data['content'] = json_encode(['file_name' => $file_name, 'original_file_name' => $data['file_data']->getClientOriginalName()]);

        }

        if (empty($data['content'])) return response()->json('Content is empty', 403);

        $data['document_id'] = $document_id;
        $data['user_name'] = $auth_user->name;
        $data['user_image'] = $auth_user->profile_image;

        $message = $auth_user->messages()->create($data);

        MessageEvent::dispatch($message);

        return response()->json($data);
    }
}
