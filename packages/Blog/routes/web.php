<?php
Route::resource('admin/blog/posts', 'Blog\Http\Controllers\PostsAdminController')
    ->names('admin.blog.posts');

Route::resource('admin/blog/categories', 'Blog\Http\Controllers\CategoriesAdminController')
    ->names('admin.blog.categories');


Route::put('admin/blog/posts/{id}/publish', 'Blog\Http\Controllers\PostsAdminController@publish')
    ->name('admin.blog.posts.publish');

Route::put('admin/blog/posts/{id}/unpublish', 'Blog\Http\Controllers\PostsAdminController@unpublish')
    ->name('admin.blog.posts.unpublish');



Route::get('images/blog/{width}/{height}/{path}/', function ($width, $height, $path)
{
    return Response::make(Blog::getPostImage($width, $height, $path), 200, array(
        'Content-Type' => 'image/jpeg',
        "Cache-Control" => "max-age=3600",
    ));

})->name('blog.post.image');


