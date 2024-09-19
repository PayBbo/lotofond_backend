<?php

use App\Http\Controllers\Admin\AdditionsController;
use App\Http\Controllers\Admin\ApplicationsController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\ContentRulesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EgrnStatementsController;
use App\Http\Controllers\Admin\FedresursController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\HolidayDayController;
use App\Http\Controllers\Admin\LotController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TariffController;
use App\Http\Controllers\Admin\TextDataController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' =>['localization', 'role:admin|manager', 'json.response', 'auth.deny:api']], function () {

    Route::get('/dashboard', [DashboardController::class, 'getDashboardData']);

    Route::post('/change-watermark', [DashboardController::class, 'changeWatermark']);

    Route::post('/change-trial-period', [DashboardController::class, 'changeTrialPeriod']);

    Route::get('/regions', [DashboardController::class, 'getRegions']);

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', [UserController::class, 'get']);

        Route::post('/add', [UserController::class, 'add']);

        Route::get('/{id}/edit', [UserController::class, 'edit']);

        Route::put('/{id}/update', [UserController::class, 'update']);

        Route::delete('/{id}', [UserController::class, 'delete']);

    });

    Route::group(['prefix' => 'contacts'], function () {

        Route::get('/', [ContactsController::class, 'get']);

        Route::post('/', [ContactsController::class, 'update']);

        Route::delete('/{id}', [ContactsController::class, 'delete']);

    });

    Route::group(['prefix' => 'applications'], function () {

        Route::get('/', [ApplicationsController::class, 'get']);

        Route::get('/{id}', [ApplicationsController::class, 'show']);

        Route::put('/update', [ApplicationsController::class, 'update']);

    });
    Route::group(['prefix' => 'text-data'], function () {

        Route::get('/', [TextDataController::class, 'get']);

        Route::post('/add', [TextDataController::class, 'add']);

        Route::get('/{id}/edit', [TextDataController::class, 'edit']);

        Route::delete('/{id}', [TextDataController::class, 'delete']);

        Route::put('/{id}/update', [TextDataController::class, 'update']);

        Route::put('/change/status/{id}', [TextDataController::class, 'changeStatus']);

    });

    Route::group(['prefix' => 'roles'], function () {

        Route::get('/', [RoleController::class, 'get']);

        Route::post('/', [RoleController::class, 'add']);

        Route::get('/{id}/edit', [RoleController::class, 'edit']);

        Route::put('/{id}/update', [RoleController::class, 'update']);

        Route::delete('/{id}', [RoleController::class, 'delete']);

        Route::get('/permissions', [RoleController::class, 'permissions']);

    });

    Route::group(['prefix' => 'tariffs'], function () {

        Route::get('/', [TariffController::class, 'get'])->name('admin-get-tariffs');

        Route::get('/{id}/edit', [TariffController::class, 'edit']);

        Route::post('/add', [TariffController::class, 'add']);

        Route::put('/{id}/update', [TariffController::class, 'update']);

        Route::put('/change/status/{id}', [TariffController::class, 'changeStatus']);

        Route::delete('/{id}', [TariffController::class, 'delete']);

    });

    Route::group(['prefix' => 'lots'], function () {

        Route::get('/', [LotController::class, 'get']);

        Route::get('/{id}/show', [LotController::class, 'show']);

        Route::delete('/{id}', [LotController::class, 'delete']);

        Route::get('/shorts', [LotController::class, 'getShorts'])->name('admin.lots.shorts');

    });

    Route::group(['prefix' => 'additions'], function () {

        Route::get('/', [AdditionsController::class, 'get']);

        Route::get('/{id}/edit', [AdditionsController::class, 'edit'])->name('edit.addition');

        Route::post('/store', [AdditionsController::class, 'add']);

        Route::put('/{id}/update', [AdditionsController::class, 'update']);

        Route::put('/change/status/{id}', [AdditionsController::class, 'changeStatus']);

        Route::delete('/{id}', [AdditionsController::class, 'delete']);

    });

    Route::group(['prefix' => 'files'], function () {

        Route::post('/upload', [FileController::class, 'upload'])->name('admin.file.upload');

        Route::post('/lot/upload', [FileController::class, 'uploadLotFiles']);

        Route::delete('/{id}', [FileController::class, 'delete']);

    });

    Route::group(['prefix' => 'content-rules'], function () {

        Route::get('/', [ContentRulesController::class, 'get']);

        Route::put('/update', [ContentRulesController::class, 'update']);

    });

    Route::get('/egrn-statements', [EgrnStatementsController::class, 'get']);

    Route::group(['prefix' => 'holiday-days'], function () {

        Route::get('/', [HolidayDayController::class, 'get']);

        Route::post('/', [HolidayDayController::class, 'add']);

        Route::delete('/{id}', [HolidayDayController::class, 'delete']);

    });

    Route::group(['prefix' => 'news'], function () {

        Route::get('/', [NewsController::class, 'get']);

        Route::get('/{id}/edit', [NewsController::class, 'edit']);

        Route::post('/add', [NewsController::class, 'add']);

        Route::post('/{id}', [NewsController::class, 'update']);

        Route::delete('/{id}', [NewsController::class, 'delete']);

        Route::put('/change/status/{id}', [NewsController::class, 'changeStatus']);

    });

    Route::group(['prefix' => 'fedresurs'], function() {
        Route::get('/trade-messages', [FedresursController::class, 'getTradeMessages']);
        Route::get('/trade-messages/by-trade', [FedresursController::class, 'getTradeMessagesByTrade']);
        Route::get('/trade-messages/{id}', [FedresursController::class, 'getTradeMessageContent']);
        Route::get('/messages', [FedresursController::class, 'getMessageIds']);
        Route::get('/messages/{id}', [FedresursController::class, 'getMessageContent']);
    });

});
