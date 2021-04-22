<?php


namespace Core\EditorJs;


use Illuminate\Support\ServiceProvider;

class EditorJsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $url_prefix = env('API_PATH') . '/editor_js/';
        \Route::prefix($url_prefix)->group(__DIR__ . '/routes.php');
    }
}
