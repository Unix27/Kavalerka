<?php

Route::post('api/blog/posts/like', 'Site\Http\Controllers\Api\BlogApiController@like')
    ->name('site.api.blog.posts.like');

Route::post('api/blog/posts/unlike', 'Site\Http\Controllers\Api\BlogApiController@unlike')
    ->name('site.api.blog.posts.unlike');
