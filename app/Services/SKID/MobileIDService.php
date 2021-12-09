<?php


namespace App\Services\SKID;


use App\Jobs\ProcessMobileIDAuth;
use App\Jobs\ProcessMobileIDSigning;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Sk\Mid\Exception\MidInvalidNationalIdentityNumberException;
use Sk\Mid\Exception\MidInvalidPhoneNumberException;
use Sk\Mid\MobileIdClient;
use Sk\Mid\Util\MidInputUtil;

class MobileIDService
{

    public function send($phoneNumber, $nationalIdentityNumber, $user_id = null): string
    {
        try {
            $phoneNumber = MidInputUtil::getValidatedPhoneNumber($phoneNumber);
            $nationalIdentityNumber = MidInputUtil::getValidatedNationalIdentityNumber($nationalIdentityNumber);
        } catch (MidInvalidPhoneNumberException $e) {
            Log::info('Error: The phone number you entered is invalid');
            die('The phone number you entered is invalid');
        } catch (MidInvalidNationalIdentityNumberException $e) {
            Log::info('The national identity number you entered is invalid');
            die('The national identity number you entered is invalid');
        }

        Log::info('Phone: ' . $phoneNumber . ', nationalIdentityNumber: ' . $nationalIdentityNumber);

        $client = MobileIdClient::newBuilder()
            ->withRelyingPartyUUID(env('SKID_PRUUID'))
            ->withRelyingPartyName(env('SKID_NAME'))
            ->withHostUrl(env('SKID_MOBILE_URL'))
            ->withLongPollingTimeoutSeconds(60)
            ->withSslPinnedPublicKeys("sha256//k/w7/9MIvdN6O/rE1ON+HjbGx9PRh/zSnNJ61pldpCs=;sha256//+aKQHcCEBu5zSlcNENV/u/Hug0s5E4j6lezohRhFBm4=")
            ->build();

        $transaction_id = DB::table('skid_transactions')->insertGetId([
            'type' => 'mobile_id',
            'user_id' => $user_id,
            'ip' => request()->ip(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Log::info('Dispatching the job');
        ProcessMobileIDAuth::dispatchAfterResponse($transaction_id, $client, $phoneNumber, $nationalIdentityNumber);

        return $transaction_id;
    }


    public function sign($phoneNumber, $nationalIdentityNumber, $user_id, $deal)
    {
        $file = Storage::path('public/documents/' . $deal->document_file);
        $hash = base64_encode(hash_file("sha256", $file, true));

        $transaction_id = DB::table('skid_transactions')->insertGetId([
            'type' => 'mobile_id',
            'document_id' => $deal->id,
            'user_id' => $user_id,
            'ip' => request()->ip(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        ProcessMobileIDSigning::dispatchAfterResponse($transaction_id, $phoneNumber, $nationalIdentityNumber, $hash);

        return $transaction_id;
    }




}
