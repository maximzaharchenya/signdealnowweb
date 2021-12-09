<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessMobileIDAuth;
use App\Services\SKID\MobileIDService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Sk\Mid\Exception\MidServiceUnavailableException;
use Sk\Mid\Exception\MidSslException;
use Sk\Mid\AuthenticationResponseValidator;
use Sk\Mid\Exception\MidDeliveryException;
use Sk\Mid\Exception\MidInvalidNationalIdentityNumberException;
use Sk\Mid\Exception\MidInvalidPhoneNumberException;
use Sk\Mid\Exception\MidInvalidUserConfigurationException;
use Sk\Mid\Exception\MidSessionNotFoundException;
use Sk\Mid\Exception\MidSessionTimeoutException;
use Sk\Mid\Exception\MissingOrInvalidParameterException;
use Sk\Mid\Exception\MidPhoneNotAvailableException;
use Sk\Mid\Exception\MidUserCancellationException;
use Sk\Mid\Language\ENG;
use Sk\Mid\Exception\MidInternalErrorException;
use Sk\Mid\Exception\MidNotMidClientException;
use Sk\Mid\DisplayTextFormat;
use Sk\Mid\MobileIdAuthentication;
use Sk\Mid\MobileIdClient;
use Sk\Mid\Exception\MidUnauthorizedException;
use Sk\Mid\Rest\Dao\Request\AuthenticationRequest;
use Sk\Mid\Rest\Dao\Request\CertificateRequest;
use Sk\Mid\MobileIdAuthenticationHashToSign;
use Sk\Mid\Util\MidInputUtil;

class MobileIDController
{

    public function index()
    {
        return view('support.mobil_id');
    }

    public function send()
    {
        $phoneNumber = request()->phone;
        $nationalIdentityNumber = request()->id_code;

        $mobileIDService = new MobileIDService();
        $transaction_id = $mobileIDService->send($phoneNumber, $nationalIdentityNumber);

        return response()->json([
            'transaction_id' => $transaction_id
        ]);
    }
}
