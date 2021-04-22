<?php


namespace Customers\Providers;


use Carbon\Laravel\ServiceProvider;
use Customers\Events\NewCustomer;
use Customers\Listeners\NewCustomerListener;
use Customers\Models\Customer;
use Route;

class CustomersServiceProvider extends ServiceProvider
{

    protected $listen = [
        NewCustomer::class => [
            NewCustomerListener::class
        ]
    ];

    public function boot()
    {
        parent::boot();

        $url_prefix = env('API_PATH') . '/';

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
        Route::prefix($url_prefix)->group(__DIR__ . '/../Api/routes.php',['middleware' => 'auth:api']);

        Customer::created(function ($model) {
            NewCustomer::dispatch($model);
        });
    }
}
