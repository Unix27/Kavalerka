@php
	$cat = new \Shop\Catalog\Models\Category();
	$categories = $cat->getMenuCatalog();
	$menu_categories = $cat->getTopMenu();
@endphp
<footer class="footer">
	<div class="footer__top">
		<div class="container">
			<div class="footer__top-inner">
				<div class="footer__description">
					<a href="#" class="footer__logo">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#logotype') }}"></use>
						</svg>
					</a>
					<div class="footer__social-media">
						<a href="#">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#youtube') }}"></use>
							</svg>
						</a>
						<a href="#">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#telegram') }}"></use>
							</svg>
						</a>
						<a href="#">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#instagram') }}"></use>
							</svg>
						</a>
						<a href="#">
							<svg>
								<use xlink:href="{{ asset('/assets/img/sprite.svg#facebook') }}"></use>
							</svg>
						</a>
					</div>
					<div class="footer__address">
						<p>Украина, Львовская область, Львов, ул. Базарная, 11</p>
					</div>
				</div>
				<div class="footer__accord">
					<div
						class="footer__title footer__accord-trigger"
						onclick="this.parentNode.classList.toggle('active')"
					>
						<h2>Клиентам</h2>
					</div>
					<div class="footer__accord-body">
						<ul>
							<li><a href="#">{!! __('menu.about_company') !!}</a></li>
							<li><a href="{{ route('site.reviews') }}">{!! __('menu.review') !!}</a></li>
							<li><a href="{{ route('site.delivery_payment') }}">{!! __('menu.delivery') !!}</a></li>
							<li><a href="{{ route('site.warranty_return') }}">{!! __('menu.guaranty') !!}</a></li>
							<li><a href="{{ route('site.blog') }}">{!! __('menu.blog') !!}</a></li>
							<li><a href="{{ route('site.discount') }}">{!! __('menu.discount') !!}</a></li>
							<li><a href="#">{!! __('menu.contacts') !!}</a></li>
						</ul>
					</div>
				</div>
				<div class="footer__accord">
					<div
						class="footer__title footer__accord-trigger"
						onclick="this.parentNode.classList.toggle('active')"
					>
						<h2>{!! __('menu.contact_us') !!}</h2>
					</div>
					<div class="footer__accord-body">
						<ul>
							<li><a href="tel:380988888888">+38 (098) 888-8888</a></li>
							<li><a href="tel:380977777777">+38 (097) 777-7777</a></li>
						</ul>
						<a href="#" class="footer__link">{!! __('site.recall_me') !!}</a>
					</div>
				</div>
				<div class="footer__accord">
					<div
						class="footer__title footer__accord-trigger"
						onclick="this.parentNode.classList.toggle('active')"
					>
						<h2>Скидка 150 грн на первый заказ</h2>
					</div>
					<div class="footer__accord-body">
						<p>Подпишитесь и получите Промокод на 150 грн</p>
						<input type="text" placeholder="Введите  ваш email" />
						<a href="#" class="footer__link">Я женщина</a>
						<a href="#" class="footer__link">Я мужчина</a>
					</div>
				</div>
{{--				<div class="footer__accord d-lg-none d-block">--}}
{{--					<div--}}
{{--						class="footer__title footer__accord-trigger"--}}
{{--						onclick="this.parentNode.classList.toggle('active')"--}}
{{--					>--}}
{{--						<h2>Соглашения</h2>--}}
{{--					</div>--}}
{{--					<div class="footer__accord-body">--}}
{{--						<ul>--}}
{{--							<li><a href="tel:380988888888">{{ __('menu.privacy_policy') }}</a></li>--}}
{{--							<li><a href="tel:380977777777">{{ __('menu.terms_use') }}</a></li>--}}
{{--							<li><a href="tel:380977777777">{{ __('menu.cookie') }}</a></li>--}}
{{--						</ul>--}}
{{--					</div>--}}
{{--				</div>--}}
			</div>
		</div>
	</div>

	<div class="footer__center">
		<div class="container">
			<div class="footer__center-inner">
				<div class="footer__links">
					<a href="{{ route('site.page', 'privacy-policy') }}">{{ __('menu.privacy_policy') }}</a>
					<a href="{{ route('site.page', 'terms-use') }}">{{ __('menu.terms_use') }}</a>
					<a href="{{ route('site.page', 'cookie') }}">{{ __('menu.cookie') }}</a>
				</div>

				<div class="footer__theme">
					<h2 class="footer__title">{!! __('site.theme') !!}</h2>
					<input
						class="theme-switch__input"
						type="checkbox"
						id="theme-switch__checkbox"
						onchange="toggleTheme()"
					/>
					<label class="theme-switch" for="theme-switch__checkbox">
						<svg class="theme-switch__sunny-day">
							<use xlink:href="{{ asset('/assets/img/sprite.svg#sunny-day') }}"></use>
						</svg>
						<span class="theme-switch__round"></span>
						<svg class="theme-switch__night">
							<use xlink:href="{{ asset('/assets/img/sprite.svg#night') }}"></use>
						</svg>
					</label>
				</div>
				<div class="footer__lang">
					<h2 class="footer__title">{!! __('site.language') !!}</h2>
					<select>
						<option selected>{!! __('site.lang_ru') !!}</option>
						<option>{!! __('site.lang_ua') !!}</option>
						<option>{!! __('site.lang_en') !!}</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="footer__bottom">
		<div class="container">
			<div class="footer__bottom-inner">
				<div class="footer__copy-right">
					<span>{!! __('site.copyright') !!}</span>
				</div>
				<div class="footer__developed-by">
					<span>{!! __('site.designed_by') !!} <a href="#">UniwersalWeb</a></span>
				</div>
			</div>
		</div>
	</div>

