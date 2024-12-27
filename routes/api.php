<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiRecordController;
use App\Http\Controllers\Api\ApiUserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::controller(ApiAuthController::class)->prefix('auth')->group(function () {
    Route::middleware('auth-validator')->group(function () {
        Route::post('register', [ApiAuthController::class, 'register'])->name('register');
        Route::post('login', [ApiAuthController::class, 'login'])->name('login');
    });
    Route::post('logout', [ApiAuthController::class, 'logout'])->middleware('auth:api');
});

Route::middleware('auth:api')->controller(ApiUserController::class)->prefix('user')->group(function ()
{
    Route::get('/','index')->name('user');
    Route::get('/{id}', 'show')->name('user/show')->where('id','[0-9]+');
    Route::middleware('user-validator')->group(function () {
        Route::post('/', 'store')->name('user/store');
        Route::put('/{id}', 'update')->name('user/update')->where('id','[0-9]+');
    });
    Route::delete('/{id}', 'destroy')->name('user/destroy')->where('id','[0-9]+');
});

Route::middleware('auth:api')->controller(ApiRecordController::class)->prefix("record")->group(function ()
{
    Route::get('/', 'index')->name('record');
    Route::middleware('record-validator')->group(function () {
        Route::post('/', 'store')->name('record/store');
        Route::put('/{id}', 'update')->name('record/update')->where('id','[0-9]+');
    });
    Route::get('/show/{id}', 'show')->name('record/edit')->where('id','[0-9]+');
    Route::delete('/{id}', 'destroy')->name('record/destroy')->where('id','[0-9]+');

});
