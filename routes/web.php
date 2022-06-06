<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main');
});


Route::resource('monitoring', App\Http\Controllers\MonitoringController::class);

Route::resource('favourite', App\Http\Controllers\FavouriteController::class);

Route::resource('event', App\Http\Controllers\EventController::class);

Route::resource('note', App\Http\Controllers\NoteController::class);

Route::resource('mark', App\Http\Controllers\MarkController::class);
