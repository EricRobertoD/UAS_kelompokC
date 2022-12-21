<?php

use Illuminate\Http\Request;
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


Route::post('register', 'App\Http\Controllers\AuthController@register');
Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('logout', 'App\Http\Controllers\AuthController@logout');
Route::get('email-verification', 'App\Http\Controllers\AuthController@verify')->name('verification.verify');
Route::get('getRevUser', 'App\Http\Controllers\reservasiController@getRevUser')->middleware('auth:api');

Route::group(['middleware' => 'auth:api'], function(){
        
    Route::apiResource('/users',
    App\Http\Controllers\userController::class);

    Route::apiResource('/reservasis',
    App\Http\Controllers\reservasiController::class);

    Route::apiResource('/barbers',
    App\Http\Controllers\barberController::class);

    Route::apiResource('/sarans',
    App\Http\Controllers\saranController::class);

    Route::apiResource('/produks',
    App\Http\Controllers\produkController::class);
});
