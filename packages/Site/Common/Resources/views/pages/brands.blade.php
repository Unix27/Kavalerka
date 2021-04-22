@php
	$sortBrands = array();
			foreach($brands as $value) {
				 $sortBrands[(mb_substr($value->title, 0, 1))][] = $value;
			}
@endphp
@extends('site::layouts.site')
@section('seo')
	<title>{{ $page->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $page->meta_description ??'' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection
@section('content')
	@include('site::lk.blocks.breadcrumbs')

	<section class="info">
		<div class="container">
			<h2 class="info__title title">{{ $page->title ?? '' }}</h2>
			<div class="info__inner">
				<div class="info__brands">
					<div class="info__items">

						@foreach($sortBrands as $key => $items)
							<div class="info__item">
								<h4 class="info__item-title subtitle">{{ $key }}</h4>
							</div>
							<div class="info__text text">
								@foreach($items as $brand)
									<a href="#">{{ $brand->title }}</a>
								@endforeach
							</div>
						@endforeach
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
