<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRecoveryUserData;
use App\Http\Requests\StoreRecoveryUserData;
use App\Models\RecoveryUsers;
use App\Models\User;
use App\Services\MailService;
use App\Services\MainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RecoveryUserController extends Controller
{
    public function store(StoreRecoveryUserData $request, MailService $mailService, MainService $mainService): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            $data['pin'] = $mainService->makePin();
            $data['email'] = $user['email'];
            $data['user_id'] = $user['id'];
            RecoveryUsers::create($data);
            $message_data['title'] = 'Восстановаление доступа к системе';
            $message_data['content'] = 'Для того, чтобы восставноить доступ к системе, перейдите по ссылке ниже.';
            $message_data['button_link'] = env('APP_URL') . '/reset?pin=' . $data['pin'];
            $message_data['button_text'] = 'Восстановить';
            $mailService->send($data['email'], $message_data['title'], $message_data['content'], $message_data['button_text'], $message_data['button_link']);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'This email does not belong to anyone.'], 400);
        }
    }

    public function delete(DeleteRecoveryUserData $request): JsonResponse
    {
        $recoveryUser = RecoveryUsers::where('pin', $request->pin)->first();
        $user = User::where('id', $recoveryUser['user_id'])->where('email', $recoveryUser['email'])->first();
        if (!empty($user)) {
            $data['password'] = Hash::make($request->password);
            $user->update($data);
            $recoveryUser->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'This email or id doesn\'t belong to anyone.'], 400);
        }
    }
}
