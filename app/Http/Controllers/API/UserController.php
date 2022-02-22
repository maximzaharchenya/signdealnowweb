<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\EmailCheckData;
use App\Http\Requests\UpdateUserData;
use App\Http\Requests\UpdateUserPasswordData;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp;
use Illuminate\Http\JsonResponse;
use App\Services\MainService;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function login(): JsonResponse
    {
        $http = new GuzzleHttp\Client;

        try {
            $data = [
                'grant_type' => 'password',
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
                'username' => request()->email,
                'password' => request()->password,
                'scope' => '',
            ];

            // Get access_token
            $request = Request::create('/oauth/token', 'POST', $data);

            //
            $response = app()->handle($request);


            if ($response->getStatusCode() != 200) {

                return response()->json([
                    'message' => 'Incorrect email or password - maybe both, or at least one(1).',
                    'status' => $response->getStatusCode(),
                ], $response->getStatusCode());
            }
            // unpack the response
            $responseData = json_decode($response->getContent());


            return response()->json($responseData);
        } catch (GuzzleHttp\Exception\BadResponseException $e) {

            if ($e->getCode() === 500) {
                return response()->json('Please enter email and password.', $e->getCode());
            } else if ($e->getCode() === 400) {
                return response()->json('User email or password doesn’t match.', $e->getCode());
            }
            return response()->json('The server is not responding. Try later.', $e->getCode());
        }
    }

    public function register(RegisterRequest $request, MainService $mainService, MailService $mailService): JsonResponse
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['type'] = 0;
        $data['email_check'] = $mainService->makePin();
        $user = User::create($data);

        $message_data['title'] = 'Нам требуется проверить Ваш E-mail!';
        $message_data['content'] = 'Перейдите по ссылке ниже, чтобы закончить проверку Вашего E-mail!';
        $message_data['button_link'] = config('app.url') . 'email/check?pin=' . $data['email_check'];
        $message_data['button_text'] = 'Проверить';
        $mailService->send($data['email'], $message_data['title'], $message_data['content'], $message_data['button_text'], $message_data['button_link']);
        return response()->json($user);
    }

    public function user_show(): JsonResponse
    {
        $user = auth('api')->user();
        return response()->json($user);
    }

    public function user_update(UpdateUserData $request, MainService $mainService): JsonResponse
    {
        $user = auth('api')->user();
        $data = $request->all();
        if (!empty($data['middle_name'])) unset($data['middle_name']);
        if (!empty($data['email'])) unset($data['email']);
        if (!empty($data['type'])) unset($data['type']);
        if (!empty($data['CountryRegistry'])) unset($data['CountryRegistry']);
        if (!empty($data['AuthenticationType'])) unset($data['AuthenticationType']);
        if (!empty($data['UserCertificate'])) unset($data['UserCertificate']);
        if (!empty($data['PersonalCode'])) unset($data['PersonalCode']);
        if (!empty($data['PersonalCodeType'])) unset($data['PersonalCodeType']);
        if (!empty($request->file('profile_image'))) {
            $path = $mainService->saveImage($request->file('profile_image'), 'profile_img', 200, 200);
            $data['profile_image'] = 'profile_img/' . $path;
        }
        $user->update($data);
        return response()->json(['success' => true]);
    }

    public function password_update(UpdateUserPasswordData $request): JsonResponse
    {
        $user = auth('api')->user();
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user->update($data);
        return response()->json(['success' => true]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json(['success' => true]);
    }

    public function email_check(EmailCheckData $request): JsonResponse
    {
        $user = User::where('email_check', $request->pin)->firstOrFail();
        $user->email_check = 1;
        $user->save();
        return response()->json(['success' => true]);
    }
}