</footer>

<div class="drop-menu-mobile__wrapper" id="modal-mobile-menu">
	<button onclick="toggleModal('modal-mobile-menu')" class="drop-menu-mobile__area"></button>
	<div class="drop-menu-mobile__inner">
		<div class="drop-menu-mobile__content drop-menu-mobile">
			<div class="drop-menu-mobile__top">
				<div class="header__profile header__profile--mobile">
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
			</div>
			<div class="drop-menu-mobile__body">
				<div class="drop-menu-mobile__gender">
					<ul>
						@foreach($menu_categories['categories'] as $item)
							<li>
								<a href="{{ route('site.page', ['slug' => $item->slug]) }}" @if($menu_categories['category'] == $item->id) class="active" @endif>{{ $item->title }}</a>
							</li>
						@endforeach
					</ul>
				</div>
				<div class="drop-menu-mobile__list">
					<ul>
						<li><a href="{{ route('site.index') }}">{!! __('menu.index') !!}</a></li>
						<li>
							<span type="button" onclick="this.parentNode.classList.toggle('active')">Одежда</span>
							<div class="drop-menu-mobile">
								<div class="drop-menu-mobile__top" onclick="this.parentNode.parentNode.classList.toggle('active')">
									<button class="drop-menu-mobile__top-title">
										<svg>
											<use xlink:href={{ asset('/assets/img/sprite.svg#arrow-left') }}></use>
										</svg>
										<span>Одежда</span>
									</button>
								</div>
								<div class="drop-menu-mobile__body">
									<ul>
										<li><a href="#">Туники</a></li>
										<li><a href="#">Сарафаны</a></li>
										<li class="extra-menu__wrapper" onclick="this.classList.toggle('active')">
											<a href="#" class="extra-menu__title">
												<span>Одежда для пляжа</span>
												<svg>
													<use xlink:href="{{ asset('/assets/img/sprite.svg#add') }}"></use>
												</svg>
												<svg>
													<use xlink:href={{ asset('/assets/img/sprite.svg#minus') }}></use>
												</svg>
											</a>
											<ul class="extra-menu">
												<li><a href="#">Купальники</a></li>
												<li><a href="#">Плавки</a></li>
											</ul>
										</li>
										<li><a href="#">Пункт 4</a></li>
										<li><a href="#">Пункт 5</a></li>
										<li><a href="#">Пункт 6</a></li>
										<li><a href="#">Пункт 7</a></li>
										<li><a href="#" class="link-arrow-right">
												<span>Все товары</span>
												<svg>
													<use xlink:href="{{ asset('/assets/img/sprite.svg#long-arrow-right') }}"></use>
												</svg>
											</a></li>
									</ul>
								</div>
								<div class="drop-menu-mobile__footer">
									<span>Популярные категории</span>
								</div>
								<div class="drop-menu-mobile__images">
									<ul>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-1.jpg') }}" alt="" />
												<span>Категория 1</span>
											</a>
										</li>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-2.jpg') }}" alt="" />
												<span>Категория 2</span>
											</a>
										</li>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-3.jpg') }}" alt="" />
												<span>Категория 3</span>
											</a>
										</li>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-4.jpg') }}" alt="" />
												<span >Категория 4</span>
											</a>
										</li>
									</ul>
								</div>
								<div class="drop-menu-mobile__footer">
									<span>Популярные бренды</span>
								</div>
								<div class="drop-menu-mobile__with-mini-image">
									<ul>
										<li> <a href="#" class="weight-600"><img src="{{ asset('/assets/img/brand-1.jpg') }}" alt="" />Бренд 1</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-2.jpg') }}" alt="" />Бренд 2</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-3.jpg') }}" alt="" />Бренд 3</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-4.jpg') }}" alt="" />Бренд 4</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-1.jpg') }}" alt="" />Бренд 5</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-3.jpg') }}" alt="" />Бренд 6</a> </li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<span onclick="this.parentNode.classList.toggle('active')">Обувь</span>
							<div class="drop-menu-mobile">
								<div class="drop-menu-mobile__top" onclick="this.parentNode.parentNode.classList.toggle('active')">
									<button class="drop-menu-mobile__top-title">
										<svg>
											<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-left') }}"></use>
										</svg>
										<span>Обувь</span>
									</button>
								</div>
								<div class="drop-menu-mobile__body">
									<ul>
										<li><a href="#">Туники</a></li>
										<li><a href="#">Сарафаны</a></li>
										<li class="extra-menu__wrapper" onclick="this.classList.toggle('active')">
											<a href="#" class="extra-menu__title">
												<span>Одежда для пляжа</span>
												<svg>
													<use xlink:href={{ asset('/assets/img/sprite.svg#add') }}></use>
												</svg>
												<svg>
													<use xlink:href={{ asset('/assets/img/sprite.svg#minus') }}></use>
												</svg>
											</a>
											<ul class="extra-menu">
												<li><a href="#">Купальники</a></li>
												<li><a href="#">Плавки</a></li>
											</ul>
										</li>
										<li><a href="#">Пункт 4</a></li>
										<li><a href="#">Пункт 5</a></li>
										<li><a href="#">Пункт 6</a></li>
										<li><a href="#">Пункт 7</a></li>
										<li><a href="#" class="link-arrow-right">
												<span>Все товары</span>
												<svg>
													<use xlink:href={{ asset('/assets/img/sprite.svg#long-arrow-right') }}></use>
												</svg>
											</a></li>
									</ul>
								</div>
								<div class="drop-menu-mobile__footer">
									<span>Последние обновления</span>
								</div>
								<div class="drop-menu-mobile__images">
									<ul>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-1.jpg') }}" alt="" />
												<span>Категория 1</span>
											</a>
										</li>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-2.jpg') }}" alt="" />
												<span>Категория 2</span>
											</a>
										</li>
										<li>
											<a href="#"><img src="{{ asset('/assets/img/event-3.jpg') }}" alt="" />
												<span >Категория 3</span></a>
										</li>
										<li>
											<a href="#"><img src="{{ asset('/assets/img/event-4.jpg') }}" alt="" />
												<span >Категория 4</span></a>
										</li>
									</ul>
								</div>
								<div class="drop-menu-mobile__footer">
									<span>Новинки по брендам</span>
								</div>
								<div class="drop-menu-mobile__with-mini-image">
									<ul>
										<li> <a href="#" class="weight-600"><img src="{{ asset('/assets/img/brand-1.jpg') }}" alt="" />Бренд 1</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-2.jpg') }}" alt="" />Бренд 2</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-3.jpg') }}" alt="" />Бренд 3</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-4.jpg') }}" alt="" />Бренд 4</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-5.jpg') }}" alt="" />Бренд 5</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-6.jpg') }}" alt="" />Бренд 6</a> </li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<span onclick="this.parentNode.classList.toggle('active')">Аксессуары</span>
							<div class="drop-menu-mobile">
								<div class="drop-menu-mobile__top" onclick="this.parentNode.parentNode.classList.toggle('active')">
									<button class="drop-menu-mobile__top-title">
										<svg>
											<use xlink:href={{ asset('/assets/img/sprite.svg#arrow-left') }}></use>
										</svg>
										<span>Аксессуары</span>
									</button>
								</div>
								<div class="drop-menu-mobile__body">
									<ul>
										<li><a href="#">Туники</a></li>
										<li><a href="#">Сарафаны</a></li>
										<li class="extra-menu__wrapper" onclick="this.classList.toggle('active')">
											<a href="#" class="extra-menu__title">
												<span>Одежда для пляжа</span>
												<svg>
													<use xlink:href={{ asset('/assets/img/sprite.svg#add') }}></use>
												</svg>
												<svg>
													<use xlink:href={{ asset('/assets/img/sprite.svg#minus') }}></use>
												</svg>
											</a>
											<ul class="extra-menu">
												<li><a href="#">Купальники</a></li>
												<li><a href="#">Плавки</a></li>
											</ul>
										</li>
										<li><a href="#">Пункт 4</a></li>
										<li><a href="#">Пункт 5</a></li>
										<li><a href="#">Пункт 6</a></li>
										<li><a href="#">Пункт 7</a></li>
										<li><a href="#" class="link-arrow-right">
												<span>Все товары</span>
												<svg>
													<use xlink:href={{ asset('/assets/img/sprite.svg#long-arrow-right') }}></use>
												</svg>
											</a></li>
									</ul>
								</div>
								<div class="drop-menu-mobile__footer">
									<span>Текущие акции</span>
								</div>
								<div class="drop-menu-mobile__images">
									<ul>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-1.jpg') }}" alt="" />
												<span>Категория 1</span>
											</a>
										</li>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-2.jpg') }}" alt="" />
												<span>Категория 2</span>
											</a>
										</li>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-3.jpg') }}" alt="" />
												<span >Категория 3</span>
											</a>
										</li>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-4.jpg') }}" alt="" />
												<span >Категория 4</span>
											</a>
										</li>
									</ul>
								</div>
								<div class="drop-menu-mobile__footer">
									<span>Популярные бренды</span>
								</div>
								<div class="drop-menu-mobile__with-mini-image">
									<ul>
										<li> <a href="#" class="weight-600"><img src="{{ asset('/assets/img/brand-1.jpg') }}" alt="" />Бренд 1</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-2.jpg') }}" alt="" />Бренд 2</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-3.jpg') }}" alt="" />Бренд 3</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-4.jpg') }}" alt="" />Бренд 4</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-5.jpg') }}" alt="" />Бренд 5</a> </li>
										<li> <a href="#"><img src="{{ asset('/assets/img/brand-6.jpg') }}" alt="" />Бренд 6</a> </li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<span onclick="this.parentNode.classList.toggle('active')">Новинки</span>
							<div class="drop-menu-mobile">
								<div class="drop-menu-mobile__top" onclick="this.parentNode.parentNode.classList.toggle('active')">
									<button class="drop-menu-mobile__top-title">
										<svg>
											<use xlink:href={{ asset('/assets/img/sprite.svg#arrow-left') }}></use>
										</svg>
										<span>Новинки</span>
									</button>
								</div>
								<div class="drop-menu-mobile__none">
									<p>Упс! Новинок нет, но они скоро появятся :)</p>
								</div>
							</div>
						</li>
						<li>
							<span onclick="this.parentNode.classList.toggle('active')">Распродажа</span>
							<div class="drop-menu-mobile">
								<div class="drop-menu-mobile__top" onclick="this.parentNode.parentNode.classList.toggle('active')">
									<button class="drop-menu-mobile__top-title">
										<svg>
											<use xlink:href={{ asset('/assets/img/sprite.svg#arrow-left') }}></use>
										</svg>
										<span>Распродажа</span>
									</button>
								</div>
								<div class="drop-menu-mobile__none">
									<p>Сейчас нет никаких распродаж. Но мы скоро это исправим :)</p>
								</div>
							</div>
						</li>
						<li>
							<span onclick="this.parentNode.classList.toggle('active')">Бренды</span>
							<div class="drop-menu-mobile">
								<div class="drop-menu-mobile__top" onclick="this.parentNode.parentNode.classList.toggle('active')">
									<button class="drop-menu-mobile__top-title">
										<svg>
											<use xlink:href={{ asset('/assets/img/sprite.svg#arrow-left') }}></use>
										</svg>
										<span>Бренды</span>
									</button>
								</div>
								<div class="drop-menu-mobile__body">
									<ul>
										<li><a href="#">Туники</a></li>
										<li><a href="#">Сарафаны</a></li>
										<li class="extra-menu__wrapper" onclick="this.classList.toggle('active')">
											<a href="#" class="extra-menu__title">
												<span>Одежда для пляжа</span>
												<svg>
													<use xlink:href={{ asset('/assets/img/sprite.svg#add') }}></use>
												</svg>
												<svg>
													<use xlink:href={{ asset('/assets/img/sprite.svg#minus') }}></use>
												</svg>
											</a>
											<ul class="extra-menu">
												<li><a href="#">Купальники</a></li>
												<li><a href="#">Плавки</a></li>
											</ul>
										</li>
										<li><a href="#">Пункт 4</a></li>
										<li><a href="#">Пункт 5</a></li>
										<li><a href="#">Пункт 6</a></li>
										<li><a href="#">Пункт 7</a></li>
										<li><a href="#" class="link-arrow-right">
												<span>Все товары</span>
												<svg>
													<use xlink:href={{ asset('/assets/img/sprite.svg#long-arrow-right') }}></use>
												</svg>
											</a></li>
									</ul>
								</div>
								<div class="drop-menu-mobile__footer">
									<span>Текущие акции</span>
								</div>
								<div class="drop-menu-mobile__images">
									<ul>
										<li>
											<a href="#"><img src="{{ asset('/assets/img/event-1.jpg') }}" alt="" /><span
												>Категория 1</span></a>
										</li>
										<li>
											<a href="#">
												<img src="{{ asset('/assets/img/event-2.jpg') }}" alt="" />
												<span>Категория 2</span>
											</a>
										</li>
										<li>
											<a href="#"><img src="{{ asset('/assets/img/event-3.jpg') }}" alt="" /><span
												>Категория 3</span></a>
										</li>
										<li>
											<a href="#"><img src="{{ asset('/assets/img/event-4.jpg') }}" alt="" /><span
												>Категория 4</span></a>
										</li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="drop-menu-mobile__menu">
					<ul>
						<li><a href="#">{!! __('menu.about_company') !!}</a></li>
						<li><a href="{{ route('site.reviews') }}">{!! __('menu.review') !!}</a></li>
						<li><a href="{{ route('site.delivery_payment') }}">{!! __('menu.delivery') !!}</a></li>
						<li><a href="{{ route('site.warranty_return') }}">{!! __('menu.guaranty') !!}</a></li>
						<li><a href="{{ route('site.blog') }}">{!! __('menu.blog') !!}</a></li>
						<li><a href="{{ route('site.discount') }}">{!! __('menu.discount') !!}</a></li>
						<li><a href="#">{!! __('menu.contacts') !!}</a></li>
					</ul>
				</div>
			</div>
			<div class="drop-menu-mobile__footer">
				<div class="header__tel">
					<button class="header__tel-trigger">
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#tel') }}"></use>
						</svg>
						<a href="tel:+380984574401">+38 098 457 44 01</a>
						<svg>
							<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
						</svg>
					</button>
					<div class="header__tel-drop-menu header__tel-drop-menu--mobile">
						<div class="header__tel-drop-menu-body">
							<a href="tel:+380984574401">+38 098 457 44 01</a>
							<button class="accent-btn header__tel-btn">Перезвонить мне</button>
						</div>
					</div>
				</div>
				<div class="drop-menu-mobile__lang" id="header__lang-mobile" onclick="this.parentNode.classList.toggle('active')">
					<span>{{Localization::getCurrentLocale() == 'uk' ? 'UA' : Localization::getCurrentLocale() }}</span>
					<svg>
						<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-down') }}"></use>
					</svg>
				</div>
			</div>
			<div class="drop-menu-mobile__lang-list">
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
</div>

