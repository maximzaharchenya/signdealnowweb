<?php

namespace App\Http\Controllers\API\SkidSolutions;

use App\Http\Controllers\Controller;
use App\Services\SKID\MobileIDService;
use App\Services\SKID\SmartIDService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SkidSolutionsController extends Controller
{
    public function auth()
    {

        Log::info('Starting authentication process');

        $data = request()->validate([
            'authenticationType' => ['required'],
            'personalCode' => ['nullable'],
            'phoneNumber' => ['nullable'],
            'country' => ['nullable'],
            'identityType' => ['nullable'],
            'documentNumber' => ['nullable'],
        ]);

        $user = auth('api')->user();

        switch ($data['authenticationType']) {
            case 'mobile_id':
                Log::info('Selected mobile id authentication');
                $user->authentication_type = 'mobile_id';
                $mobileIDService = new MobileIDService();
                $transaction_id = $mobileIDService->send($data['phoneNumber'], $data['personalCode'], $user->id);
                break;
            case 'smart_id':
                $user->authentication_type = 'smart_id';
                $smartIDService = new SmartIDService();
                $transaction_id = $smartIDService->send($data['identityType'], $data['country'], $data['personalCode'], $user->id);
                break;
            default:
                $transaction_id = null;
        }

        $user->authentication_transaction_id = $transaction_id;
        $user->save();

        return response()->json([
            'transaction_id' => $transaction_id
        ]);
    }

    public function check($transaction_id = null)
    {
        $user = auth('api')->user();
        if(empty($transaction_id)) $transaction_id = $user->authentication_transaction_id;
        $transaction = DB::table('skid_transactions')->where('id', $transaction_id)->first();
        return response()->json($transaction);
    }

}
