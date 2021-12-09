<?php

use Illuminate\Support\Facades\Route;

// Passport AUTH
Route::post('login', [\App\Http\Controllers\API\UserController::class, 'login']);
Route::post('register', [\App\Http\Controllers\API\UserController::class, 'register']);

/* External Deal */
Route::post('external_deal', [\App\Http\Controllers\API\ExternalDealController::class, 'create']);

// Languages
Route::get('languages', [\App\Http\Controllers\API\LanguageController::class, 'index']);

// Countries
Route::get('countries', [\App\Http\Controllers\API\CountryController::class, 'index']);

// DealStatuses
Route::get('statuses', [\App\Http\Controllers\API\StatusController::class, 'index']);

// Roles
Route::get('roles', [\App\Http\Controllers\API\RoleController::class, 'index']);

// SupportRequests
Route::post('support/store', [\App\Http\Controllers\API\SupportRequestController::class, 'store']);

// Recovery users
Route::post('recovery/store', [\App\Http\Controllers\API\RecoveryUserController::class, 'store']);
Route::post('recovery/delete', [\App\Http\Controllers\API\RecoveryUserController::class, 'delete']);

// Email check
Route::post('email/check', [\App\Http\Controllers\API\UserController::class, 'email_check']);

// ShortDescription
Route::get('deal/{deal_id}/description', [\App\Http\Controllers\API\DealController::class, 'description']);
Route::get('deal/{deal_id}/documents/generate', [\App\Http\Controllers\API\DocumentController::class, 'generate']);
Route::group(['middleware' => 'auth:api'], function () {

    // Mobile ID
    Route::post('skid/auth', [\App\Http\Controllers\API\SkidSolutions\SkidSolutionsController::class, 'auth']);
    Route::get('skid/check', [\App\Http\Controllers\API\SkidSolutions\SkidSolutionsController::class, 'check']);
    Route::get('skid/check/{transaction_id}', [\App\Http\Controllers\API\SkidSolutions\SkidSolutionsController::class, 'check']);

    // User
    Route::get('user_show', [\App\Http\Controllers\API\UserController::class, 'user_show']);
    Route::post('user_update', [\App\Http\Controllers\API\UserController::class, 'user_update']);
    Route::post('password_update', [\App\Http\Controllers\API\UserController::class, 'password_update']);
    Route::get('logout', [\App\Http\Controllers\API\UserController::class, 'logout']);

    // Deals
    Route::get('deal/index', [\App\Http\Controllers\API\DealController::class, 'index']);
    Route::get('deal/{deal_id}', [\App\Http\Controllers\API\DealController::class, 'show']);
    Route::post('deal/store', [\App\Http\Controllers\API\DealController::class, 'store']);
    Route::post('deal/register', [\App\Http\Controllers\API\DealController::class, 'register']);
    Route::get('deal/{deal_id}/exit', [\App\Http\Controllers\API\DealController::class, 'exit']);
    Route::post('deal/{deal_id}/user/delete', [\App\Http\Controllers\API\DealController::class, 'user_delete']);
    Route::post('deal/{deal_id}/user_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'storeUserData']);
    Route::post('deal/{deal_id}/additional_seller_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateAdditionalSellerData']);
    Route::post('deal/{deal_id}/seller_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateSellerData']);
    Route::post('deal/{deal_id}/additional_client_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateAdditionalClientData']);
    Route::post('deal/{deal_id}/client_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateClientData']);
    Route::post('deal/{deal_id}/property_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updatePropertyData']);
    Route::post('deal/{deal_id}/co_owner_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateCoOwnerData']);
    Route::post('deal/{deal_id}/mortgage', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'storeMortgageData']);
    Route::post('deal/{deal_id}/mortgage/{mortgage_id}', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateMortgageData']);
    Route::get('deal/{deal_id}/mortgage/{mortgage_id}/delete', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'deleteMortgageData']);
    Route::post('deal/{deal_id}/mortgage/{mortgage_id}/holder_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateHolderData']);
    Route::get('deal/{deal_id}/mortgage/{mortgage_id}/holder_data/delete', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'deleteHolderData']);
    Route::post('deal/{deal_id}/note_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'storeNoteData']);
    Route::post('deal/{deal_id}/note_data/{note_id}', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateNoteData']);
    Route::get('deal/{deal_id}/note_data/{note_id}/delete', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'deleteNoteData']);
    Route::post('deal/{deal_id}/married_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateMarriedData']);
    Route::post('deal/{deal_id}/representative_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateRepresentativeData']);
    Route::post('deal/{deal_id}/contributors_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'storeContributorsData']);
    Route::post('deal/{deal_id}/contributors_data/{contributor_id}', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateContributorsData']);
    Route::get('deal/{deal_id}/contributors_data/{contributor_id}/delete', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'deleteContributorsData']);
    Route::post('deal/{deal_id}/notary_data', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateNotaryData']);
    Route::get('deal/{deal_id}/sign_info', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateSignInfoData']);
    Route::get('deal/{deal_id}/sign_info/document', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateSignInfoDocData']);
    Route::get('deal/{deal_id}/notary_fees', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateNotaryFeesData']);
    Route::get('deal/{deal_id}/fees', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'updateFeesData']);

    /* Signing */
    Route::post('deal/{deal_id}/upload_document', [\App\Http\Controllers\API\DealController::class, 'uploadDocument']);
    Route::post('deal/{deal_id}/sign', [\App\Http\Controllers\API\DealSigningController::class, 'sign']);
    Route::get('deal/{deal_id}/sign', [\App\Http\Controllers\API\DealSigningController::class, 'change_status']);
    Route::get('deal/{deal_id}/check_signing_status', [\App\Http\Controllers\API\DealSigningController::class, 'checkSigningStatus']);

    // Approve deal info
    Route::get('deal/{deal_id}/approve', [\App\Http\Controllers\API\DealController::class, 'approve']);
    // Approve deal info
    Route::get('deal/{deal_id}/fees_approve', [\App\Http\Controllers\API\DealController::class, 'fees_approve']);
    // Approve sign info
    Route::get('deal/{deal_id}/sign_approve', [\App\Http\Controllers\API\DealController::class, 'sign_approve']);
    Route::get('deal/{deal_id}/sign_disagree', [\App\Http\Controllers\API\DealController::class, 'sign_disagree']);
    // Check deal approves and fullness
    Route::get('deal/{deal_id}/check/statuses', [\App\Http\Controllers\API\DealController::class, 'check_statuses']);
    // Download preliminary contract
    Route::post('deal/{deal_id}/contract/download', [\App\Http\Controllers\API\DealAdditionalInfoController::class, 'downloadContract']);

    // Notary
    Route::get('/notary', [\App\Http\Controllers\API\NotaryController::class, 'index']);
    Route::get('deal/{deal_id}/notary/{notary_id}/invite', [\App\Http\Controllers\API\NotaryController::class, 'invite']);
    Route::get('deal/{deal_id}/notary/accept', [\App\Http\Controllers\API\NotaryController::class, 'accept']);
    Route::get('deal/{deal_id}/notary/decline', [\App\Http\Controllers\API\NotaryController::class, 'decline']);

    /* Messages */
    Route::get('messages/{document_id}', [\App\Http\Controllers\MessageController::class, 'index']);
    Route::post('message/{document_id}', [\App\Http\Controllers\MessageController::class, 'store']);

    // Inputs
    Route::post('input/store', [\App\Http\Controllers\API\InputController::class, 'store']);

    // Generate Document

});