<div class="modal" id="modal-back-call">
	<button onclick="toggleModal('modal-back-call')" class="modal__area"></button>
	<div class="modal__body">
		<button onclick="toggleModal('modal-back-call')" class="modal__close">
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
			</svg>
		</button>
		<div class="modal__content modal__content--p-60-90">
			<h2 class="modal__title accent-title">Перезвоните мне</h2>
			<div class="modal__text">
				<p>Оставьте заявку и мы с вами свяжемся</p>
			</div>
			<div class="modal__inputs">
				<input name="name" type="text" placeholder="Ваше имя">
				<input name="phone" type="tel" placeholder="Ваш телефон">
			</div>
			<div class="modal__btns">
				<button onclick="toggleModal('modal-back-call');toggleModal('modal-back-call-success');" class="modal__btn accent-btn">Отправить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-back-call-success">
	<button onclick="toggleModal('modal-back-call-success')" class="modal__area"></button>
	<div class="modal__body">
		<button onclick="toggleModal('modal-back-call-success')" class="modal__close">
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
			</svg>
		</button>
		<div class="modal__content">
			<h2 class="modal__title-success">Заявка успешно отправлена!</h2>
			<div class="modal__text">
				<p>Менеджер свяжется с вам в ближайшее время</p>
			</div>
			<div class="modal__btns modal__btns--mw-277">
				<button onclick="toggleModal('modal-back-call-success')" class="modal__btn accent-btn">{!! __('site.close') !!}</button>
			</div>
		</div>
	</div>
