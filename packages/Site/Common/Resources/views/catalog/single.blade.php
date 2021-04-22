@extends('site::layouts.site')

@section('seo')
	<title>{{ $product->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $product->meta_description ?? '' }}">
	<meta name="keywords" content="{{ $product->meta_keywords ?? '' }}">
@endsection
@php
		$recomended_products = [];
    $buy_with_products = [];
    $similar_products = [];
    $reviews = $product->reviews()->get();
    $amount_reviews = $product->reviews()->where('parent_id', '=', 0)->get();
    $mean = 0;
    $sale = $product->getSalePrice();
    if(count($amount_reviews)){
			foreach($amount_reviews as $review){
					$mean += $review->rating;
			}
			$mean = intval(round($mean / $amount_reviews->count()));
    }


    foreach($product->relations()->with('product')->whereHas('product',function($query){
        $query->where('active',1);
    })->get() as $item){
        if($item->type == 'recomended'){
            $recomended_products[] = $item;
        } elseif ($item->type == 'buy_with'){
            $buy_with_products[] = $item;
        } else {
            $similar_products[] = $item;
        }
    }

	$charatcters = \Shop\Catalog\Models\AttributeValue::
					join('shop_products_shop_attributes','shop_products_shop_attributes.attribute_id','=','shop_attribute_values.id')
					->join('shop_attribute_values_translations','shop_attribute_values_translations.attribute_value_id','=','shop_attribute_values.id')

					->join('shop_attributes','shop_attributes.id','=','shop_attribute_values.attribute_id')
					->join('shop_attribute_translations','shop_attribute_translations.attribute_id','=','shop_attributes.id')

					->where('shop_products_shop_attributes.product_id','=',$product->id)
					->where('shop_attributes.active', '=', 1)
					->where('shop_products_shop_attributes.show', '=', 1)
					->where('shop_attribute_values_translations.locale', '=', app()->getLocale())
					->where('shop_attribute_translations.locale', '=', app()->getLocale())

					->select('shop_attribute_translations.title as attr_title',
					'shop_attribute_values_translations.title as value_title','shop_attributes.id as attribute_id','show','shop_attributes.image')
					->get();
    $variations = \Shop\Catalog\Models\Attribute::whereHas('products',function($q) use ($product){
        $q->where('product_id',$product->id);
    })->first();
    $in_session = false;
    if(session()->get('favorites')){
			$in_session = array_search($product->id, session()->get('favorites'));
		}
		$category = $product->categories()->first()->id;
@endphp

