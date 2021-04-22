<?php


namespace Shop\Core\Providers;

use Route;
use Shop\Orders\Models\Order;
use Shop\Orders\Observers\OrderObserver;
use Carbon\Laravel\ServiceProvider;

class
ShopServiceProvider extends ServiceProvider
{

    public function boot()
    {
        parent::boot();
        Order::observe(OrderObserver::class);
    }

    public function register()
    {
        app('config')->set('shop', require(__DIR__ . '/../config/config.php'));
				$this->registerPromotions();

        $this->registerCatalog();
        $this->registerReviews();
        $this->registerOrders();
        $this->registerReturns();
        $this->registerPromocodes();

    }

    protected function registerCatalog()
    {
        $url_prefix = env('API_PATH') . '/shop/catalog/';
        $dir = __DIR__ . '/../../Catalog/';

        $this->loadMigrationsFrom($dir . 'Database/Migrations/');
        Route::prefix($url_prefix)->group($dir . 'Api/routes.php',['middleware' => 'auth:api']);
    }

    protected function registerOrders()
    {
        $url_prefix = env('API_PATH') . '/shop/';
        $dir = __DIR__ . '/../../Orders/';

        $this->loadMigrationsFrom($dir . 'Database/Migrations/');
        Route::prefix($url_prefix)->group($dir . 'Api/routes.php',['middleware' => 'auth:api']);
    }

    protected function registerReturns()
    {
        $url_prefix = env('API_PATH') . '/shop/';
        $dir = __DIR__ . '/../../Returns/';

        $this->loadMigrationsFrom($dir . 'Database/Migrations/');
        Route::prefix($url_prefix)->group($dir . 'Api/routes.php',['middleware' => 'auth:api']);
    }

    protected function registerReviews()
    {
				$url_prefix = env('API_PATH') . '/shop/';
        $dir = __DIR__ . '/../../Reviews/';

        $this->loadMigrationsFrom($dir . 'Database/Migrations/');
				Route::prefix($url_prefix)->group($dir . 'Api/routes.php',['middleware' => 'auth:api']);
		}

    protected function registerPromotions()
    {
				$url_prefix = env('API_PATH') . '/shop/';
        $dir = __DIR__ . '/../../Promotions/';

        $this->loadMigrationsFrom($dir . 'Database/Migrations/');
				Route::prefix($url_prefix)->group($dir . 'Api/routes.php',['middleware' => 'auth:api']);
    }

    protected function registerPromocodes()
    {
				$url_prefix = env('API_PATH') . '/shop/';
        $dir = __DIR__ . '/../../Promocodes/';

        $this->loadMigrationsFrom($dir . 'Database/Migrations/');
				Route::prefix($url_prefix)->group($dir . 'Api/routes.php',['middleware' => 'auth:api']);
    }
}
