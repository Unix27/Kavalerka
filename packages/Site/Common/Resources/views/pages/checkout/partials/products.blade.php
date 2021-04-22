@foreach($products as $key => $item)
	@php
		$product = \Shop\Catalog\Models\Product::find($item['product_id']);
		$variation = \Shop\Catalog\Models\Variations::find($item['variation_id']);
		$price = $product->getSalePrice();
		if(isset($price->discount)){
				$price = $price->price;
		}
	@endphp
<li class="shopping-cart__item" data-price="{{ intval($item['price'] * $item['quantity']) }}">
	<a href="#" class="shopping-cart__img">
		<img src="{{ $product->image }}" alt="{{ $product->title }}">
	</a>
	<div class="shopping-cart__body">
		<div class="shopping-cart__block">
			<div class="shopping-cart__block-top">
				<h3 class="shopping-cart__title">{{ $product->title }}</h3>
			</div>
			@if(isset($variation))
				<div class="shopping-cart__block-body">
					<span class="shopping-cart__title shopping-cart__title--grey">{!! __('shop.size') !!}: {{ $variation->values()->first()->value }}</span>
				</div>
			@endif
		</div>
		@if(isset(auth()->user()->id) && auth()->user()->is_wholesale == true)
			<div class="shopping-cart__block">
				<div class="shopping-cart__block-top">
					<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">{!! __('shop.amount') !!}</h3>
				</div>
				<div class="shopping-cart__block-body">
					<select name="opt_amount">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
			</div>
		@endif
		<div class="shopping-cart__block shopping-cart__block--price">
			<div class="shopping-cart__block-top">
				<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">{!! __('shop.price') !!}</h3>
			</div>
			<div class="shopping-cart__block-body">
				<span class="shopping-cart__price">{{ intval($price) }} {!! __('shop.grn') !!}</span>
				@if(isset(auth()->user()->id) && auth()->user()->is_wholesale == true)
					<span class="shopping-cart__opt">({!! __('shop.wholesale') !!})</span>
				@endif
				<a href="#" class="shopping-cart__del js-remove-product"  data-id="{{ $key }}">
					<svg>
						<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
					</svg>
				</a>
			</div>
		</div>
	</div>
</li>
@endforeach