</div>

{{--<div class="modal" id="modal-shopping-card">--}}
{{--	<button onclick="toggleModal('modal-shopping-card')" class="modal__area"></button>--}}
{{--	<div class="modal__body">--}}
{{--		<button onclick="toggleModal('modal-shopping-card')" class="modal__close">--}}
{{--			<svg>--}}
{{--				<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>--}}
{{--			</svg>--}}
{{--		</button>--}}
{{--		<div class="modal__content modal__content--m-w-900">--}}
{{--			<div class="modal__shopping-cart shopping-cart">--}}
{{--				<div class="shopping-cart__inner">--}}
{{--					<div class="shopping-cart__top shopping-cart__top">--}}
{{--						<h2 class="shopping-cart__top-title title">Корзина</h2><span class="shopping-cart__top-span">(2 товара)</span>--}}
{{--					</div>--}}
{{--					<ul>--}}

{{--						<li class="shopping-cart__item">--}}
{{--							<a href="#" class="shopping-cart__img">--}}
{{--								<img src="{{ asset('/assets/img/product-women-1.jpg') }}" alt="">--}}
{{--							</a>--}}
{{--							<div class="shopping-cart__body">--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title">Название товара</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__title shopping-cart__title--grey">Размер: S</span>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Количество</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<select>--}}
{{--											<option>1</option>--}}
{{--											<option>2</option>--}}
{{--											<option>3</option>--}}
{{--											<option>4</option>--}}
{{--											<option>5</option>--}}
{{--										</select>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block shopping-cart__block--price">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Цена</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__price">529 грн.</span>--}}
{{--										<span class="shopping-cart__opt">(опт)</span>--}}
{{--										<a href="#" class="shopping-cart__del">--}}
{{--											<svg>--}}
{{--												<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>--}}
{{--											</svg>--}}
{{--										</a>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</li>--}}

