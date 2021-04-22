<?php

// Route::post('admin/blog/posts/image/upload', 'Blog\EditorJs\Api\EditorJsImageController@upload');
// Route::post('admin/blog/posts/image/fetch', 'Blog\EditorJs\Api\EditorJsImageController@fetch');
Route::middleware(['auth:api'])
    ->group(function(){
        Route::post('posts/table', 'Blog\Api\Controllers\PostsController@index');
        Route::apiResource('posts', 'Blog\Api\Controllers\PostsController');

        Route::post('categories/table', 'Blog\Api\Controllers\CategoriesController@table');
        Route::apiResource('categories', 'Blog\Api\Controllers\CategoriesController');
});
