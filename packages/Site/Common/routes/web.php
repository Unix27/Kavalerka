<?php

/*Route::prefix('{locale?}')->where(['locale' => '[a-zA-Z]{2}'])->middleware('localeUrl')->group(function ($lang) {

    Route::get('/', 'Site\Http\Controllers\SiteController@index')->name('site.index');

    Route::get('blog', 'Site\Http\Controllers\BlogController@index')->name('site.blog.index');
    Route::get('blog/search', 'Site\Http\Controllers\BlogController@search')->name('site.blog.search');
    Route::get('blog/{slug}/{slug1}', 'Site\Http\Controllers\BlogController@view')->name('site.blog.post.view');
    Route::get('blog/{slug}', 'Site\Http\Controllers\BlogController@category')->name('site.blog.category');

    Route::get('policy', 'Site\Http\Controllers\SiteController@policy')->name('site.policy');
    Route::get('offer', 'Site\Http\Controllers\SiteController@offer')->name('site.offer');

});


Route::get('blog', 'Site\Http\Controllers\BlogController@index');
Route::get('blog/search', 'Site\Http\Controllers\BlogController@search');
Route::get('blog/{slug}/{slug1}', 'Site\Http\Controllers\BlogController@view');
Route::get('blog/{slug}', 'Site\Http\Controllers\BlogController@category');

Route::get('policy', 'Site\Http\Controllers\SiteController@policy');
Route::get('offer', 'Site\Http\Controllers\SiteController@offer');*/



Auth::routes(['register' => false,'login' => false]);

Route::get('/test', function (){

	dump(session('cart'));
});