{{--						<li class="shopping-cart__item">--}}
{{--							<a href="#" class="shopping-cart__img">--}}
{{--								<img src="{{ asset('/assets/img/product-women-1.jpg') }}" alt="">--}}
{{--							</a>--}}
{{--							<div class="shopping-cart__body">--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title">Название товара</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__title shopping-cart__title--grey">Размер: S</span>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Количество</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<select>--}}
{{--											<option>1</option>--}}
{{--											<option>2</option>--}}
{{--											<option>3</option>--}}
{{--											<option>4</option>--}}
{{--											<option>5</option>--}}
{{--										</select>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block shopping-cart__block--price">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Цена</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__price">529 грн.</span>--}}
{{--										<span class="shopping-cart__opt">(опт)</span>--}}
{{--										<a href="#" class="shopping-cart__del">--}}
{{--											<svg>--}}
{{--												<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>--}}
{{--											</svg>--}}
{{--										</a>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</li>--}}

{{--						<li class="shopping-cart__item">--}}
{{--							<a href="#" class="shopping-cart__img">--}}
{{--								<img src="{{ asset('/assets/img/product-women-1.jpg') }}" alt="">--}}
{{--							</a>--}}
{{--							<div class="shopping-cart__body">--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title">Название товара</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__title shopping-cart__title--grey">Размер: S</span>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Количество</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<select>--}}
{{--											<option>1</option>--}}
{{--											<option>2</option>--}}
{{--											<option>3</option>--}}
{{--											<option>4</option>--}}
{{--											<option>5</option>--}}
{{--										</select>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block shopping-cart__block--price">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Цена</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__price">529 грн.</span>--}}
{{--										<span class="shopping-cart__opt">(опт)</span>--}}
{{--										<a href="#" class="shopping-cart__del">--}}
{{--											<svg>--}}
{{--												<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>--}}
{{--											</svg>--}}
{{--										</a>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</li>--}}