@section('content')
	@include('site::catalog.singlePartials.breadcrumbs')

	<section class="product">
		<div class="container">
			<div class="product__inner">
				<div class="product__major">
					<div class="product__slider">
						<div class="product__slider-minor">
							<div class="product__slider-minor-container swiper-container" id="product__slider-minor">
								<div class="product__slider-minor-wrapper swiper-wrapper">
								@foreach($product_images as $image)
									<div class="product__slider-minor-swiper-slide swiper-slide">
										<div class="product__slider-minor-img">
											<img src="{{ $image->url }}" alt="{{ $product->title }}">
										</div>
									</div>
								@endforeach
								</div>
							</div>
							<div class="product__slider-minor-button-prev swiper-button-prev" id="product-slider-minor-swiper-button-prev">
								<svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-top') }}"></use>
								</svg>
							</div>
							<div class="product__slider-minor-button-next swiper-button-next" id="product-slider-minor-swiper-button-next">
								<svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
								</svg>
							</div>
						</div>

						<div class="product__slider-major">
							<div class="product__slider-major-container swiper-container" id="product__slider-major">
								<div class="product__slider-major-wrapper swiper-wrapper">
								@foreach($product_images as $image)
									<div class="product__slider-major-swiper-slide swiper-slide">
										<div class="product__slider-major-img">
											<img src="{{ $image->url }}" alt="{{ $product->title }}">
											@if($product->created_at > \Carbon\Carbon::now()->subDays(60))
												<span class="product__slider-major-mark">New</span>
											@endif
											@if(isset($sale->price) && $sale->percent_status)
												<span class="product__slider-major-sale">- {{ $sale->discount }}%</span>
											@elseif(isset($sale->price) && !$sale->percent_status)
												<span class="product__slider-major-sale">- {{ intval($sale->discount) }} {!! __('shop.grn') !!}</span>
											@endif
											@if(auth()->user())
												<button class="product__slider-major-favorites js-add-to-favorite @if($product->favoriteProduct()) active @endif" onclick="this.classList.toggle('active')" data-id="{{ $product->id }}">
													<svg>
														<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
													</svg>
												</button>
											@else
												<a href="#" class="card-product__favorites js-add-to-favorite @if($in_session !== false) active @endif" onclick="this.classList.toggle('active')" data-id="{{ $product->id }}">
													<svg>
														<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
													</svg>
												</a>
											@endif
										</div>
									</div>
								@endforeach
								</div>
							</div>
						</div>
					</div>

					<div class="product__description">
						<h2 class="product__title">{{ $product->title }}</h2>
						<div class="product__options">
							<div class="product__code">
								<h3 class="product__span">{!! __('shop.sku') !!}: <span class="product__span product__span--grey">{{ $product->sku }}</span></h3>
								<h3 class="product__span">{!! __('shop.vendor_code') !!}: <span class="product__span product__span--grey">CU4361-010</span></h3>
							</div>
							<div class="product__reviews">
								<div class="product__stars js-paint-stars" data-stars="{{ $mean }}">
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
									</svg>
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
									</svg>
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
									</svg>
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
									</svg>
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
									</svg>
								</div>
								<a href="#" class="product__link js-goto-review"><span>{!! __('shop.reviews') !!} {{ $product->reviews_count }}</span></a>
							</div>
						</div>
						<div class="product__price js-product__price" data-val="{!! __('shop.grn') !!}">
							<div class="product__price-left">
								@if(isset($sale->price) && $sale->percent_status)
									<span class="product__price-current">{{ intval( $sale->price) }} {!! __('shop.grn') !!}</span>
									<span class="product__price-old">{{ $product->price }} {!! __('shop.grn') !!}</span>
								@elseif(isset($sale->price)  && !$sale->percent_status)
									<span class="product__price-current">{{ $sale->price }} {!! __('shop.grn') !!}</span>
									<span class="product__price-old">{{ $product->price }} {!! __('shop.grn') !!}</span>
								@else
									<span class="product__price-current">{{$product->price}} {!! __('shop.grn') !!}</span>
								@endif
							</div>
							<div class="product__price-right">
{{--								<span class="product__span">{!! __('shop.wholesale_price') !!}</span>--}}
								<span class="product__span">{!! __('shop.retail_price') !!}</span>
								<div class="product__svg">
									<div class="product__svg-drop-menu text">
{{--										<p>{!! __('shop.wholesale_price_desc_in_product') !!}</p>--}}
										<p>{!! __('shop.retail_price_desc_in_product') !!}</p>
									</div>
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#question') }}"></use>
									</svg>
								</div>
							</div>
						</div>
					@if(isset($variations))
						<div class="product__size">
							<div class="product__size-top">
								<span class="product__span">{!! __('shop.size') !!}:</span>
								<button class="product__link">
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#size') }}"></use>
									</svg>
									<span class="product__span">{!! __('shop.table_sizes') !!}</span>
								</button>
							</div>
							<div class="product__size-body">
								<div class="product__select select" onclick="select(this, event)">
									<button class="select__trigger">
										<span>{!! __('shop.choose_size') !!}</span>
										<input type="number" placeholder="{!! __('shop.enter_count_items') !!}">
										<svg>
											<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
										</svg>
									</button>

									<div class="select__body">
										<span class="select__body-title">{!! __('shop.choose_size') !!}</span>
										<ul class="select__options">
{{--											@if(count($charatcters))--}}
{{--												@foreach($charatcters as $item)--}}
{{--												<li class="select__option" data-value="{{ $item->value_title }}">--}}
{{--													<span>{{ $item->value_title }}</span>--}}
{{--												</li>--}}
{{--												@endforeach--}}
{{--											@else--}}
{{--												<li class="select__option" data-value="L">--}}
{{--													<span>L - {!! __('shop.not_available') !!}</span>--}}
{{--													<button class="product__link select__not-available-btn">{!! __('shop.tell_about_admission') !!}</button>--}}
{{--												</li>--}}
{{--											@endif--}}
											@foreach($variations->values()->has('products')->get() as $key => $variation)
												@php
													$var = \Shop\Catalog\Models\Variations::where('product_id',$product->id)
														->whereHas('values',function ($q) use ($variation){
															$q->whereIn('value_id',[$variation->id]);
														},'=',1)->first();
												@endphp
												@if(isset($var))
												<li class="select__option" data-value="{{ $variation->title }}" data-id="{{ $variation->id }}">
													<span>{{ $variation->title }}</span>
												</li>
												@endif
											@endforeach
										</ul>
									</div>
									<button class="select__area" onclick="closeSelect(this)"></button>

								</div>
							</div>
						</div>
					@endif
{{--						<div class="product__count">--}}
{{--							<div class="product__count-top">--}}
{{--								<span class="product__span">{!! __('shop.amount_items') !!}:</span>--}}
{{--							</div>--}}
{{--							<div class="product__count-body">--}}
{{--								<div class="product__select select" onclick="select(this, event)">--}}
{{--									<button class="select__trigger">--}}
{{--										<span>{!! __('shop.amount_items') !!}</span>--}}
{{--										<input type="number" placeholder="{!! __('shop.enter_amount') !!}">--}}
{{--										<svg>--}}
{{--											<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>--}}
{{--										</svg>--}}
{{--									</button>--}}
{{--									<div class="select__body">--}}
{{--										<ul class="select__options">--}}
{{--											<li class="select__option selected" data-value="1">--}}
{{--												<span>1</span>--}}
{{--											</li>--}}
{{--											<li class="select__option" data-value="2">--}}
{{--												<span>2</span>--}}
{{--											</li>--}}
{{--											<li class="select__option" data-value="3">--}}
{{--												<span>3</span>--}}
{{--											</li>--}}
{{--											<li class="select__option" data-value="4">--}}
{{--												<span>4</span>--}}
{{--											</li>--}}
{{--											<li class="select__option" data-value="5">--}}
{{--												<span>5</span>--}}
{{--											</li>--}}
{{--											<li class="select__option" data-value="input">--}}
{{--												<span>{!! __('shop.enter_your_amount') !!}</span>--}}
{{--											</li>--}}
{{--										</ul>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
						<button class="product__size-btn">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#size') }}"></use>
							</svg>
							<span>{!! __('shop.choose_size_online') !!}</span>
						</button>
						<div class="product__buy" data-id="{{ $product->id }}">
							<a href="#" class="accent-btn product__buy-btn js-buy-button">{!! __('shop.buy') !!}</a>
							<a href="#" class="white-btn product__buy-btn product__buy-btn--mobile">{!! __('shop.buy_in_one_click') !!}</a>
						</div>
						<a href="#" class="product__discount product__link">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#credit-card') }}"></use>
							</svg>
							<span class="product__link">{!! __('shop.save_on_orders_with_discount') !!}</span>
						</a>
					</div>
				</div>
				<div class="product__minor">
					<div class="product__tabs">
						<div class="product__tabs-trigers" data-trigger=".product__tabs-btn" data-content=".product__tabs-content">
							<button class="white-btn product__tabs-btn active" onclick="tabChange(this, 'description')">{!! __('shop.model_description') !!}</button>
							<button class="white-btn product__tabs-btn" onclick="tabChange(this, 'about')">{!! __('shop.about_brand') !!}: {{ $product->brand()->first()->title ?? '' }}</button>
							<button class="white-btn product__tabs-btn" onclick="tabChange(this, 'delivery')">{!! __('shop.delivery_payment') !!}</button>
							<button class="white-btn product__tabs-btn" onclick="tabChange(this, 'warranty')">{!! __('shop.warranty_return') !!}</button>
							<button class="white-btn product__tabs-btn product__tabs-btn--mobile-none js-review-goto" onclick="tabChange(this, 'reviews')">{!! __('shop.reviews') !!} {{$amount_reviews->count() ?? 0}}</button>
						</div>
						<div class="product__tabs-body">
							<div class="product__tabs-content active" id="description">
								<div class="product__tabs-left">
									<h3 class="product__tabs-subtitle subtitle">{!! __('shop.characteristics') !!}</h3>
									{!! $product->characteristics !!}
								</div>
								<div class="product__tabs-right">
									<h3 class="product__tabs-subtitle subtitle">{!! __('shop.description') !!}</h3>
									<div class="product__tabs-descr text">
										{!! $product->description !!}
									</div>
								</div>
							</div>
							<div class="product__tabs-content" id="about">
								<div class="product__tabs-left">
									<h3 class="product__tabs-subtitle subtitle">{!! __('shop.title_desc_brand') !!} {{ $product->brand()->first()->title ?? '' }}</h3>
									<div class="product__tabs-descr text">
										<p>
											{{ $product->brand()->first()->description ?? '' }}
										</p>
									</div>
								</div>
								@if(isset($product->brand()->first()->image))
									<div class="product__tabs-right">
										<div class="product__tabs-img">
											<img src="{{ $product->brand()->first()->image}}" alt="{{ $product->title }}">
										</div>
									</div>
								@endif
							</div>
							<div class="product__tabs-content" id="delivery">
								<div class="product__tabs-left">
									<h3 class="product__tabs-subtitle subtitle">{!! __('shop.payment_methods') !!}</h3>

									<div class="product__tabs-paragraph">
										<h4 class="product__tabs-suptitle suptitle">{!! __('shop.payment_methods_title_1') !!}</h4>
										<div class="product__tabs-descr text">
											<p>
												{!! __('shop.payment_methods_desc_1') !!}
											</p>
										</div>
									</div>
									<div class="product__tabs-paragraph">
										<h4 class="product__tabs-suptitle suptitle">{!! __('shop.payment_methods_title_2') !!}</h4>
										<div class="product__tabs-descr text">
											<p>
												{!! __('shop.payment_methods_desc_2') !!}
											</p>
										</div>
									</div>
									<div class="product__tabs-paragraph">
										<h4 class="product__tabs-suptitle suptitle">{!! __('shop.payment_methods_title_3') !!}</h4>
										<div class="product__tabs-descr text">
											<p>
												{!! __('shop.payment_methods_desc_3') !!}
											</p>
										</div>
									</div>
								</div>
								<div class="product__tabs-right">
									<h3 class="product__tabs-subtitle subtitle">{!! __('shop.shipment_methods') !!}</h3>
									<div class="product__tabs-paragraph">
										<h4 class="product__tabs-suptitle suptitle">{!! __('shop.shipment_methods_title_1') !!}</h4>
										<div class="product__tabs-descr text">
											<p>
												{!! __('shop.shipment_methods_desc_1') !!}
											</p>
										</div>
									</div>
									<div class="product__tabs-paragraph">
										<h4 class="product__tabs-suptitle suptitle">{!! __('shop.shipment_methods_title_2') !!}</h4>
										<div class="product__tabs-descr text">
											<p>
												{!! __('shop.shipment_methods_desc_2') !!}
											</p>
										</div>
									</div>
									<div class="product__tabs-paragraph">
										<h4 class="product__tabs-suptitle suptitle">{!! __('shop.shipment_methods_title_3') !!}</h4>
										<div class="product__tabs-descr text">
											<p>
												{!! __('shop.shipment_methods_desc_3') !!}
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="product__tabs-content" id="warranty">
								<div class="product__tabs-left">
									<h3 class="product__tabs-subtitle subtitle">{!! __('shop.warranty') !!}</h3>
									<div class="product__tabs-descr">
										<p>
											{!! __('shop.warranty_product_desc') !!}
										</p>
									</div>
								</div>
								<div class="product__tabs-right">
									<h3 class="product__tabs-subtitle subtitle">{!! __('shop.return') !!}</h3>
									<div class="product__tabs-descr">
										<p>
											{!! __('shop.warranty_product_desc') !!}
										</p>
										<p>{!! __('site.you_can_look_here') !!} <a href="{{ route('site.warranty_return') }}" class="product__link"><span>{!! __('site.here') !!}</span></a></p>
									</div>
								</div>
							</div>
							<div class="product__tabs-content" id="reviews">
								<div class="profile__reviews-wrapper">
									<div class="product__tabs-top">
										<h3 class="product__tabs-subtitle subtitle">{!! __('site.reviews') !!}<span class="product__span">({{ $reviews->count() ?? 0 }})</span></h3>
										<button onclick="toggleModal('modal-give-feedback-product')" class="product__link">{!! __('site.leave_review_about_product') !!}</button>
									</div>
									<div class="product__reviews-inner">
									@foreach($reviews as $review)
										@if($review->parent_id > 0)
											@continue
										@endif
										@php
											$answer = $review->answer()->first();
										@endphp

										<div class="profile__review">
											<div class="profile__review-inner">
												<div class="profile__review-body">
													<div class="profile__review-top">
														<div class="profile__review-top-left">
															<div class="profile__review-title">{{ $review->name }}</div>
															<div class="profile__review-date">{{ date("d.m.Y", strtotime($review->created_at)) }}</div>
														</div>
														<div class="profile__review-top-right">
															<div class="profile__review-stars js-paint-stars" data-stars="{{ $review->rating }}">
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
															</div>
														</div>
													</div>
													<div class="profile__review-text">
														<p>
															{{ $review->comment }}
														</p>
													</div>
													@if(isset($answer))
														<div class="profile__review-answer">
															<div class="profile__review-answer-title">{!! __('site.admin_answer') !!}</div>
															<div class="profile__review-answer-text">
																<p>
																	{{ $answer->comment }}
																</p>
															</div>
														</div>
													@endif
												</div>
											</div>
										</div>

									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
				</div></div>
		</div>
	</section>

	@if(isset($similar_products) && $similar_products)
		<section class="other-products">
			<div class="container">
				<h2 class="other-products__title accent-title">{!! __('shop.similar_products') !!}</h2>
				<div class="other-products__inner">
					<div class="other-products-swiper swiper-container" id="other-products">
						<div class="other-products-swiper-wrapper swiper-wrapper">
							@foreach($similar_products as $item)
								@php
									$sim_product = $item->product()->first();
									if(session()->get('favorites')){
										$in_session = array_search($sim_product->id, session()->get('favorites'));
									}
									$sale = $sim_product->getSalePrice();
								@endphp
								@if(isset($sim_product->slug))
									<div class="card-product other-products-swiper-slide swiper-slide">
										<div class="card-product__inner">
											<div class="card-product__img">
												<a href="{{ route('catalog.product', ['slug' => $sim_product->slug ?? '#']) }}">
													<img src="{{ $sim_product->image }}" alt="{{ $sim_product->title }}" loading="lazy">
												</a>
												@if($sim_product->created_at > \Carbon\Carbon::now()->subDays(60))
													<span class="card-product__mark">New</span>
												@endif
												@if(isset($sale->percent_status) && $sale->percent_status)
													<span class="card-product__sale">-{{ intval($sale->discount) }}%</span>
												@elseif(isset($sale->percent_status) && $sale->percent_status == false)
													<span class="card-product__sale">{{ intval($sale->discount) . ' ' . __('shop.grn') }}</span>
												@endif
												@if(auth()->user())
													<a href="#" class="card-product__favorites js-add-to-favorite @if($sim_product->favoriteProduct()) active @endif" onclick="this.classList.toggle('active')" data-id="{{ $sim_product->id }}">
														<svg>
															<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
														</svg>
													</a>
												@else
													<a href="#" class="card-product__favorites js-add-to-favorite @if($in_session !== false) active @endif" onclick="this.classList.toggle('active')" data-id="{{ $sim_product->id }}">
														<svg>
															<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
														</svg>
													</a>
												@endif
											</div>
											<div class="card-product__bottom">
												<a href="{{ route('catalog.product', ['slug' => $sim_product->slug ?? '#']) }}" class="card-product__title">{{ $sim_product->title }}</a>
												<div class="card-product__price">
													@if(isset($sale->price) && $sale->percent_status)
														<span class="card-product__price-old">{{ $sim_product->price }}</span>
														<span class="card-product__price-new">{{ intval($product->price - $sale->price) }} {!! __('shop.grn') !!}</span>
													@elseif(isset($sale->price)  && !$sale->percent_status)
														<span class="card-product__price-old">{{ $sim_product->price }}</span>
														<span class="card-product__price-new">{{ $sale->price }} {!! __('shop.grn') !!}</span>
													@else
														<span class="card-product__price-new">{{$sim_product->price}} {!! __('shop.grn') !!}</span>
													@endif
												</div>
												<a href="{{ route('catalog.product', ['slug' => $sim_product->slug ?? '#']) }}" class="card-product__btn white-btn">{!! __('shop.buy') !!}</a>
											</div>
										</div>
									</div>
								@endif
							@endforeach
						</div>
					</div>
					<div class="accent-arrow accent-arrow--border swiper-button-prev" id="other-products-swiper-button-prev">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-left') }}"></use>
						</svg>
					</div>
					<div class="accent-arrow accent-arrow--border swiper-button-next" id="other-products-swiper-button-next">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-right') }}"></use>
						</svg>
					</div>
				</div>
			</div>
		</section>
	@endif
	@if(isset($recomended_products) && $recomended_products)
		<section class="viewed-products">
			<div class="container">
				<h2 class="viewed-products__title accent-title">{!! __('shop.viewed_products') !!}</h2>
				<div class="viewed-products__inner">
					<div class="viewed-products-swiper swiper-container" id="viewed-products">
						<div class="viewed-products-swiper-wrapper swiper-wrapper">
						@foreach($recomended_products as $item)
							@php
								$rec_product = $item->product()->first();
								$sale = $rec_product->getSalePrice();
								if(session()->get('favorites')){
									$in_session = array_search($rec_product->id, session()->get('favorites'));
								}
							@endphp
							@if(isset($rec_product->slug))
								<div class="card-product viewed-products-swiper-slide swiper-slide">
									<div class="card-product__inner">
										<div class="card-product__img">
											<a href="{{ route('catalog.product', ['slug' => $rec_product->slug ?? '#']) }}">
												<img src="{{ $rec_product->image }}" alt="{{ $rec_product->title }}" loading="lazy">
											</a>
											@if($rec_product->created_at > \Carbon\Carbon::now()->subDays(60))
												<span class="card-product__mark">New</span>
											@endif
											@if(isset($sale->percent_status) && $sale->percent_status)
												<span class="card-product__sale">-{{ intval($sale->discount) }}%</span>
											@elseif(isset($sale->percent_status) && $sale->percent_status == false)
												<span class="card-product__sale">{{ intval($sale->discount) . ' ' . __('shop.grn') }}</span>
											@endif
											@if(auth()->user())
												<a href="#" class="card-product__favorites js-add-to-favorite @if($rec_product->favoriteProduct()) active @endif" onclick="this.classList.toggle('active')" data-id="{{ $rec_product->id }}">
													<svg>
														<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
													</svg>
												</a>
											@else
												<a href="#" class="card-product__favorites js-add-to-favorite @if($in_session !== false) active @endif" onclick="this.classList.toggle('active')" data-id="{{ $rec_product->id }}">
													<svg>
														<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
													</svg>
												</a>
											@endif
										</div>
										<div class="card-product__bottom">
											<a href="{{ route('catalog.product', ['slug' => $rec_product->slug ?? '#']) }}" class="card-product__title">{{ $rec_product->title }}</a>
											<div class="card-product__price">
												@if(isset($sale->price) && $sale->percent_status)
													<span class="card-product__price-old">{{ $rec_product->price }}</span>
													<span class="card-product__price-new">{{ intval($product->price - $sale->price) }} {!! __('shop.grn') !!}</span>
												@elseif(isset($sale->price)  && !$sale->percent_status)
													<span class="card-product__price-old">{{ $rec_product->price }}</span>
													<span class="card-product__price-new">{{ $sale->price }} {!! __('shop.grn') !!}</span>
												@else
													<span class="card-product__price-new">{{$rec_product->price}} {!! __('shop.grn') !!}</span>
												@endif
											</div>
											<a href="{{ route('catalog.product', ['slug' => $rec_product->slug ?? '#']) }}" class="card-product__btn white-btn">{!! __('shop.buy') !!}</a>
										</div>
									</div>
								</div>
							@endif
						@endforeach
						</div>
					</div>
					<div class="accent-arrow accent-arrow--border swiper-button-prev" id="viewed-products-swiper-button-prev">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-left') }}"></use>
						</svg>
					</div>
					<div class="accent-arrow accent-arrow--border swiper-button-next" id="viewed-products-swiper-button-next">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-right') }}"></use>
						</svg>
					</div>
				</div>
			</div>
		</section>
	@endif
</main>

<div class="modal" id="modal-give-feedback-product">
	<button onclick="toggleModal('modal-give-feedback-product')" class="modal__area"></button>
	<div class="modal__body">
		<button onclick="toggleModal('modal-give-feedback-product')" class="modal__close">
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
			</svg>
		</button>
		<form action="#" method="POST" class="js-leave-reviews">
			<div class="modal__content modal__content--m-w-718">
				<h2 class="modal__title accent-title">{!! __('site.leave_review_about_product_title') !!}</h2>
				<div class="modal__review">
					<div class="modal__inputs">
						<input name="name" type="text" placeholder="{!! __('site.your_name') !!}" required>
						<input name="email" type="email" value="@if(auth()->user()) {{ auth()->user()->email }} @else {!! __('site.your_email') !!} @endif" required>
						<textarea name="comment" placeholder="{!! __('site.your_review') !!}" required></textarea>
						<input type="hidden" name="product_id" value="{{ $product->id }}">
						<input type="hidden" name="category_id" value="{{ $category['id'] }}">
					</div>
					<div class="modal__grade">
						<p>{!! __('site.your_rating') !!}:</p>
						<div class="product__stars">
							<label>
								<input type="radio" name="rating" value="1" onchange="changeRating(this)">
								<svg class="star" id="star-1">
									<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
								</svg>
							</label>
							<label>
								<input type="radio" name="rating" value="2" onchange="changeRating(this)">
								<svg class="star" id="star-2">
									<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
								</svg>
							</label>
							<label>
								<input type="radio" name="rating" value="3" onchange="changeRating(this)">
								<svg class="star" id="star-3">
									<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
								</svg>
							</label>
							<label>
								<input type="radio" name="rating" value="4" onchange="changeRating(this)">
								<svg class="star" id="star-4">
									<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
								</svg>
							</label>
							<label>
								<input type="radio" name="rating" checked value="5" onchange="changeRating(this)">
								<svg class="star" id="star-5">
									<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
								</svg>
							</label>
						</div>
					</div>
					<div class="modal__btns">
						@if(auth()->user())
							<button  class="modal__btn accent-btn js-send-review">{!! __('site.leave_review_button') !!}</button>
						@else
							<button onclick="toggleModal('modal-give-feedback-fail');" class="modal__btn accent-btn">{!! __('site.leave_review_button') !!}</button>
						@endif
					</div>
					<!--если успешно - toggleModal('modal-give-feedback-fail');-->
					{{--				onclick="toggleModal('modal-give-feedback');toggleModal('modal-give-feedback-success');"--}}
				</div>
				<div class="modal__text modal__text--grey">
					<p>{!! __('site.publish_your_review_after_moderating') !!}</p>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
