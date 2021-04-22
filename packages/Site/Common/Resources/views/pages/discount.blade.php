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
		<h2 class="info__title title  info__title--mobile-center">{{ $page->title ?? '' }}</h2>
		<div class="info__inner">
			<div class="info__discount">
				<div class="info__box">
					<h3 class="info__box-title subtitle"> {!! __('site.discount_system') !!} </h3>
					<div class="info__box-descr text">
						<p>
							{!! __('site.discount_system_description') !!}
						</p>
					</div>
				</div>
				<div class="info__discount-inner">

					@foreach($discounts as $discount)

						<div class="info__discount-item">
							<div class="info__discount-item-body"><span>{{ $discount->percent }} %</span></div>
							<div class="info__discount-item-bottom text"><span>{!! __('shop.from') !!} {{ $discount->total }} {!! __('shop.grn') !!}</span></div>
						</div>

					@endforeach
				</div>
				<div class="info__centered">
					<h3 class="info__title title">{!! __('site.discount_conditions_title') !!}</h3>
					<div class="info__text text">
						<p>{!! __('site.discount_conditions_sub_title') !!}</p>
					</div>
				</div>
				<div class="info__items">
					<div class="info__item">
						<h4 class="info__item-title subtitle">{!! __('site.discount_condition_title_1') !!}</h4>
						<div class="info__item-text text">
							<p>{!! __('site.discount_condition_description_1') !!}</p>
						</div>
					</div>
					<div class="info__item">
						<h4 class="info__item-title subtitle">{!! __('site.discount_condition_title_2') !!}</h4>
						<div class="info__item-text text">
							<p>{!! __('site.discount_condition_description_2') !!}</p>
						</div>
					</div>
					<div class="info__item">
						<h4 class="info__item-title subtitle">{!! __('site.discount_condition_title_3') !!}</h4>
						<div class="info__item-text text">
							<p>{!! __('site.discount_condition_description_3') !!}</p>
						</div>
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
