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

Route::get('users', 'UserManagerController@index');
Route::get('user/{id}', 'UserManagerController@show');

Route::post('user', 'UserManagerController@store');
Route::put('user/{id}', 'UserManagerController@update');

Route::delete('user/{id}', 'UserManagerController@destroy');