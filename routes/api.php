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
Route::get('login',function () {
    return "unautorize";
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'Api\UserController@postLogin');
Route::get('logout', 'Api\UserController@getLogout');
Route::group(['middleware' => 'auth:api'], function(){

});
Route::post('test', 'Api\ShirtController@test');
Route::get('get-all-vps', 'Api\VpsController@getAll');

Route::get('get-shirt/{id}', 'Api\ShirtController@getShirt');
Route::get('get-shirts-by-account', 'Api\ShirtController@getShirtsByAccount');
Route::get('get-colors-of-shirt/{id}', 'Api\ShirtController@getShirtColors');

Route::get('get-account/{id}', 'Api\AccountController@getAccount');
Route::get('get-accounts-by-vps/{id}', 'Api\AccountController@getAccountsByVps');
Route::get('get-accounts-with-countshirts-by-vps/{id}', 'Api\AccountController@getAccountsWithCountShirtsByVps');
Route::get('get-shirts-by-vps', 'Api\ShirtController@getShirtByVps');
Route::get('get-image-of-shirt/{id}', 'Api\ShirtController@getShirtImage');
