<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Notary;
use App\Models\UnauthorizedUser;
use App\Models\User;
use App\Services\MailService;
use App\Services\MainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotaryController extends Controller
{
    public function index(): JsonResponse
    {
        $page = request()->page;
        $count = count(Notary::all());
        $notaries = Notary::with('user')->offset(6 * $page)->limit(6)->get();
        return response()->json(['notaries' => $notaries, 'count' => $count]);
    }

    public function invite(int $deal_id, int $notary_id, MainService $mainService)
    {
        $deal = Document::where('id', $deal_id)->first();
        if (empty($deal)) return response()->json(['message' => 'No deal found'], 404);
        $notary = Notary::where('id', $notary_id)->first();
        if (empty($notary)) return response()->json(['message' => 'No user found'], 404);
        $user = User::where('id', $notary->user_id)->first();

        $data['pin'] = $mainService->makePin();
        $data['document_id'] = $deal['id'];
        $data['email'] = $user['email'];
        $data['phone'] = $user['phone'];
        $data['name'] = $user['name'];
        $data['surname'] = $user['surname'];
        $data['type'] = 3;
        $data['signs'] = 1;
        $data['present'] = 1;
        $data['from'] = auth('api')->id();
        UnauthorizedUser::create($data);


        $message_data['title'] = 'Вам пришло приглашение вступить в сделку!';
        $message_data['content'] = 'Вас пригласили вступить в сделку по адресу: ' . $deal['country'] . ', ' . $deal['city'] . ',' . $deal['address'] . '. Перейдите по ссылке ниже, чтобы вступить!';
//        $message_data['button_link'] = env('APP_URL') . 'account/deal/' . $deal['id'] . '/notary/register?pin=' . $data['pin'];
        $message_data['button_link'] = config('app.url') . 'account/deal/' . $deal['id'] . '/notary/register?pin=' . $data['pin'];
        $message_data['button_text'] = 'Вступить';
        $mailService = new MailService();
        $mailService->send($user['email'], $message_data['title'], $message_data['content'], $message_data['button_text'], $message_data['button_link'],);

        $deal->notary_id = $notary->id;
        $deal->status = Document::STATUS_WAITING_FOR_NOTARY;
        $deal->save();

        return response()->json(['success' => true]);
    }

    public function accept(int $deal_id)
    {
        $user = auth('api')->user();
        $notary = Notary::where('user_id', $user->id)->first();
        $deal = Document::where('id', $deal_id)->first();
        if (empty($deal)) return response()->json(['message' => 'No deal found'], 404);
        if ($deal->notary_id != $notary->id) return response()->json(['message' => 'This notary is not assigned to this deal']);
        $deal->status = Document::STATUS_NOTARY_ACCEPTED;
        $deal->save();

        $deal->users()->attach($user, ['user_role' => 3, 'user_signs' => false, 'user_present' => true]);

        $un_user = UnauthorizedUser::where('document_id', $deal->id)->where('type', 3)->first();
        $un_user->delete();
        return response()->json(['success' => true]);
    }

    public function decline(int $deal_id)
    {
        $user = auth('api')->user();
        $notary = Notary::where('user_id', $user->id)->first();
        $deal = Document::where('id', $deal_id)->first();
        if (empty($deal)) return response()->json(['message' => 'No deal found'], 404);
        if ($deal->notary_id != $notary['id']) return response()->json(['message' => 'This notary is not assigned to this deal']);
        $deal->notary_id = null;
        $deal->status = Document::STATUS_NOTARY_DECLINED;
        $deal->save();
        $un_user = UnauthorizedUser::where('document_id', $deal->id)->where('type', 3)->first();
        $un_user->delete();
        return response()->json(['success' => true]);
    }

}
