@extends('site::layouts.site')

@section('seo')
	<title>{{ $category->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $category->meta_description ?? '' }}">
	<meta name="keywords" content="{{ $category->meta_keywords ?? '' }}">
	<meta name="keywords" content="{{ $category->meta_keywords ?? '' }}">
@endsection
@php
	$in_session = false;
@endphp
@section('content')
@if(count($page->slider))
	<section class="top-slider">
		<div class="top-slider__inner">
			<div class="top-major-swiper swiper-container" id="top-major-swiper">
				<div class="top-major-swiper__wrapper swiper-wrapper">
				@foreach($page->slider as $slide)
					<div class="top-major-swiper__slide swiper-slide">
						<div class="top-major-swiper__slide-container">
							<div class="top-major-swiper__slide__inner">
								<img src="{{ $slide->image }}" alt="" loading="lazy">
								<h2 class="top-major-swiper__slide-title">{{ $slide->title }}</h2>
								<h2 class="top-major-swiper__slide-subtitle">{{ $slide->desc }}</h2>
								<a href="{{ $slide->link }}" class="accent-btn top-major-swiper__slide-btn">{{ $slide->button_name }}</a>
							</div>
						</div>
					</div>

				@endforeach

				</div>

				@if(count($page->slider) > 1)
					<div class="top-minor-swiper swiper-container" id="top-minor-swiper">
						<div class="top-minor-swiper__wrapper swiper-wrapper">

						@foreach($page->slider as $key => $slide)
							<div class="top-minor-swiper__slide swiper-slide">
								<div class="top-minor-swiper__slide-num">{{ ($key+1) }}</div>
								<h2 class="top-minor-swiper__slide-title">{{ $slide->name }}</h2>
							</div>

						@endforeach

						</div>
					</div>
				@endif
			</div>
		</div>
	</section>
@endif
	<section class="categories">
		<div class="container">
			<div class="categories__inner">
			@foreach($categories as $item)
					<a href="{{ route('site.page', ['slug' => $category->slug.'/'.$item->slug]) }}" class="categories__item">
						<img src="{{ $item->image }}" alt="{{ $item->title }}" loading="lazy">
						<span class="link-arrow-right">{{ $item->title }}
							 <svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#long-arrow-right') }}"></use>
								</svg>
						</span>
					</a>
			@endforeach
			</div>
		</div>
	</section>

@if(count($sale_products))
	<section class="popular-products">
		<div class="container">
			<h2 class="popular-products__title accent-title">{!! __('site.sale') !!}</h2>
			<div class="popular-products__inner">
			@foreach($sale_products as $product)
				@php
					if(session()->get('favorites')){
						$in_session = array_search($product->product_id, session()->get('favorites'));
					}
					$sale = $product->getSalePrice();
				@endphp
				<div class="card-product popular-products__item">
					<div class="card-product__inner">
						<div class="card-product__img">
							<a href="{{ route('catalog.product', $product->slug) }}">
								<img src="{{ $product->image }}" alt="{{ $product->title }}" loading="lazy">
							</a>
							@if($product->created_at > \Carbon\Carbon::now()->subDays(60))
								<span class="card-product__mark">New</span>
							@endif
							@if(isset($sale->percent_status) && $sale->percent_status)
								<span class="card-product__sale">- {{ intval($sale->discount) }}%</span>
							@elseif(isset($sale->percent_status) && $sale->percent_status == false)
								<span class="card-product__sale">- {{ intval($sale->discount) }} {!! __('shop.grn') !!}</span>
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
									<span class="card-product__price-old">{{ intval($product->price) }}</span>
									<span class="card-product__price-new">{{ intval($product->price - $sale->price) }} {!! __('shop.grn') !!}</span>
								@elseif(isset($sale->price)  && !$sale->percent_status)
									<span class="card-product__price-old">{{ intval($product->price) }}</span>
									<span class="card-product__price-new">{{ intval($sale->price) }} {!! __('shop.grn') !!}</span>
								@else
									<span class="card-product__price-new">{{ intval($product->price) }} {!! __('shop.grn') !!}</span>
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