{{--						<li class="shopping-cart__item">--}}
{{--							<a href="#" class="shopping-cart__img">--}}
{{--								<img src="{{ asset('/assets/img/product-women-1.jpg') }}" alt="">--}}
{{--							</a>--}}
{{--							<div class="shopping-cart__body">--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title">Название товара</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__title shopping-cart__title--grey">Размер: S</span>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Количество</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<select>--}}
{{--											<option>1</option>--}}
{{--											<option>2</option>--}}
{{--											<option>3</option>--}}
{{--											<option>4</option>--}}
{{--											<option>5</option>--}}
{{--										</select>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block shopping-cart__block--price">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Цена</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__price">529 грн.</span>--}}
{{--										<span class="shopping-cart__opt">(опт)</span>--}}
{{--										<a href="#" class="shopping-cart__del">--}}
{{--											<svg>--}}
{{--												<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>--}}
{{--											</svg>--}}
{{--										</a>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</li>--}}

{{--						<li class="shopping-cart__item">--}}
{{--							<a href="#" class="shopping-cart__img">--}}
{{--								<img src="{{ asset('/assets/img/product-women-1.jpg') }}" alt="">--}}
{{--							</a>--}}
{{--							<div class="shopping-cart__body">--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title">Название товара</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__title shopping-cart__title--grey">Размер: S</span>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Количество</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<select>--}}
{{--											<option>1</option>--}}
{{--											<option>2</option>--}}
{{--											<option>3</option>--}}
{{--											<option>4</option>--}}
{{--											<option>5</option>--}}
{{--										</select>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block shopping-cart__block--price">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Цена</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__price">529 грн.</span>--}}
{{--										<span class="shopping-cart__opt">(опт)</span>--}}
{{--										<a href="#" class="shopping-cart__del">--}}
{{--											<svg>--}}
{{--												<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>--}}
{{--											</svg>--}}
{{--										</a>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</li>--}}

{{--						<li class="shopping-cart__item">--}}
{{--							<a href="#" class="shopping-cart__img">--}}
{{--								<img src="{{ asset('/assets/img/product-women-1.jpg') }}" alt="">--}}
{{--							</a>--}}
{{--							<div class="shopping-cart__body">--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title">Название товара</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__title shopping-cart__title--grey">Размер: S</span>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Количество</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<select>--}}
{{--											<option>1</option>--}}
{{--											<option>2</option>--}}
{{--											<option>3</option>--}}
{{--											<option>4</option>--}}
{{--											<option>5</option>--}}
{{--										</select>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="shopping-cart__block shopping-cart__block--price">--}}
{{--									<div class="shopping-cart__block-top">--}}
{{--										<h3 class="shopping-cart__title shopping-cart__title--grey shopping-cart__md-d-none">Цена</h3>--}}
{{--									</div>--}}
{{--									<div class="shopping-cart__block-body">--}}
{{--										<span class="shopping-cart__price">529 грн.</span>--}}
{{--										<span class="shopping-cart__opt">(опт)</span>--}}
{{--										<a href="#" class="shopping-cart__del">--}}
{{--											<svg>--}}
{{--												<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>--}}
{{--											</svg>--}}
{{--										</a>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</li>--}}

