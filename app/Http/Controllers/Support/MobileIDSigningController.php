<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessMobileIDAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Sk\Mid\DisplayTextFormat;
use Sk\Mid\Exception\MidInternalErrorException;
use Sk\Mid\Exception\MidInvalidNationalIdentityNumberException;
use Sk\Mid\Exception\MidInvalidPhoneNumberException;
use Sk\Mid\Exception\MidNotMidClientException;
use Sk\Mid\Exception\MidServiceUnavailableException;
use Sk\Mid\Exception\MidSslException;
use Sk\Mid\Exception\MidUnauthorizedException;
use Sk\Mid\Exception\MissingOrInvalidParameterException;
use Sk\Mid\HashType\HashType;
use Sk\Mid\Language\ENG;
use Sk\Mid\MobileIdAuthenticationHashToSign;
use Sk\Mid\MobileIdClient;
use Sk\Mid\Rest\Dao\Request\AbstractRequest;
use Sk\Mid\Rest\Dao\Request\AuthenticationRequest;
use Sk\Mid\Rest\MobileIdRestConnector;
use Sk\Mid\Util\MidInputUtil;

class MobileIDSigningController extends Controller
{
    private const sslPinnedPublicKeys = "sha256//k/w7/9MIvdN6O/rE1ON+HjbGx9PRh/zSnNJ61pldpCs=;sha256//+aKQHcCEBu5zSlcNENV/u/Hug0s5E4j6lezohRhFBm4=";

    public function index()
    {
        return view('support.mobil_id_signing');
    }

    public function check($transaction_id)
    {
        $url = env('SKID_MOBILE_URL') . '/signature/session/' . $transaction_id;
        $response = $this->getRequest($url);
        dd($response);
    }

    public function send()
    {
        // "sessionID" => "d4b1b270-5108-4e83-a1c0-816ee37b4118"
        // "sessionID" => "3a0df404-0191-4f2f-b967-8ffb716b63a8"

        $phoneNumber = request()->phone;
        $nationalIdentityNumber = request()->id_code;

        $hash = base64_encode(hash_file("sha256", request()->file, true));

        dump('HASH CODE: ' . $hash);

        $json = json_encode([
            'phoneNumber' => $phoneNumber,
            'nationalIdentityNumber' => $nationalIdentityNumber,
            'relyingPartyUUID' => env('SKID_PRUUID'),
            'relyingPartyName' => env('SKID_NAME'),
            'hash' => $hash,
            'hashType' => "SHA256",
            'language' => "ENG",
            'displayText' => "Sign document.",
            'displayTextFormat' => "GSM-7",
        ]);

        dump('PARAMS: ' . $json);

        $url = env('SKID_MOBILE_URL') . '/signature';

        dump('URL: ' . $url);

        $response = $this->postRequest($url, $json);
        dd($response);
    }

    /* Private functions */

    private function postRequest(string $url, string $json): array
    {

        /*$this->logger->debug('POST '.$url.' contents: ' . $json);*/

        /*{"phoneNumber":"+37256884885","nationalIdentityNumber":"36710090277","relyingPartyUUID":"9a3c94e1-6f47-4dd4-88de-e934ebcc913f","relyingPartyName":"SDN","hash":"bb55e1dd38221f6d3c1012f864f04604021dc7c176bd7bc8c6204a011f0d0184","hashType":"SHA256","language":"ENG"}*/

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        /*curl_setopt( $ch, CURLOPT_INTERFACE, $this->networkInterface );*/

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->addCustomHeaders(array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json)))
        );

        curl_setopt($ch, CURLOPT_PINNEDPUBLICKEY, self::sslPinnedPublicKeys);

        $result = curl_exec($ch);
        if ($result === false) {
            $rawError = curl_error($ch);
            $curl_error = "while trying to connect to '$url' got curl error: " . $rawError;

            if (strpos($rawError, "public key does not match pinned public key") !== false) {
                throw new MidSslException("SSL public key is untrusted for host: " . $url . " . See README . md for setting API host certificate as trusted . ");
            } else {
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                switch ($http_code) {
                    case 400:
                        dump('URL:' . $url);
                        dump('JSON:' . $json);
                        dump(curl_getinfo($ch));
                        dump(curl_error($ch));
                        dd('error message: "MID API returned HTTP status code 400"');
                        throw new MissingOrInvalidParameterException("MID API returned HTTP status code 400");
                    case 401:
                        throw new MidUnauthorizedException("MID API returned HTTP status code 401");
                    case 405:
                        throw new MissingOrInvalidParameterException("MID API returned HTTP status code 405");
                    case 503:
                        throw new MidServiceUnavailableException("MID API is temporarily unavailable");
                    default:
                        throw new MidInternalErrorException('POST request to MID returned unknown status code ' . $http_code);
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
                throw new MissingOrInvalidParameterException($responseAsArray['error']);
            case 401:
                throw new MidUnauthorizedException($responseAsArray['error']);
            case 503:
                throw new MidServiceUnavailableException("MID API is temporarily unavailable");
            default:
                throw new MidInternalErrorException('POST request to MID returned unknown status code ' . $http_code);
        }
    }

    private function getRequest(string $url) : array
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
        if($result === false)
        {
            $rawError = curl_error($ch);
            $curl_error = "While trying to connect to '$url' got curl error: " . $rawError;
            if (strpos($rawError, "public key does not match pinned public key") !== false) {
                throw new MidSslException("SSL public key is untrusted for host: ".$url. ". See README.md for setting API host certificate as trusted.");
            }
            else {
                throw new MidInternalErrorException($curl_error);
            }
        }
        return json_decode($result, true);
    }


    private function addCustomHeaders(array $headers)
    {
        return array_merge(array(), $headers);
    }


}
