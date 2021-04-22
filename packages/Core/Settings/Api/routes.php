<?php

Route::get('settings', 'Core\Settings\Api\Controllers\SettingsController@index');
Route::put('settings', 'Core\Settings\Api\Controllers\SettingsController@save');

Route::post('settings/currency/table', 'Core\Settings\Api\Controllers\CurrencyController@index');
Route::get('settings/currency/validate', 'Core\Settings\Api\Controllers\CurrencyController@validateName');

Route::post('settings/currency/{id}/setDefault', 'Core\Settings\Api\Controllers\CurrencyController@setDefault');

Route::apiResource('settings/currency', 'Core\Settings\Api\Controllers\CurrencyController');

Route::post('settings/storage/table', 'Core\Settings\Api\Controllers\StorageStatusController@index');
Route::get('settings/storage/validate', 'Core\Settings\Api\Controllers\StorageStatusController@validateName');

Route::apiResource('settings/storage', 'Core\Settings\Api\Controllers\StorageStatusController');

// Discount's system
Route::post('settings/discounts-system/table', 'Core\Settings\Api\Controllers\DiscountsSystemController@index');
Route::get('settings/discounts-system/validate', 'Core\Settings\Api\Controllers\DiscountsSystemController@validateName');
Route::apiResource('settings/discounts-system', 'Core\Settings\Api\Controllers\DiscountsSystemController');


Route::post('settings/units/table', 'Core\Settings\Api\Controllers\UnitController@index');
Route::get('settings/units/validate', 'Core\Settings\Api\Controllers\UnitController@validateName');
Route::post('settings/units/{id}/setDefault', 'Core\Settings\Api\Controllers\UnitController@setDefault');

Route::apiResource('settings/units', 'Core\Settings\Api\Controllers\UnitController');


Route::post('settings/unit-weight/table', 'Core\Settings\Api\Controllers\UnitWeightController@index');
Route::get('settings/unit-weight/validate', 'Core\Settings\Api\Controllers\UnitWeightController@validateName');
Route::post('settings/unit-weight/{id}/setDefault', 'Core\Settings\Api\Controllers\UnitWeightController@setDefault');

Route::apiResource('settings/unit-weight', 'Core\Settings\Api\Controllers\UnitWeightController');


