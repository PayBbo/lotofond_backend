<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
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
Route::group(['middleware' => ['json.response']], function () {

    Route::post('login', [LoginController::class, 'login'])->name('login');

    Route::group(['prefix' => 'registration'], function () {

        Route::post('/', [RegisterController::class, 'register']);

        Route::post('/code/verify', [RegisterController::class, 'verifyRegistrationCode']);

        Route::post('/code', [RegisterController::class, 'requestRegistrationCode']);

    });

    Route::group(['prefix' => 'account'], function () {

        Route::post('password/code', [ResetPasswordController::class, 'getResetPasswordCode']);

        Route::post('password/code/verify', [ResetPasswordController::class, 'verifyResetPasswordCode']);

        Route::post('password/reset', [ResetPasswordController::class, 'resetPassword']);

    });
    Route::group(['prefix' => 'trades'], function () {

        Route::get('/', [AuctionController::class, 'getTrades']);

        Route::get('/{auctionId}', [AuctionController::class, 'getLotsByAuction']);

        Route::get('/lot/{lotId}', [AuctionController::class, 'getLotInformation']);

    });

    Route::middleware("auth:api")->group(function () {

        Route::group(['prefix' => 'account'], function () {

            Route::get('user', [ProfileController::class, 'getUser']);

            Route::put('user/update', [ProfileController::class, 'updateUser']);

            Route::get('logout', [LoginController::class, 'logout']);

        });

        Route::group(['prefix' => 'trades'], function () {

            Route::put('/lot/action', [AuctionController::class, 'actionWithLot']);
            
        });

        Route::resource('monitoring', App\Http\Controllers\MonitoringController::class);

        Route::resource('favourite', App\Http\Controllers\FavouriteController::class);

        Route::resource('event', App\Http\Controllers\EventController::class);

        Route::resource('note', App\Http\Controllers\NoteController::class);

        Route::resource('mark', App\Http\Controllers\MarkController::class);
    });

});
