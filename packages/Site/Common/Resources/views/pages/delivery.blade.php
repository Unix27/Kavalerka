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
				<div class="info__delivery">
					<div class="info__title-svg">
						<div class="info__title">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#package') }}"></use>
							</svg>
							<h3 class="info__subtitle subtitle">{!! __('shop.delivery') !!}</h3>
						</div>
						<div class="info__text text">
							<p>
								{!! __('shop.delivery_description') !!}
							</p>
						</div>
					</div>
					<div class="info__items">
						<div class="info__item">
							<h4 class="info__item-title subtitle">{!! __('shop.delivery_method_1') !!}</h4>
							<div class="info__item-text text">
								<p>
									{!! __('shop.delivery_method_description_1') !!}
								</p>
							</div>
						</div>
						<div class="info__item">
							<h4 class="info__item-title subtitle">{!! __('shop.delivery_method_2') !!}</h4>
							<div class="info__item-text text">
								<p>
									{!! __('shop.delivery_method_description_2') !!}
								</p>
							</div>
						</div>
						<div class="info__item">
							<h4 class="info__item-title subtitle">{!! __('shop.delivery_method_3') !!}</h4>
							<div class="info__item-text text">
								<p>
									{!! __('shop.delivery_method_description_3') !!}
								</p>
							</div>
						</div>
					</div>
					<div class="info__title-svg">
						<div class="info__title">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#payment') }}"></use>
							</svg>
							<h3 class="info__subtitle subtitle">{!! __('shop.payment') !!}</h3>
						</div>
						<div class="info__text text">
							<p>
								{!! __('shop.payment_description') !!}
							</p>
						</div>
					</div>
					<div class="info__items">
						<div class="info__item">
							<h4 class="info__item-title subtitle">{!! __('shop.payment_method_1') !!}</h4>
							<div class="info__item-text text">
								<p>
									{!! __('shop.payment_method_description_1') !!}
								</p>
							</div>
						</div>
						<div class="info__item">
							<h4 class="info__item-title subtitle">{!! __('shop.payment_method_2') !!}</h4>
							<div class="info__item-text text">
								<p>
									{!! __('shop.payment_method_description_2') !!}
								</p>
							</div>
						</div>
						<div class="info__item">
							<h4 class="info__item-title subtitle">{!! __('shop.payment_method_3') !!}</h4>
							<div class="info__item-text text">
								<p>
									{!! __('shop.payment_method_description_3') !!}
								</p>
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
