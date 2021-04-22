<?php


namespace Torgsoft\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Localization\Models\Locale;
use Route;
use Site\Common\Helpers\Site;
use Site\Common\Http\Middleware\SeoRedirects;
use Str;
use Torgsoft\Models\Import;

class TorgsoftServiceProvider extends ServiceProvider
{

	public function boot(Router $router)
	{
		$this->loadViewsFrom(__DIR__ . '/../Resources/views', 'torgsoft');

		$this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

//		if(\Schema::hasTable('locales') && Locale::first()) {
//			Route::middleware(['web'])->group(__DIR__ . '/../routes/web.php');
//
				Route::middleware(['web'])->group(__DIR__ . '/../routes/web.php');
	}

	public function register()
	{
		$this->registerFacades();
	}

	protected function registerFacades()
	{
		app()->bind('torgsoft', function () {
			return new Import();
		});
	}
}
