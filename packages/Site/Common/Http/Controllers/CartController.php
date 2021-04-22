<?php


namespace Site\Common\Http\Controllers;


use App\Http\Controllers\Controller;
use Core\Settings\Models\DiscountsSystem;
use Customers\Models\Customer;

use Illuminate\Database\Eloquent\Relations\Relation;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Models\ProductImage;
use Shop\Catalog\Models\Variations;
use Shop\Catalog\Models\Video;
use Shop\Catalog\Models\Relations;
use Shop\Reviews\Models\ProductReview;
use Shop\Reviews\Models\ProductReviewImage;
use Shop\Reviews\Models\ProductReviewLikes;
use Spatie\SchemaOrg\Review;


class CartController extends Controller
{

	public function index(){
		$cart = session()->get('cart');

		$html = view('site::layouts.partials.'.request('template'),['products' => $cart['products']])->render();

		return json_encode($html);
	}

	public function save()
	{
		$input = request()->all();

		$id = $input['product_id'];
		$ids = $input['variations'];

		$variation = Variations::where('product_id',$id)
			->whereHas('values',function ($q) use ($ids){
				$q->whereIn('value_id',$ids);
			},'=',count($ids))->first();

		$product = Product::find($id);

		$sale = $product->getSalePrice($variation);
		$html = view('site::catalog.singlePartials.price')->with('sale',$sale)->render();

		return json_encode([
			'html' => $html,
			'input' => $input,
			'variation' => $variation
		]);
	}

	public function remove($id){
		$cart = session()->get('cart');

		if(isset($cart['total'])){
			$cart['total'] =  $cart['total'] - $cart['products'][$id]['price'];
		} else{
			$cart['total'] = 0;
		}
		if(isset($cart['discount'])){
			$cart['discount'] = $cart['discount'] - $cart['products'][$id]['discount'];
		}else {
			$cart['discount'] = $cart['products'][$id]['discount'];
		}

		unset($cart['products'][$id]);

		if(!count($cart['products'])){
			session()->forget('cart');
		} else {
			session()->put('cart',$cart);
		}

		return \Response::json('ok');
	}

	public function add(){
		$input = request()->all();
		$id    = $input['product_id'];
		$type  = 'retail';
		if(isset($input['variations'])){
			$ids   = $input['variations'];
		} else{
			$ids = null;
		}
		$cart  = session()->get('cart');
		$total_discount = 0;

		if(isset(auth()->user()->is_wholesale) && auth()->user()->is_wholesale == true){
			$type = 'opt';
		}

//		$variation = Variations::where('product_id',$id)
//			->whereHas('values',function ($q) use ($ids){
//				$q->whereIn('value_id',[$ids]);
//			},'=',1)->first();

		$variation = Variations::where('id', '=', $ids)->first();

		$product = Product::find($id);

		$discount = $product->discounts()
			->where('date_start','<=',\Carbon\Carbon::now()->format('Y/m/d H:i:s'))
			->where('date_end','>=',\Carbon\Carbon::now()->format('Y/m/d H:i:s'))
			->where('type', '=', $type)
			->first();

		$old_price = isset($variation) ? $variation->price : $product->price;
		$price = isset($variation) ? $variation->price : $product->price;

		if($discount){
			if($discount->is_percent){
				$price = $price - $price * $discount->price/100;
			}else{
				$price -= $discount->price;
			}
			$total_discount = $old_price - $price;
		}

		$data =  [
			'product_id'   => $id,
			'discount_id'  => $discount->id??null,
			'variation_id' => isset($variation->id) ? $variation->id : null,
			'old_price'    => $old_price,
			'price'        => $price,
			'discount'     => $total_discount,
			'quantity'     => $input['quantity']??1,

		];

//		exit(json_encode($cart));

		if(isset($cart['products']) && $cart['products']){
			$findProduct = false;
			foreach($cart['products'] as $key => $value){
				if(isset($variation->id)){
					if($value['product_id'] == $id && $value['variation_id'] == $variation->id) {
						$cart['products'][$key]['quantity'] = $value['quantity'] + $input['quantity']??1;
						$findProduct = true;

						break;
					}
				}
				elseif($value['product_id'] == $id){
					$cart['products'][$key]['quantity'] = $value['quantity']+ $input['quantity']??1;
					$findProduct = true;
					break;
				}
			}
			if(!$findProduct){
				$cart['products'][uniqid()] = $data;
			}
		}else{
			$cart = [];
			$cart['products'][uniqid()] = $data;
		}

		if(!isset($cart['discount_total'])){
			$cart['discount_total'] = 0;
		}

		if(isset($cart['total'])){
			if(!isset($data['discount_id'])){
				$cart['discount_total'] += $price;
			}
			$cart['total'] =  $cart['total'] + $price;
		} else{
			if(!isset($data['discount_id'])){
				$cart['discount_total'] = $price;
			}
			$cart['total'] = $price;
		}

		if(isset($cart['discount'])){
			if($discount) {
				$cart['discount'] = $cart['discount'] + $old_price - $price;
			}
		}else {
			if($discount) {
				$cart['discount'] = $old_price - $price;
			} else {
				$cart['discount'] = 0;
			}
		}

		if(!isset($cart['discount_system'])){
			$cart['discount_system'] = 0;
		}

		$discount_system = DiscountsSystem::where('total', '<=', $cart['discount_total'])
				->orderBy('total', 'DESC')
				->first();

		if(isset($discount_system) && $discount_system){
			$new_total = $cart['discount_total'] * ($discount_system->percent / 100);
			$cart['discount_system'] = $new_total;
		}

		if($id) {
			session()->put('cart', $cart);
		}
		$html = view('site::layouts.partials.cart',['products' => $cart['products']])->render();

		return json_encode($html);
	}

	public function quantity(){
		$cart = session()->get('cart');

		$cart['products'][request('id')]['quantity'] = request('quantity');

		session()->put('cart',$cart);

		$html = view('site::layouts.partials.cart-product',['value' => $cart['products'][request('id')],'key'=>request('id')])->render();

		return \Response::json($html);
	}

}
