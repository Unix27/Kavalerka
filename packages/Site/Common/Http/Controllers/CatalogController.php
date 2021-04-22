<?php


namespace Site\Common\Http\Controllers;

use App\Http\Controllers\Controller;
use Blog\Models\BlogPost;
use Customers\Models\Customer;

use Illuminate\Database\Eloquent\Relations\Relation;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Shop\Catalog\Models\Category;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Models\ProductImage;
use Shop\Catalog\Models\Video;
use Shop\Catalog\Models\Relations;
use Pages\Models\Page;
use Shop\Catalog\Models\ViewedProduct;
use Shop\Reviews\Models\ProductsReview;
use Site\Common\Http\Middleware\CatalogMiddleware;

class CatalogController extends Controller
{

	public function index($slug = '',Request $request)
	{
		$filter = $this->filter($slug);

		if(request()->ajax()) {

			return $filter;

		}else{
			$category = Category::where('slug', '=', $slug)->first();
			if(!$category){
				$category = Category::where('id', '=', session()->get('category'))->first();
				if(!$category){
					$category = Category::first();
				}
			}

			$page = $request->get('page');
			$type = $request->get('type');
			$reviews = ProductsReview::where('category_id', '=', $category->id)
				->take(3)->orderBy('created_at', 'desc')->get();

			if($type == 'page'){
				\Session::put('category', $category->id);
				$categories = Category::whereHas('parent',function ($query) use ($category){
					$query->whereIn('parent_id', [$category->id]);
				})->get();
			} else {
				$categories = $category->children()->get();
			}


			return view('site::pages.catalog')->with([
				'products' => $filter,
				'slug'     => $slug,
				'page'     => $request->get('page'),
				'type'     => $request->get('type'),
				'category' => $category,
				'reviews'  => $reviews,
				'main_category' => $category->parent()
			]);
		}
	}

	public function show($slug){
		$product = Product::where('slug', '=', $slug)->withCount('reviews')->first();
		$product->popularity += 1;
		$product->save();

		if(auth()->user()){
			$viewed = ViewedProduct::firstOrCreate(['customer_id' => auth()->user()->id,
					'product_id' => $product->id]);
			$viewed->save();
		}

		$video = Video::where('product_id', $product->id)->first();
		$product_images = ProductImage::where('product_id', $product->id)->get();

		return view('site::catalog.single', compact(['product', 'product_images', 'video', ]));
	}

	public function filter($slug = ''){

		$input = request()->all();
		$price = [400,500];
		$categories = [];
		$product = Product::query()
			->where('active',1);
		if($slug){
			$pages = ['promotions','news','sales'];
			if(in_array($slug,$pages)){
				$product = $product->where($slug,1);
			}
		}

		if(isset($input['manufacturer'])){
			$product = $product->whereHas('brand',function ($query) use ($input){
				$query->whereIn('brand_id',$input['manufacturer']);
			});
		}

		if(isset($input['gender'])){
			$product = $product->whereHas('categories',function ($query) use ($input){
				$query->whereIn('category_id',$input['gender']);
			});
			$categories = array();
			foreach($input['gender'] as $item) {
				$cat = Category::find($item);
				$categories = $cat->children()->where('status_id','=',1)
					->get();
				$ids = collect([]);
				$categories = $cat->getSubCategories($categories,$ids);
//			exit(json_encode([
//				'products' => $product,
//				'gender' => $categories,
//				'input' => $input['gender'],
//				'cat' => $cat,
//				'item' => $item
//			]));
			}
		}

		if(isset($input['categories'])){
			$product = $product->whereHas('categories',function ($query) use ($input){
				$query->whereIn('category_id',$input['categories']);
			});
		}elseif(request()->get('type') == 'category'){
			$category = request()->get('page');
			$categories = $category->children()->get();
			$cat = array($category->id);
			foreach($categories as $item){
				$cat[] = $item->id;
			}
			$product = $product->whereHas('categories',function ($query) use ($cat){
				$query->whereIn('category_id',$cat);
			});
		}

		if(isset($input['new'])){
			$product = $product->where('created_at','>',\Carbon\Carbon::now()->subDays(30));
		}

		if(isset($input['sale'])){
			$product = $product->has('discounts');
		}

		if(isset($input['pre-order'])){
			$product = $product->where('receipt_date','>',gmdate('Y-m-d H:i:s'));
		}

		$date = [];
		if(isset($input['date_in']) && $input['daterange']){
			$date = explode(' - ',$input['daterange']);

			$product = $product->where('receipt_date','>=',\Carbon\Carbon::createFromFormat('d/m/y', $date[0])->startOfMinute()->format('Y-m-d 00:00:00'))
				->where('receipt_date','<=',\Carbon\Carbon::createFromFormat('d/m/y', $date[1])->startOfMinute()->format('Y-m-d 00:00:00'));
		}

		if(isset($input['attribute'])){
			$product = $product->whereHas('attributesGet',function ($query) use ($input){
				$query->whereIn('shop_products_shop_attributes.attribute_id',$input['attribute']);
			});

		}

		if(isset($input['from_price']) && isset($input['to_price'])){
			$price = explode(';', $input['from_price']);
			$product->where('price','>=', $input['from_price'])
				->where('price','<=', $input['to_price']);
		}

		if(isset($input['stock'])){

			if($input['stock'] == 1)
				$product = $product->where('quantity','>',0);
			else
				$product = $product->where('quantity','=',0);
		}

		if(isset($input['type'])){
			if($input['type'] == 'cheap')
				$product = $product->orderBy('price','asc');
			elseif($input['type'] == 'expensive')
				$product = $product->orderBy('price','desc');
			else
				$product = $product->orderBy('popularity','asc');
		}

		if(isset($input['q'])){
			$product = $product->whereTranslationLike('title', '%'.$input['q'].'%');
		}

		$product = $product->orderBy('sort')->paginate(10);
		if(request()->ajax()) {
			exit(json_encode([
				'products' => $product,
				'html' => view('site::catalog.partials.products')->with('products',$product)->render(),
				'test' => base64_encode(json_encode($input)),
				'input' => $input,
				'json' => json_encode($input),
				'date' => \Carbon\Carbon::createFromFormat('d.m.Y', '13.02.1990')->toDateTimeString(),
				'categories' => $categories,
				'slug' => $slug,
			]));
		}else{
			return $product;
		}
	}

