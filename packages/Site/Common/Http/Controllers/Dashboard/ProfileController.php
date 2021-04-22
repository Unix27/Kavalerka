<?php


namespace Site\Common\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use Customers\Models\CustomerAddress;
use Pages\Models\Page;
use Customers\Models\Customer;
use Customers\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Customers\Models\CustomerDeliveries;
use Shop\Catalog\Models\FavoriteProduct;
use Shop\Catalog\Models\ViewedProduct;
use Shop\Orders\Models\City;
use Shop\Reviews\Models\ProductsReview;
use Shop\Reviews\Models\ShopReview;
use Shop\Catalog\Models\Product;
use Carbon\Carbon;


class ProfileController extends Controller {

    public function index(){

    		$page = Page::where('slug', '=', '/dashboard/profile')->first();

        return view('site::lk.personal-profile', compact( [ 'page' ]));
    }

    public function save(){

        $input = request()->all();

				$address = CustomerAddress::where('customer_id', auth()->user()->id)->first();

				if(!$address){
					$address = new CustomerAddress();
				}
        if(isset($input['date_of_birth'])){
					$input['date_of_birth'] = Carbon::createFromFormat('d.m.Y', $input['date_of_birth'])->toDateTimeString();
				}

        if(isset($input['address'])){
        	if(isset($input['address']['ukr_poshta'])){
						$address->ukr_poshta = $input['address']['ukr_poshta'];
					}
					$address->customer_id = auth()->user()->id;
					$address->city = $input['address']['city'];
					$address->street = $input['address']['street'];
					$address->build = $input['address']['build'];
					$address->apartment = $input['address']['apartment'];
					$address->nova_poshta = $input['address']['nova_poshta'];
					$address->np_city_code = $input['ref-city'];
					$address->np_warehouse_code = $input['ref-warehouse'];
					$address->justin = $input['address']['justin'];
					$address->save();
				}

        $customer = Customer::find(auth()->user()->id);

        $customer->fill($input);
        $customer->save();

        return response()->json(['message' => __('site.profile_updated_successfully')]);
    }

    public function changePassword(Request $request){

        $validator = Validator::make($request->all(),
            [
                'password' => 'required|confirmed|string',
                'password_confirmation' => 'required|string',
            ]
        );

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        if (Hash::check($request->old_password, auth()->user()->password)) {
            $customer = Customer::find(auth()->user()->id)->update(['password' => bcrypt($request->password_confirmation)]);
            return json_encode([
                'status' => 'success',
                'message' => __('auth.password_was_changed'),
                'customer' => $customer
            ]);

        } else {
            $response = [
                "message" => __('auth.old_password_is_wrong'),
                "status" => 'error',
            ];
            return response($response, 422);
        }
    }

		public function myReviews(){

    	$page = Page::where('slug', '=', '/dashboard/my-reviews')->first();
			$products_reviews = ProductsReview::where('customer_id', '=', auth()->user()->id)->get();
			$shop_reviews = ShopReview::where('customer_id', '=', auth()->user()->id)->get();

    	return view('site::lk.my-reviews', compact( [ 'page', 'shop_reviews', 'products_reviews' ] ));
		}

		public function wholesale(){

			$page = Page::where('slug', '=', '/dashboard/wholesale')->first();

    	return view('site::lk.wholesale', compact( [ 'page' ] ));
		}

		public function viewedProducts(){
			$page = Page::where('slug', '=', '/dashboard/viewed-products')->first();

//			$products = ViewedProduct::join('shop_products', 'product_id', '=', 'shop_products.id')
//				->join('shop_product_translations', 'shop_product_translations.product_id', '=', 'shop_products.id')
//				->where('locale', '=', app()->getLocale())
//				->where('customer_id', '=', auth()->user()->id)
//				->select('title', 'shop_product_translations.product_id', 'sku', 'shop_product_translations.description', 'price', 'image', 'is_sale', 'slug')
//				->paginate(9);

			$products = Product::join('viewed_products', 'product_id', '=', 'shop_products.id')
				->join('shop_product_translations', 'shop_product_translations.product_id', '=', 'shop_products.id')
				->where('locale', '=', app()->getLocale())
				->where('customer_id', '=', auth()->user()->id)
				->select('title', 'shop_products.id', 'shop_product_translations.product_id', 'sku', 'shop_product_translations.description', 'price', 'image', 'is_sale', 'slug')
				->paginate(9);

//			$products = auth()->user()->viewedProducts()->paginate(9);
			$count_viewed = count(ViewedProduct::where('customer_id', '=', auth()->user()->id)->get());

    	return view('site::lk.viewed-products', compact( [ 'page', 'products', 'count_viewed' ] ));
		}

		public function favoriteProducts(){

    	$request = request()->all();

    	$page = Page::where('slug', '=', '/dashboard/favorite-products')->first();
			if(auth()->user()->is_wholesale == true){
				$products = Product::join('favorite_products', 'product_id', '=', 'shop_products.id')
					->join('shop_product_translations', 'shop_product_translations.product_id', '=', 'shop_products.id')
//						->join('favorite_products', 'product_id', '=', 'shop_products.id')
					->where('locale', '=', app()->getLocale())
					->where('customer_id', '=', auth()->user()->id)
					->select('title', 'shop_products.id', 'shop_product_translations.product_id', 'sku', 'shop_product_translations.description', 'price_opt as price', 'min_opt', 'image', 'is_sale', 'slug')
					->paginate(9);
			} else {
				$products = Product::join('favorite_products', 'product_id', '=', 'shop_products.id')
					->join('shop_product_translations', 'shop_product_translations.product_id', '=', 'shop_products.id')
//						->join('favorite_products', 'product_id', '=', 'shop_products.id')
					->where('locale', '=', app()->getLocale())
					->where('customer_id', '=', auth()->user()->id)
					->select('title', 'shop_products.id', 'shop_product_translations.product_id', 'sku', 'shop_product_translations.description', 'price', 'image', 'is_sale', 'slug')
					->paginate(9);
			}
    	$count_favorite = count(FavoriteProduct::where('customer_id', auth()->user()->id)->get());

//			if(request()->ajax())
//			{
//				$data = DB::table('shops')->simplePaginate(5);
//				return response()->json('all', 200);
//			}

    	$count = $products->url(2);

//    	dd($count);
//    	$products = auth()->user()->favoriteProducts()->get();


    	return view('site::lk.favorites-products', compact( [ 'page', 'products', 'count_favorite' ] ));
		}

