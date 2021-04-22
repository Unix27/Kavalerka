<?php


namespace Site\Common\Http\Controllers;

use App\Http\Controllers\Controller;
use Customers\Models\Customer;

use Illuminate\Database\Eloquent\Relations\Relation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Shop\Catalog\Models\CategoryTranslation;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Models\Variations;
use Shop\Orders\Repositories\OrdersRepository;
use Shop\Promocodes\Models\Promocode;
use Shop\Promocodes\Models\PromocodesCategories;
use Shop\Promocodes\Models\PromocodesProduct;

class OrderController extends Controller
{
	public function __construct()
	{
		$this->repository = app(OrdersRepository::class);
	}

	public function index(Request $request)
	{
		return view('site::pages.checkout');
	}

	public function update(){
		$products = session('cart');
		$html = view('site::pages.checkout.partials.products',['products'=> $products['products']])->render();

		return json_encode($html);
	}

	public function save(){
		$cart = session('cart');

		$attributes = request()->all();
//		exit(json_encode($attributes));
		$user_id = 0;
		if(auth()->user()){
			$user_id = auth()->user()->id;
			$attributes['customer_last_name'] = auth()->user()->first_name;
			$attributes['customer_first_name'] = auth()->user()->last_name;
			$attributes['customer_email'] = auth()->user()->email;
		}elseif(isset($attributes['create_account']) && $attributes['create_account']){
			$this->validatorAuth($attributes)->validate();
			$customer = Customer::create([
				'email' =>  $attributes['email'],
				'phone' =>  $attributes['phone'],
				'password' =>  $attributes['password'],
				'first_name' => $attributes['first_name'],
				'last_name' => $attributes['last_name'],
				'middle_name' => $attributes['middle_name'],
			]);

			$user_id = $customer->id;

			$attributes['customer_last_name'] = $customer->first_name;
			$attributes['customer_first_name'] = $customer->last_name;
			$attributes['customer_email'] = $customer->email;
		} else{
			$this->validator($attributes)->validate();

			$attributes['customer_first_name'] = $attributes['first_name'];
			$attributes['customer_last_name'] = $attributes['last_name'];
			$attributes['customer_middle_name'] = $attributes['middle_name'];
			$attributes['customer_email'] = $attributes['email'];
			$attributes['customer_phone'] = $attributes['phone'];
		}

//		$attributes['customer_id'] = $user_id;
		$attributes['status'] = 1;
		if(isset($attributes['promocode'])){
			$attributes['coupon_code'] = $attributes['promocode'];
		}

		foreach($cart['products'] as $value){
			$product = Product::find($value['product_id']);
			$price = $product->getSalePrice();
			if(isset($price->discount)){
				$price = $price->price;
			}
			if(isset($value['variation_id'])){
				$variation = Variations::find($value['variation_id']);
				$attributes['items'][] = [
					'title' => $variation->title,
					'quantity' => $value['quantity'],
					'price' => $price,
					'product_id' => $variation->id,
					'product' =>[
						'product_id' => $product->id,
					]
				];
			}else{
				$attributes['items'][] = [
					'title' => $product->title,
					'quantity' => $value['quantity'],
					'price' => $price,
					'product_id' => $product->id,
				];
			}
		}

		$order = $this->repository->create($attributes);
		session()->put('cart',[]);

		$html = view('site::pages.checkout.partials.done')->with('order',$order)->render();

		return json_encode([
			'html' => $html,
			'type' => 'order'
		]);

	}

	protected function validator(array $data){
		return Validator::make($data, [
			'phone' =>     ['required', 'regex:/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){12,16}(\s*)?$/'],
			'email' =>     ['required', 'string', 'regex:/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
				'max:255'],
		]);
	}

	protected function validatorAuth(array $data){
		return Validator::make($data, [
			'phone' =>     ['required', 'regex:/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){12,16}(\s*)?$/', 'unique:customers'],
			'email' =>     ['required', 'string', 'regex:/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
				'max:255', 'unique:customers'],
			'password' => ['required'],
		]);
	}

	public function usePromocode(){
		$input = request()->all();
		$ids = explode(',', $input['ids']);

		$promocode = Promocode::where('promocode', '=',$input['promocode'])->first();
		$products = PromocodesProduct::whereIn('product_id', $ids)->pluck('product_id');

		if(!isset($promocode)){
			return response()->json([ 'error' => __('shop.promocode_not_found') ]);
		}

		if(count($products)) {
			if(isset($promocode->quantity)) {
				if ($promocode->date_start <= \Carbon\Carbon::now()->format('Y-m-d') &&
					$promocode->date_end >= \Carbon\Carbon::now()->format('Y-m-d')) {
					$session_promocode = session()->get('promocode.promocode');

					if (isset($session_promocode) && $session_promocode == $promocode->id) {
						return response()->json([ 'error' => __('shop.used_promocode') ]);
					} else {
						$cart_products = session()->get('cart.products');
						$data['promocode'] = $promocode->id;
						$data['discount'] = 0;
						foreach($cart_products as $item) {
							$finded = array_search($item['product_id'], $products->toArray());
							if($finded !== false){
								if ($promocode->is_percent) {
									$data['discount'] += intval($item['price'] * ($promocode->discount / 100));
								} else {
									$data['discount'] += intval($item['price'] - $promocode->discount);
								}
							}
						}
						$promocode->quantity -= 1;
						$promocode->save();
						session()->put('promocode', $data);
						return response()->json([ 'success' => __('shop.activated_promocode'), 'discount' => $data['discount'] ]);
					}
				} else {
					return response()->json([ 'error' => __('shop.promocode_not_time') ]);
				}
			} else {
				return response()->json([ 'error' => __('shop.promocode_is_done') ]);
			}
		} else{
			$categories = PromocodesCategories::where('promocode_id', '=', $promocode->id)->pluck('category_id');
			$categories_title = CategoryTranslation::whereIn('category_id', $categories)
				->where('locale', '=', app()->getLocale())
				->pluck('title');

			$cats = implode(', ', $categories_title->toArray());

			return response()->json([ 'error' => __('shop.promocode_another_products') . ' ' . $cats ]);
		}
	}

}
