@if(isset($value['product_id']))
	@php
		$product = \Shop\Catalog\Models\Product::find($value['product_id']);
		$variation = \Shop\Catalog\Models\Variations::find($value['variation_id']);
		$price = $product->getSalePrice($variation);
		if(isset($price->discount)){
			$price = $price->price;
		}
	@endphp
	<li class="shopping-cart__item shopping-cart__item--mini js-shop-cart"
			data-quantity="{{$value['quantity']}}"
			data-price="{{ intval($price * $value['quantity']) }}"
			data-id="{{ $product->id }}"
		>
		<a href="{{ route('catalog.product', $product->slug) }}" class="shopping-cart__img shopping-cart__img--mini">
			<img src="{{ $product->image }}" alt="#">
		</a>
		<div class="shopping-cart__body shopping-cart__body--mini">
			<div class="shopping-cart__block">
				<div class="shopping-cart__block-top shopping-cart__block-top--mini">
					<h3 class="shopping-cart__title">{{ $product->title }}</h3>
				</div>
				@if(isset($variation))
					<div class="shopping-cart__block-body">
						<span class="shopping-cart__title shopping-cart__title--grey">{!! __('shop.size') !!}: {{ $variation->values()->first()->value }}</span>
						@if(isset(auth()->user()->is_wholesale) && auth()->user()->is_wholesale == true)
							<span class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">{!! __('shop.count') !!}: {{$value['quantity']}}</span>
							<div class="shopping-cart__md-d-block">
								<select>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
								</select>
							</div>
						@endif
					</div>
				@endif
			</div>
			<div class="shopping-cart__block shopping-cart__block--price">
				<div class="shopping-cart__block-top shopping-cart__md-d-block">

				</div>
				<div class="shopping-cart__block-body">
					<span class="shopping-cart__price">{{ intval($price * $value['quantity']) }} {!! __('shop.grn') !!}</span>
					@if(isset(auth()->user()->is_wholesale) && auth()->user()->is_wholesale == true)
						<span class="shopping-cart__opt">(опт)</span>
					@endif
					<a href="#" class="shopping-cart__del shopping-cart__del--mini js-remove-product" data-id="{{ $key }}">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
						</svg>
					</a>
				</div>
			</div>
		</div>
	</li>
@endif
