<?php

Route::post('categories/table', 'Shop\Catalog\Api\Controllers\CategoriesController@table');
Route::get('categories/validate', 'Shop\Catalog\Api\Controllers\CategoriesController@validateName');

Route::apiResource('categories', 'Shop\Catalog\Api\Controllers\CategoriesController');

Route::post('products/table', 'Shop\Catalog\Api\Controllers\ProductsController@index');
Route::get('products/table', 'Shop\Catalog\Api\Controllers\ProductsController@index');
Route::post('products/save-image', 'Shop\Catalog\Api\Controllers\ProductsController@SaveImage')->name('save-image');

Route::post('statuses', 'Shop\Catalog\Api\Controllers\ShopStatusesController@index');


Route::get('products/search', 'Shop\Catalog\Api\Controllers\ProductsController@search');
Route::apiResource('products', 'Shop\Catalog\Api\Controllers\ProductsController');

Route::post('brands/table', 'Shop\Catalog\Api\Controllers\BrandsController@table');
Route::apiResource('brands', 'Shop\Catalog\Api\Controllers\BrandsController');
Route::get('/attributes/validate', 'Shop\Catalog\Api\Controllers\AttributesController@validateName');
Route::post('attributes/table', 'Shop\Catalog\Api\Controllers\AttributesController@index');

Route::post('/attributes/{id}', 'Shop\Catalog\Api\Controllers\AttributesController@findByProductId');
Route::apiResource('attributes', 'Shop\Catalog\Api\Controllers\AttributesController');

Route::post('attribute_groups/table', 'Shop\Catalog\Api\Controllers\AttributeGroupsController@index');
Route::apiResource('attribute_groups', 'Shop\Catalog\Api\Controllers\AttributeGroupsController');


Route::get('/images/{id}', 'Shop\Catalog\Api\Controllers\ImagesController@index');
Route::delete('/images/{id}', 'Shop\Catalog\Api\Controllers\ImagesController@delete');

Route::get('/related/{type}/{id}', 'Shop\Catalog\Api\Controllers\RelatedController@index');
Route::delete('/related/{type}/{id}', 'Shop\Catalog\Api\Controllers\RelatedController@delete');

Route::get('/videos/{id}', 'Shop\Catalog\Api\Controllers\VideosController@index');


Route::get('/variations/{id}', 'Shop\Catalog\Api\Controllers\VariationsController@index');
Route::post('/variations/{id}/table', 'Shop\Catalog\Api\Controllers\VariationsController@index');
Route::put('/variations/{id}', 'Shop\Catalog\Api\Controllers\VariationsController@save');
Route::get('/variations/{id}/edit', 'Shop\Catalog\Api\Controllers\VariationsController@edit');
Route::delete('/variations/{id}', 'Shop\Catalog\Api\Controllers\VariationsController@delete');

Route::get('/variations/images/{id}', 'Shop\Catalog\Api\Controllers\VariationImagesController@index');
Route::delete('/variations/images/{id}', 'Shop\Catalog\Api\Controllers\VariationImagesController@delete');


Route::post('/discounts/{id}/table', 'Shop\Catalog\Api\Controllers\DiscountsController@index');



Route::post('attribute-values/table', 'Shop\Catalog\Api\Controllers\AttributesValueController@index');
Route::post('attribute-values/filter-attr', 'Shop\Catalog\Api\Controllers\AttributesValueController@filterAttr');
Route::post('attribute-values/updateAll', 'Shop\Catalog\Api\Controllers\AttributesValueController@updateAll');

Route::apiResource('attribute-values', 'Shop\Catalog\Api\Controllers\AttributesValueController');



//Route::get('test', function () { //Speed test
//   dump(\Shop\Catalog\Models\Product::all());
//   dump(\Customers\Models\Customer::all());
//});
