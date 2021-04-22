<?php


namespace Pages\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Route;


class PagesServiceProvider extends ServiceProvider
{

	public function boot()
	{
//        $url_prefix = env('API_PATH').'/admin/pages/';
		$url_prefix = env('API_PATH') . '/';
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
//        Route::middleware('web')->group(__DIR__ . '/../routes/web.php');
//        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php')->prefix(env('API_PATH'));

		Route::prefix($url_prefix)->group(__DIR__.'/../Api/api.php',['middleware' => 'auth:api']);
//
//        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'pages');
//        ['middleware' => 'auth:api']
//        $this->registerRoutes();
	}

	// protected function registerRoutes()
	// {
	//     if(Schema::hasTable('pages')) {
	//         $router = app(Router::class);

	//         foreach (Page::all() as $page) {
	//             $router->get( config('pages.url_prefix') . $page->slug . config('pages.url_suffix'),  'Site\Http\Controllers\SiteController@page')
	//                 ->prefix(Localization::setLocale())->name('site.' . $page->slug)->group(null,['middleware' => 'auth:api']);
	//         }
	//     }
	// }
}

