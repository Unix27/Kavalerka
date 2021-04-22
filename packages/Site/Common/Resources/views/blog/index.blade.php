@extends('site::layouts.site')
@php
	$page = \Pages\Models\Page::where('slug', '=', 'blog')->first();
@endphp
@section('seo')
	<title>{{ $page->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $page->meta_description ??'' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection
@section('content')
@include('site::lk.blocks.breadcrumbs')

<section class="blog">
	<div class="container">
		<div class="blog__top">
			<h2 class="blog__title title">{{ $page->title ?? '' }}</h2>
		</div>

		<div class="blog__buttons">

			@foreach($categories as $item)
				<a href="{{ route('site.blog.category', $item->slug) }}" class="blog__btn white-btn @if($item->id == $category->id) active @endif" data-id="{{ $item->id }}">
					{{ $item->title }} ({{$item->posts()->count()}})
				</a>
			@endforeach

		</div>

		<div class="blog__inner">
			@include('site::blog.partials.articles')
		</div>
	</div>
</section>

</main>
@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