{{--					</ul>--}}
{{--					<div class="shopping-cart__bottom">--}}
{{--						<div class="shopping-cart__content shopping-cart__content--row shopping-cart__content--mobile-d-none">--}}
{{--							<button type="submit" class="shopping-cart__btn white-btn">Продолжить покупки</button>--}}
{{--							<button type="submit" class="shopping-cart__btn accent-btn">Оформить заказ</button>--}}
{{--						</div>--}}
{{--						<div class="shopping-cart__total">--}}
{{--							<div class="shopping-cart__line">--}}
{{--								<span class="shopping-cart__title shopping-cart__title--grey">Всего: </span>--}}
{{--								<span class="shopping-cart__total-price">1058 грн.</span>--}}
{{--							</div>--}}
{{--							<div class="shopping-cart__line">--}}
{{--								<span class="shopping-cart__span">Докупите товара на <a href="#">422 грн</a> чтобы оформить заказ </span>--}}
{{--								<div class="shopping-cart__svg">--}}
{{--									<div class="shopping-cart__svg-drop-menu text">--}}
{{--										<p>Минимальная сумма оптового заказа составляет 1500 грн</p>--}}
{{--									</div>--}}
{{--									<svg>--}}
{{--										<use xlink:href="{{ asset('/assets/img/sprite.svg#question') }}"></use>--}}
{{--									</svg>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							<div class="shopping-cart__line">--}}
{{--								<span class="shopping-cart__title shopping-cart__title--grey">Скидка: </span>--}}
{{--								<span class="shopping-cart__price shopping-cart__price--big">-100 грн.</span>--}}
{{--								<div class="shopping-cart__svg">--}}
{{--									<div class="shopping-cart__svg-drop-menu shopping-cart__svg-drop-menu--big">--}}
{{--										<h4 class="shopping-cart__svg-drop-menu-title subtitle">Система скидок</h4>--}}
{{--										<div class="shopping-cart__text text">--}}
{{--											<p>Докупите товаров на N грн, чтобы получить скиду №%.</p>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--									<svg>--}}
{{--										<use xlink:href="{{ asset('/assets/img/sprite.svg#question') }}"></use>--}}
{{--									</svg>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<!--Выводить если корзина пуста-->--}}

