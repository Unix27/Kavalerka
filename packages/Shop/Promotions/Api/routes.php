<?php
//Route::post('promotions-category/table', 'Shop\Promotions\Api\Controllers\CategoryController@table');
//Route::get('promotions-category/validate', 'Shop\Promotions\Api\Controllers\CategoryController@validateName');

//Route::apiResource('promotions-category', 'Shop\Promotions\Api\Controllers\CategoryController');
//Route::get('shop/promotions/categories/table', 'Shop\Promotions\Api\Controllers\CategoryController@table');

Route::get('catalog/promotions/categories', 'Shop\Promotions\Api\Controllers\CategoryController@table');

Route::get('catalog/tree-categories', 'Shop\Promotions\Api\Controllers\PromotionsController@categories');

Route::post('catalog/promotions/categories/table', 'Shop\Promotions\Api\Controllers\CategoryController@table');
//Route::get('promotions/products', 'Shop\Orders\Api\Controllers\PromotionsController@products');

Route::apiResource('catalog/promotions', 'Shop\Promotions\Api\Controllers\PromotionsController');

Route::post('catalog/promotions/table', 'Shop\Promotions\Api\Controllers\PromotionsController@index');
Route::post('catalog/promotions/{id}/update', 'Shop\Promotions\Api\Controllers\PromotionsController@update');

Route::apiResource('promotions/categories', 'Shop\Promotions\Api\Controllers\CategoryController');
