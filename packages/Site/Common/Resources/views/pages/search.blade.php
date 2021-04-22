@extends('site::layouts.site')
@php
		$page = \Pages\Models\Page::where('slug', '=', 'search')->first();
		$cat = new \Shop\Catalog\Models\Category();
		$categories = $cat->getMenuCatalog();
		$categories_filter = \Shop\Catalog\Models\Category::where('parent_id', '!=', null)->get();
		$gender = \Shop\Catalog\Models\Category::where('show_menu', '=', 1)
			->where('parent_id', '=', null)->get();
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
	<meta name="description" content="{{ $page->meta_description ??'' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection
@section('content')
	@include('site::lk.blocks.breadcrumbs')
	<section class="catalog">
		<div class="container">
			<div class="catalog__top">
				<h2 class="catalog__title title">{!! __('shop.search_result') !!}@if(isset($title)): «{{ $title }}»@endif</h2>
				<span class="catalog__span span">({{ $products->count() }} {!! __('shop.count_products') !!})</span>
			</div>
		<form action="#" class="filter-catalog">
			<div class="catalog__buttons-mobile">
				<select>
					<option selected hidden>{!! __('shop.sort') !!}</option>
					<option>{!! __('shop.sort_new') !!}</option>
					<option>{!! __('shop.sort_sale') !!}</option>
					<option >{!! __('shop.cheap_to_expensive') !!}</option>
					<option>{!! __('shop.expensive_to_cheap') !!}</option>
				</select>
				<button class="catalog__filter-btn" onclick="toggleModal('modal-filter')">
					<span>{!! __('shop.filters') !!}</span>
				</button>
			</div>
			<div class="catalog__buttons">
				<button type="reset" class="catalog__clear clear_filters" style="display: none;">
					{!! __('shop.clear_all_filters') !!}
				</button>
			</div>
			<div class="catalog__selects">

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

	<div class="catalog__select select-checkbox">
		<a class="select-checkbox__trigger" onclick="openFilter(this)">
			<span>{!! __('shop.filter_sex') !!}</span>
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
			</svg>
		</a>
		<div class="select-checkbox__body">
			<ul>
				@foreach($gender as $item)
					<li>
						<label>
							<input class="checkbox__input"
										 type="checkbox"
										 name="gender[]"
										 @if(isset($input['gender']) && in_array($item->id,$input['gender'])) checked @endif
										 id="gender-{{$item->id}}"
										 value="{{$item->id}}">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
							</svg>
							<span>{{ $item->title }}</span>
						</label>
					</li>
				@endforeach
			</ul>
		</div>
		<button type="button" class="select-checkbox__area" onclick="closeFilter(this)" style="display: none;"></button>
	</div>

	<div class="catalog__select select-checkbox js-category-list">
		<a class="select-checkbox__trigger" onclick="openFilter(this)">
			<span>{!! __('shop.filter_product_type') !!}</span>
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
			</svg>
		</a>

		<div class="select-checkbox__body">
			<ul>
				@foreach($categories_filter as $cat)
					<li>
						<label>
							<input type="checkbox" @if(isset($input['categories'][$cat->id]) && in_array($value->id,$input['attribute'][$attribute->id])) checked @endif
							class="checkbox__input"
										 name="categories[{{$cat->id}}][]"
										 id="categories_{{$cat->id}}_{{$cat->id}}"
										 value="{{$cat->id}}">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
							</svg>
							<span>{{ $cat->title }}</span>
						</label>
					</li>
				@endforeach
			</ul>
		</div>
		<button type="button" class="select-checkbox__area" onclick="closeFilter(this)"></button>
	</div>

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
		<button type="button" class="select-checkbox__area" onclick="closeFilter(this)"></button>
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

</div>
</form>
		<div class="catalog__inner">
			@include('site::catalog.partials.products')
		</div>

	</section>
	</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
