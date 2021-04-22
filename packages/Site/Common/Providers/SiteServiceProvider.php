<?php


namespace Site\Common\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Localization\Models\Locale;
use Route;
use Site\Common\Helpers\Site;
use Site\Common\Http\Middleware\SeoRedirects;
use Str;

class SiteServiceProvider extends ServiceProvider
{

    public function boot(Router $router)
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'site');

        $router->aliasMiddleware('seo_redirects', SeoRedirects::class);
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        if(\Schema::hasTable('locales') && Locale::first()) {
            Route::middleware(['web'])->group(__DIR__ . '/../routes/web.php');
        }
    }

    public function register()
    {
        $this->registerFacades();
    }

    protected function registerFacades()
    {
        app()->bind('site', function () {
            return new Site();
        });
    }
}