@if(count($new_products))
	<section class="popular-products">
		<div class="container">
			<h2 class="popular-products__title accent-title">{!! __('site.new_product') !!}</h2>
			<div class="popular-products__inner">
				@foreach($new_products as $product)
				@php
					$sale = $product->getSalePrice();
					if(session()->get('favorites')){
						$in_session = array_search($product->product_id, session()->get('favorites'));
					}
				@endphp
				<div class="card-product catalog__item">
					<div class="card-product__inner">
						<div class="card-product__img">
							<a href="{{ route('catalog.product', $product->slug) }}">
								<img src="{{ $product->image }}" alt="{{ $product->title }}" loading="lazy">
							</a>
							@if($product->created_at > \Carbon\Carbon::now()->subDays(60))
								<span class="card-product__mark">New</span>
							@endif
							@if(isset($sale->percent_status) && $sale->percent_status)
								<span class="card-product__sale">- {{ intval($sale->discount) }}%</span>
							@elseif(isset($sale->percent_status) && $sale->percent_status == false)
								<span class="card-product__sale">- {{ intval($sale->discount) }} {!! __('shop.grn') !!}</span>
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

{{--				<div class="card-product popular-products__item">--}}
{{--					<div class="card-product__inner">--}}
{{--						<div class="card-product__img">--}}
{{--							<a href="#">--}}
{{--								<img src="{{ asset('/assets/img/product-mans-2.jpg') }}" alt="" loading="lazy">--}}
{{--							</a>--}}
{{--							<!--<span class="card-product__mark">New</span>-->--}}
{{--							<!--<span class="card-product__sale">- 10%</span>-->--}}
{{--							<button class="card-product__favorites" onclick="this.classList.toggle('active')">--}}
{{--								<svg>--}}
{{--									<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>--}}
{{--								</svg>--}}
{{--							</button>--}}
{{--						</div>--}}
{{--						<div class="card-product__bottom">--}}
{{--							<a href="#" class="card-product__title">Название товара</a>--}}
{{--							<div class="card-product__price">--}}
{{--								<span class="card-product__price-new">529 грн.</span>--}}
{{--								<span class="card-product__price-old">740 грн.</span>--}}
{{--							</div>--}}
{{--							<a href="#" class="card-product__btn white-btn white-btn--disable">Нет в наличии</a>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}


			</div>
		</div>
	</section>
@endif

@if(count($popular_products))
	<section class="popular-products">
		<div class="container">
			<h2 class="popular-products__title accent-title">{!! __('site.popular') !!}</h2>
			<div class="popular-products__inner">
			@foreach($popular_products as $product)
					@php
						$sale = $product->getSalePrice();
						if(session()->get('favorites')){
							$in_session = array_search($product->product_id, session()->get('favorites'));
						}
					@endphp
					<div class="card-product catalog__item">
						<div class="card-product__inner">
							<div class="card-product__img">
								<a href="{{ route('catalog.product', $product->slug) }}">
									<img src="{{ $product->image }}" alt="{{ $product->title }}" loading="lazy">
								</a>
								@if($product->created_at > \Carbon\Carbon::now()->subDays(60))
									<span class="card-product__mark">New</span>
								@endif
								@if(isset($sale->percent_status) && $sale->percent_status)
									<span class="card-product__sale">- {{ intval($sale->discount) }}%</span>
								@elseif(isset($sale->percent_status) && $sale->percent_status == false)
									<span class="card-product__sale">- {{ intval($sale->discount) }} {!! __('shop.grn') !!}</span>
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

@if(count($reviews))
	<section class="reviews-slider">
		<div class="container">
			<h2 class="reviews-slider__title accent-title">Последние отзывы про женскую одежду</h2>
			<div class="reviews-slider__inner">
				<div class="reviews-major-swiper swiper-container" id="reviews-major-swiper">
					<div class="reviews-major-swiper__wrapper swiper-wrapper">
					@foreach($reviews as $review)
						@php
							$review_product = $review->product()->first();
						@endphp
						<div class="reviews-major-swiper__slide swiper-slide">
							<h3 class="reviews-major-swiper__slide-title">{{ $review_product->title }}</h3>
							<div class="reviews-major-swiper__slide-body">
								<div class="reviews-major-swiper__slide-img">
									<img src="{{ $review_product->image }}" alt="{{ $review_product->title }}" loading="lazy">
								</div>
								<div class="reviews-major-swiper__slide-text">
									<p>
										{!! $review->comment !!}
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
					@foreach($reviews as $review)
						<div class="reviews-minor-swiper__slide swiper-slide">
							<h3 class="reviews-minor-swiper__slide-title">{{ $review->name }}</h3>
							<span class="reviews-minor-swiper__slide-date">{{ date("d.m.Y", strtotime($review->created_at)) }}</span>
						</div>
					@endforeach
					</div>
				</div>
				<div class="reviews-slider__btns">
					<a href="#" class="reviews-slider__link accent-btn">{!! __('site.all_reviews') !!}</a>
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

	@include('site::pages.partials.seo-text')

	</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
