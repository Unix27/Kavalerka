<?php


Route::post('returns/table', 'Shop\Returns\Api\Controllers\ReturnsController@index');

Route::post('returns/{id}/updateStatus', 'Shop\Returns\Api\Controllers\ReturnsController@updateStatus');
Route::post('returns/{id}/updateReason', 'Shop\Returns\Api\Controllers\ReturnsController@updateReason');



Route::apiResource('returns', 'Shop\Returns\Api\Controllers\ReturnsController');



Route::post('return-reasons/table', 'Shop\Returns\Api\Controllers\ReturnReasonController@index');
Route::post('return-statuses/table', 'Shop\Returns\Api\Controllers\ReturnStatusesController@index');



Route::apiResource('return-reasons', 'Shop\Returns\Api\Controllers\ReturnReasonController');


Route::apiResource('return-statuses', 'Shop\Returns\Api\Controllers\ReturnStatusesController');


