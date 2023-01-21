<?php

use App\Http\Controllers\V1\Auth\RegisterController;
use App\Http\Controllers\V1\Auth\ResetPasswordController;
use App\Http\Controllers\V1\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['json.response', 'localization'], 'prefix' => 'v1'], function () {


    Route::group(['prefix' => 'registration'], function () {

        Route::post('/', [RegisterController::class, 'register']);

        Route::post('/code', [RegisterController::class, 'requestRegistrationCode']);

    });

    Route::group(['prefix' => 'account'], function () {

        Route::post('password/code', [ResetPasswordController::class, 'getResetPasswordCode']);

    });

    Route::middleware("auth.deny:api")->group(function () {

        Route::group(['prefix' => 'account'], function () {

            Route::post('credentials/code', [ProfileController::class, 'getCredentialsCode']);

            Route::post('delete/code', [ProfileController::class, 'getDeleteProfileCode']);

        });

    });

});
