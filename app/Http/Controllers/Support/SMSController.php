<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Services\SMSService;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function test($phone)
    {
        dump($phone);
        $SMSService = new SMSService();
        $SMSService->send($phone, 'Test message from SignDealNow');
        return 'done';
    }
}