{{--					<!--<div class="shopping-cart__none">--}}
{{--		<h3 class="shopping-cart__none-title">В корзине пусто</h3>--}}
{{--		<p class="shopping-cart__none-descr">Вы не добавили ни одного товара</p>--}}
{{--	</div>-->--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}
{{--</div>--}}

<div class="modal" id="modal-forgot-password">
	<button onclick="toggleModal('modal-forgot-password')" class="modal__area"></button>
	<div class="modal__body">
		<button onclick="toggleModal('modal-forgot-password')" class="modal__close">
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
			</svg>
		</button>
		<div class="modal__content">
			<h2 class="modal__title title">Забыли пароль?</h2>
			<div class="modal__text">
				<p>Введите ваш email и мы вышлем новый пароль</p>
			</div>
			<div class="modal__inputs">
				<input type="email" placeholder="Введите email">
			</div>
			<div class="modal__btns">
				<button onclick="toggleModal('modal-forgot-password');toggleModal('modal-forgot-password-success')" class="modal__btn accent-btn">Выслать новый пароль</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-forgot-password-success">
	<button onclick="toggleModal('modal-forgot-password-success')" class="modal__area"></button>
	<div class="modal__body">
		<button onclick="toggleModal('modal-forgot-password-success')" class="modal__close">
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
			</svg>
		</button>
		<div class="modal__content modal__content--p-40-45">
			<h2 class="modal__title title">Забыли пароль?</h2>
			<div class="modal__text">
				<p>Введите ваш email и мы вышлем новый пароль</p>
			</div>
			<div class="modal__success">
				<p>Пароль выслан на почту</p>
			</div>
			<div class="modal__text">
				<p>Перейдите по ссылке в письму, чтобы создать новый пароль</p>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-clear-products">
	<button onclick="toggleModal('modal-clear-products')" class="modal__area"></button>
	<div class="modal__body">
		<button onclick="toggleModal('modal-clear-products')" class="modal__close">
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
			</svg>
		</button>
		<form action="#" class="modal__content modal__content--m-w-718">
			<h2 class="modal__title title">Вы точно хотите очистить все товары?</h2>
			<div class="modal__btns modal__btns--mw-277 modal__btns--mt-60">
			</div>
			<button type="submit" class="modal__btn accent-btn">Очистить</button>
			<button type="button" onclick="toggleModal('modal-clear-products')" class="modal__btn white-btn">{!! __('site.cancel') !!}</button>
		</form>
	</div>
</div>

<div class="modal" id="modal-give-feedback">
	<button onclick="toggleModal('modal-give-feedback')" class="modal__area"></button>
	<div class="modal__body">
		<button onclick="toggleModal('modal-give-feedback')" class="modal__close">
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
			</svg>
		</button>
		<form action="#" method="POST" class="js-leave-reviews">
			<div class="modal__content modal__content--m-w-718">
				<h2 class="modal__title accent-title">{!! __('site.leave_review_about_company_title') !!}</h2>
				<div class="modal__review">
						<div class="modal__inputs">
							<input name="name" type="text" placeholder="{!! __('site.your_name') !!}" required>
							<input name="email" type="email" value="@if(auth()->user()) {{ auth()->user()->email }} @else {!! __('site.your_email') !!} @endif" required>
							<textarea name="comment" placeholder="{!! __('site.your_review') !!}" required></textarea>
						</div>
						<div class="modal__grade">
							<p>{!! __('site.your_rating') !!}:</p>
							<div class="product__stars">
								<label>
									<input type="radio" name="rating" value="1" onchange="changeRating(this)">
									<svg class="star" id="star-1">
										<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
									</svg>
								</label>
								<label>
									<input type="radio" name="rating" value="2" onchange="changeRating(this)">
									<svg class="star" id="star-2">
										<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
									</svg>
								</label>
								<label>
									<input type="radio" name="rating" value="3" onchange="changeRating(this)">
									<svg class="star" id="star-3">
										<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
									</svg>
								</label>
								<label>
									<input type="radio" name="rating" value="4" onchange="changeRating(this)">
									<svg class="star" id="star-4">
										<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
									</svg>
								</label>
								<label>
									<input type="radio" name="rating" checked value="5" onchange="changeRating(this)">
									<svg class="star" id="star-5">
										<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
									</svg>
								</label>
							</div>
						</div>
						<div class="modal__btns">
							@if(auth()->user())
								<button  class="modal__btn accent-btn js-send-review">{!! __('site.leave_review_button') !!}</button>
							@else
								<button onclick="toggleModal('modal-give-feedback-fail');" class="modal__btn accent-btn">{!! __('site.leave_review_button') !!}</button>
							@endif
						</div>
						<!--если успешно - toggleModal('modal-give-feedback-fail');-->
		{{--				onclick="toggleModal('modal-give-feedback');toggleModal('modal-give-feedback-success');"--}}
					</div>
				<div class="modal__text modal__text--grey">
						<p>{!! __('site.publish_your_review_after_moderating') !!}</p>
					</div>
			</div>
		</form>
	</div>
</div>

<div class="modal" id="modal-give-feedback-success">
	<button onclick="toggleModal('modal-give-feedback-success')" class="modal__area"></button>
	<div class="modal__body">
		<button onclick="toggleModal('modal-give-feedback-success')" class="modal__close">
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
			</svg>
		</button>
		<div class="modal__content modal__content--m-w-718">
			<h2 class="modal__title-success">Отзыв успешно отправлен!</h2>
			<div class="modal__text">
				<p>Ваш отзыв будет опубликован после проверки модератором</p>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-give-feedback-fail">
	<button onclick="toggleModal('modal-give-feedback-fail')" class="modal__area"></button>
	<div class="modal__body">
		<button onclick="toggleModal('modal-give-feedback-fail')" class="modal__close">
			<svg>
				<use xlink:href="{{ asset('/assets/img/sprite.svg#delete') }}"></use>
			</svg>
		</button>
		<div class="modal__content modal__content--m-w-718">
			<h2 class="modal__title-success modal__title-success--default">Только авторизованные пользователи могут оставлять отзывы</h2>
			<div class="modal__btns modal__btns--mobile-column modal__btns--mw-277">
				<button onclick="toggleModal('modal-give-feedback-fail');" class="modal__btn modal__btn--mobile-d-none accent-btn">Закрыть</button>
				<a href="/authorization.html" class="modal__btn modal__btn--mobile-d-block accent-btn">Войти</a>
				<a href="/authorization.html" class="modal__btn modal__btn--mobile-d-block white-btn">Зарегистрироваться</a>
			</div>
		</div>
	</div>
</div>



<script src="{{ asset('/assets/js/jquery-3.5.1.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/css-vars-ponyfill/2.4.3/css-vars-ponyfill.min.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=Array.from%2CNodeList.prototype.forEach"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/svgxuse/1.2.6/svgxuse.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/jquery.inputmask.bundle.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.0.7/imask.min.js"></script>--}}
<script src="https://unpkg.com/imask"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.2/pikaday.min.js" ></script>
@if(isset($address) && $address || isset($page) && $page->slug == 'checkout')
{{--	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">--}}
	<link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
@endif
<script  src="{{ asset('/assets/js/main.min.js') }}"></script>
<script  src="{{ asset('/assets/js/frontend.js') }}"></script>
<script>window.MSInputMethodContext && document.documentMode && document.write('<script src="https://cdn.jsdelivr.net/gh/nuxodin/ie11CustomProperties@4.1.0/ie11CustomProperties.min.js"><\/script>');</script>
</body>
</html>
