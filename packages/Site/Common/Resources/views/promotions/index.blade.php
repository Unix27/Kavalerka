@extends('site::layouts.site')

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
				<h2 class="catalog__title title">{{ $category->title ?? '' }}</h2>
				<span class="catalog__span span">({{ $category->promotions_count }} {!! __('site.promotions') !!})</span>
			</div>
			<div class="catalog__events-buttons">

				@foreach($categories as $item)
					<a href="{{ route('site.promotions', $item->slug) }}" class="catalog__events-btn white-btn @if($item->id == $category->id) active @endif">
						{{ $item->title }} <span>({{ $item->promotions_count }})</span>
					</a>
				@endforeach

			</div>
			<div class="catalog__events-inner">

				@include('site::promotions.partials.promotion')


			</div>
		</div>
	</section>
	</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection

