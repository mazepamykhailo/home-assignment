<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;

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
    return redirect('/login');
});

Route::middleware('auth')->controller(UserController::class)->prefix('user')->group(function ()
{
    Route::get('/','index')->name('user');
    
    Route::get('/create','create')->name('user/create');

    Route::post('/store', 'store')->name('user/store');

    Route::get('/edit/{id}', 'edit')->name('user/edit')->where('id','[0-9]+');

    Route::post('/update', 'update')->name('user/update')->where('id','[0-9]+');

    Route::get('/destroy/{id}', 'destroy')->name('user/destroy')->where('id','[0-9]+');


});

Route::middleware('auth')->controller(RecordController::class)->prefix("record")->group(function (){
    Route::get('/', 'index')->name('record');

    Route::get('/create', 'create')->name('record/create');

    Route::post('/store', 'store')->name('record/store');

    Route::get('/edit/{id}', 'edit')->name('record/edit')->where('id','[0-9]+');

    Route::post('/update', 'update')->name('record/update')->where('id','[0-9]+');

    Route::get('/destroy/{id}', 'destroy')->name('record/destroy')->where('id','[0-9]+');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
