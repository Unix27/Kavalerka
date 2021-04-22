@extends('site::layouts.site')

@section('seo')
	<title>{{ $page->meta_title ?? __('menu.favorites') }}</title>
	<meta name="description" content="{{ $page->meta_description ?? '' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection

@section('content')
	@include('site::lk.blocks.breadcrumbs')
	<section class="profile">
		<div class="container">
			<div class="profile__top">
				<h2 class="profile__title title">{{ $page->title ?? __('menu.favorites') }}</h2>
					<span class="profile__span span" data-count="{{ $count_favorite }}" data-text="{!! __('shop.count_products') !!}">({{ $count_favorite }} {!! __('shop.count_products') !!})</span>

				@if(count($products))

					<div class="profile__top-buttons">
{{--						<select name="sort">--}}
{{--							<option selected hidden>{!! __('shop.sort') !!}</option>--}}
{{--							<option value="last">{!! __('site.sort_added_last') !!}</option>--}}
{{--							<option value="first">{!! __('site.sort_added_first') !!}</option>--}}
{{--						</select>--}}
						<a href="#" class="profile__delete clear-btn js-remove-favorite" data-id="all">
							<span>{!! __('shop.remove_all_products') !!}</span>
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
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
							$variations = \Shop\Catalog\Models\Attribute::whereHas('products',function($q) use ($product){
										$q->where('product_id',$product->id);
								})->first();
							$sale = $product->getSalePrice();
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
									@if(isset($sale->percent_status) && $sale->percent_status)
										<span class="card-product__sale">- {{ $sale->discount }}%</span>
									@elseif(isset($sale->percent_status) && !$sale->percent_status)
										<span class="card-product__sale">- {{ intval($sale->discount) }} {!! __('shop.grn') !!}</span>
									@endif
									<button class="card-product__favorites js-remove-favorite" data-id="{{ $product->id }}" onclick="this.classList.toggle('active')">
										<svg>
											<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
										</svg>
									</button>
								</div>
								<div class="card-product__bottom">
									<a href="{{ route('catalog.product', [ 'slug' => $product->slug ?? '#'])}}" class="card-product__title">{{ $product->title }}</a>
									@if(isset($variations))

										<div class="product__size">
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
															@foreach($variations->values()->has('products')->get() as $key => $variation)
																@php
																	$var = \Shop\Catalog\Models\Variations::where('product_id',$product->id)
																		->whereHas('values',function ($q) use ($variation){
																			$q->whereIn('value_id',[$variation->id]);
																		},'=',1)->first();
																@endphp
																@if(isset($var))
																	<li class="select__option" data-value="{{ $variation->title }}" data-id="{{ $var->id }}" data-price="{{ $var->price }}">
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
									<div class="card-product__price js-product__price" data-val="{!! __('shop.grn') !!}">
										@if(isset($sale->percent_status) && $sale->percent_status)
											<span class="card-product__price-old">{{ $product->price }}</span>
											<span class="card-product__price-new">{{ intval($product->price) - intval($product->price * $sale->price / 100) }} {!! __('shop.grn') !!}</span>
										@elseif(isset($sale->percent_status)  && !$sale->percent_status)
											<span class="card-product__price-old">{{ $product->price }}</span>
											<span class="card-product__price-new">{{ intval($product->price - $sale->discount) }} {!! __('shop.grn') !!}</span>
										@else
											<span class="card-product__price-new">{{$product->price}} {!! __('shop.grn') !!}</span>
										@endif
									</div>
									<a href="#" class="card-product__btn white-btn js-buy-button-favorite" data-id="{{ $product->id }}">{!! __('shop.buy') !!}</a>
							</div>
							</div>
						</div>

					@endforeach

						</div>

						<div class="profile__products">

							<div class="profile__pagination pagination">

								@if(count($products) == 9)

{{--									<a href="#" class="accent-btn pagination__btn js-more-product" data-method="favorites" data-take="{{ count($products) }}">--}}
{{--										{!! __('shop.show_more_products') !!}--}}
{{--									</a>--}}

								@endif

								<div class="pagination__inner">
									{{ $products->links() }}
								</div>
							</div>

				@else

								<div class="profile__content-none">
									<h3 class="profile__content-none-title">{!! __('site.you_have_not_added_favorite') !!}</h3>
								</div>

				@endif

							<div class="profile__content-none" style="display: none">
								<h3 class="profile__content-none-title">{!! __('site.you_have_not_added_favorite') !!}</h3>
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
