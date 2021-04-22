@extends('site::layouts.site')

@section('seo')
	<title>{{ $page->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $page->meta_description ??'' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection

@section('content')

	<section class="authorization">
		<div class="container">
			<h2 class="authorization__title title">{{ $page->title ?? '' }}</h2>
			<div class="authorization__inner">
				<div class="authorization__box">
					<div class="authorization__top" data-trigger=".authorization__trigger" data-content=".authorization__content">
						<button class="authorization__trigger" onclick="tabChange(this, 'form-authorization')">{!! __('site.enter') !!}</button>
						<button class="authorization__trigger active" onclick="tabChange(this, 'form-registration')">{!! __('site.register') !!}</button>
					</div>
					<div class="authorization__body">

						<form action="#" class="authorization__content" id="form-authorization">

							<div class="authorization__input-wrapper">  <!--выдать класс authorization__input-wrapper--error, если ошибка-->
								<input name="email" type="email" placeholder="Email" autocomplete="email"/>
								<span class="authorization__input-error">{!! __('auth.enter_email') !!}</span>
							</div>

							<div class="authorization__input-wrapper"> <!--выдать класс authorization__input-wrapper--error, если ошибка-->
								<input name="password" type="password" placeholder="{!! __('site.password') !!}" autocomplete="current-password"/>
								<svg onclick="visibilityPassword(this.previousElementSibling)">
									<use xlink:href="{{ asset('/assets/img/sprite.svg#eye') }}"></use>
								</svg>
								<span class="authorization__input-error">{!! __('auth.enter_password') !!}</span>
							</div>

							<button type="submit" class="accent-btn authorization__btn">{!! __('site.enter') !!}</button>

							<div class="authorization__forgot">
								<a href="#">{!! __('auth.forgot_password') !!}</a>
							</div>
							<!--показывать, если есть ошибка-->
							<div class="authorization__error">
								{{--									<span></span>--}}
							</div>
						</form>

						<form action="#" method="POST" class="authorization__content active" id="form-registration">
							@csrf
							<div class="authorization__input-wrapper">
								<input name="first_name" type="text" placeholder="{!! __('site.name') !!}" autocomplete="username"/>
								<span class="authorization__input-error">{!! __('auth.enter_name') !!}</span>
							</div>

							<div class="authorization__input-wrapper"> <!--выдать класс authorization__input-wrapper--error, если ошибка-->
								<input name="email" type="email" placeholder="Email" autocomplete="email"/>
								<span class="authorization__input-error">{!! __('auth.enter_mail') !!}</span>
							</div>

							<div class="authorization__input-wrapper">
								<input name="phone" type="tel" placeholder="{!! __('site.phone') !!}" autocomplete="tel"/>
								<span class="authorization__input-error">{!! __('auth.enter_phone') !!}</span>
							</div>

							<div class="authorization__input-wrapper"> <!--выдать класс authorization__input-wrapper--error, если ошибка-->
								<input name="password" type="password" placeholder="{!! __('site.password') !!}" autocomplete="new-password"/>
								<svg onclick="visibilityPassword(this.previousElementSibling)">
									<use xlink:href="{{ asset('/assets/img/sprite.svg#eye') }}"></use>
								</svg>
								<span class="authorization__input-error">{!! __('auth.enter_password') !!}</span>
							</div>

							<label class="authorization__agree">
								<input name="confirmation" type="checkbox" checked/>
								<svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#check') }}"></use>
								</svg>
								<span>{!! __('auth.i_agree') !!} <a href="{{ route('site.page', 'privacy-policy') }}">{!! __('auth.privacy_policy') !!}</a> {!! __('site.and') !!} <a href="{{ route('site.page', 'terms-use') }}">{!! __('auth.terms_use') !!}</a></span>
							</label>

							<button type="submit" class="accent-btn authorization__btn">{!! __('site.enter') !!}</button>
							<!--показывать, если есть ошибка-->
							<div class="authorization__error">
								{{--									<span>Текст ошибки</span>--}}
							</div>

						</form>

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
