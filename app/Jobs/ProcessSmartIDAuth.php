<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Sk\SmartId\Api\Data\AuthenticationHash;
use Sk\SmartId\Api\Data\CertificateLevelCode;
use Sk\SmartId\Api\Data\NationalIdentity;
use Sk\SmartId\Exception\SmartIdException;

class ProcessSmartIDAuth implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $db_record;
    protected $client;
    protected $identity_type;
    protected $country_code;
    protected $code;

    public function __construct($db_record, $client, $identity_type, $country_code, $code)
    {
        $this->db_record = $db_record;
        $this->client = $client;
        $this->identity_type = $identity_type;
        $this->country_code = $country_code;
        $this->code = $code;

    }

    public function handle()
    {

        $identity = new NationalIdentity($this->country_code, $this->code);

        $authenticationHash = AuthenticationHash::generate();

        $verificationCode = $authenticationHash->calculateVerificationCode();
        DB::table('skid_transactions')->where('id', $this->db_record)->update(['code' => $verificationCode, 'updated_at' => Carbon::now()]);

        try {
            $authenticationResponse = $this->client->authentication()
                ->createAuthentication()
                //->withNationalIdentityNumber($id_code)
                ->withNationalIdentity($identity) // or with document number: ->withDocumentNumber( 'PNOEE-10101010005-Z1B2-Q' )
                ->withAuthenticationHash($authenticationHash)
                ->withCertificateLevel(CertificateLevelCode::QUALIFIED)
                ->authenticate();

            DB::table('skid_transactions')->where('id', $this->db_record)->update(['status' => true,
                'data' => json_encode([
                    $authenticationResponse->getSignedData()
                ]), 'updated_at' => Carbon::now()]);

        } catch (SmartIdException $e) {
            $message = "Something went wrong with Mobile-ID service: " . $e->getMessage();
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        }
    }
}
