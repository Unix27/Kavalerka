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



Route::group(['middleware' => ['cors']], function () {


//    Route::group(['middleware'=>['check_token']], function(){
//        Route::post('is_auth', 'Dashboard\ApiController@api_is_auth');
//        Route::post('logout', 'Auth\LoginController@logout'); //выход
//
//        Route::post('get_dashboard_application', 'Dashboard\ApiController@api_dashboard_application');
//        Route::post('get_page_application', 'Dashboard\ApiController@api_page_application');
//
//    });

});
