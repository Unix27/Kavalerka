@extends('site::layouts.site')

@php

	@endphp

@section('seo')
	<title>{{ $page->meta_title ??  __('menu.orders') }}</title>
	<meta name="description" content="{{ $page->meta_description ?? '' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection

@section('content')
	@include('site::lk.blocks.breadcrumbs')
		<section class="profile">
			<div class="container">
				<!--Скрыть span если нету заказов-->
				<div class="profile__top">
					<h2 class="profile__title title">{{ $page->title ?? __('menu.orders') }}</h2>

					@if(count($orders))
						<span class="profile__span span">({{ count($orders) }} {!! __('site.count_orders') !!})</span>
					@endif

				</div>
				<div class="profile__inner">

					@include('site::lk.blocks.aside-menu')

					<div class="profile__content profile__content--orders">

						@if(count($orders))

							@foreach($orders as $order)
								@php
									$order_details = $order->items()->get();
									$price = 0;
								@endphp
{{--									$order_status = \Shop\Catalog\Models\Status::find($order->status_id)->first()->name;--}}

								<div class="profile__order" onclick="toggleActiveByButton(this, event)">
									<div class="profile__order-top">
										<div class="profile__order-item">
											<button class="white-btn white-btn--svg">
												<span>{!! __('shop.order_details') !!}</span>
												<svg>
													<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
												</svg>
											</button>
										</div>
										<div class="profile__order-item">
											<span class="profile__order-item-title">{!! __('shop.order_number') !!}</span>
											<span class="profile__order-item-content">{{ $order->id }}</span>
										</div>
										<div class="profile__order-item">
											<span class="profile__order-item-title">{!! __('shop.order_ttn') !!}</span>
											<span class="profile__order-item-content">20400208346270</span>
										</div>
										<div class="profile__order-item">
											<span class="profile__order-item-title">{!! __('shop.order_price') !!}</span>
											<span class="profile__order-item-content">{{ $order->total_price }} {!!  __('shop.grn') !!}</span>
										</div>
										<div class="profile__order-item">
											<span class="profile__order-item-title">{!! __('shop.order_date') !!}</span>
											<span class="profile__order-item-content">{{ date("d.m.Y", strtotime($order->created_at)) }}</span>
										</div>
										<div class="profile__order-item">
											<span class="profile__order-item-title">{!! __('shop.order_status') !!}</span>
											<span class="profile__order-item-content">{{ $order->status->name }}</span>
										</div>
									</div>
									<div class="profile__order-body">
										<div class="profile__order-body-inner">
											<div class="profile__order-products">
												<h3 class="profile__order-subtitle">{!! __('shop.order_count_products') !!} ({{ count($order_details) }})</h3>
												<ul>
													@foreach($order_details as $item)
														@php
															$price += $item->price;
																if(isset($item->variation_id)){
																	$variation = \Shop\Catalog\Models\Variations::find($item->variation_id)->first();
																}
																$product = $item->product;
														@endphp
														<li class="shopping-cart__item shopping-cart__item--mini profile__order-product">
														<a href="{{ route('site.catalog', $product->slug) }}" class="shopping-cart__img shopping-cart__img--mini">
															<img src="{{ $product->image }}" alt="{{ $product->title }}">
														</a>
														<div class="shopping-cart__body shopping-cart__body--mini">
															<div class="shopping-cart__block">
																<div class="shopping-cart__block-top shopping-cart__block-top--mini">
																	<h3 class="shopping-cart__title">{{ $item->title }}</h3>
																</div>
																<div class="shopping-cart__block-body">
																	@if(isset($variation))
																		<span class="shopping-cart__title shopping-cart__title--grey">{!! __('shop.size') !!}: {{ $variation->values()->first()->title }}</span>
																	@endif
																	<span class="shopping-cart__title shopping-cart__title--grey">{!! __('shop.count') !!}: {{ $item->quantity }}</span>
																</div>
															</div>
															<div class="shopping-cart__block shopping-cart__block--price-reverse">
																<div class="shopping-cart__block-top shopping-cart__md-d-block">

																</div>
																<div class="shopping-cart__block-body">
																	<span class="shopping-cart__price">{{ intval($item->price) }} {!! __('shop.grn') !!}</span>
{{--																	<span class="shopping-cart__price">529 грн.<span class="shopping-cart__opt">(опт)</span></span>--}}
																</div>
															</div>
														</div>
													</li>
													@endforeach

												</ul>
											</div>
											<div class="profile__order-details">
												<div class="profile__order-subtitle">{!! __('shop.order_details') !!}</div>
												<ul>

													<li class="profile__order-detail">
														<h3 class="profile__order-detail-title">{!! __('shop.recipient_name') !!}</h3>
														<div class="profile__order-detail-body">
															<span>{{ $order->customer_last_name . ' ' . $order->customer_first_name . ' ' . $order->customer_middle_name}}</span>
														</div>
													</li>
													<li class="profile__order-detail"	>
														<h3 class="profile__order-detail-title">{!! __('shop.recipient_phone') !!}</h3>
														<div class="profile__order-detail-body">
															<span>+380988888888</span>
														</div>
													</li>
													<li class="profile__order-detail">
														<h3 class="profile__order-detail-title">Email:</h3>
														<div class="profile__order-detail-body">
															<span>{{ $order->customer_email }}</span>
														</div>
													</li>
													<li class="profile__order-detail">
														<h3 class="profile__order-detail-title">{!! __('shop.delivery_method') !!}</h3>
														<div class="profile__order-detail-body">
															<span>{{ $order->shipping_method }}</span>
														</div>
													</li>
													<li class="profile__order-detail">
														<h3 class="profile__order-detail-title">{!! __('shop.delivery_address') !!}</h3>
														<div class="profile__order-detail-body">
															<span>Хмельницкая обл.,</span>
															<span>Хмельницкий р-н.,</span>
															<span>Хмельницкий,</span>
															<span>Отделение №13,</span>
															<span>ул. Черновола, д.110</span>
														</div>
													</li>
													<li class="profile__order-detail">
														<h3 class="profile__order-detail-title">{!! __('shop.order_price_with_colon') !!}</h3>
														<div class="profile__order-detail-body">
															<span>{{ count($order_details) }} {!! __('shop.count_items') !!}: {{ $price }} {!! __('shop.grn') !!}</span>
{{--															<span>{!! __('shop.delivery') !!} 50 грн</span>--}}
{{--															<span>{!! __('shop.promo_code') !!} -20 грн</span>--}}
														</div>
													</li>
													<li class="profile__order-detail profile__order-detail--total">
														<h3 class="profile__order-total-title">{!! __('shop.total_payable') !!}</h3>
														<span class="profile__order-tital-body">{{ $order->total_price }} {!! __('shop.grn') !!}</span>
													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>

							@endforeach

						@else

							<div class="profile__content-none">
								<h3 class="profile__content-none-title">{!! __('site.you_have_not_ordered_anything') !!}</h3>
							</div>

						@endif
					</div>
				</div>
			</div>
		</section>
		</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
