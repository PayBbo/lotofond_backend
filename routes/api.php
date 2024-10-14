<?php


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ApplePaymentController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\BidderController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
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

    Route::get('/information-message', [DataController::class, 'getInformationMessage']);

    Route::post('login', [LoginController::class, 'login'])->name('login');

    Route::post('payment/notification', [PaymentController::class, 'paymentNotification']);

    Route::post('payment/check/status', [PaymentController::class, 'checkStatus']);

    Route::group(['prefix' => 'registration'], function () {

        Route::post('/', [RegisterController::class, 'register']);

        Route::post('/code/verify', [RegisterController::class, 'verifyRegistrationCode']);

        Route::post('/code', [RegisterController::class, 'requestRegistrationCode']);

    });

    Route::group(['prefix' => 'account'], function () {

        Route::post('password/code', [ResetPasswordController::class, 'getResetPasswordCode']);

        Route::post('password/code/verify', [ResetPasswordController::class, 'verifyResetPasswordCode']);

        Route::post('password/reset', [ResetPasswordController::class, 'resetPassword']);

        Route::post('apple/callback', [SocialController::class, 'appleCallback']);

        Route::post('refresh/token', [LoginController::class, 'refreshToken']);

    });
    Route::group(['prefix' => 'trades'], function () {

        Route::group(['middleware' => ['auth:api']], function () {

            Route::put('/', [AuctionController::class, 'getTrades'])->name('trades');

            Route::put('/nearest', [AuctionController::class, 'getNearestTrades']);

            Route::put('/filter', [AuctionController::class, 'getFilteredTrades'])->name('lots-filter');

            Route::put('/{auctionId}', [AuctionController::class, 'getLotsByAuction']);

            Route::get('/lot/{lotId}', [AuctionController::class, 'getLotInformation']);

            Route::get('/short/lot/{lotId}', [AuctionController::class, 'getShortLotInformation']);

            Route::get('/victories', [AuctionController::class, 'getVictories']);

            Route::put('/short/lots', [AuctionController::class, 'getShortTrades']);

            Route::get('/orders', [ApplicationController::class, 'get']);

        });
        Route::get('/notifications/{lotId}', [AuctionController::class, 'getLotNotifications'])
            ->middleware('auth.deny:api');

        Route::group(['prefix' => 'filter'], function () {

            Route::put('/bidders/{type}', [FilterController::class, 'getBiddersForFilter']);

            Route::get('/trade-places', [FilterController::class, 'getTradePlacesForFilter']);

            Route::get('/trade-places/v1', [FilterController::class, 'getTradePlacesForFilterV1']);

            Route::get('/categories', [FilterController::class, 'getCategoriesForFilter']);

            Route::get('/regions', [FilterController::class, 'getRegionsForFilter']);

            Route::get('/prices', [FilterController::class, 'getPricesForFilter']);

        });

    });

    Route::get('/messages/filter/types', [FilterController::class, 'getRegistryTypesForFilter']);

    Route::group(['prefix' => 'text-data'], function () {

        Route::get('/content-rules', [DataController::class, 'getContentRules']);

        Route::get('/{type}', [DataController::class, 'getTextData']);

    });

    Route::put('/bidders/trades', [BidderController::class, 'getTradesByBidder'])
        ->middleware('auth:api')->name('bidders-trades');

    Route::group(['prefix' => 'bidders', 'middleware'=>['check.tariff:hasAccessToReestr', 'auth:api']], function () {

        Route::get('/{bidderId}/{type}', [BidderController::class, 'getBidder'])->middleware('auth:api');

        Route::put('/get/{type}', [BidderController::class, 'getBidders']);

        Route::get('/{tradePlaceId}', [BidderController::class, 'getTradePlace']);

        Route::put('/trade-places', [BidderController::class, 'getTradePlaces'])
            ->middleware('auth:api')->name('trade-places');

        Route::post('/estimate', [BidderController::class, 'estimateBidder'])
            ->middleware('auth.deny:api');

        Route::post('/estimate-answer', [\App\Http\Controllers\OrganizerAnswerRatingController::class, 'create'])
            ->withoutMiddleware('check.tariff:hasAccessToReestr');

        Route::put('/debtor/messages', [BidderController::class, 'getDebtorMessages']);

        Route::post('/debtor/message', [BidderController::class, 'getDebtorMessagePage']);

    });

    Route::group(['prefix' => 'statistics'], function () {

        Route::get('/categories', [StatisticsController::class, 'getStatisticsByCategories']);

        Route::get('/lots', [StatisticsController::class, 'getStatisticsByLots']);
    });

    Route::post('/send/contacts', [ApplicationController::class, 'sendContacts']);

    Route::get('/tariffs', [PaymentController::class, 'getTariffs']);

    Route::post('/services', [PaymentController::class, 'getServices']);

    Route::middleware("auth.deny:api")->group(function () {

        Route::group(['prefix' => 'send'], function () {

            Route::post('/application', [ApplicationController::class, 'sendApplication']);

            Route::post('/question', [ApplicationController::class, 'sendQuestion']);

            Route::post('/purchase/instructions', [ApplicationController::class, 'purchaseInstructions']);

            Route::post('/receipt/egrn', [ApplicationController::class, 'receiptEgrn']);

        });

        Route::group(['prefix' => 'account'], function () {

            Route::post('password/change', [ProfileController::class, 'changePassword']);

            Route::get('user', [ProfileController::class, 'getUser']);

            Route::get('notifications', [ProfileController::class, 'hasNotSeenNotifications']);

            Route::put('user/update', [ProfileController::class, 'updateUser']);

            Route::put('update/token', [ProfileController::class, 'updateDeviceToken']);

            Route::post('logout', [LoginController::class, 'logout']);

            Route::post('credentials/code', [ProfileController::class, 'getCredentialsCode']);

            Route::post('credentials/code/verify', [ProfileController::class, 'verifyCredentialsCode']);

            Route::post('notifications/settings', [ProfileController::class, 'updateNotificationsSettings']);

            Route::post('socials/link', [ProfileController::class, 'linkSocials']);

            Route::delete('change/credentials/delete/{changeCredentialsProcessId}', [ProfileController::class, 'changeCredentialsProcessDelete']);

            Route::post('delete/code', [ProfileController::class, 'getDeleteProfileCode']);

            Route::post('delete/code/verify', [ProfileController::class, 'verifyDeleteProfileCode']);

        });

        Route::group(['prefix' => 'trades'], function () {

            Route::put('/lot/toggle-seen/{lotId}', [AuctionController::class, 'toggleSeen']);

            Route::put('/lot/toggle-pin/{lotId}', [AuctionController::class, 'togglePin']);

            Route::put('/lot/toggle-hide/{lotId}', [AuctionController::class, 'toggleHide']);

            Route::put('/make/hidden/lots/{tradeId}', [AuctionController::class, 'makeHiddenLotByTrade']);

            Route::put('/delete/hidden/lots/{tradeId}', [AuctionController::class, 'deleteHiddenLotByTrade']);

        });

        Route::group(['prefix' => 'favourite', 'middleware'=>['check.tariff:hasAccessToFavourite']], function () {

            Route::post('/add/edit/path', [FavouriteController::class, 'addEditFavouritePath']);

            Route::delete('/delete/path/{id}', [FavouriteController::class, 'deleteFavouritePath']);

            Route::post('/download/path', [FavouriteController::class, 'downloadFavouritePath']);

            Route::put('/', [FavouriteController::class, 'getFavourites']);

            Route::post('/add/lots', [FavouriteController::class, 'addLotsToFavourite']);

            Route::get('/get/paths', [FavouriteController::class, 'getFavouritePaths']);

            Route::delete('/delete/lot', [FavouriteController::class, 'deleteLotFromFavourite']);

            Route::put('/move/lot', [FavouriteController::class, 'moveLotInFavourite']);

        });

        Route::group(['prefix' => 'monitoring', 'middleware'=>['check.tariff:hasAccessToMonitoring']], function () {

            Route::post('/add/edit/path', [MonitoringController::class, 'addEditMonitoringPath']);

            Route::delete('/delete/path/{id}', [MonitoringController::class, 'deleteMonitoringPath']);

            Route::put('/', [MonitoringController::class, 'getMonitoringLots']);

            Route::get('/get/paths', [MonitoringController::class, 'getMonitoringPaths']);

            Route::delete('/delete/lot', [MonitoringController::class, 'deleteLotFromMonitoring']);

        });
        Route::group(['prefix' => 'mark'], function () {

            Route::delete('/{markId}/lot/{lotId}', [MarkController::class, 'deleteMark']);

            Route::get('/lot/{lotId}', [MarkController::class, 'getMarksByLot']);

            Route::post('/', [MarkController::class, 'addMark']);

        });
        Route::get('/marks', [MarkController::class, 'getMarks']);

        Route::group(['prefix' => 'files', 'middleware'=>['check.tariff:hasAccessToTradeFiles']], function () {

            Route::post('/store', [FileController::class, 'storeFile']);

            Route::delete('/{id}', [FileController::class, 'deleteUserFile']);

            Route::get('/{lotId}', [FileController::class, 'getFiles']);

        });

        Route::group(['prefix' => 'note'], function () {

            Route::delete('/delete', [NoteController::class, 'deleteNote']);

            Route::put('/edit', [NoteController::class, 'editNote']);

            Route::post('/', [NoteController::class, 'addNote']);

            Route::get('/{itemType}/{itemId}', [NoteController::class, 'getNote']);
        });

        Route::get('/notes', [NoteController::class, 'getUserNotes']);


        Route::group(['prefix' => 'notifications'], function () {

            Route::get('/test', [NotificationController::class, 'testNots']);

            Route::get('/{type}', [NotificationController::class, 'getNotifications']);

            Route::post('/seen', [NotificationController::class, 'makeNotificationsSeen']);

            Route::post('/seen/by/{type}', [NotificationController::class, 'makeSeenAllNotificationsByType']);

            Route::get('/count/{type}', [NotificationController::class, 'countNotificationsByType']);



        });

        Route::group(['prefix' => 'event'], function () {

            Route::delete('/delete', [EventController::class, 'deleteEvent']);

            Route::put('/edit', [EventController::class, 'editEvent']);

            Route::post('/', [EventController::class, 'addEvent']);

        });
        Route::post('/events', [EventController::class, 'getEvents']);

        Route::get('/admin/check', [DashboardController::class, 'checkAdmin']);

        Route::group(['prefix' => 'payment'], function () {

            Route::post('/', [PaymentController::class, 'payment']);

            Route::post('/validate/apple/transaction', [ApplePaymentController::class, 'validateTransaction']);

        });

    });

});
