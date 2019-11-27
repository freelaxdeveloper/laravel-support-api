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

Route::get('/messageHistory', 'ChatMessageHistoryController@index');
Route::get('/messageHistory/{support}', 'ChatMessageHistoryController@show');

Route::delete('/message/{message}', 'MessageController@destroy');
Route::post('/message/{message}/file', 'MessageController@uploadFile');
Route::patch('/message/{message}/like', 'MessageController@like');
Route::put('/message/{message}', 'MessageController@update');
Route::post('/message', 'MessageController@store');
