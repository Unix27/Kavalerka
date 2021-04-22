<?php namespace Localization\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Localization\Commands\CleanCommand;
use Localization\Commands\ExportCommand;
use Localization\Commands\FindCommand;
use Localization\Commands\ImportCommand;
use Localization\Commands\ResetCommand;
use Localization\Helpers\Manager;

class ManagerServiceProvider extends ServiceProvider {
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        // Register the config publish path
        $configPath = __DIR__ . '/../config/translation-manager.php';
        $this->mergeConfigFrom($configPath, 'translation-manager');

        $this->app->singleton('translation-manager', function ($app) {
            $manager = $app->make(Manager::class);
            return $manager;
        });

        $this->app->singleton('command.translation-manager.reset', function ($app) {
            return new ResetCommand($app['translation-manager']);
        });
        $this->commands('command.translation-manager.reset');

        $this->app->singleton('command.translation-manager.import', function ($app) {
            return new ImportCommand($app['translation-manager']);
        });
        $this->commands('command.translation-manager.import');

        $this->app->singleton('command.translation-manager.find', function ($app) {
            return new FindCommand($app['translation-manager']);
        });
        $this->commands('command.translation-manager.find');

        $this->app->singleton('command.translation-manager.export', function ($app) {
            return new ExportCommand($app['translation-manager']);
        });
        $this->commands('command.translation-manager.export');

        $this->app->singleton('command.translation-manager.clean', function ($app) {
            return new CleanCommand($app['translation-manager']);
        });
        $this->commands('command.translation-manager.clean');
	}

    /**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        $viewPath = __DIR__.'/../Resources/views';
        $this->loadViewsFrom($viewPath, 'admin');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('translation-manager',
            'command.translation-manager.reset',
            'command.translation-manager.import',
            'command.translation-manager.find',
            'command.translation-manager.export',
            'command.translation-manager.clean'
        );
	}

}
