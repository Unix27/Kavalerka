@php
	$cat = new \Shop\Catalog\Models\Category();
	$categories = $cat->getMenuCatalog();
	$menu_categories = $cat->getTopMenu();
	$brands = \Shop\Catalog\Models\Brand::where('active', '=', 1)->get();
	$input = request()->all();
	$cart = session()->get('cart');
	$favorites = session()->get('favorites');
@endphp
<!DOCTYPE html>
<html lang="{{Localization::getCurrentLocale() == 'uk' ? 'UA' : Localization::getCurrentLocale() }}">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="_token" content="<?php echo csrf_token(); ?>">
	<!--<link rel="icon" href="img/favicon.png" type="image/png"/>-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.2/css/pikaday.min.css"  />
	<link rel="stylesheet" href="{{ asset('/assets/css/style.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('/assets/css/frontend.css') }}" />
	@yield('seo')
</head>
<body>

<header class="header">
	<div class="header__top">
		<div class="container">
			<div class="header__top-inner">
				<div class="header__lang">
					<div class="header__lang-trigger">
						<span>{{Localization::getCurrentLocale() == 'uk' ? 'UA' : Localization::getCurrentLocale() }}</span>
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
						</svg>
					</div>
					<div class="header__lang-drop-menu">
						<div class="header__lang-drop-menu-body">
							<ul>
								@foreach(Localization::getSupportedLocales() as $localeCode => $locale)
									<li>
										<a hreflang="{{ $localeCode }}" href="{{
                                            Localization::getDefaultLocale() == $localeCode ?
                                            Localization::getNonLocalizedURL() :
                                            Localization::getLocalizedURL($localeCode, null, [], true)
                                            }}">
											@if($localeCode  == 'uk')
												{{ __('site.lang_ua') }}
											@elseif($localeCode  == 'en')
												{{ __('site.lang_en') }}
											@else
												{{ __('site.lang_ru') }}
											@endif
										</a>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
				<nav class="header__menu">
					<ul>
						<li><a href="#">{!! __('menu.about_company') !!}</a></li>
						<li><a href="{{ route('site.reviews') }}">{!! __('menu.review') !!}</a></li>
						<li><a href="{{ route('site.delivery_payment') }}">{!! __('menu.delivery') !!}</a></li>
						<li><a href="{{ route('site.warranty_return') }}">{!! __('menu.guaranty') !!}</a></li>
						<li><a href="{{ route('site.blog') }}">{!! __('menu.blog') !!}</a></li>
						<li><a href="{{ route('site.discount') }}">{!! __('menu.discount') !!}</a></li>
						<li><a href="#">{!! __('menu.contacts') !!}</a></li>
					</ul>
				</nav>
				<div class="header__tel">
					<a href="tel:+380984574401" class="header__tel-trigger">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#tel') }}"></use>
						</svg>
						<span>+38 098 457 44 01</span>
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
						</svg>
					</a>
					<div class="header__tel-drop-menu">
						<div class="header__tel-drop-menu-body">
							<a href="tel:+380984574401">+38 098 457 44 01</a>
							<button class="accent-btn header__tel-btn">{!! __('site.recall_me') !!}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header__center">
		<div class="container">
			<div class="header__center-inner">

				<button class="header__burger burger" onclick="togglePopup('modal-mobile-menu');" id="burger" aria-label="Mobile menu">
					<span class="burger__inner"> <span></span> </span>
				</button>

				<div class="header__gender">
					<ul>

						@foreach($menu_categories['categories'] as $item)
							@if(isset($item->slug))
								<li>
									<a href="{{ route('site.page', ['slug' => $item->slug]) }}" @if($menu_categories['category'] == $item->id) class="active" @endif>{{ $item->title }}</a>
								</li>
							@endif
						@endforeach

					</ul>
				</div>

				<div class="header__logo">
					<a href="{{ route('site.index') }}">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#logotype') }}"></use>
						</svg>
						<h1 class="header__logo-title">{!! __('site.title_under_logo') !!}</h1>
					</a>
				</div>

				<div class="header__profile">
				@if(auth()->user())
					<div class="header__profile-trigger">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#profile-user') }}"></use>
						</svg>
						<span>{!! __('site.hello') !!}, {{ auth()->user()->first_name }}</span>
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
						</svg>
						<div class="header__profile-drop-menu">
							<div class="header__profile-drop-menu-body">
								<ul>
									<li><a href="{{ route('site.dashboard.profile') }}">{!! __('menu.my_profile') !!}</a></li>
									<li>
										<ul>
											<li><a href="{{ route('site.dashboard.my_orders') }}">{!! __('menu.orders') !!}</a></li>
											<li><a href="{{ route('site.dashboard.favorite_products') }}">{!! __('menu.favorites') !!}</a></li>
											<li><a href="{{ route('site.dashboard.viewed_products') }}">{!! __('menu.seen') !!}</a></li>
										</ul>
									</li>
									<li><a href="{{ route('site.dashboard.my_reviews') }}">{!! __('menu.my_review') !!}</a></li>
									<li><a href="{{ route('site.dashboard.wholesale') }}">{!! __('menu.wholesale') !!}</a></li>
									<li><a href="{{ route('site.logout') }}">{!! __('menu.exit') !!}</a></li>
								</ul>
							</div>
						</div>
					</div>
				@else
					<div class="header__profile-trigger">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#profile-userк') }}"></use>
						</svg>
						<a href="{{ route('login') }}">
							<span>{!! __('auth.enter') !!}</span>
						</a>
						<span> / </span>
						<a href="{{ route('register') }}">
							<span>{!! __('auth.registration') !!}</span>
						</a>
					</div>
				@endif
					</div>
				<form method="GET" action="{{ route('site.search')}}">
					<div class="header__search">
						<input name="q" type="text" placeholder="{!! __('site.search') !!}">
						<button type="submit" class="header__button header__button--loupe">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#loupe') }}"></use>
							</svg>
						</button>
					</div>
				</form>
					@if(auth()->user())
						<div class="header__favorites">
							<a href="{{ route('site.dashboard.favorite_products') }}" class="header__button header__button--heart">
								<svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
								</svg>
								<span>{{ auth()->user()->favoriteProducts()->count() }}</span>
							</a>
						</div>
					@else
						<div class="header__favorites">
							<a href="{{ route('login') }}" class="header__button header__button--heart">
								<svg>
									<use xlink:href="{{ asset('/assets/img/sprite.svg#heart') }}"></use>
								</svg>
								<span>@if(isset($favorites)) {{ count($favorites) }} @else 0 @endif</span>
							</a>
						</div>
					@endif

					<div class="header__shopping-cart">
						<button class="header__button header__button--shopping-cart">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#shopping-cart') }}"></use>
							</svg>
							<span></span>
						</button>
						<div class="header__shopping-cart-drop-menu shopping-cart">
							@include('site::layouts.partials.cart')
						</div>
					</div>
					</div>
				</div>
			</div>

@if(route('site.index') != url()->current())
	@include('site::pages.partials.shop-menu')
@endif

</header>


<main class="main">
@yield('content')

@yield('footer')