	public function category($slug, Request $request){
		$main_category = session()->get('category');
		if (strpos($slug, '/') !== false) {
			$strArray = explode('/', $slug);

			$lastElement = end($strArray);
			$slug = $lastElement;
		}

		$category = Category::where('slug', '=', $slug)->first();

		$page = $request->get('page');
		$type = $request->get('type');
		$categories = [];

		if($type == 'page'){
			\Session::put('category', $category->id);

			$categories = $category->children()->where('show_on_front','=',1)
				->get();

			$ids = collect([]);
			$categories = $category->getShowOnFrontCategories($categories,$ids);

//			dd($category->children()->get());
			//			$categories = Category::where('parent_id', '=', $category->id)
//				->where('status_id',1)
//				->where('show_on_front', true)
//				->get();
		} else {

			$filter = $this->filter($slug);

			$categories = $category->children()->get();
			$cat = array($category->id);
			foreach($categories as $item){
				$cat[] = $item->id;
			}

			$reviews = ProductsReview::where('category_id', '=', $category->id)
				->take(3)->orderBy('created_at', 'desc')->get();

			return view('site::pages.catalog')->with([
				'products' => $filter,
				'slug'     => $slug,
				'page'     => $request->get('page'),
				'type'     => $request->get('type'),
				'category' => $category,
				'reviews'  => $reviews,
				'main_category' => Category::find($main_category),
			]);
		}

		$popular_products = Product::whereHas('categories', function($query) use ($category) {
			$query->where('category_id', $category->id)->take(8);
		})->select('shop_products.id', 'image', 'slug', 'price')->orderBy('popularity', 'desc')
			->get();

		$new_products = Product::whereHas('categories', function($query) use ($category) {
			$query->where('category_id', $category->id)
				->where('shop_products.created_at', '>', \Carbon\Carbon::now()->subDays(60))
				->take(8);
		})->select('shop_products.id', 'image', 'slug', 'price')->orderBy('shop_products.created_at', 'desc')
			->get();

		$sale_products = Product::whereHas('categories', function($query) use ($category) {
			$query->where('category_id', $category->id)->take(8);
		})->orderBy('popularity', 'desc')
			->get();

		$reviews = ProductsReview::where('category_id', '=', $category->id)
			->take(3)->get();

		$blog = BlogPost::where('active', '=', 1)
			->orderBy('created_at', 'desc')
			->take(7)
			->get();

		return view('site::pages.category', compact( [ 'category', 'popular_products', 'reviews', 'blog', 'new_products', 'sale_products', 'categories', 'page', 'type' ] ));
	}

	public function search(Request $request){

		$title = $request['q'];
		$products = $this->filter();
//		dd($filter);
//		$products = $filter->whereTranslationLike('title', $title);

		return view('site::pages.search', compact( [ 'title', 'products' ] ));
	}

}
