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
			<div class="info__text text">
				<p>
					{!! __('shop.warranty_return_description') !!}
				</p>
			</div>
			<div class="info__inner">
				<div class="info__warranty">
					<div class="info__items">
						<h3 class="info__items-title subtitle">{!! __('shop.condition_return_product') !!}</h3>
						<div class="info__item">
							<h4 class="info__item-title subtitle">{!! __('shop.warranty_return_condition_1') !!}</h4>
							<div class="info__item-text text">
								<p>
									{!! __('shop.warranty_return_condition_description_1') !!}
								</p>
							</div>
						</div>
						<div class="info__item">
							<h4 class="info__item-title subtitle">{!! __('shop.warranty_return_condition_2') !!}</h4>
							<div class="info__item-text text">
								<p>
									{!! __('shop.warranty_return_condition_description_2') !!}
								</p>
							</div>
						</div>
						<div class="info__item">
							<h4 class="info__item-title subtitle">{!! __('shop.warranty_return_condition_3') !!}</h4>
							<div class="info__item-text text">
								<p>
									{!! __('shop.warranty_return_condition_description_3') !!}
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
