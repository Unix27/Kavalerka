<?php

use Admin\Models\AdminPermission;
use Admin\Models\AdminRole;
use Admin\Services\Datatable;
use Illuminate\Support\Facades\Route;
use Localization\Models\Translation;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





Route::get('/test', function (){
		dd(session()->get('cart'));
});

