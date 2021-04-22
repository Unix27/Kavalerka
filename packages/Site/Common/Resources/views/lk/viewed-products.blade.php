@extends('site::layouts.site')
@section('seo')
	<title>{{ $page->meta_title ?? __('menu.seen') }}</title>
	<meta name="description" content="{{ $page->meta_description ?? '' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection

@section('content')
	@include('site::lk.blocks.breadcrumbs')
	<section class="profile">
		<div class="container">
			<div class="profile__top">
				<h2 class="profile__title title">{{ $page->title ??  __('menu.seen') }}</h2>
				<span class="profile__span span">({{ $count_viewed }} {!! __('shop.count_products') !!})</span>
				@if(count($products))
					<div class="profile__top-buttons">
						<a href="#" class="profile__delete clear-btn js-add-to-favorite" data-id="all">
							<span>{!! __('site.remove_all_products') !!}</span>
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#delete')}}"></use>
							</svg>
						</a>
					</div>
				@endif
			</div>

			<div class="profile__inner">

				@include('site::lk.blocks.aside-menu')

				<div class="profile__content">
					<div class="profile__products js-favorites-inner">

						@if(count($products))

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
								<div class="card-product profile__product">
									<div class="card-product__inner">
										<div class="card-product__img">
											<a href="{{ route('catalog.product', $product->slug)}}">
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

							</div>
							<div class="profile__products">
								<div class="profile__pagination pagination">

									@if(count($products) == 9)

										<a href="#" class="accent-btn pagination__btn js-more-product" data-method="viewed" data-take="{{ count($products) }}">
											{!! __('shop.show_more_products') !!}
										</a>

									@endif

									<div class="pagination__inner">
										{{ $products->links() }}
									</div>
								</div>

						@else

							<div class="profile__content-none">
								<h3 class="profile__content-none-title">{!! __('site.you_have_not_viewed_any_products_yet') !!}</h3>
							</div>

						@endif

						<div class="profile__content-none" style="display: none">
							<h3 class="profile__content-none-title">{!! __('site.you_have_not_viewed_any_products_yet') !!}</h3>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
	</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
