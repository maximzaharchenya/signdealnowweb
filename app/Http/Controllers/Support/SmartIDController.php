<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Services\SKID\SmartIDService;
use Sk\SmartId\Client;
use Sk\SmartId\Exception\SmartIdException;
use Sk\SmartId\Api\Data\NationalIdentity;
use Sk\SmartId\Api\Data\AuthenticationHash;
use Sk\SmartId\Api\Data\CertificateLevelCode;
use Sk\SmartId\Api\AuthenticationResponseValidator;

class SmartIDController extends Controller
{

    public function index()
    {
        return view('support.smart_id');
    }

    public function send()
    {

        $identity_type = request()->identity_type;
        $country_code = request()->country_code;
        $id_code = request()->id_code;

        $smartIDService = new SmartIDService();
        $transaction_id = $smartIDService->send($identity_type, $country_code, $id_code);

        return response()->json([
            'transaction_id' => $transaction_id
        ]);




        dd($identity_type);

        dump('id_code: ' . $id_code);
        dump('country_code: ' . $country_code);



        dump($verificationCode);

        try
        {
            $authenticationResponse = $client->authentication()
                ->createAuthentication()
                //->withNationalIdentityNumber($id_code)
                ->withNationalIdentity( $identity ) // or with document number: ->withDocumentNumber( 'PNOEE-10101010005-Z1B2-Q' )
                ->withAuthenticationHash( $authenticationHash )
                ->withCertificateLevel( CertificateLevelCode::QUALIFIED ) // Certificate level can either be "QUALIFIED" or "ADVANCED"
                ->authenticate();

            dd($authenticationResponse);

        }
        catch (SmartIdException $e) {
            dump('exception');
            dd($e);
            // Handle exception (more on exceptions in "Handling intentional exceptions")
        }

    }




}
