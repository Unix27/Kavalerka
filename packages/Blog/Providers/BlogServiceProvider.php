<?php


namespace Blog\Providers;

use Blog\Helpers\Blog as BlogHelper;
use Illuminate\Support\ServiceProvider;
use Route;


class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $url_prefix = env('API_PATH') . '/blog/';

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
        Route::prefix($url_prefix)
            ->group(__DIR__ . '/../Api/routes.php',['middleware' => 'auth:api']);


        $this->mergeConfigFrom(__DIR__ . '/../config/blog.php', 'blog');
    }

    public function register()
    {
        $this->registerFacades();
    }

    protected function registerFacades()
    {
        \App::bind('blog', function () {
            return new BlogHelper();
        });
    }
}

