<?php


Route::get('customers/validate','Customers\Api\Controllers\CustomersController@vuelidate');

Route::post('customers/table', 'Customers\Api\Controllers\CustomersController@table');
Route::post('customers/update-password', 'Customers\Api\Controllers\CustomersController@updatePassword');

Route::apiResource('customers', 'Customers\Api\Controllers\CustomersController');

Route::post('customer_groups/table', 'Customers\Api\Controllers\CustomerGroupsController@table');
Route::apiResource('customer_groups', 'Customers\Api\Controllers\CustomerGroupsController');
