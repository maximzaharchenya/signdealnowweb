<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('smart-id', [\App\Http\Controllers\Support\SmartIDController::class, 'index']);
Route::post('smart-id', [\App\Http\Controllers\Support\SmartIDController::class, 'send']);

Route::get('mobile-id', [\App\Http\Controllers\Support\MobileIDController::class, 'index']);
Route::post('mobile-id', [\App\Http\Controllers\Support\MobileIDController::class, 'send']);

Route::get('mobile-id/signing', [\App\Http\Controllers\Support\MobileIDSigningController::class, 'index']);
Route::post('mobile-id/signing', [\App\Http\Controllers\Support\MobileIDSigningController::class, 'send']);
Route::get('mobile-id/signing/{transaction_id}', [\App\Http\Controllers\Support\MobileIDSigningController::class, 'check']);

Route::get('digi-doc', [\App\Http\Controllers\Support\DigiDocController::class, 'index']);
Route::post('digi-doc', [\App\Http\Controllers\Support\DigiDocController::class, 'test']);

Route::get('sms/test/{phone}', [\App\Http\Controllers\Support\SMSController::class, 'test']);

Route::get('jitsi', [\App\Http\Controllers\Support\JitsiController::class, 'index']);
Route::get('jitsi/create', [\App\Http\Controllers\Support\JitsiController::class, 'create']);


Route::get('mail/test', [\App\Http\Controllers\MailController::class, 'test']);


/* Account */
Route::get('/account', [PageController::class, 'account'])->where('any', '.*');
Route::get('/account/{any}', [PageController::class, 'account'])->where('any', '.*');

Route::get('support/php', [\App\Http\Controllers\SupportController::class, 'php']);

/* Logs */
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

/* Default */
Route::get('/{any}', [PageController::class, 'index'])->where('any', '.*');
