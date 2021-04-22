@extends('site::layouts.site')

@section('seo')
	<title>{{ $page->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $page->meta_description ??'' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection

@section('content')
	<section class="notification">
		<div class="container">
			<span class="notification__title-minor title">{!! __('auth.login_or_register') !!}</span>
			<div class="notification__inner notification__inner--border">
				<h2 class="notification__title title">{!! __('auth.title_success_register') !!}</h2>
				<div class="notification__text text">
					<p>{!! __('auth.description_success_register') !!}</p>
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
