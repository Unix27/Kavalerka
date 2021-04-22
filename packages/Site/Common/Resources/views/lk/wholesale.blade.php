@extends('site::layouts.site')
@section('seo')
	<title>{{ $page->meta_title ?? __('menu.wholesale') }}</title>
	<meta name="description" content="{{ $page->meta_description ?? '' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection

@section('content')
	@include('site::lk.blocks.breadcrumbs')
	<section class="profile">
		<div class="container">
			<div class="profile__top">
				<h2 class="profile__title title">{{ $page->title ?? __('menu.wholesale') }}</h2>
			</div>
			<div class="profile__inner">

				@include('site::lk.blocks.aside-menu')

				<div class="profile__content">
					<h2 class="profile__suptitle suptitle">{!! __('site.show_wholesales_price') !!}</h2>
					<div class="profile__opt">
						<label class="check-switch">
							<input name="is_wholesale" class="check-switch__input" type="checkbox" value="1" />
							<span class="check-switch__right"> {!! __('site.off') !!} </span>
							<span class="check-switch__round"></span>
							<span class="check-switch__left"> {!! __('site.on') !!} </span>
						</label>
						{!! $page->content !!}
{{--						<ul style="display:none">--}}
{{--							<li>{!! __('site.wholesale_desc_1') !!}</li>--}}
{{--							<li>{!! __('site.wholesale_desc_1') !!}</li>--}}
{{--							<li>{!! __('site.wholesale_desc_1') !!}</li>--}}
{{--						</ul>--}}
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
