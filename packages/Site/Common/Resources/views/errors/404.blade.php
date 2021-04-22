@extends('site::layouts.site')

@section('content')

<section class="notification">
	<div class="container">
		<div class="notification__inner">
			<h2 class="notification__title">{{ __('site.404_title') }}</h2>
			<div class="notification__text">
				<p>{!! __('site.404_description') !!}</p>
			</div>
			<div class="notification__btn">
				<a href="#" class="accent-btn">{!! __('site.go_home') !!}</a>
			</div>
		</div>
	</div>
</section>
</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
