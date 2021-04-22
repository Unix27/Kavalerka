<?php


namespace Core\Settings\Providers;


use Core\Settings\Contracts\SettingStorage;
use Core\Settings\Helpers\SettingEloquentStorage;
use Core\Settings\Helpers\Settings;
use Illuminate\Support\ServiceProvider;
use Route;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app('config')->set('settings', require(__DIR__ . '/../Config/settings.php'));
        include __DIR__ . '/../Helpers/helpers.php';

        $url_prefix = env('API_PATH') . '/';

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations/');
        Route::prefix($url_prefix)
            ->group(__DIR__ . '/../Api/routes.php',['middleware' => 'auth:api']);
    }
    public function register()
    {
        $this->app->bind(
            SettingStorage::class,
            SettingEloquentStorage::class
        );

        $this->app->singleton('settings', function ($app) {
            return new Settings($app->make(SettingStorage::class));
        });
    }
}
