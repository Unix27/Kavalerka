@extends('site::layouts.site')

@section('seo')
	<title>{{ $article->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $article->meta_description ??'' }}">
	<meta name="keywords" content="{{ $article->meta_keywords ?? '' }}">
@endsection
@section('content')
<div class="breadcrumbs">
	<div class="container">
		<div class="breadcrumbs__inner">
			<ol class="breadcrumbs__list">
				<li><a href="{{ route('site.index') }}">{{ __('menu.index') }}</a></li>
				<li><a href="{{ route('site.blog') }}">{{ __('menu.blog') }}</a></li>
				<li><a href="{{ route('site.blog.category', $category->slug)}}">{{ $article->category()->first()->title }}</a></li>
					<li>{{ $article->title }}</li>
			</ol>
		</div>
	</div>
</div>

<section class="article">
	<div class="container">
		<div class="article__top">
			<h2 class="article__title title">{{ $page->title ?? '' }}</h2>
			<div class="article__date">
				<svg>
					<use xlink:href="{{ asset('/assets/img/sprite.svg#clock') }}"></use>
				</svg>
				<span>{{ date("d.m.Y", strtotime($article->created_at)) }}</span>
			</div>
			<div class="article__views">
				<svg>
					<use xlink:href="{{ asset('/assets/img/sprite.svg#eye') }}"></use>
				</svg>
				<span>{{ $article->views }}</span>
			</div>
		</div>

		<div class="article__inner">
			{!! $article->content !!}
		</div>

	</div>
</section>
</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
