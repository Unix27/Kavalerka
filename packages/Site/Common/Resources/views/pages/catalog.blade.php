@extends('site::layouts.site')
@php
	$cat = new \Shop\Catalog\Models\Category();
	$categories = $cat->getMenuCatalog();


	$brands = \Shop\Catalog\Models\Brand::where([
			'active' => true,
	])->withCount('products')->orderBy('sort')->get();

	$attributes = \Shop\Catalog\Models\Attribute::where('active',1)
			->where('use_filter',1)
			->where('active',1)
			->with('values','values.products')->orderBy('sort')->get();
	$input = request()->all();

	$max_price = \Shop\Catalog\Models\Product::max('price');
@endphp

@section('seo')
	<title>{{ $page->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $page->meta_description ?? '' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection
@section('content')
	@include('site::catalog.partials.breadcrumbs')
<section class="catalog">
	<div class="container">
		<div class="catalog__top">
			<h2 class="catalog__title title">{{ $page->title }}</h2>
			<span class="catalog__span span">(<span>{{ count($products) }}</span> товаров)</span>
		</div>
	<form class="category__left filter-catalog">
		<div class="catalog__buttons-mobile">

			<select>
				<option selected hidden>{!! __('shop.sort') !!}</option>
				<option>{!! __('shop.sort_new') !!}</option>
				<option>{!! __('shop.sort_sale') !!}</option>
				<option >{!! __('shop.cheap_to_expensive') !!}</option>
				<option>{!! __('shop.expensive_to_cheap') !!}</option>
			</select>

			<button class="catalog__filter-btn" onclick="togglePopup('modal-filter')">
				<span>{!! __('shop.filters') !!}</span>
			</button>
		</div>

		<div class="catalog__buttons">

			<button type="reset" class="catalog__clear clear_filters">
				{!! __('shop.clear_all_filters') !!}
			</button>

		</div>

		<div class="catalog__selects">
{{--
		Sort
--}}
			<div class="catalog__select select-checkbox">
				<a class="select-checkbox__trigger" onclick="openFilter(this)">
					<span>{!! __('shop.sort') !!}</span>
					<svg>
						<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
					</svg>
				</a>
				<div class="select-checkbox__body">
					<ul>
						<li>
							<label>
								<input name="sort"
											 id="1"
											 type="radio"
											 value="new">
								<svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
								</svg>
								<span class="js-item-sorting-category">{!! __('shop.sort_new') !!}</span>
							</label>
						</li>
						<li>
							<label>
								<input name="sort"
											 id="1"
											 type="radio"value="sale">
								<svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
								</svg>
								<span class="js-item-sorting-category">{!! __('shop.sort_sale') !!}</span>
							</label>
						</li>
						<li>
							<label>
								<input name="sort"
											 id="1"
											 type="radio"
											 value="cheap">
								<svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
								</svg>
								<span class="js-item-sorting-category">{!! __('shop.cheap_to_expensive') !!}</span>
							</label>
						</li>
						<li>
							<label>
								<input name="sort"
											 id="1"
											 type="radio"
											 value="expensive">
								<svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
								</svg>
								<span class="js-item-sorting-category">{!! __('shop.expensive_to_cheap') !!}</span>
							</label>
						</li>
					</ul>
				</div>
				<button type="button" class="select-checkbox__area" onclick="closeFilter(this)" style="display: none;"></button>
			</div>
{{--
		Category
--}}
		@if($category->parent()->first()->id == $categories['category']->id)
			<div class="catalog__select select-checkbox">
				<a class="select-checkbox__trigger" onclick="openFilter(this)">
					<span>{!! __('shop.filter_product_type') !!}</span>
					<svg>
						<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
					</svg>
				</a>

				<div class="select-checkbox__body">
					<ul>
						@foreach($category->children()->get() as $key => $item)
						<li>
							<a href="{{ route('site.page', ['slug' => $categories['category']->slug .'/'.$category->slug.'/'.$item->slug]) }}">{{ $item->title }}</a>
						</li>
						@endforeach
					</ul>
				</div>
				<button type="button" class="select-checkbox__area" onclick="closeFilter(this)" style="display: none;"></button>
			</div>
		@endif
{{--
		Brands
--}}
			<div class="catalog__select select-checkbox">
				<a class="select-checkbox__trigger" onclick="openFilter(this)">
					<span>{!! __('shop.filter_brands') !!}</span>
					<svg>
						<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
					</svg>
				</a>
				<div class="select-checkbox__body">
					<ul>
						@foreach($brands as $brand)
							<li>
							<label>
								<input class="checkbox__input"
											 type="checkbox"
											 name="manufacturer[]"
											 @if(isset($input['manufacturer']) && in_array($brand->id,$input['manufacturer'])) checked @endif
											 id="manufacturer-{{$brand->id}}"
											 value="{{$brand->id}}">
								<svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
								</svg>
								<span>{{ $brand->title }}</span>
							</label>
						</li>
						@endforeach
					</ul>
				</div>
				<button type="button" class="select-checkbox__area" onclick="closeFilter(this)" style="display: none;"></button>
			</div>
{{--
		Attributes
--}}
		@foreach($attributes as $attribute)
			<div class="catalog__select select-checkbox">
				<a type="button" class="select-checkbox__trigger" onclick="openFilter(this)">
					<span>{{ $attribute->title }}</span>
					<svg>
						<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
					</svg>
				</a>
				<div class="select-checkbox__body">
					<ul>
						@foreach($attribute->values as $value)
							<li>
								<label>
									<input type="checkbox" @if(isset($input['attribute'][$attribute->id]) && in_array($value->id,$input['attribute'][$attribute->id])) checked @endif
									class="checkbox__input"
												 name="attribute[{{$attribute->id}}][]"
												 id="attribute_{{$attribute->id}}_{{$value->id}}"
												 value="{{$value->id}}">
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
									</svg>
									<span>{{ $value->title }}</span>
								</label>
							</li>
						@endforeach
					</ul>
				</div>
				<button type="button" class="select-checkbox__area" onclick="closeFilter(this)" style="display: none;"></button>
			</div>
		@endforeach
{{--
		Price
--}}
			<div class="catalog__select select-checkbox select-checkbox--wide">
				<a type="button" class="select-checkbox__trigger" onclick="openFilter(this)">
					<span>{!! __('shop.price') !!}</span>
					<svg>
						<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
					</svg>
				</a>
				<div class="select-checkbox__body">
					<div class="select-checkbox__body-inputs">
						<div class="select-checkbox__body-input-from"><input type="text" data-max-price="{{$max_price}}" id="result-range-from" name="from_price" placeholder="0" type="number" value="@if(isset($input['from_price'])){{$input['from_price']}}@else 0 @endif"></div>
						<div class="select-checkbox__body-input-to"><input type="text" name="to_price" value="@if(isset($input['to_price'])){{$input['to_price']}} @else {{$max_price}} @endif"></div>
					</div>
					<button type="submit" class="select__body-submit">
						<span>{!! __('shop.submit') !!}</span>
					</button>
				</div>
				<button type="button" class="select-checkbox__area" onclick="closeFilter(this)" style="display: none;"></button>
			</div>
{{--
		More filters...
--}}
{{--			<div class="catalog__more">--}}
{{--				<a href="#">--}}
{{--					<span>{!! __('shop.more_filters') !!}</span>--}}
{{--					<svg>--}}
{{--						<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>--}}
{{--					</svg>--}}
{{--				</a>--}}
{{--			</div>--}}

		</div><!-- Filters -->

	</form>
		<div class="catalog__inner">
			@include('site::catalog.partials.products')
		</div>

	</div>
</section>

@if(count($reviews))
	<section class="reviews-slider">
	<div class="container">
		<h2 class="reviews-slider__title accent-title">
			@if($category->id == 33)
				{!! __('site.last_reviews_about_children_clothes') !!}
			@elseif($category->id == 32)
				{!! __('site.last_reviews_about_men_clothes') !!}
			@else
				{!! __('site.last_reviews_about_women_clothes') !!}
			@endif
		</h2>
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

@include('site::pages.partials.seo-text')

</main>

@endsection

@section('footer')
	<div class="drop-menu-mobile__wrapper" id="modal-filter">
		<button onclick="toggleModal('modal-filter')" class="drop-menu-mobile__area"></button>
		<div class="drop-menu-mobile__inner">
			<form action="#" class="drop-menu-mobile__content drop-menu-mobile__content--right drop-menu-mobile drop-menu-mobile--right">

				<div class="drop-menu-mobile__top">
					<h2 class="drop-menu-mobile__top-title">{!! __('shop.filters') !!}</h2>
					<button type="reset" class="drop-menu-mobile__clear">{!! __('shop.clear_all_filters') !!}</button>
				</div>

				<div class="drop-menu-mobile__body">
{{--					<div class="drop-menu-mobile__buttons">--}}
{{--						<a href="#" class="clear-btn drop-menu-mobile__button">--}}
{{--							<span>Характеристика 1</span>--}}
{{--							<svg>--}}
{{--								<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>--}}
{{--							</svg>--}}
{{--						</a>--}}
{{--						<a href="#" class="clear-btn drop-menu-mobile__button">--}}
{{--							<span>Характеристика 1</span>--}}
{{--							<svg>--}}
{{--								<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>--}}
{{--							</svg>--}}
{{--						</a>--}}
{{--					</div>--}}

					<div class="drop-menu-mobile__selects">
						<ul>

							<div class="catalog__select select-checkbox">
								<a type="button" class="select-checkbox__trigger" onclick="openFilter(this)">
									<span>{!! __('shop.filter_product_type') !!}</span>
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
									</svg>
								</a>

								<div class="select-checkbox__body">
									<ul>
										@foreach($category->children()->get() as $key => $item)
											<li>
												<a href="{{ route('site.page', ['slug' => $categories['category']->slug .'/'.$category->slug.'/'.$item->slug]) }}">{{ $item->title }}</a>
											</li>
										@endforeach
									</ul>
								</div>
								<button type="button" class="select-checkbox__area" onclick="closeFilter(this)" style="display: none;"></button>
							</div>

							@if($category->parent()->first()->id == $categories['category']->id)
								<li>
									<button type="button" onclick="openFilterMobile(this)" class="drop-menu-mobile__select">
										<span>{!! __('shop.filter_product_type') !!}</span>
										<svg>
											<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
										</svg>
									</button>
									<div class="drop-menu-mobile">

										<div class="drop-menu-mobile__top" class="drop-menu-mobile__select">
											<h3 class="drop-menu-mobile__top-title" onclick="this.parentNode.parentNode.parentNode.classList.toggle('active')">
												<svg>
													<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-left') }}"></use>
												</svg>
												<span>{!! __('shop.filter_product_type') !!}</span>
											</h3>
											<button type="reset" class="drop-menu-mobile__clear">{!! __('shop.clear_all_filters') !!}</button>
										</div>

										<div class="drop-menu-mobile__body">
											<div class="drop-menu-mobile__labels">
												<ul>

													@foreach($category->children()->get() as $key => $item)
														<li>
															<a href="{{ route('site.page', ['slug' => $categories['category']->slug .'/'.$category->slug.'/'.$item->slug]) }}">{{ $item->title }}</a>
														</li>
													@endforeach

												</ul>
											</div>
											<button type="submit" class="accent-btn drop-menu-mobile__submit">{!! __('shop.submit') !!}</button>
										</div>
									</div>

								</li>
							@endif

							@foreach($attributes as $attribute)
								<li>
									<button type="button" onclick="openFilterMobile(this)" class="drop-menu-mobile__select">
										<span>{{ $attribute->title }}</span>
										<svg>
											<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
										</svg>
									</button>
									<div class="drop-menu-mobile">

										<div class="drop-menu-mobile__top" class="drop-menu-mobile__select">
											<h3 class="drop-menu-mobile__top-title" onclick="this.parentNode.parentNode.parentNode.classList.toggle('active')">
												<svg>
													<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-left') }}"></use>
												</svg>
												<span>{{ $attribute->title }}</span>
											</h3>
											<button type="reset" class="drop-menu-mobile__clear">{!! __('shop.clear_all_filters') !!}</button>
										</div>

										<div class="drop-menu-mobile__body">
											<div class="drop-menu-mobile__labels">
												<ul>
													@foreach($attribute->values as $value)
														<li>
															<label>
																<input
																	class="checkbox__input"
																	name="attribute[{{$attribute->id}}][]"
																	id="attribute_{{$attribute->id}}_{{$value->id}}"
																	value="{{$value->id}}">
																@if(isset($input['attribute'][$attribute->id]) && in_array($value->id,$input['attribute'][$attribute->id])) checked @endif
																type="checkbox">
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
																</svg>
																<span>{{ $value->title }}</span>
															</label>
														</li>
													@endforeach
												</ul>
											</div>
											<button type="submit" class="accent-btn drop-menu-mobile__submit">{!! __('shop.submit') !!}</button>
										</div>
									</div>

								</li>
							@endforeach


							<li>
								<label>
									<input class="checkbox__input"
												 type="checkbox"
												 name="manufacturer[]"
												 @if(isset($input['manufacturer']) && in_array($brand->id,$input['manufacturer'])) checked @endif
												 id="manufacturer-{{$brand->id}}"
												 value="{{$brand->id}}">
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
									</svg>
									<span>{{ $brand->title }}</span>
								</label>
							</li>


							<li>
								<button type="button" onclick="openFilterMobile(this)" class="drop-menu-mobile__select">
									<span>{!! __('shop.filter_brands') !!}</span>
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
									</svg>
								</button>
								<div class="drop-menu-mobile">

									<div class="drop-menu-mobile__top" class="drop-menu-mobile__select">
										<h3 class="drop-menu-mobile__top-title" onclick="this.parentNode.parentNode.parentNode.classList.toggle('active')">
											<svg>
												<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-left') }}"></use>
											</svg>
											<span>{!! __('shop.brand') !!}</span>
										</h3>
										<button type="reset" class="drop-menu-mobile__clear">{!! __('shop.clear_all_filters') !!}</button>
									</div>

									<div class="drop-menu-mobile__body">
										<div class="drop-menu-mobile__labels">
											<ul>
												@foreach($brands as $brand)
													<li>
														<label>
															<input class="checkbox__input"
																		 type="checkbox"
																		 name="manufacturer[]"
																		 @if(isset($input['manufacturer']) && in_array($brand->id,$input['manufacturer'])) checked @endif
																		 id="manufacturer-{{$brand->id}}"
																		 value="{{$brand->id}}">
															<svg>
																<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
															</svg>
															<span>{{ $brand->title }}</span>
														</label>
													</li>
												@endforeach

											</ul>
										</div>
										<button type="submit" class="accent-btn drop-menu-mobile__submit">{!! __('shop.submit') !!}</button>
									</div>
								</div>

							</li>


							<li>
								<button type="button" onclick="openFilterMobile(this)" class="drop-menu-mobile__select">
									<span>{!! __('shop.price') !!}</span>
									<svg>
										<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
									</svg>
								</button>
								<div class="drop-menu-mobile">

									<div class="drop-menu-mobile__top" class="drop-menu-mobile__select">
										<h3 class="drop-menu-mobile__top-title" onclick="this.parentNode.parentNode.parentNode.classList.toggle('active')">
											<svg>
												<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-left') }}"></use>
											</svg>
											<span>{!! __('shop.price') !!}</span>
										</h3>
										<button type="reset" class="drop-menu-mobile__clear">{!! __('shop.clear_all_filters') !!}</button>
									</div>

									<div class="drop-menu-mobile__body">
										<div class="drop-menu-mobile__price">
											<div class="select-checkbox__body-input-from"><input type="text" data-max-price="{{$max_price}}" id="result-range-from" name="from_price" placeholder="0" type="number" value="@if(isset($input['from_price'])){{$input['from_price']}}@else 0 @endif"></div>
											<div class="select-checkbox__body-input-to"><input type="text" name="to_price" value="@if(isset($input['to_price'])){{$input['to_price']}} @else {{$max_price}} @endif"></div>
										</div>
										<button type="submit" class="accent-btn drop-menu-mobile__submit">{!! __('shop.submit') !!}</button>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<button type="submit" class="accent-btn drop-menu-mobile__submit">{!! __('shop.submit') !!}</button>
				</div>
			</form>
		</div>
	</div>
	@include('site::layouts.site-footer')
@endsection