		public function myOrders(){

    	$page = Page::where('slug', '/dashboard/my-orders')->first();
    	$orders = auth()->user()->orders()->get();

    	return view('site::lk.my-orders', compact( [ 'page', 'orders' ] ));
		}

		public function getMoreProducts(){

    	$input = request()->all();

			$take = $input['take'];
			$skip = $input['count'];

			$currentPage = $input['current_page'];


    	if($input['type'] == 'favorites'){

				$products = FavoriteProduct::join('shop_products', 'product_id', '=', 'shop_products.id')
					->join('shop_product_translations', 'shop_product_translations.product_id', '=', 'shop_products.id')
					->where('locale', '=', app()->getLocale())
					->where('customer_id', '=', auth()->user()->id)
					->select('title', 'shop_product_translations.product_id', 'sku', 'shop_product_translations.description', 'price', 'image', 'is_sale', 'slug')
					->take($take)
					->skip($skip + (($currentPage - 1) * $take))
					->get();

				$html = '';

				foreach($products as $product){

					$html .= '<div class="card-product profile__product">
							<div class="card-product__inner">
								<div class="card-product__img">
									<a href="#">
										<img src="'. asset("/assets/img/product-women-1.jpg") .'" alt="'. $product->title .'" loading="lazy">
									</a>
									<span class="card-product__mark">New</span>
									<!--<span class="card-product__sale">- 10%</span>-->
									<button class="card-product__favorites js-remove-favorite" data-id="'. $product->product_id .'" onclick="this.classList.toggle(\'active\')">
										<svg>
											<use xlink:href="'. asset("/assets/img/sprite.svg#delete") .'"></use>
										</svg>
									</button>
								</div>
								<div class="card-product__bottom">
									<a href="#" class="card-product__title">'. $product->title .'</a>
									<select>
										<option selected hidden>'. __("shop.size") .'</option>
										<option>XS</option>
										<option>S</option>
										<option>M</option>
										<option>L</option>
										<option>XL</option>
										<option>XXL</option>
									</select>
									<div class="card-product__price">
										<span class="card-product__price-new">'. $product->price .' '. __("shop.grn") .'</span>
										<span class="card-product__price-old">740 грн.</span>
									</div>
									<a href="#" class="card-product__btn white-btn">'. __("shop.buy") .'</a>
								</div>
							</div>
						</div>';
				}

				return response()->json([
					'html' => $html,
					'count' => count($products),
					'take' => $take
				]);
			}

			if($input['type'] == 'viewed'){

				$products = ViewedProduct::join('shop_products', 'product_id', '=', 'shop_products.id')
					->join('shop_product_translations', 'shop_product_translations.product_id', '=', 'shop_products.id')
					->where('locale', '=', app()->getLocale())
					->where('customer_id', '=', auth()->user()->id)
					->select('title', 'shop_product_translations.product_id', 'sku', 'shop_product_translations.description', 'price', 'image', 'is_sale', 'slug')
					->take($take)
					->skip($skip + (($currentPage - 1) * $take))
					->get();

				$html = '';

				foreach($products as $product){

					$html .= '<div class="card-product profile__product">
							<div class="card-product__inner">
								<div class="card-product__img">
									<a href="#">
										<img src="'. asset("/assets/img/product-women-1.jpg") .'" alt="'. $product->title .'" loading="lazy">
									</a>
									<span class="card-product__mark">New</span>
									<!--<span class="card-product__sale">- 10%</span>-->
									<button class="card-product__favorites js-add-to-favorite" data-id="'. $product->product_id .'" onclick="this.classList.toggle(\'active\')">
										<svg>
											<use xlink:href="'. asset("/assets/img/sprite.svg#heart") .'"></use>
										</svg>
									</button>
								</div>
								<div class="card-product__bottom">
									<a href="#" class="card-product__title">'. $product->title .'</a>
									<select>
										<option selected hidden>'. __("shop.size") .'</option>
										<option>XS</option>
										<option>S</option>
										<option>M</option>
										<option>L</option>
										<option>XL</option>
										<option>XXL</option>
									</select>
									<div class="card-product__price">
										<span class="card-product__price-new">'. $product->price .' '. __("shop.grn") .'</span>
										<span class="card-product__price-old">740 грн.</span>
									</div>
									<a href="#" class="card-product__btn white-btn">'. __("shop.buy") .'</a>
								</div>
							</div>
						</div>';
				}
			}

			return response()->json([
				'html' => $html,
				'count' => count($products),
				'take' => $take
			]);


			return response()->json($input);
		}

		public function isWholesale(){
			$input = request()->all();

			$user = auth()->user();
			if($input['status'] == "false"){
				$user->is_wholesale = 0;
			} else {
				$user->is_wholesale = 1;
			}
			$user->save();
			return response()->json($user->is_wholesale);
		}

}
