<?php

use Illuminate\Http\Request;

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

Route::get('/token', 'UserController@token');
Route::get('/myinfo', 'UserController@myinfo');

Route::prefix('messageHistory')->group(function () {
    Route::get('/', 'ChatMessageHistoryController@index');
    Route::get('/{chat}', 'ChatMessageHistoryController@show');
});

Route::prefix('message')->group(function () {
    Route::prefix('{message}')->group(function () {
        Route::delete('/', 'MessageController@destroy');
        Route::post('/file', 'MessageController@uploadFile');
        Route::patch('/like', 'MessageController@like');
        Route::put('/', 'MessageController@update');
    });
    Route::post('/', 'MessageController@store');
});
