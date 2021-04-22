<?php

/*Locales*/


Route::post('locales/table', 'Localization\Api\Controllers\LocalesController@index');
Route::get('/locales/active', 'Localization\Api\Controllers\LocalesController@activeLocales');
Route::apiResource('locales', 'Localization\Api\Controllers\LocalesController');
Route::post('locales/{id}/setActive', 'Localization\Api\Controllers\LocalesController@setActive');
Route::post('locales/{id}/setDefault', 'Localization\Api\Controllers\LocalesController@setDefault');

/*TRANSLATIONS*/
Route::any('translations/import', 'Localization\Api\Controllers\TranslationsController@import');

Route::get('translations/groups', 'Localization\Api\Controllers\TranslationsController@groups');
Route::post('translations/table', 'Localization\Api\Controllers\TranslationsController@index');
Route::apiResource('translations', 'Localization\Api\Controllers\TranslationsController');

Route::any('admin/locale/manager/postpublish', 'Localization\Http\Controllers\Admin\ManagerController@postPublish')
    ->name('admin.localization.manager.postpublish');
