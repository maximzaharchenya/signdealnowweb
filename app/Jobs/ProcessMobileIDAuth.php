<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Sk\Mid\DisplayTextFormat;
use Sk\Mid\Exception\MidDeliveryException;
use Sk\Mid\Exception\MidInternalErrorException;
use Sk\Mid\Exception\MidInvalidUserConfigurationException;
use Sk\Mid\Exception\MidNotMidClientException;
use Sk\Mid\Exception\MidPhoneNotAvailableException;
use Sk\Mid\Exception\MidServiceUnavailableException;
use Sk\Mid\Exception\MidSessionNotFoundException;
use Sk\Mid\Exception\MidSessionTimeoutException;
use Sk\Mid\Exception\MidSslException;
use Sk\Mid\Exception\MidUnauthorizedException;
use Sk\Mid\Exception\MidUserCancellationException;
use Sk\Mid\Exception\MissingOrInvalidParameterException;
use Sk\Mid\Language\ENG;
use Sk\Mid\MobileIdAuthenticationHashToSign;
use Sk\Mid\Rest\Dao\Request\AuthenticationRequest;

class ProcessMobileIDAuth implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $db_record;
    protected $client;
    protected $phoneNumber;
    protected $nationalIdentityNumber;

    public function __construct($db_record, $client, $phoneNumber, $nationalIdentityNumber)
    {
        $this->db_record = $db_record;
        $this->client = $client;
        $this->phoneNumber = $phoneNumber;
        $this->nationalIdentityNumber = $nationalIdentityNumber;
    }

    public function handle()
    {
        Log::info('Job: Trying to authenticate user:');

        $authenticationHash = MobileIdAuthenticationHashToSign::generateRandomHashOfDefaultType();
        $verificationCode = $authenticationHash->calculateVerificationCode();
        DB::table('skid_transactions')->where('id', $this->db_record)->update(['code' => $verificationCode, 'updated_at' => Carbon::now()]);

        $request = AuthenticationRequest::newBuilder()
            ->withPhoneNumber($this->phoneNumber)
            ->withNationalIdentityNumber($this->nationalIdentityNumber)
            ->withHashToSign($authenticationHash)
            ->withLanguage(ENG::asType())
            ->withDisplayText("Log into self-service?")
            ->withDisplayTextFormat(DisplayTextFormat::GSM7)
            ->build();

        // step #6 - send request to user's phone and catch possible errors

        try {
            $response = $this->client->getMobileIdConnector()->initAuthentication($request);
        } catch (MidNotMidClientException $e) {
            $message = 'User is not a MID client or user\'s certificates are revoked.';
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MidUnauthorizedException $e) {
            $message = 'Integration error with Mobile-ID. Invalid MID credentials';
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MissingOrInvalidParameterException $e) {
            $message = 'Problem with MID integration';
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MidInternalErrorException $e) {
            $message = 'MID internal error';
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        }

        // step #7 - keep polling for session status until we have a final status from phone

        $finalSessionStatus = $this->client
            ->getSessionStatusPoller()
            ->fetchFinalSessionStatus($response->getSessionID());

        // step #8 - get authenticationResult

        try {
            $authenticationResult = $this->client
                ->createMobileIdAuthentication($finalSessionStatus, $authenticationHash);

        } catch (MidUserCancellationException $e) {
            $message = 'User cancelled operation from his/her phone.';
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MidNotMidClientException $e) {
            $message = "User is not a MID client or user's certificates are revoked.";
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MidSessionTimeoutException $e) {
            $message = "User did not type in PIN code or communication error.";
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MidPhoneNotAvailableException $e) {
            $message = "Unable to reach phone/SIM card. User needs to check if phone has coverage.";
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MidDeliveryException $e) {
            $message = "Error communicating with the phone/SIM card.";
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MidInvalidUserConfigurationException $e) {
            $message = "Mobile-ID configuration on user's SIM card differs from what is configured on service provider's side. User needs to contact his/her mobile operator.";
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MidSessionNotFoundException | MissingOrInvalidParameterException | MidUnauthorizedException | MidSslException $e) {
            $message = "Integrator-side error with MID integration or configuration. Error code:" . $e->getCode();
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MidServiceUnavailableException $e) {
            $message = "MID service is currently unavailable. User should try again later.";
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        } catch (MidInternalErrorException $internalError) {
            $message = "Something went wrong with Mobile-ID service";
            DB::table('skid_transactions')->where('id', $this->db_record)->update(['data' => json_encode(['error_message' => $message]), 'updated_at' => Carbon::now()]);
            Log::info('Authentication fail: ' . $message);
            die($message);
        }

        # validate returned result (to protect yourself from man-in-the-middle attack)
        /*$validator = AuthenticationResponseValidator::newBuilder()
            ->withTrustedCaCertificatesFolder('/var/www/stage/resources/cert/')
            ->build();

        $validator->validate($authenticationResult);*/

        # read out authenticated person details

        $authenticatedPerson = $authenticationResult->constructAuthenticationIdentity();

        DB::table('skid_transactions')->where('id', $this->db_record)->update(['status' => true,
            'data' => json_encode([
                'authenticated_person_name' => $authenticatedPerson->getGivenName().' '.$authenticatedPerson->getSurName(),
                'authenticated_person_id' => $authenticatedPerson->getIdentityCode(),
                'authenticated_person_country' => $authenticatedPerson->getCountry(),
            ]), 'updated_at' => Carbon::now()]);

        $record = DB::table('skid_transactions')->where('id', $this->db_record)->first();
        if(!empty($record)) {
            $user = User::where('id', $record->user_id)->first();
            if(!empty($user)) {
                $user->authentication = true;
                $user->authentication_data = json_encode($authenticatedPerson->toString());
                $user->save();
            }
        }
    }

}
