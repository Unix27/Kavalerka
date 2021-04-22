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
		<div class="info__inner">
			<h2 class="info__title title"> {{ $page->title ?? '' }}</h2>

			{!! $page->content ?? '' !!}

		</div>
	</div>
</section>
</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection

