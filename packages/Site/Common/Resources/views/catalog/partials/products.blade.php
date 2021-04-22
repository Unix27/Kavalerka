@foreach($products as $product)
	@php
		$sale = $product->getSalePrice();
		$in_session = false;
		if(session()->get('favorites')){
			$in_session = array_search($product->id, session()->get('favorites'));
		}
		if(isset($sale->discount)){
				$sale = $product->discounts()->first();
		}
	@endphp
	<div class="card-product catalog__item">
		<div class="card-product__inner">
			<div class="card-product__img">
				<a href="{{ route('catalog.product', [ 'slug' => $product->slug ?? '#'])}}">
					<img src="{{ $product->image }}" alt="{{ $product->title }}" loading="lazy">
				</a>
				@if($product->created_at > \Carbon\Carbon::now()->subDays(60))
					<span class="card-product__mark">New</span>
				@endif
				@if(isset($sale['is_percent']) && $sale['is_percent'])
					<span class="card-product__sale">- {{ intval($sale['price']) }}%</span>
				@elseif(isset($sale['is_percent']) && !$sale['is_percent'])
					<span class="card-product__sale">- {{ intval($sale['price']) }} {!! __('shop.grn') !!}</span>
				@endif
				@if(auth()->user())
					<a href="#" class="card-product__favorites js-add-to-favorite @if($product->favoriteProduct()) active @endif" onclick="this.classList.toggle('active')" data-id="{{ $product->id }}">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
						</svg>
					</a>
				@else
					<a href="#" class="card-product__favorites js-add-to-favorite @if($in_session !== false) active @endif" onclick="this.classList.toggle('active')" data-id="{{ $product->id }}">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
						</svg>
					</a>
				@endif
			</div>
			<div class="card-product__bottom">
				<a href="{{ route('catalog.product', [ 'slug' => $product->slug ?? '#'])}}" class="card-product__title">{{ $product->title }}</a>
				<div class="card-product__price">
					@if(isset($sale['is_percent']) && $sale['is_percent'])
						<span class="card-product__price-old">{{ $product->price }}</span>
						<span class="card-product__price-new">{{ intval($product->price) - intval($product->price * $sale['price'] / 100) }} {!! __('shop.grn') !!}</span>
					@elseif(isset($sale['is_percent'])  && !$sale['is_percent'])
						<span class="card-product__price-old">{{ $product->price }}</span>
						<span class="card-product__price-new">{{ intval($product->price - $sale['price']) }} {!! __('shop.grn') !!}</span>
					@else
						<span class="card-product__price-new">{{$product->price}} {!! __('shop.grn') !!}</span>
					@endif
				</div>
				<a href="{{ route('catalog.product', [ 'slug' => $product->slug ?? '#'])}}" class="card-product__btn white-btn">{!! __('shop.buy') !!}</a>
			</div>
		</div>
	</div>
@endforeach

<div class="catalog__pagination js-catalog-pagination pagination">
{{--	<a href="#" class="accent-btn pagination__btn">--}}
{{--		Показать еще 15 товаров--}}
{{--	</a>--}}
	<div class="pagination__inner">
		{{ $products->links() }}
	</div>
</div>

