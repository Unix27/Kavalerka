<?php

namespace Localization\Providers;

use Illuminate\Support\ServiceProvider;
use Localization\Commands\RouteTranslationsCacheCommand;
use Localization\Commands\RouteTranslationsClearCommand;
use Localization\Commands\RouteTranslationsListCommand;
use Localization\Helpers\Localization;
use Route;

class LocalizationServiceProvider extends ServiceProvider
{
    public function register()
    {

        $url_prefix = env('API_PATH') . '/localization/';

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');

        Route::prefix($url_prefix)->group(__DIR__ . '/../Api/routes.php',['middleware' => 'auth:api']);

        $this->registerBindings();

        $this->registerCommands();

        $packageConfigFile = __DIR__.'/../config/config.php';

        $this->mergeConfigFrom(
            $packageConfigFile, 'localization'
        );
    }

    /**
     * Registers app bindings and aliases.
     */
    protected function registerBindings()
    {
        $this->app->singleton(Localization::class, function () {
            return new Localization();
        });

        $this->app->alias(Localization::class, 'localization');
    }

    /**
     * Registers route caching commands.
     */
    protected function registerCommands()
    {
        $this->app->singleton('laravellocalizationroutecache.cache', RouteTranslationsCacheCommand::class);
        $this->app->singleton('laravellocalizationroutecache.clear', RouteTranslationsClearCommand::class);
        $this->app->singleton('laravellocalizationroutecache.list', RouteTranslationsListCommand::class);

        $this->commands([
            'laravellocalizationroutecache.cache',
            'laravellocalizationroutecache.clear',
            'laravellocalizationroutecache.list',
        ]);
    }

    public function provides()
    {
        return ['modules.handler', 'modules'];
    }
}
