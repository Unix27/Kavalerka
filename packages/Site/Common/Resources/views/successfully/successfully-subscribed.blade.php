@extends('site::layouts.site')

@section('seo')
	<title>{{ $page->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $page->meta_description ??'' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection

@section('content')
	@include('site::lk.blocks.breadcrumbs')
	<section class="notification">
		<div class="container">
			<div class="notification__inner">
				<h2 class="notification__title title">{!! __('site.successfully_subscribe_title') !!}</h2>
				<div class="notification__text text">
					<p>{!! __('site.successfully_subscribe_description') !!}</p>
				</div>
				<div class="notification__btn">
					<a href="{{ route('site.index') }}" class="accent-btn">{!! __('site.go_home') !!}</a>
				</div>
			</div>
		</div>
	</section>
</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
