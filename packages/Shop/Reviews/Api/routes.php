<?php

Route::post('shop-reviews/table', 'Shop\Reviews\Api\Controllers\ReviewsController@index');
Route::apiResource('shop-reviews', 'Shop\Reviews\Api\Controllers\ReviewsController');

Route::post('product-reviews/table', 'Shop\Reviews\Api\Controllers\ProductReviewsController@index');
Route::apiResource('product-reviews', 'Shop\Reviews\Api\Controllers\ProductReviewsController');

