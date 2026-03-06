<?php

use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\PersonalTokenController;
use App\Http\Controllers\Api\UserInfoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (SSO Server)
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group and "auth:api" guard (Passport).
|
| OAuth 2.0 endpoints (/oauth/*) are automatically registered by Passport
| via the HasApiTokens trait on the User model.
|
*/

Route::middleware('auth:api')->group(function () {

    /*
    |----------------------------------------------------------------------
    | User Info – SSO client apps call this to identify the logged-in user
    |----------------------------------------------------------------------
    */
    Route::get('/user', [UserInfoController::class, 'show']);

    /*
    |----------------------------------------------------------------------
    | Availability Check – client apps call this to verify the token is
    | still valid and the user account is active.
    |----------------------------------------------------------------------
    */
    Route::get('/availability', [AvailabilityController::class, 'check']);

    /*
    |----------------------------------------------------------------------
    | Personal Access Tokens – useful for testing / internal clients
    |----------------------------------------------------------------------
    */
    Route::get('/tokens', [PersonalTokenController::class, 'index']);
    Route::post('/tokens/create', [PersonalTokenController::class, 'store']);
    Route::delete('/tokens/{tokenId}', [PersonalTokenController::class, 'destroy']);
});
