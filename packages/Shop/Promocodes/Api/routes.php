<?php

//Route::get('promocodes/products', 'Shop\Orders\Api\Controllers\PromocodesController@products');
Route::get('catalog/tree-categories', 'Shop\Promocodes\Api\Controllers\PromocodesController@categories');

Route::apiResource('catalog/promocodes', 'Shop\Promocodes\Api\Controllers\PromocodesController');

Route::post('catalog/promocodes/table', 'Shop\Promocodes\Api\Controllers\PromocodesController@index');
Route::post('catalog/promocodes/{id}/update', 'Shop\Promocodes\Api\Controllers\PromocodesController@update');

