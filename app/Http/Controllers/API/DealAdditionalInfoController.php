<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadDealContract;
use App\Http\Requests\UpdateDealAdditionalClientData;
use App\Http\Requests\UpdateDealAdditionalSellerData;
use App\Http\Requests\UpdateDealClientData;
use App\Http\Requests\UpdateDealContributorsData;
use App\Http\Requests\UpdateDealHolderData;
use App\Http\Requests\UpdateDealMarriedData;
use App\Http\Requests\UpdateDealMortgageData;
use App\Http\Requests\UpdateDealNotaryData;
use App\Http\Requests\UpdateDealPropertyData;
use App\Http\Requests\UpdateDealRepresentativeData;
use App\Http\Requests\UpdateDealSellerData;
use App\Http\Requests\StoreDealUserData;
use App\Http\Requests\StoreDealNoteData;
use App\Http\Requests\UpdateDealSignInfoData;
use App\Models\Contributor;
use App\Models\Document;
use App\Models\Mortgage;
use App\Models\Note;
use App\Models\UnauthorizedUser;
use App\Models\User;
use App\Services\DealApproveService;
use App\Services\MailService;
use App\Services\MainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DealAdditionalInfoController extends Controller
{
    public function storeUserData(int $deal_id, StoreDealUserData $request, MainService $mainService): JsonResponse
    {
        $data = $request->all();
        $data['pin'] = $mainService->makePin();
        $data['document_id'] = $deal_id;
        $data['from'] = auth('api')->id();
        UnauthorizedUser::create($data);

        $document = Document::where('id', $deal_id)->first();
        $message_data['title'] = 'Вам пришло приглашение вступить в сделку!';
        $message_data['content'] = 'Вас пригласили вступить в сделку по адресу: ' . $document['country'] . ', ' . $document['city'] . ',' . $document['address'] . '. Перейдите по ссылке ниже, чтобы вступить!';
//        $message_data['button_link'] = env('APP_URL') . 'account/deal/' . $deal_id . '/register?pin=' . $data['pin'];
        $message_data['button_link'] = config('app.url') . 'account/deal/' . $deal_id . '/register?pin=' . $data['pin'];
        $message_data['button_text'] = 'Вступить';
        $mailService = new MailService();
        if (!empty(request()->user_email))
            $user = User::where('email', request()->user_email)->first();
        elseif (!empty(request()->user_phone))
            $user = User::where('phone', request()->user_phone)->first();

        if (!empty($user))
            $mailService->send($user['email'], $message_data['title'], $message_data['content'], $message_data['button_text'], $message_data['button_link'],);
        elseif (!empty(request()->user_email))
            $mailService->send($request->email, $message_data['title'], $message_data['content'], $message_data['button_text'], $message_data['button_link'],);
        return response()->json(['success' => true]);
    }

    public function updateAdditionalSellerData(int $deal_id, UpdateDealAdditionalSellerData $request, DealApproveService $dealApproveService)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $deal->additional_seller_data = json_encode($request->all());
        $deal->save();
        $dealApproveService->unapproved($deal_id);
        return $deal;
    }

    public function updateSellerData(int $deal_id, UpdateDealSellerData $request, DealApproveService $dealApproveService)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $deal->seller_data = json_encode($request->all());
        $deal->save();
        $dealApproveService->unapproved($deal_id);
        return $deal;
    }

    public function updateAdditionalClientData(int $deal_id, UpdateDealAdditionalClientData $request, DealApproveService $dealApproveService)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();

        $additional_client_data = $request->all();
        $additional_client_data['client_user_id'] = auth('api')->id();

        if (!empty($deal->additional_client_data)) {
            $deal_additional_client_data = json_decode($deal->additional_client_data);
            foreach ($deal_additional_client_data as $key => $data) {
                if ($data->client_user_id == $additional_client_data['client_user_id']) {
                    $deal_additional_client_data[$key] = $additional_client_data;
                    $deal->additional_client_data = json_encode($deal_additional_client_data);
                    $deal->save();
                    $dealApproveService->unapproved($deal_id);
                    return $deal;
                }
            }
            array_push($deal_additional_client_data, $additional_client_data);
            $deal->additional_client_data = json_encode($deal_additional_client_data);
            $deal->save();
            $dealApproveService->unapproved($deal_id);
            return $deal;

        } else $deal_additional_client_data = [$additional_client_data];

        $deal->additional_client_data = json_encode($deal_additional_client_data);
        $deal->save();
        $dealApproveService->unapproved($deal_id);
        return $deal;
    }

    public function updateClientData(int $deal_id, UpdateDealClientData $request, DealApproveService $dealApproveService)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();

        $client_data = $request->all();
        $client_data['client_user_id'] = auth('api')->id();

        if (!empty($deal->client_data)) {
            $deal_client_data = json_decode($deal->client_data);


            foreach ($deal_client_data as $key => $data) {
                if ($data->client_user_id == $client_data['client_user_id']) {
                    $deal_client_data[$key] = $client_data;
                    $deal->client_data = json_encode($deal_client_data);
                    $deal->save();
                    $dealApproveService->unapproved($deal_id);
                    return $deal;
                }
            }
            array_push($deal_client_data, $client_data);
            $deal->client_data = json_encode($deal_client_data);
            $deal->save();
            $dealApproveService->unapproved($deal_id);
            return $deal;
        } else $deal_client_data = [$client_data];

        $deal->client_data = json_encode($deal_client_data);
        $deal->save();
        $dealApproveService->unapproved($deal_id);
        return $deal;
    }

    public function updatePropertyData(int $deal_id, UpdateDealPropertyData $request, DealApproveService $dealApproveService)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $deal->property_data = json_encode($request->all());
        $deal->country = $request->country;
        $deal->city = $request->city;
        $deal->address = $request->address;
        $deal->cadastral_number = $request->cadastral_number;
        $deal->save();
        $dealApproveService->unapproved($deal_id);
        return $deal;
    }

    public function updateCoOwnerData(int $deal_id, DealApproveService $dealApproveService)
    {
        if (!auth('api')->user()->can('inDeal', $deal_id)) {
            return response()->json(['error' => 'Please enter correct id of deal.'], 403);
        }
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $co_owner_data = request()->co_owner_data;
        $deal->co_owner_data = $co_owner_data;
        $deal->save();
        $dealApproveService->unapproved($deal_id);
        return $deal;
    }

    public function storeMortgageData(int $deal_id, UpdateDealMortgageData $request, DealApproveService $dealApproveService): JsonResponse
    {
        $data = $request->all();
        $data['document_id'] = $deal_id;
        $data['user_id'] = auth('api')->id();
        Mortgage::create($data);
        $dealApproveService->unapproved($deal_id);
        return response()->json(['success' => true]);
    }

    public function updateMortgageData(int $deal_id, int $mortgage_id, UpdateDealMortgageData $request, DealApproveService $dealApproveService): JsonResponse
    {
        $mortgage = Mortgage::where('id', $mortgage_id)->where('document_id', $deal_id)->firstOrFail();
        $mortgage_data = $request->all();
        $mortgage->update($mortgage_data);
        $dealApproveService->unapproved($deal_id);
        return response()->json(['success' => true]);
    }

    public function deleteMortgageData(int $deal_id, int $mortgage_id, DealApproveService $dealApproveService): JsonResponse
    {
        if (!auth('api')->user()->can('inDeal', $deal_id)) {
            return response()->json(['error' => 'Please enter correct id of deal.'], 403);
        }
        $mortgage = Mortgage::where('id', $mortgage_id)->where('document_id', $deal_id)->firstOrFail();
        $mortgage->delete();
        $dealApproveService->unapproved($deal_id);
        return response()->json(['success' => true]);
    }

    public function updateHolderData(int $deal_id, int $mortgage_id, DealApproveService $dealApproveService, UpdateDealHolderData $request): JsonResponse
    {
        $mortgage = Mortgage::where('id', $mortgage_id)->where('document_id', $deal_id)->firstOrFail();

        $holder_data = $request->all();
        $holder_data['holder_user_id'] = auth('api')->id();

        if (!empty($mortgage->holder_data)) {
            $deal_holder_data = json_decode($mortgage->holder_data);
            foreach ($deal_holder_data as $key => $data) {
                if ($data->holder_user_id == $holder_data['holder_user_id']) {
                    $deal_holder_data[$key] = $holder_data;
                    $mortgage->holder_data = json_encode($deal_holder_data);
                    $mortgage->save();
                    $dealApproveService->unapproved($deal_id);
                    return response()->json(['success' => true]);
                }
            }
            array_push($deal_holder_data, $holder_data);
            $mortgage->holder_data = json_encode($deal_holder_data);
            $mortgage->save();
            $dealApproveService->unapproved($deal_id);
            return response()->json(['success' => true]);
        } else $deal_holder_data = [$holder_data];
        $mortgage->holder_data = json_encode($deal_holder_data);
        $mortgage->save();

        $dealApproveService->unapproved($deal_id);
        return response()->json(['success' => true]);
    }

    public function deleteHolderData(int $deal_id, int $mortgage_id, DealApproveService $dealApproveService): JsonResponse
    {
        $mortgage = Mortgage::where('id', $mortgage_id)->where('document_id', $deal_id)->firstOrFail();

        $mortgage->holder_data = null;
        $mortgage->save();

        $dealApproveService->unapproved($deal_id);
        return response()->json(['success' => true]);
    }

    public function storeNoteData(int $deal_id, StoreDealNoteData $request): JsonResponse
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $user = auth('api')->user();
        $data['document_id'] = $deal->id;
        $data['user_id'] = $user['id'];
        $data['note'] = $request->note;
        Note::create($data);
        return response()->json(['success' => true]);
    }

    public function updateNoteData(int $deal_id, int $note_id, StoreDealNoteData $request): JsonResponse
    {
        $note = Note::where('document_id', $deal_id)->where('id', $note_id)->firstOrFail();
        $data = $request->all();
        $note->update($data);
        return response()->json(['success' => true]);
    }

    public function deleteNoteData(int $deal_id, int $note_id): JsonResponse
    {
        if (!auth('api')->user()->can('inDeal', $deal_id)) {
            return response()->json(['error' => 'Please enter correct id of deal.'], 403);
        }
        $note = Note::where('document_id', $deal_id)->where('id', $note_id)->firstOrFail();
        $note->delete();
        return response()->json(['success' => true]);
    }

    public function updateMarriedData(int $deal_id, UpdateDealMarriedData $request, DealApproveService $dealApproveService)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();

        $married_data = $request->all();
        $married_data['user_id'] = auth('api')->id();

        if (!empty($deal->married_data)) {
            $deal_married_data = json_decode($deal->married_data);
            foreach ($deal_married_data as $key => $data) {
                if ($data->user_id == $married_data['user_id']) {
                    $deal_married_data[$key] = $married_data;
                    $deal->married_data = json_encode($deal_married_data);
                    $deal->save();
                    $dealApproveService->unapproved($deal_id);
                    return $deal;
                }
            }
            array_push($deal_married_data, $married_data);
            $deal->married_data = json_encode($deal_married_data);
            $deal->save();
            $dealApproveService->unapproved($deal_id);
            return $deal;
        } else $deal_married_data = [$married_data];
        $deal->married_data = json_encode($deal_married_data);
        $deal->save();
        $dealApproveService->unapproved($deal_id);
        return $deal;
    }

    public function updateRepresentativeData(int $deal_id, UpdateDealRepresentativeData $request, DealApproveService $dealApproveService)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();

        $representative_data = $request->all();
        $representative_data['user_id'] = auth('api')->id();

        if (!empty($deal->representative_data)) {
            $deal_representative_data = json_decode($deal->representative_data);
            foreach ($deal_representative_data as $key => $data) {
                if ($data->user_id == $representative_data['user_id']) {
                    if ($request->file('file')) {
                        if (!empty($data['file'])) Storage::delete('/public/representative_files/' . $data['file']);
                        $path = $request->file('file')->store('representative_files', 'public');
                        $representative_data['file'] = $path;
                    }
                    $deal_representative_data[$key] = $representative_data;
                }
            }
            if ($request->file('file')) {
                if (!empty($data['file'])) Storage::delete('/public/representative_files/' . $data['file']);
                $path = $request->file('file')->store('representative_files', 'public');
                $representative_data['file'] = $path;
            }
            array_push($deal_representative_data, $representative_data);
            $deal->representative_data = json_encode($deal_representative_data);
            $deal->save();
            $dealApproveService->unapproved($deal_id);
            return $deal;
        } else {
            if ($request->file('file')) {
                $path = $request->file('file')->store('representative_files', 'public');
                $representative_data['file'] = $path;
            }
            $deal_representative_data = [$representative_data];
        }

        $deal->representative_data = json_encode($deal_representative_data);
        $deal->save();
        $dealApproveService->unapproved($deal_id);
        return $deal;
    }

    public function downloadContract(int $deal_id, DownloadDealContract $request)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        if (!empty($deal->representative_data)) {
            $deal_representative_data = json_decode($deal->representative_data);
            foreach ($deal_representative_data as $data) {
                if ($data->user_id == $request->user_id) {
                    if (!empty($data->file)) {
                        return response()->download($data->file);
                    } else {
                        return response()->json(['error' => 'Information not found.'], 400);
                    }
                }
            }
        }
    }

    public function storeContributorsData(int $deal_id, UpdateDealContributorsData $request): JsonResponse
    {
        $data = $request->all();
        $data['document_id'] = $deal_id;
        if (!empty(request()->file('representative_file')))
            $data['representative_file'] = request()->file('representative_file')->store('representative_files', 'public');
        Contributor::create($data);
        return response()->json(['success' => true]);
    }

    public function updateContributorsData(int $deal_id, int $contributor_id, UpdateDealContributorsData $request): JsonResponse
    {
        $data = $request->all();
        $contributor = Contributor::where('id', $contributor_id)->where('document_id', $deal_id)->firstOrFail();
        if (!empty(request()->file('representative_file'))) {
            if (!empty($contributor['representative_file'])) Storage::delete('/public/' . $data['representative_file']);
            $data['representative_file'] = request()->file('representative_file')->store('representative_files', 'public');
        }
        $contributor->update($data);
        return response()->json(['success' => true]);
    }

    public function deleteContributorsData(int $deal_id, int $contributor_id): JsonResponse
    {
        if (!auth('api')->user()->can('inDeal', $deal_id)) {
            return response()->json(['error' => 'Please enter correct id of deal.'], 403);
        }
        $contributor = Contributor::where('id', $contributor_id)->where('document_id', $deal_id)->firstOrFail();
        if (!empty($contributor['representative_file'])) Storage::delete('/public/' . $contributor['representative_file']);
        $contributor->delete();
        return response()->json(['success' => true]);
    }


    public function updateSignInfoData(int $deal_id, UpdateDealSignInfoData $request, DealApproveService $dealApproveService)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $deal->sign_info = json_encode($request->all());
        $deal->save();
        $dealApproveService->sign_unapproved($deal_id);
        return $deal;
    }

    public function updateSignInfoDocData(int $deal_id, UpdateDealSignInfoData $request)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        if (request()->file('file')) {
            if (!empty($deal['sign_info_file'])) Storage::delete('/public/representative_files/' . $deal['sign_info_file']);
            $deal->sign_info_file = $request->file('file')->store('representative_files', 'public');
            $deal->save();
        }
        return $deal;
    }

    public function updateNotaryFeesData(int $deal_id)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $data = request()->all();
        $deal->notary_fees = json_encode($data);
        $deal->save();
        return $deal;
    }

    public function updateFeesData(int $deal_id)
    {
        if (!auth('api')->user()->can('inDeal', $deal_id)) {
            return response()->json(['error' => 'Please enter correct id of deal.'], 403);
        }
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $data = request()->all();
        $deal->fees = json_encode($data);
        $deal->save();
        return $deal;
    }


    public function updateNotaryData(int $deal_id, UpdateDealNotaryData $request)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $deal->notary_data = json_encode($request->all());
        $deal->save();
        return $deal;
    }


}
