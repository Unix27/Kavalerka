@php
	$cart = session()->get('cart');
	/*$total_discount = $cart['discount'] ?? 0;*/
	$discounts = \Core\Settings\Models\DiscountsSystem::all();
	$discount_system = $cart['discount_system'] ?? 0;
@endphp
<div class="shopping-cart__inner" data-val="{!! __('shop.grn') !!}">
	@if(isset($cart['products']) && $cart['products'])
	<div class="shopping-cart__top">
		<h2 class="shopping-cart__top-title shopping-cart__top-title--upper">{!! __('shop.basket') !!}</h2><span class="shopping-cart__top-span js-text-count" data-count="@if(isset($cart['products'])) {{ count($cart['products']) }} @endif" data-text="{!! __('shop.count_products') !!}">(@if(isset($cart['products'])) {{ count($cart['products']) }} @endif {!! __('shop.count_products') !!})</span>
	</div>
	<ul>

	@include('site::layouts.partials.cart-products',['products' => $cart['products']])

	</ul>
	<div class="shopping-cart__bottom">
		<div class="shopping-cart__content">
			<a href="{{ route('site.checkout') }}" class="shopping-cart__link shopping-cart__md-d-none">{!! __('shop.in_basket') !!}</a>
		</div>
		<div class="shopping-cart__total">
			<div class="shopping-cart__line">
				<span class="shopping-cart__title shopping-cart__title--grey">{!! __('shop.total') !!}: </span>
				<span class="shopping-cart__total-price shopping-cart__total-price--mini js-total" data-total="">0 грн.</span>
			</div>
			@if(isset(auth()->user()->is_wholesale) && auth()->user()->is_wholesale == true)
				<div class="shopping-cart__line">
					<span class="shopping-cart__span">Докупите товара на <a href="#">422 грн</a></span>
					<div class="shopping-cart__svg">
						<div class="shopping-cart__svg-drop-menu text">
							<p>Минимальная сумма оптового заказа составляет 1500 грн</p>
						</div>
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#question') }}"></use>
						</svg>
					</div>
				</div>
			@endif
			<div class="shopping-cart__line">
				<span class="shopping-cart__span">{!! __('shop.discount') !!}: </span>
				@if(isset($discount_system))
					<span class="shopping-cart__price js-discount-total" data-total-discount="{{ intval($discount_system) }}">- {{ intval($discount_system) }} {!! __('shop.grn') !!}</span>
				@else
					<span class="shopping-cart__price">0 {!! __('shop.grn') !!}</span>
				@endif
				<div class="shopping-cart__svg">
					<div class="shopping-cart__svg-drop-menu shopping-cart__svg-drop-menu--big">
						<h3 class="shopping-cart__svg-drop-menu-title subtitle">{!! __('site.discount_system') !!}</h3>
						<div class="shopping-cart__text text">
							@foreach($discounts as $item)
								<p>{!! __('site.buy_more_products') !!} {{ $item->total }} {!! __('shop.grn') !!}, {!! __('site.for_get_discount') !!} {{ $item->percent }}%.</p>
							@endforeach
						</div>
					</div>
					<svg>
						<use xlink:href="{{ asset('/assets/img/sprite.svg#question') }}"></use>
					</svg>
				</div>
			</div>
		</div>
	</div>

	<a href="{{ route('site.checkout') }}" class="shopping-cart__main-btn accent-btn">{!! __('shop.checkout') !!}</a>
	<a href="/order.html" class="shopping-cart__main-link shopping-cart__link shopping-cart__md-d-block">{!! __('shop.continue_shopping') !!}</a>
@endif
<div class="shopping-cart__none d-none" @if(isset($cart['products']) && count($cart['products'])) style="display: none;" @else style="display: block" @endif>
	<h3 class="shopping-cart__none-title">{!! __('shop.empty_basket') !!}</h3>
	<p class="shopping-cart__none-descr">{!! __('shop.you_didnt_add_any_product') !!}</p>
</div>

</div>
