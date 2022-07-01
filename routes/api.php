<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BidderController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\NotificationController;
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
Route::group(['middleware' => ['json.response', 'localization']], function () {


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

        Route::put('/', [AuctionController::class, 'getTrades']);

        Route::put('/filter', [AuctionController::class, 'getFilteredTrades']);

        Route::put('/{auctionId}', [AuctionController::class, 'getLotsByAuction']);

        Route::get('/lot/{lotId}', [AuctionController::class, 'getLotInformation']);

        Route::group(['prefix' => 'filter'], function () {

            Route::get('/bidders/{type}', [FilterController::class, 'getBiddersForFilter']);

            Route::get('/trade-places', [FilterController::class, 'getTradePlacesForFilter']);

            Route::get('/categories', [FilterController::class, 'getCategoriesForFilter']);

        });

        Route::get('/{type}/{bidderType}/{bidderId}', [BidderController::class, 'getTradesByBidder']);

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

        Route::group(['prefix' => 'favourite'], function () {

            Route::post('/add/edit/path', [FavouriteController::class, 'addEditFavouritePath']);

            Route::delete('/delete/path/{id}', [FavouriteController::class, 'deleteFavouritePath']);

            Route::post('/download/path', [FavouriteController::class, 'downloadFavouritePath']);

            Route::put('/', [FavouriteController::class, 'getFavourites']);

            Route::post('/add/lots', [FavouriteController::class, 'addLotsToFavourite']);

            Route::get('/get/paths', [FavouriteController::class, 'getFavouritePaths']);

            Route::delete('/delete/{pathId}/lot/{lotId}', [FavouriteController::class, 'deleteLotFromFavourite']);

            Route::put('/move/lot', [FavouriteController::class, 'moveLotInFavourite']);

        });

        Route::group(['prefix'=>'monitoring'], function(){

            Route::post('/add/edit/path', [MonitoringController::class, 'addEditMonitoringPath']);

            Route::delete('/delete/path/{id}', [MonitoringController::class, 'deleteMonitoringPath']);

            Route::put('/', [MonitoringController::class, 'getMonitoringLots']);

            Route::get('/get/paths', [MonitoringController::class, 'getMonitoringPaths']);

            Route::delete('/delete/{pathId}/lot/{lotId}', [MonitoringController::class, 'deleteLotFromMonitoring']);

        });
        Route::group(['prefix'=>'mark'], function(){

            Route::delete('/{markId}/lot/{lotId}', [MarkController::class, 'deleteMark']);

            Route::get('/lot/{lotId}', [MarkController::class, 'getMarksByLot']);

            Route::post('/', [MarkController::class, 'addMark']);

        });
        Route::get('/marks', [MarkController::class, 'getMarks']);

        Route::group(['prefix'=>'files'], function(){

            Route::post('/store', [FileController::class, 'storeFile']);

            Route::delete('/{id}', [FileController::class, 'deleteUserFile']);

            Route::get('/{lotId}', [FileController::class, 'getFiles']);

        });

        Route::group(['prefix'=>'notifications'], function(){

            Route::get('/{type}', [NotificationController::class, 'getNotifications']);

        });



        Route::resource('event', App\Http\Controllers\EventController::class);

        Route::resource('note', App\Http\Controllers\NoteController::class);

    });

});
