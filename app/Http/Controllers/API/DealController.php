<?php

namespace App\Http\Controllers\API;

use App\Events\DocumentUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUnauthorizedUserData;
use App\Http\Requests\StoreDealData;
use App\Http\Resources\DealResources;
use App\Models\Document;
use App\Models\Notary;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\JsonResponse;
use App\Services\MainService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\UnauthorizedUser;

class DealController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();
        $query = $user->documents();
        if (!empty(request()->roleInDeal)) $query->wherePivot('user_role', request()->roleInDeal);
        if (!empty(request()->dealState)) $query->where('status', request()->dealState);
        switch (request()->sortBy) {
            case 1:
                $query->orderBy('address', 'ASC');
                break;
            case 2:
                $query->orderBy('address', 'DESC');
                break;
            case 3:
                $query->orderBy('created_at', 'ASC');
                break;
            default:
            case 4:
                $query->orderBy('created_at', 'DESC');
                break;
        }
        $deals = $query->get();
        return DealResources::collection($deals);
    }

    public function show($deal_id)
    {
        $validator = Validator::make(['deal_id' => $deal_id], [
            'deal_id' => 'numeric',
        ]);
        if ($validator->fails()) return response()->json(['error' => 'Please enter correct id of deal.'], 400);
        if (!auth('api')->user()->can('inDeal', $deal_id)) {
            return response()->json(['error' => 'Please enter correct id of deal.'], 403);
        }
        $deal = Document::where('id', $deal_id)->with('users', 'notes', 'contributors', 'mortgages')->first();
        if (!empty($deal['notary_id'])) {
            $notary = Notary::where('id', $deal['notary_id'])->first();
            $deal['notary'] = User::where('id', $notary['user_id'])->first();
            $deal['notary']['office_name'] = $notary->office_name;
        }
        if (empty($deal)) return response()->json(['error' => 'Please enter correct id of deal.'], 400);
        return new DealResources($deal);
    }

    public function description($deal_id)
    {
        $validator = Validator::make(['deal_id' => $deal_id], [
            'deal_id' => 'numeric',
        ]);
        if ($validator->fails())
            return response()->json(['error' => 'Please enter correct id of deal.'], 400);
        $deal = Document::where('id', $deal_id)->first();
        $description['id'] = $deal['id'];
        $description['type'] = $deal['type'];
        $description['country'] = $deal['country'];
        $description['city'] = $deal['city'];
        $description['address'] = $deal['address'];
        if (empty($deal))
            return response()->json(['error' => 'Please enter correct id of deal.'], 400);
        return new DealResources($description);
    }

    public function store(StoreDealData $request, MainService $mainService, MailService $mailService): JsonResponse
    {
        $data = $request->all();
        if ($data['country'] == 'null' || $data['city'] == 'null' || $data['address'] == 'null') {
            return response()->json(['error' => 'Please enter valid country, city and address.'], 400);
        }

        unset($data['user_email']);
        unset($data['user_phone']);
        unset($data['user_role']);
        unset($data['image']);
        $data['status'] = Document::STATUS_CREATED;

        if (!empty($request->file('image'))) {
            $path = $mainService->saveImage($request->file('image'), 'deal_img', 240, 256);
            $data['image'] = 'deal_img/' . $path;
        }

        $document = Document::create($data);

        $request->user_role != null ? $document->users()->attach(auth('api')->user(), ['user_role' => $request->user_role, 'user_signs' => 1, 'user_present' => 1]) : $document->users()->attach(auth('api')->user(), ['user_role' => 1, 'user_signs' => 1, 'user_present' => 1]);

        $unauthorized_user['pin'] = $mainService->makePin();
        $unauthorized_user['document_id'] = $document['id'];
        $unauthorized_user['email'] = $request->user_email;
        $unauthorized_user['phone'] = $request->user_phone;
        $unauthorized_user['type'] = $request->user_type;
        $unauthorized_user['signs'] = 1;
        $unauthorized_user['present'] = 1;
        $unauthorized_user['from'] = auth('api')->id();
        UnauthorizedUser::create($unauthorized_user);

        if (!empty($request->user_email))
            $user = User::where('email', $request->user_email)->first();
        elseif (!empty($request->user_phone))
            $user = User::where('phone', $request->user_phone)->first();

        $message_data['title'] = 'Вам пришло приглашение вступить в сделку!';
        $message_data['content'] = 'Вас пригласили вступить в сделку по адресу: ' . $document['country'] . ', ' . $document['city'] . ',' . $document['address'] . '. Перейдите по ссылке ниже, чтобы вступить!';
        $message_data['button_link'] = env('APP_URL') . 'account/deal/' . $document['id'] . '/register?pin=' . $unauthorized_user['pin'];
        $message_data['button_text'] = 'Вступить';
        if (!empty($user))
            $mailService->send($user['email'], $message_data['title'], $message_data['content'], $message_data['button_text'], $message_data['button_link'],);
        elseif (!empty($request->user_email))
            $mailService->send($request->user_email, $message_data['title'], $message_data['content'], $message_data['button_text'], $message_data['button_link'],);

        return response()->json(['success' => true]);
    }

    public function register(RegisterUnauthorizedUserData $request): JsonResponse
    {
        $unauthorized_user = UnauthorizedUser::where('pin', $request->pin)->first();
        if (!empty($unauthorized_user)) {
            if (!empty($unauthorized_user['email'])) {
                $user = User::where('email', $unauthorized_user['email'])->first();
            } else {
                $user = User::where('phone', $unauthorized_user['phone'])->first();
            }
            $document = Document::where('id', $unauthorized_user['document_id'])->first();
            if ($document->status == 1) $document->update(['status' => Document::STATUS_WORK_WITH_DOCUMENT]);
            $document->users()->attach($user, ['user_role' => $unauthorized_user['type'], 'user_signs' => $unauthorized_user['signs'], 'user_present' => $unauthorized_user['present'], 'from' => $unauthorized_user['from']]);
            $unauthorized_user->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Information not found.'], 400);
        }
    }

    public function exit(int $deal_id): JsonResponse
    {
        if (!auth('api')->user()->can('inDeal', $deal_id)) {
            return response()->json(['error' => 'Please enter correct id of deal.'], 403);
        }
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $id = auth('api')->id();
        $deal->users()->wherePivot('user_id', $id)->detach();
        return response()->json(['success' => true]);
    }

    public function user_delete(int $deal_id): JsonResponse
    {
        if (!auth('api')->user()->can('inDeal', $deal_id)) {
            return response()->json(['error' => 'Please enter correct id of deal.'], 403);
        }
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $id_from = auth('api')->id();
        $id = request()->user_id;
        $deal->users()->wherePivot('from', $id_from)->wherePivot('user_id', $id)->detach();
        return response()->json(['success' => true]);
    }

    public function approve(int $deal_id): JsonResponse
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $user = auth('api')->user();
        $deal->users()->updateExistingPivot($user, ['approved' => 1]);
        DocumentUpdatedEvent::dispatch($deal);
        return response()->json(['success' => true]);
    }

    public function fees_approve(int $deal_id): JsonResponse
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $user = auth('api')->user();
        $deal->users()->updateExistingPivot($user, ['fees_approved' => 1]);
        DocumentUpdatedEvent::dispatch($deal);
        return response()->json(['success' => true]);
    }

    public function sign_approve(int $deal_id): JsonResponse
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $user_approve = auth('api')->user();
        $deal->users()->updateExistingPivot($user_approve, ['sign_approved' => 1]);
        DocumentUpdatedEvent::dispatch($deal);

        $users = $deal->users()->get();
        $result = [];
        foreach ($users as $user) {
            if ($user->pivot->user_role != 3 && $user->pivot->user_signs != 0) {
                $data['sign_approved'] = $user->pivot->sign_approved;
                array_push($result, $data);
            }
        }
        $all_sign = true;
        foreach ($result as $el) {
            if (!$el['sign_approved']) $all_sign = false;
        }
        if ($all_sign) $deal->update(['status' => Document::STATUS_APPROVAL_OF_THE_SIGNING_TIME]);

        return response()->json(['success' => true]);
    }

    public function sign_disagree(int $deal_id): JsonResponse
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $user = auth('api')->user();
        $deal->users()->updateExistingPivot($user, ['sign_approved' => 2]);
        DocumentUpdatedEvent::dispatch($deal);
        return response()->json(['success' => true]);
    }

    public function check_statuses(int $deal_id): JsonResponse
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $users = $deal->users()->get();
        $result = [];
        foreach ($users as $user) {
            $data['name'] = $user['name'];
            $data['surname'] = $user['surname'];
            $data['user_role'] = $user->pivot->user_role;
            $data['approved'] = $user->pivot->approved;
            if ($data['user_role'] == 1) {
                $seller_data = $deal['seller_data'];
                $seller_data_fullness = false;
                if (!empty($seller_data)) $seller_data_fullness = true;

                $additional_seller_data = $deal['additional_seller_data'];
                $additional_seller_data_fullness = false;
                if (!empty($additional_seller_data)) $additional_seller_data_fullness = true;

                $property_data = $deal['property_data'];
                $property_data_fullness = false;
                if (!empty($property_data)) $property_data_fullness = true;

                $data['fullness'] = false;
                if ($seller_data_fullness && $additional_seller_data_fullness && $property_data_fullness) $data['fullness'] = true;
            } else {
                $client_data = json_decode($deal['client_data']);
                $client_data_fullness = false;
                if (!empty($client_data)) {
                    foreach ($client_data as $info) {
                        if ($info->client_user_id == $user['id']) $client_data_fullness = true;
                    }
                }

                $additional_client_data = json_decode($deal['additional_client_data']);
                $additional_client_data_fullness = false;
                if (!empty($additional_client_data)) {
                    foreach ($additional_client_data as $info) {
                        if ($info->client_user_id == $user['id']) $additional_client_data_fullness = true;
                    }
                }

                $mortgages = $deal->mortgages()->get();
                $mortgages_data_fullness = false;
                if (count($mortgages) == 0) {
                    $mortgages_data_fullness = true;
                } else {
                    foreach ($mortgages as $info) {
                        if ($info->user_id == $user['id']) {
                            $holder = $info->holder_data;
                            if (!empty($holder)) {
                                $mortgages_data_fullness = true;
                            }
                        }
                    }
                }

                $data['fullness'] = false;
                if ($client_data_fullness && $additional_client_data_fullness && $mortgages_data_fullness) $data['fullness'] = true;
            }
            array_push($result, $data);
        }
        $all_fullness = true;
        $all_approved = true;
        foreach ($result as $el) {
            if (!$el['approved']) $all_approved = false;
            if (!$el['fullness']) $all_fullness = false;
        }

        if ($deal->status == Document::STATUS_WORK_WITH_DOCUMENT && $all_fullness && $all_approved) $deal->update(['status' => Document::STATUS_NOTARY_INVITED]);

        return response()->json($result);
    }

    public function uploadDocument(int $deal_id)
    {
        $authUser = auth('api')->user();
        if (empty($authUser)) return response()->json('User is not authorized', 403);
        if ($authUser->type != 3) return response()->json('User is not notary', 403);

        $deal = Document::where('id', $deal_id)->firstOrFail();

        $document = request()->file('document');

        $mainService = new MainService();
        $document_file = $mainService->saveImageOrDocument($document, 'documents');

        if (!empty($deal->document_file)) Storage::delete('/public/documents/' . $deal->document_file);

        $deal->document_file = $document_file;
        $deal->save();

        return response()->json();

    }
}
