<?php


namespace Site\Common\Http\Controllers;


use App\Http\Controllers\Controller;
use Blog\Models\BlogPost;
use Core\Settings\Models\DiscountsSystem;
use Customers\Models\Customer;
use Customers\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Pages\Models\Page;
use Shop\Catalog\Models\Brand;
use Shop\Catalog\Models\Category;
use Shop\Catalog\Models\Discounts;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Models\Settings;
use Shop\Reviews\Models\ProductsReview;
use Shop\Reviews\Models\ShopReview;


class SiteController extends Controller
{
	public function index(){
		$page = Page::where('slug', '=', '/')->first();
		$category_id = session()->get('category');
		$seo_text = Settings::where('name', '=', 'main_page_post_content')
			->where('locale', '=', app()->getLocale())->first();

		$blog = BlogPost::where('active', '=', 1)
			->orderBy('created_at', 'desc')
			->take(7)
			->get();

		$women_popular_product = Product::join('shop_products_shop_categories', 'product_id', '=', 'shop_products.id')
			->join('shop_product_translations', 'shop_product_translations.product_id', '=', 'shop_products.id')
			->where('category_id', '=', 55)
			->where('active', '=', 1)
			->where('locale', app()->getLocale())
			->where('slug', '!=', '')
			->orderBy('popularity', 'desc');
//			->select('title', 'shop_products.id', 'image', 'slug', 'price')
//			->take(8)
//			->get();

		$men_popular_product = Product::join('shop_products_shop_categories', 'product_id', '=', 'shop_products.id')
			->join('shop_product_translations', 'shop_product_translations.product_id', '=', 'shop_products.id')
			->where('category_id', '=', 56)
			->where('active', '=', 1)
			->where('locale', app()->getLocale())
			->where('slug', '!=', '')
			->orderBy('popularity', 'desc');
//			->take(8)
//			->select('title', 'shop_products.id', 'image', 'slug', 'price')
//			->get();

		$children_popular_product = Product::join('shop_products_shop_categories', 'product_id', '=', 'shop_products.id')
			->join('shop_product_translations', 'shop_product_translations.product_id', '=', 'shop_products.id')
			->where('category_id', '=', 57)
			->where('locale', app()->getLocale())
			->where('slug', '!=', '')
			->where('active', '=', 1)
			->orderBy('popularity', 'desc');
//			->select('title', 'shop_products.id', 'image', 'slug', 'price')
//			->take(8)
//			->get();

		$shop_reviews = ShopReview::where('parent_id', '=', 0)
			->take(3)
			->orderBy('created_at', 'desc')
			->get();

//		if(isset($category_id)){
//			$category = Category::where('id', '=', $category_id)->first();
//
//			return redirect()->route('site.page', $category->slug)->with('category');
//		}

		if(isset(auth()->user()->is_wholesale) && auth()->user()->is_wholesale == true){
			return view('site::pages.home')->with([
				'page' => $page,
				'blog' => $blog,
				'shop_reviews' => $shop_reviews,
				'seo_text' => $seo_text,
				'women_popular_product' => $women_popular_product->select('title', 'shop_products.id', 'image', 'slug', 'price_opt as price', 'min_opt')
					->take(8)->get(),
				'men_popular_product' => $men_popular_product->select('title', 'shop_products.id', 'image', 'slug', 'price_opt as price', 'min_opt')
					->take(8)->get(),
				'children_popular_product' => $children_popular_product->select('title', 'shop_products.id', 'image', 'slug', 'price_opt as price', 'min_opt')
					->take(8)->get(),
			]);
		} else {
			return view('site::pages.home')->with([
				'page' => $page,
				'blog' => $blog,
				'shop_reviews' => $shop_reviews,
				'seo_text' => $seo_text,
				'women_popular_product' => $women_popular_product->select('title', 'shop_products.id', 'image', 'slug', 'price')
					->take(8)->get(),
				'men_popular_product' => $men_popular_product->select('title', 'shop_products.id', 'image', 'slug', 'price')
					->take(8)->get(),
				'children_popular_product' => $children_popular_product->select('title', 'shop_products.id', 'image', 'slug', 'price')
					->take(8)->get(),
			]);
		}
	}

	public function show($slug){
		$page = Page::where('slug', $slug)->first();

		if(!$page){
			abort(404);
		}

		return view('site::pages.page', compact(['page']));
	}

	public function reviews(){

		$page = Page::where('slug', '=', 'reviews-about-company')->first();
		$amount_reviews = count(ShopReview::where('parent_id', 0)->where('is_verified', '=', true)->get());
		$reviews = ShopReview::where('is_verified', '=', true)->paginate(5);

		return view('site::pages.reviews', compact( [ 'page', 'amount_reviews', 'reviews' ] ));
	}

	public function deliveryPayment(){

		$page = Page::where('slug', '=', 'delivery-and-payment')->first();

		return view('site::pages.delivery', compact( [ 'page' ] ));
	}

	public function warrantyReturn(){

		$page = Page::where('slug', '=', 'warranty-and-return')->first();

		return view('site::pages.warranty-and-return', compact( [ 'page' ] ));
	}

	public function discount(){

		$page = Page::where('slug', '=', 'discount')->first();

		$discounts = DiscountsSystem::where('active', '=', true)->get();

		return view('site::pages.discount', compact( [ 'page', 'discounts' ] ));
	}

	public function sendReview(){
		$input = request()->all();

		if(isset($input['product_id']) && $input['product_id']){
			$review = new ProductsReview();

			$review->rating = $input['rating'];
			$review->product_id = $input['product_id'];
			$review->category_id = $input['category_id'];
			$review->name = $input['name'];
			$review->email = $input['email'];
			$review->comment = $input['comment'];
			$review->customer_id = auth()->user()->id;

			$review->save();
		} else {
			$review = new ShopReview();
			$review->fill($input);
			$review->customer_id = auth()->user()->id;

			$review->save();
		}
		return response()->json($input);
	}

	public function brands(){

		$page = Page::where('slug', '=', 'brands')->first();
		$brands = Brand::all();

		return view('site::pages.brands', compact( [ 'page', 'brands', ] ));
	}
}
