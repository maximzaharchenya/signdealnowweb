<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Sk\Mid\Exception\MidInternalErrorException;
use Sk\Mid\Exception\MidServiceUnavailableException;
use Sk\Mid\Exception\MidSslException;
use Sk\Mid\Exception\MidUnauthorizedException;
use Sk\Mid\Exception\MissingOrInvalidParameterException;

class ProcessMobileIDSigning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const sslPinnedPublicKeys = "sha256//k/w7/9MIvdN6O/rE1ON+HjbGx9PRh/zSnNJ61pldpCs=;sha256//+aKQHcCEBu5zSlcNENV/u/Hug0s5E4j6lezohRhFBm4=";

    protected $db_record;
    protected $phone_number;
    protected $national_identity_number;
    protected $hash;

    public function __construct($transaction_id, $phoneNumber, $nationalIdentityNumber, $hash)
    {
        $this->db_record = $transaction_id;
        $this->phone_number = str_replace(' ', '', $phoneNumber);
        $this->national_identity_number = $nationalIdentityNumber;
        $this->hash = $hash;
    }

    public function handle()
    {
        Log::info('Trying to sign document:');
        Log::info('Phone: ' . $this->phone_number . ', nationalIdentityNumber: ' . $this->national_identity_number);

        $json = json_encode([
            'phoneNumber' => $this->phone_number,
            'nationalIdentityNumber' => $this->national_identity_number,
            'relyingPartyUUID' => env('SKID_PRUUID'),
            'relyingPartyName' => env('SKID_NAME'),
            'hash' => $this->hash,
            'hashType' => "SHA256",
            'language' => "ENG",
            'displayText' => "Sign document.",
            'displayTextFormat' => "GSM-7",
        ]);

        $url = env('SKID_MOBILE_URL') . '/signature';

        if (App::environment('local')) {
            sleep(3);
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['status' => true, 'data' => json_encode(['local_environment']), 'updated_at' => Carbon::now()]);
        } else {
            $response = $this->postRequest($url, $json);

            Log::info('Session ID: ' . $response['sessionID']);

            $count = 0;
            do {
                sleep(3);
                $status = $this->checkSession($response['sessionID']);
                if (!empty($status['state']) && $status['state'] == 'COMPLETE') {
                    DB::table('skid_transactions')->where('id', $this->db_record)->update(['status' => true, 'data' => json_encode($status), 'updated_at' => Carbon::now()]);
                    $count = 5;
                } else $count++;
            } while ($count < 5);
        }

    }

    /* Private functions */
    private function postRequest(string $url, string $json)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->addCustomHeaders(array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json)))
        );

        curl_setopt($ch, CURLOPT_PINNEDPUBLICKEY, self::sslPinnedPublicKeys);

        $result = curl_exec($ch);
        if ($result === false) {
            $rawError = curl_error($ch);

            if (strpos($rawError, "public key does not match pinned public key") !== false) {
                $message = "SSL public key is untrusted for host: " . $url . " . See README . md for setting API host certificate as trusted . ";
                DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
                Log::info('Signing fail: ' . $message);
                throw new MidSslException("SSL public key is untrusted for host: " . $url . " . See README . md for setting API host certificate as trusted . ");
            } else {
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                switch ($http_code) {
                    case 400:
                        $message = "MID API returned HTTP status code 400";
                        DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
                        Log::info('Signing fail: ' . $message);
                        Log::info('Curl error: ' . curl_error($ch));
                        break;
                    case 401:
                        $message = "MID API returned HTTP status code 401";
                        DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
                        Log::info('Signing fail: ' . $message);
                        break;
                    case 405:
                        $message = "MID API returned HTTP status code 405";
                        DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
                        Log::info('Signing fail: ' . $message);
                        break;
                    case 503:
                        $message = "MID API is temporarily unavailable";
                        DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
                        Log::info('Signing fail: ' . $message);
                        break;
                    default:
                        $message = 'POST request to MID returned unknown status code ' . $http_code;
                        DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
                        Log::info('Signing fail: ' . $message);
                        break;
                }
            }
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseAsArray = json_decode($result, true);

        switch ($http_code) {
            case 200:
                return $responseAsArray;
            case 400:
            case 405:
            case 401:
            case 503:
            default:
                $message = 'POST request to MID returned unknown status code ' . $http_code;
                DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
                Log::info('Signing fail: ' . $message);
                break;
        }

        return null;
    }

    private function getRequest(string $url): array
    {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER,
            $this->addCustomHeaders(array('Content-Type: application/json'))
        );
        curl_setopt($ch, CURLOPT_PINNEDPUBLICKEY, self::sslPinnedPublicKeys);

        $result = curl_exec($ch);
        if ($result === false) {
            $rawError = curl_error($ch);
            $curl_error = "While trying to connect to '$url' got curl error: " . $rawError;
            if (strpos($rawError, "public key does not match pinned public key") !== false) {
                throw new MidSslException("SSL public key is untrusted for host: " . $url . ". See README.md for setting API host certificate as trusted.");
            } else {
                throw new MidInternalErrorException($curl_error);
            }
        }
        return json_decode($result, true);
    }

    private function addCustomHeaders(array $headers)
    {
        return array_merge(array(), $headers);
    }

    public function checkSession($session_id)
    {
        $url = env('SKID_MOBILE_URL') . '/signature/session/' . $session_id;
        $response = $this->getRequest($url);
        Log::info('Checking session ' . $session_id . ': ' . json_encode($response));
        return $response;

    }

}
