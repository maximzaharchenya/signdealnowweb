<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\SKID\MobileIDService;
use App\Services\SKID\SmartIDService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealSigningController extends Controller
{
    public function sign($deal_id)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $authUser = auth('api')->user();
        if (empty($deal->users()->where('user_id', $authUser->id)->first())) return response()->json('User cant sign this deal', 403);

        $data = request()->validate([
            'authenticationType' => ['required'],
            'personalCode' => ['nullable'],
            'phoneNumber' => ['nullable'],
            'country' => ['nullable'],
            'identityType' => ['nullable'],
            'documentNumber' => ['nullable'],
        ]);

        switch ($data['authenticationType']) {
            case 'mobile_id':
                $mobileIDService = new MobileIDService();
                $transaction_id = $mobileIDService->sign($data['phoneNumber'], $data['personalCode'], $authUser->id, $deal);
                break;
            case 'smart_id':
                $smartIDService = new SmartIDService();
                $transaction_id = $smartIDService->send($data['identityType'], $data['country'], $data['personalCode'], $authUser->id);
                break;
            default:
                $transaction_id = null;
        }

        return response()->json(['transaction_id' => $transaction_id]);
    }

    public function change_status($deal_id): JsonResponse
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        if ($deal->status = 6) $deal->update(['status' => Document::STATUS_SIGNING]);
        return response()->json(['success' => true]);
    }

    public function checkSigningStatus($deal_id)
    {
        $deal = Document::where('id', $deal_id)->firstOrFail();
        $authUser = auth('api')->user();
        if (empty($deal->users()->where('user_id', $authUser->id)->first())) return response()->json('User cant sign this deal', 403);

        $records = DB::table('skid_transactions')->where('user_id', $authUser->id)->where('document_id', $deal->id)->get();
        $isSigned = 0;
        foreach ($records as $record)
            if ($record->status == true) $isSigned = 1;

        return response()->json(['is_signed' => $isSigned]);
    }
}