Route::group(['prefix' => Localization::setLocale()], function()
{
		Route::get('/destroy', function (){
//			session()->forget('cart');
			session()->forget('promocode');
			return 'success';
		});

    Route::get('/', 'Site\Common\Http\Controllers\SiteController@index')->name('site.index');
    Route::get('/login', 'Site\Common\Http\Controllers\AuthController@login')->name('login');
    Route::post('/login', 'Site\Common\Http\Controllers\AuthController@login')->name('login');
    Route::get('/logout', 'Site\Common\Http\Controllers\AuthController@logout')->name('site.logout');

    Route::get('/register', 'Site\Common\Http\Controllers\AuthController@register')->name('register');
    Route::post('/register', 'Site\Common\Http\Controllers\AuthController@registersend')->name('register');

    Route::get('/success-registration', 'Site\Common\Http\Controllers\AuthController@successRegister')->name('success.register');
    Route::get('/successfully-subscribed', 'Site\Common\Http\Controllers\AuthController@successSubscribed')->name('success.subscribe');

//    Route::post('/password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('site.register');
//    Route::post('/password/email', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('site.reset');

//Privat cabinet
    Route::get('/dashboard/profile', 'Site\Common\Http\Controllers\Dashboard\ProfileController@index')->name('site.dashboard.profile');
    Route::post('/dashboard/profile', 'Site\Common\Http\Controllers\Dashboard\ProfileController@save')->name('site.dashboard.profile');
    Route::get('/dashboard/my-reviews', 'Site\Common\Http\Controllers\Dashboard\ProfileController@myReviews')->name('site.dashboard.my_reviews');
    Route::get('/dashboard/wholesale', 'Site\Common\Http\Controllers\Dashboard\ProfileController@wholesale')->name('site.dashboard.wholesale');
    Route::post('/dashboard/wholesale', 'Site\Common\Http\Controllers\Dashboard\ProfileController@isWholesale')->name('site.dashboard.wholesale');
    Route::get('/dashboard/viewed-products', 'Site\Common\Http\Controllers\Dashboard\ProfileController@viewedProducts')->name('site.dashboard.viewed_products');
    Route::get('/dashboard/favorite-products', 'Site\Common\Http\Controllers\Dashboard\ProfileController@favoriteProducts')->name('site.dashboard.favorite_products');
    Route::get('/dashboard/my-orders', 'Site\Common\Http\Controllers\Dashboard\ProfileController@myOrders')->name('site.dashboard.my_orders');

    Route::post('/dashboard/profile/change-password', 'Site\Common\Http\Controllers\Dashboard\ProfileController@changePassword');
    Route::post('/dashboard/profile/set-city', 'Site\Common\Http\Controllers\Dashboard\ProfileController@setCity');
//Pages
		Route::get('/reviews-about-company', 'Site\Common\Http\Controllers\SiteController@reviews')->name('site.reviews');
		Route::get('/delivery-and-payment', 'Site\Common\Http\Controllers\SiteController@deliveryPayment')->name('site.delivery_payment');
		Route::get('/warranty-and-return', 'Site\Common\Http\Controllers\SiteController@warrantyReturn')->name('site.warranty_return');
		Route::get('/discount', 'Site\Common\Http\Controllers\SiteController@discount')->name('site.discount');
		Route::get('/brands', 'Site\Common\Http\Controllers\SiteController@brands')->name('site.brands');

		Route::get('/blog/{category?}', 'Site\Common\Http\Controllers\BlogController@index')->name('site.blog.category');
		Route::post('/get-category-articles', 'Site\Common\Http\Controllers\BlogController@index')->name('site.get.category.articles');
		Route::get('/blog/{category}/{slug}', 'Site\Common\Http\Controllers\BlogController@show')->name('site.blog.article');
		Route::post('/blog', 'Site\Common\Http\Controllers\BlogController@getPosts')->name('site.blog');

		Route::post('/cart/choose-variation-product', 'Site\Common\Http\Controllers\CartController@save')->name('site.choose-variation');
		Route::post('/cart/remove/{id}', 'Site\Common\Http\Controllers\CartController@remove')->name('site.cart.remove');
		Route::post('/cart/add', 'Site\Common\Http\Controllers\CartController@add')->name('site.cart.add');
		Route::post('/cart/quantity', 'Site\Common\Http\Controllers\CartController@quantity')->name('site.cart.quantity');
		Route::post('/cart', 'Site\Common\Http\Controllers\CartController@index')->name('site.cart.add');

		Route::get('/checkout', 'Site\Common\Http\Controllers\OrderController@index')->name('site.checkout');
		Route::post('/checkout/update', 'Site\Common\Http\Controllers\OrderController@update')->name('site.checkout.update');
		Route::post('/checkout', 'Site\Common\Http\Controllers\OrderController@save')->name('site.checkout.save');

		Route::get('/promotions/{category?}','Site\Common\Http\Controllers\PromotionController@index')->name('site.promotions');

//		Route::get('/{slug}', 'Site\Common\Http\Controllers\SiteController@show')->name('site.page');

		Route::post('/remove/favorite-product', 'Shop\Catalog\Repositories\ProductsRepository@removeFromFavorite')->name('ajax.remove.from.favorite');
		Route::post('/add/favorite-product', 'Shop\Catalog\Repositories\ProductsRepository@addToFavorite')->name('ajax.add.to.favorite');
		Route::post('/get-more-product', 'Site\Common\Http\Controllers\Dashboard\ProfileController@getMoreProducts')->name('ajax.get.mote.products');
		Route::post('/use-promocode', 'Site\Common\Http\Controllers\OrderController@usePromocode');

		Route::get('/session', function (){
			dd(session()->all());
		});

		Route::post('/send-reviews', 'Site\Common\Http\Controllers\SiteController@sendReview')->name('site.send.review');

	Route::group(['middleware'=>'catalogMiddleware'],function(){

		Route::get('/search?', 'Site\Common\Http\Controllers\CatalogController@filter')->name('site.search');
		Route::post('/search?', 'Site\Common\Http\Controllers\CatalogController@filter')->name('site.search');

		Route::post('filter', 'Site\Common\Http\Controllers\CatalogController@filter')->name('catalog.filter');

		Route::get('product/{slug}', 'Site\Common\Http\Controllers\CatalogController@show')->name('catalog.product');
		Route::get('product/{slug}/{hash}', 'Site\Common\Http\Controllers\CatalogController@show')->name('catalog.product.hash');

		Route::post('product/review', 'Site\Common\Http\Controllers\ReviewController@index');

		Route::post('product/review/create', 'Site\Common\Http\Controllers\ReviewController@create');
		Route::post('/product/review/like', 'Site\Common\Http\Controllers\ReviewController@like');


		Route::get('/{slug?}', 'Site\Common\Http\Controllers\CatalogController@index')->name('site.catalog');
		Route::post('/{slug?}', 'Site\Common\Http\Controllers\CatalogController@index')->name('site.catalog');


//		Route::get('/{slug}', 'Site\Common\Http\Controllers\CatalogController@category')->name('site.category');


		Route::get('/{slug}', 'Site\Common\Http\Controllers\CatalogController@category')
			->name('site.page')->where('slug', '.*');
		Route::post('/{slug}', 'Site\Common\Http\Controllers\CatalogController@category')
			->name('site.page')->where('slug', '.*');

	});


//    Route::get('sitemap', 'Site\Common\Http\Controllers\SiteController@sitemap')->name('site.sitemap');
//    Route::get('profile/{id}', 'Site\Http\Controllers\StatisticsController@profile')->name('site.statistics.profile');


});

