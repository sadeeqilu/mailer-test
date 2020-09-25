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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("/accounts")->group( function () {
    Route::get('/{id}','AccountController@get');
    Route::post('create-account','AccountController@create');
    Route::patch('update-account/{id}','AccountController@update');

});

Route::prefix("/transactions")->group(function () {
    Route::get('/get-transaction/{account_id}','TransactionController@index');
    Route::post('/make-transaction/{account_id}','TransactionController@makeTransaction');
});

Route::get('/currencies','CurrencyController@index');
