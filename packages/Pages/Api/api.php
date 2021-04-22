<?php

//Route::post('admin/pages/image/upload', 'Pages\EditorJs\Api\EditorJsImageController@upload');
//Route::post('admin/pages/image/fetch', 'Pages\EditorJs\Api\EditorJsImageController@fetch');

Route::post('pages/table', 'Pages\Api\Controllers\PagesController@index');
Route::post('pages/{page_id}/slider', 'Pages\Api\Controllers\PagesController@slider');
Route::post('pages/{page_id}/slider-remove', 'Pages\Api\Controllers\PagesController@sliderRemove');

Route::resource('pages', 'Pages\Api\Controllers\PagesController');

