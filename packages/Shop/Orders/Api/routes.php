<?php

Route::apiResource('orders/deliveries', 'Shop\Orders\Api\Controllers\OrderDeliveriesController');


Route::get('orders/statuses', 'Shop\Orders\Api\Controllers\StatusController@index');
Route::post('orders/statuses/update', 'Shop\Orders\Api\Controllers\StatusController@update');
Route::get('orders/payment-methods', 'Shop\Orders\Api\Controllers\OrderPaymentMethodsController@index');


Route::post('orders/table', 'Shop\Orders\Api\Controllers\OrdersController@index');
Route::apiResource('orders', 'Shop\Orders\Api\Controllers\OrdersController');



Route::post('orders/{id}/updateStatus', 'Shop\Orders\Api\Controllers\OrdersController@updateStatus');
Route::post('orders/{id}/updatePayment', 'Shop\Orders\Api\Controllers\OrdersController@updatePayment');

Route::apiResource('orders/statuses', 'Shop\Orders\Api\Controllers\StatusController');

