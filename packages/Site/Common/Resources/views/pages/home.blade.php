@extends('site::layouts.site')
@php
	session_start();
	$cat = new \Shop\Catalog\Models\Category();
	$menu_categories = $cat->getTopMenu();
	$in_session = false;
@endphp
@section('seo')
	<title>{{ $page->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $page->meta_description ??'' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection
@section('content')

	<section class="first-screen">
		<div class="container">
			<h2 class="first-screen__title">Магазин одежды «Кавалерка»</h2>
			<div class="first-screen__inner">
				@foreach($menu_categories['categories'] as $item)
					@if(isset($item->slug))
						<a href="{{ route('site.page',['slug' => $item->slug]) }}" class="first-screen__item">
							<img src="{{ $item->image }}" alt="#">
							<div class="first-screen__item-text">
								<h3 class="first-screen__item-title">{{ $item->title }}</h3>
								<div class="first-screen__item-link link-arrow-right">
									<span>{!! __('site.in_section') !!}</span>
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#long-arrow-right') }}"></use>
									</svg>
								</div>
							</div>
						</a>
					@endif
				@endforeach
			</div>
		</div>
	</section>

	<section class="advantages">
			<div class="container">
				<div class="advantages__inner">
					<div class="advantages__item">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#fashion') }}"></use>
						</svg>
						<div class="advantages__item-text">
							<h2 class="advantages__item-title">{!! __('site.home_block_title_1') !!}</h2>
							<div class="advantages__item-descr">
								<p>
									{!! __('site.home_block_description_1') !!}
								</p>
							</div>
						</div>
					</div>
					<div class="advantages__item">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#shopping-bag') }}"></use>
						</svg>
						<div class="advantages__item-text">
							<h2 class="advantages__item-title">{!! __('site.home_block_title_2') !!}</h2>
							<div class="advantages__item-descr">
								<p>
									{!! __('site.home_block_description_2') !!}
								</p>
							</div>
						</div>
					</div>
					<div class="advantages__item">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#free-time') }}"></use>
						</svg>
						<div class="advantages__item-text">
							<h2 class="advantages__item-title">{!! __('site.home_block_title_3') !!}</h2>
							<div class="advantages__item-descr">
								<p>
									{!! __('site.home_block_description_3') !!}
								</p>
							</div>
						</div>
					</div>
					<div class="advantages__item">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#delivery-box') }}"></use>
						</svg>
						<div class="advantages__item-text">
							<h2 class="advantages__item-title">{!! __('site.home_block_title_4') !!}</h2>
							<div class="advantages__item-descr">
								<p>
									{!! __('site.home_block_description_4') !!}
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

	@if(count($women_popular_product))
		<section class="popular-products">
			<div class="container">
				<h2 class="popular-products__title accent-title">{!! __('site.popular_women_products_title') !!}</h2>
				<div class="popular-products__inner">

					@foreach($women_popular_product as $product)
						@php
							$sale = $product->getSalePrice();
							if(session()->get('favorites')){
								$in_session = array_search($product->product_id, session()->get('favorites'));
							}
						@endphp
						<div class="card-product popular-products__item">
							<div class="card-product__inner">
								<div class="card-product__img">
									<a href="{{ route('catalog.product', $product->slug) }}">
										<img src="{{ $product->image }}" alt="{{ $product->title }}">
									</a>
									@if($product->created_at > \Carbon\Carbon::now()->subDays(60))
										<span class="card-product__mark">New</span>
									@endif
									@if(isset($sale->percent_status) && $sale->percent_status)
										<span class="card-product__sale">-{{ intval($sale->discount) }}%</span>
									@elseif(isset($sale->percent_status) && $sale->percent_status == false)
										<span class="card-product__sale">{{ intval($sale->discount) . ' ' . __('shop.grn') }}</span>
									@endif
									@if(auth()->user())
										<a href="#" class="card-product__favorites js-add-to-favorite @if($product->favoriteProduct()) active @endif" onclick="this.classList.toggle('active')" data-id="{{ $product->id }}">
											<svg>
												<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
											</svg>
										</a>
									@else
										<a href="#" class="card-product__favorites js-add-to-favorite @if(isset($in_session)) active @endif" onclick="this.classList.toggle('active')" data-id="{{ $product->id }}">
											<svg>
												<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
											</svg>
										</a>
									@endif
								</div>
								<div class="card-product__bottom">
									<a href="{{ route('catalog.product', $product->slug) }}" class="card-product__title">{{ $product->title }}</a>
									<div class="card-product__price">
										@if(isset($sale->price) && $sale->percent_status)
											<span class="card-product__price-old">{{ $product->price }}</span>
											<span class="card-product__price-new">{{ intval($product->price - $sale->price) }} {!! __('shop.grn') !!}</span>
										@elseif(isset($sale->price)  && !$sale->percent_status)
											<span class="card-product__price-old">{{ $product->price }}</span>
											<span class="card-product__price-new">{{ $sale->price }} {!! __('shop.grn') !!}</span>
										@else
											<span class="card-product__price-new">{{$product->price}} {!! __('shop.grn') !!}</span>
										@endif
									</div>
									<a href="{{ route('catalog.product', $product->slug) }}" class="card-product__btn white-btn">{!! __('shop.buy') !!}</a>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</section>
	@endif

	@if(count($men_popular_product))
		<section class="popular-products">
			<div class="container">
				<h2 class="popular-products__title accent-title">{!! __('site.popular_men_products_title') !!}</h2>
				<div class="popular-products__inner">
					@foreach($men_popular_product as $product)
						@php
							$sale = $product->getSalePrice();
							if(session()->get('favorites')){
								$in_session = array_search($product->product_id, session()->get('favorites'));
							}
						@endphp
						<div class="card-product popular-products__item">
							<div class="card-product__inner">
								<div class="card-product__img">
									<a href="{{ route('catalog.product', $product->slug) }}">
										<img src="{{ $product->image }}" alt="{{ $product->title }}">
									</a>
									@if($product->created_at > \Carbon\Carbon::now()->subDays(60))
										<span class="card-product__mark">New</span>
									@endif
									@if(isset($sale->percent_status) && $sale->percent_status)
										<span class="card-product__sale">-{{ intval($sale->discount) }}%</span>
									@elseif(isset($sale->percent_status) && $sale->percent_status == false)
										<span class="card-product__sale">{{ intval($sale->discount) . ' ' . __('shop.grn') }}</span>
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
									<a href="{{ route('catalog.product', $product->slug) }}" class="card-product__title">{{ $product->title }}</a>
									<div class="card-product__price">
										@if(isset($sale->price) && $sale->percent_status)
											<span class="card-product__price-old">{{ $product->price }}</span>
											<span class="card-product__price-new">{{ intval($product->price - $sale->price) }} {!! __('shop.grn') !!}</span>
										@elseif(isset($sale->price)  && !$sale->percent_status)
											<span class="card-product__price-old">{{ $product->price }}</span>
											<span class="card-product__price-new">{{ $sale->price }} {!! __('shop.grn') !!}</span>
										@else
											<span class="card-product__price-new">{{$product->price}} {!! __('shop.grn') !!}</span>
										@endif
									</div>
									<a href="{{ route('catalog.product', $product->slug) }}" class="card-product__btn white-btn">{!! __('shop.buy') !!}</a>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</section>
	@endif

	@if(count($children_popular_product))
		<section class="popular-products">
			<div class="container">
				<h2 class="popular-products__title accent-title">{!! __('site.popular_children_products_title') !!}</h2>
				<div class="popular-products__inner">
					@foreach($children_popular_product as $product)
						@php
							$sale = $product->getSalePrice();
							if(session()->get('favorites')){
								$in_session = array_search($product->product_id, session()->get('favorites'));
							}
						@endphp
						<div class="card-product popular-products__item">
							<div class="card-product__inner">
								<div class="card-product__img">
									<a href="{{ route('catalog.product', $product->slug) }}">
										<img src="{{ $product->image }}" alt="{{ $product->title }}">
									</a>
									@if($product->created_at > \Carbon\Carbon::now()->subDays(60))
										<span class="card-product__mark">New</span>
									@endif
									@if(isset($sale->percent_status) && $sale->percent_status)
										<span class="card-product__sale">-{{ intval($sale->discount) }}%</span>
									@elseif(isset($sale->percent_status) && $sale->percent_status == false)
										<span class="card-product__sale">{{ intval($sale->discount) . ' ' . __('shop.grn') }}</span>
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
									<a href="{{ route('catalog.product', $product->slug) }}" class="card-product__title">{{ $product->title }}</a>
									<div class="card-product__price">
										@if(isset($sale->price) && $sale->percent_status)
											<span class="card-product__price-old">{{ $product->price }}</span>
											<span class="card-product__price-new">{{ intval($product->price - $sale->price) }} {!! __('shop.grn') !!}</span>
										@elseif(isset($sale->price)  && !$sale->percent_status)
											<span class="card-product__price-old">{{ $product->price }}</span>
											<span class="card-product__price-new">{{ $sale->price }} {!! __('shop.grn') !!}</span>
										@else
											<span class="card-product__price-new">{{$product->price}} {!! __('shop.grn') !!}</span>
										@endif
									</div>
									<a href="{{ route('catalog.product', $product->slug) }}" class="card-product__btn white-btn">{!! __('shop.buy') !!}</a>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</section>
	@endif

	@if(count($shop_reviews))
		<section class="reviews-slider">
			<div class="container">
				<h2 class="reviews-slider__title accent-title">{!! __('site.title_reviews_about_kavalerka') !!}</h2>
				<div class="reviews-slider__inner">
					<div class="reviews-major-swiper swiper-container" id="reviews-major-swiper">
						<div class="reviews-major-swiper__wrapper swiper-wrapper">

							@foreach($shop_reviews as $review)

								<div class="reviews-major-swiper__slide swiper-slide">
								<div class="reviews-major-swiper__slide-body">
									<div class="reviews-major-swiper__slide-text reviews-major-swiper__slide-text--center">
										<p>
											{{ $review->comment }}
										</p>
									</div>
								</div>
								<div class="reviews-major-swiper__slide-stars js-paint-stars" data-stars="{{ $review->rating }}">
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

							@endforeach

						</div>

					</div>
					<div class="reviews-minor-swiper swiper-container" id="reviews-minor-swiper">
						<div class="reviews-minor-swiper__wrapper swiper-wrapper">

							@foreach($shop_reviews as $review)

							<div class="reviews-minor-swiper__slide swiper-slide">
								<h3 class="reviews-minor-swiper__slide-title">{{ $review->name }}</h3>
								<span class="reviews-minor-swiper__slide-date">{{ date("d.m.Y", strtotime($review->created_at)) }}</span>
							</div>

							@endforeach

						</div>
					</div>
					<div class="reviews-slider__btns">
						<a href="{{ route('site.reviews') }}" class="reviews-slider__link accent-btn">{!! __('site.all_reviews') !!}</a>
					</div>
					<div class="accent-arrow swiper-button-prev" id="reviews-major-swiper__button-prev">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-left') }}"></use>
						</svg>
					</div>
					<div class="accent-arrow swiper-button-next" id="reviews-major-swiper__button-next">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-right') }}"></use>
						</svg>
					</div>
				</div>
			</div>
		</section>
	@endif

	@if(count($blog))
		@include('site::pages.partials.blog-slider')
	@endif

	@if(isset($seo_text->value))
		<section class="description">
				<div class="container">
					<h2 class="description__title accent-title">{!! __('site.home_title_last_block') !!}</h2>
					<div class="description__inner">
						<p>
							{!! $seo_text->value !!}
						</p>
					</div>
				</div>
			</section>
	@endif

</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
