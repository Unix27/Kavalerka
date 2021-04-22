@extends('site::layouts.site')
@php
	$page = \Pages\Models\Page::where('slug', '=', 'checkout')->first();
	$discounts = \Core\Settings\Models\DiscountsSystem::all();
	$cart = session()->get('cart');
	$discount_system = $cart['discount_system'] ?? 0;
	if(isset(auth()->user()->id)){
    $address = auth()->user()->addresses()->first();
	}
@endphp
@section('seo')
	<title>{{ $page->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $page->meta_description ??'' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection
@section('content')
	@include('site::lk.blocks.breadcrumbs')

	<section class="order">
		<div class="container">
			<h2 class="order__title title">{{ $page->title ?? '' }}</h2>
			<div class="order__inner">
					@if($cart['products'])
						<div class="order__box authorization__box js-d-none-wrapper" @if(isset($cart['products']) && count($cart['products'])) style="display: block" @else style="display: none" @endif>
						@if(!auth()->user())
							<div class="authorization__top" data-trigger=".authorization__trigger" data-content=".authorization__content">
								<div class="authorization__trigger active" onclick="tabChange(this, 'registration')">
									<div class="authorization__trigger-inner">
										<label>
											<input name="create_account" type="checkbox" onchange="toggleInput(this, 'registration-input')" value="1">
											<svg>
												<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
											</svg>
										</label>
										<h3 class="order__box-title">{!! __('site.registration') !!} <span class="order__box-span">{!! __('site.register_per_checkout') !!}</span></h3>
									</div>
								</div>
								<div class="authorization__trigger" onclick="tabChange(this, 'authorization')">{!! __('site.auth') !!}</div>
							</div>
						@endif
							<div class="authorization__body  order__body">
							<form action="#" method="POST" id="js-create-order">
								@csrf
								<div class="authorization__content active order__registration" id="registration">
								<h3 class="minor-title order__subtitle">{!! __('site.data_customer') !!}</h3>
								<div class="order__inputs">
									<input name="first_name" type="text" placeholder="{!! __('site.name') !!} *" @if(isset(auth()->user()->first_name)) value="{{ auth()->user()->first_name }}" @endif required>
									<input name="last_name" type="text" placeholder="{!! __('site.last_name') !!}" @if(isset(auth()->user()->last_name)) value="{{ auth()->user()->last_name }}" @endif>
									<input name="middle_name" type="text" placeholder="{!! __('site.middle_name') !!}" @if(isset(auth()->user()->middle_name)) value="{{ auth()->user()->middle_name }}" @endif>
									<input name="phone" id="tel" type="tel" placeholder="{!! __('site.phone_number') !!} *" @if(isset(auth()->user()->phone)) value="{{ auth()->user()->phone }}" @endif>
									<input name="email" type="email" placeholder="Email *" @if(isset(auth()->user()->email)) value="{{ auth()->user()->email }}" @endif>
									<input name="password" type="password" placeholder="{!! __('site.password') !!}" id="registration-input">
								</div>
								<h3 class="minor-title order__subtitle">{!! __('site.data_customer') !!}</h3>
								<div class="order__selects">

									<select name="method_delivery" class="js-select-required">
										<option hidden>{!! __('site.method_delivery') !!}</option>
										<option value="Новая Почта" data-id="3">{!! __('site.delivery_nova_poshta') !!}</option>
										<option value="УкрПочта" data-id="2">{!! __('site.delivery_ukr_poshta') !!}</option>
										<option value="JustIn" data-id="4">{!! __('site.delivery_justin') !!}</option>
										<option value="Самовывоз" data-id="1">{!! __('site.yourself') !!}</option>
									</select>

									<select name="your_city" class="order-city-picker" data-live-search="true" style="display: none">
										@if(isset($address) && $address)
											<option selected data-ref="{{ $address->np_city_code }}" data-uuid="{{ $address->ji_city_code }}" data-code="{{ $address->up_city_code }}">{{ $address->city }}</option>
										@else
											<option hidden>{!! __('site.your_city') !!}</option>
										@endif
									</select>

									<select name="your_warehouse" class="js-delivery-warehouse" style="display: none">
										@if(isset($address) && $address)
											<option selected data-ref="{{ $address->np_warehouse_code }}" data-uuid="{{ $address->ji_warehouse_code }}" data-code="{{ $address->up_warehouse_code }}">{{ $address->nova_poshta }}</option>
										@else
											<option hidden>{!! __('site.your_warehouse') !!}</option>
										@endif
									</select>

								</div>

								<h3 class="minor-title order__subtitle">{!! __('site.method_payment') !!}</h3>
								<div class="order__selects">
									<select name="payment_method" class="js-select-required">
										<option hidden>{!! __('site.select_method_delivery') !!}</option>
										<option value="1" data-id="1">{!! __('shop.cash') !!}</option>
										<option value="2" data-id="2">{!! __('shop.cart') !!}</option>
									</select>
								</div>

								<h3 class="minor-title order__subtitle">{!! __('site.order_comment') !!}</h3>
								<div class="order__textarea">
									<textarea name="message" placeholder="{!! __('site.your_order_comment') !!}"></textarea>
								</div>

							</div>
							</form>

							<form action="#" class="authorization__content order__authorization" id="authorization">
									@csrf
								<div class="authorization__input-wrapper authorization__input-wrapper">
									<input name="email" type="email" placeholder="Email" autocomplete="email" />
									<span class="authorization__input-error">{!! __('auth.enter_email') !!}</span>
								</div>
								<div class="authorization__input-wrapper authorization__input-wrapper">
									<input name="password" type="password" placeholder="{!! __('site.password') !!}" autocomplete="current-password" />
									<svg onclick="visibilityPassword(this.previousElementSibling)">
										<use xlink:href="{{ asset('/assets/img/sprite.svg#eye') }}"></use>
									</svg>
									<span class="authorization__input-error">{!! __('auth.enter_password') !!}</span>
								</div>
								<button type="submit" class="accent-btn authorization__btn">{!! __('auth.login') !!}</button>
								<div class="authorization__forgot">
									<a href="#">{!! __('auth.forgot_password') !!}</a>
								</div>
								<div class="authorization__error"></div>
							</form>
						</div>
						<button type="submit" class="accent-btn order__submit js-order-submit">{!! __('shop.checkout') !!}</button>
					</div>

						<div class="order__shopping-cart shopping-cart js-d-none-wrapper" @if(isset($cart['products']) && count($cart['products'])) style="display: block" @else style="display: none" @endif>
						<div class="shopping-cart__inner">

								<div class="shopping-cart__top shopping-cart__top">
									<h2 class="shopping-cart__top-title title shopping-cart__top-title--nostyle">{!! __('shop.your_order') !!}</h2><span class="shopping-cart__top-span">(@if(isset($cart['products'])) {{ count($cart['products']) }} @endif {!! __('shop.count_products') !!})</span>
								</div>
								<ul>

									@include('site::pages.checkout.partials.products',['products' => $cart['products']])

								</ul>
								<div class="shopping-cart__bottom">
									<div class="shopping-cart__content">
										<input name="promocode" type="text" placeholder="{!! __('site.type_promocode') !!}">
										<button type="submit" class="shopping-cart__btn accent-btn-grey js-submit-promocode">{!! __('shop.submit') !!}</button>
										<span class="shopping-cart__success js-promocode-message" style="display: none">{!! __('shop.promocode_activated') !!}</span>
									</div>
									<div class="shopping-cart__total">
										<div class="shopping-cart__line">
											<span class="shopping-cart__title shopping-cart__title--grey">{!! __('shop.total') !!}: </span>
											<span class="shopping-cart__total-price js-product__price"></span>
										</div>
										<div class="shopping-cart__line">
											<span class="shopping-cart__span">{!! __('shop.delivery') !!}: </span>
											<span class="shopping-cart__price js-shipping-cost" data-shipping-cost="0">0 грн.</span>
										</div>
										@if(isset(auth()->user()->id) && auth()->user()->is_wholesale == true)
											<div class="shopping-cart__line">
												<span class="shopping-cart__span">Докупите товара на <a href="#">422 грн</a> чтобы оформить заказ </span>
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
												<span class="shopping-cart__price">- {{ intval($discount_system) }} {!! __('shop.grn') !!}</span>
											@else
												<span class="shopping-cart__price">0 {!! __('shop.grn') !!}</span>
											@endif
											<div class="shopping-cart__svg">
												<div class="shopping-cart__svg-drop-menu shopping-cart__svg-drop-menu--big">
													<h4 class="shopping-cart__svg-drop-menu-title subtitle">{!! __('site.discount_system') !!}</h4>
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
										<div class="shopping-cart__line js-promocode" style="display:none" data-price="">
											<span class="shopping-cart__span">{!! __('shop.promo_code') !!}: </span>
											<span class="shopping-cart__price">0 грн.</span>
										</div>
									</div>
								</div>
								<button type="submit" class="shopping-cart__main-btn accent-btn shopping-cart__lg-d-none shopping-cart__main-btn--big js-order-submit">{!! __('shop.checkout') !!}</button>
						</div>
					</div>
					@endif
					<div class="shopping-cart__none js-empty-cart" @if(isset($cart['products']) && count($cart['products'])) style="display: none" @else style="display: block"  @endif>
						<h3 class="shopping-cart__none-title">{!! __('shop.empty_basket') !!}</h3>
						<p class="shopping-cart__none-descr">{!! __('shop.you_didnt_add_any_product') !!}</p>
					</div>
			</div>
		</div>
	</section>
	</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
