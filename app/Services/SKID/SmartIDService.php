<?php


namespace App\Services\SKID;


use App\Jobs\ProcessMobileIDAuth;
use App\Jobs\ProcessSmartIDAuth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Sk\Mid\Exception\MidInvalidNationalIdentityNumberException;
use Sk\Mid\Exception\MidInvalidPhoneNumberException;
use Sk\Mid\MobileIdClient;
use Sk\Mid\Util\MidInputUtil;
use Sk\SmartId\Api\Data\AuthenticationHash;
use Sk\SmartId\Api\Data\NationalIdentity;
use Sk\SmartId\Client;

class SmartIDService
{

    public function send($identity_type, $country, $code, $user_id = null): string
    {

        $client = new Client();
        $client
            ->setRelyingPartyUUID(env('SKID_PRUUID'))
            ->setRelyingPartyName(env('SKID_NAME'))
            ->setHostUrl(env('SKID_URL'))
            ->setPublicSslKeys("sha256//k/w7/9MIvdN6O/rE1ON+HjbGx9PRh/zSnNJ61pldpCs=;sha256//l2uvq6ftLN4LZ+8Un+71J2vH1BT9wTbtrE5+Fj3Vc5g=");

        $transaction_id = DB::table('skid_transactions')->insertGetId([
            'type' => 'smart_id',
            'user_id' => $user_id,
            'ip' => request()->ip(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        switch ($country) {
            case 'Latvia':
                $country_code = 'LV';
                break;
            case 'Lithuania':
                $country_code = 'LT';
                break;
            case 'Estonia':
            default:
                $country_code = 'EE';
        }

        ProcessSmartIDAuth::dispatchAfterResponse($transaction_id, $client, $identity_type, $country_code, $code);

        return $transaction_id;
    }

}
