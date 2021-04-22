<?php


namespace Site\Common\Http\Controllers;


use App\Http\Controllers\Controller;
use Customers\Models\Customer;
use Customers\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Pages\Models\Page;
use Shop\Catalog\Models\Category;
use Shop\Catalog\Models\Product;
use Shop\Promotions\Models\Promotion;
use Shop\Promotions\Models\PromotionsCategory;


class PromotionController extends Controller
{

	public function index($category = 'women'){
		$page = Page::where('slug', '=', 'promotions')->first();
		$category = PromotionsCategory::where('slug', $category)->withCount('promotions')->first();
		$categories = PromotionsCategory::where('active', '=', 1)->withCount('promotions')->get();
		$type = 'retail';

		if(isset(auth()->user()->id) &&
						 auth()->user()->is_wholesale == true){
			$type = 'opt';
		}

		$promotions = Promotion::where('active', '=', true)
			->where('type', '=', $type)
			->where('category_id', '=', $category->id)
			->paginate(10);

		return view('site::promotions.index', compact( [ 'page', 'promotions', 'category', 'categories'] ));
	}

	public function show($slug){
		$page = Page::where('slug', $slug)->first();

		if(!$page){
			abort(404);
		}

		return view('site::pages.page', compact(['page']));
	}

}
