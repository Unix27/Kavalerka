<?php


Route::post('/login', 'Admin\Api\Controllers\ApiAuthController@login');


/*ROLES*/
Route::post('/roles/table', 'Admin\Api\Controllers\AdminRolesController@index')->middleware('auth:api');

Route::resource("/roles", 'Admin\Api\Controllers\AdminRolesController')
    ->names('admin.admins.roles');


Route::post('/permissions/table', 'Admin\Api\Controllers\AdminPermissionsController@index');


Route::get('/menus', 'Admin\Api\Controllers\AdminMenuController@index')->middleware('auth:api');

