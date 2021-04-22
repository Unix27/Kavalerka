<?php


namespace Site\Common\Http\Middleware;


use Closure;
use Pages\Models\Page;
use Shop\Catalog\Models\Category;
use Shop\Catalog\Models\Product;
use Str;

class CatalogMiddleware
{
	public function handle($request, Closure $next)
	{

		$slug = $request->route('slug');
		$route = $request->route();

		$routeAction = array_merge($route->getAction(), [
			'uses'       => 'Site\Common\Http\Controllers\CatalogController@show',
			'slug'       => $slug,
			'controller' => 'Site\Common\Http\Controllers\CatalogController@show',
		]);

		$routeActionCategory = array_merge($route->getAction(), [
			'uses'       => 'Site\Common\Http\Controllers\CatalogController@category',
			'controller' => 'Site\Common\Http\Controllers\CatalogController@category',
		]);

		$locale = app()->getLocale();
		if($locale == 'uk'){
			$locale = '';
		}else{
			$locale .= '/';
		}

		if($request->is($locale.'product/*')){
			$type='product';
			$page = Product::where('slug', '=', $slug)->first();

			$route->setAction($routeAction);
			$route->controller = false;

			return $next($request);
		} else {
			$page = Page::where('slug', $slug)->first();
			$type = 'page';
			if($page){
				$page_category = Category::where('slug', '=', $slug)->first();
				if($page->slug == 'search') {
					$routeActionPage = array_merge($route->getAction(), [
						'uses' => 'Site\Common\Http\Controllers\CatalogController@search',
						'controller' => 'Site\Common\Http\Controllers\CatalogController@search',
					]);

				}elseif($page_category){
					$routeActionPage = array_merge($route->getAction(), [
						'uses' => 'Site\Common\Http\Controllers\CatalogController@category',
						'controller' => 'Site\Common\Http\Controllers\CatalogController@category',
					]);

				} else {
					$routeActionPage = array_merge($route->getAction(), [
						'uses' => 'Site\Common\Http\Controllers\CatalogController@index',
						'controller' => 'Site\Common\Http\Controllers\CatalogController@index',
					]);
				}
				$route->setAction($routeActionPage);
				$route->controller = false;

				$request->attributes->add(['page' => $page]);
				$request->attributes->add(['type' => 'page']);

				return $next($request);
			}else if (!$page) {
				if (strpos($slug, '/') !== false) {
					$strArray = explode('/', $slug);

					$lastElement = end($strArray);
					$slug = $lastElement;
				}
				$page = Category::where('slug', '=', $slug)->first();
				$type = 'category';
				$route->setAction($routeActionCategory);
				$route->controller = false;

				$request->attributes->add(['page' => $page]);
				$request->attributes->add(['type' => $type]);

				return $next($request);
			}
		}
	}


}
