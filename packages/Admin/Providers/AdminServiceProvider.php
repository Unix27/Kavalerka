<?php

namespace Admin\Providers;

use Admin\helpers\ImageTool;
use Admin\Http\Middleware\AdminMiddleware;
use App;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Route;

class AdminServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $router = app(Router::class);
        //$this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
        $router->aliasMiddleware('admin', AdminMiddleware::class);

        Route::prefix('api/admin')
            ->group(__DIR__.'/../Api/routes.php');

//        Route::prefix('admin')->group(__DIR__.'/../Http/routes.php');

    }

    public function register()
    {
        $this->registerFacades();


    }

    protected function registerFacades()
    {
        App::bind('ImageTool', function () {
            return new ImageTool();
        });
    }
}
