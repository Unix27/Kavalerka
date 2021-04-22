<?php

//$admin_path = setting('admin_path');
$admin_path = env('ADMIN_PATH');


Route::group(['middleware' => ['web']], function() use ($admin_path) {

    /*COMMON*/
    Route::get($admin_path, 'Admin\Http\Controllers\AdminController@index')
        ->name('admin.index');

    /*LOGIN*/
    Route::get("$admin_path/login", 'Admin\Http\Controllers\LoginController@index')
        ->name('admin.login.form');
    Route::post("$admin_path/login", 'Admin\Http\Controllers\LoginController@login')
        ->name('admin.login');
    Route::get("$admin_path/logout", 'Admin\Http\Controllers\LoginController@logout')
        ->name('admin.logout');

    Route::post("$admin_path/login/check", 'Admin\Http\Controllers\LoginController@checkLogin')
        ->name('admin.login.check');

    /*PROFILE*/

    /*ROLES*/
    Route::resource("$admin_path/admins/roles", 'Admin\Http\Controllers\AdminRolesController')
        ->names('admin.admins.roles');

    /*PERMISSIONS*/
    Route::resource("$admin_path/admins/permissions", 'Admin\Http\Controllers\AdminPermissionsController')
        ->names('admin.admins.permissions');

    /*ADMINS*/
    Route::resource("$admin_path/admins", 'Admin\Http\Controllers\AdminsController')
        ->names('admin.admins');

    Route::get("$admin_path/settings", 'Admin\Http\Controllers\SettingsController@index')
        ->name('admin.settings.index');
    Route::post("$admin_path/settings", 'Admin\Http\Controllers\SettingsController@save')
        ->name('admin.settings.save');
});

Route::group(['middleware' => ['web']], function() use ($admin_path) {

    Route::get("$admin_path/datagrid/admins", 'Admin\Http\Controllers\DataGrids\AdminsDataGrid@index')
        ->name('admin.datagrid.admins.index');
    Route::get("$admin_path/datagrid/admins/{id}/delete", 'Admin\Http\Controllers\DataGrids\AdminsDataGrid@delete')
        ->name('admin.datagrid.admins.delete');
    Route::get("$admin_path/datagrid/admins/roles", 'Admin\Http\Controllers\DataGrids\AdminRolesDataGrid@index')
        ->name('admin.datagrid.admins.roles');
    Route::get("$admin_path/datagrid/admins/roles/{id}/delete", 'Admin\Http\Controllers\DataGrids\AdminRolesDataGrid@delete')
        ->name('admin.datagrid.admins.roles.delete');
    Route::get("$admin_path/datagrid/admins/permissions", 'Admin\Http\Controllers\DataGrids\AdminPermissionsDataGrid@index')
        ->name('admin.datagrid.admins.permissions');

});



