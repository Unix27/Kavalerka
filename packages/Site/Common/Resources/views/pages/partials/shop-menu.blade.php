<div class="header__triggers">
	<div class="container">
		<div class="header__triggers-inner">
			<ul>
				@foreach($categories['categories'] as $item)

					<li>
						<span class="header__sub-menu-title">{{ $item->title }}</span>
						<div class="header__sub-menu-wrapper">
							<div class="header__sub-menu">
								<div class="header__sub-menu-inner">
									<div class="header__sub-menu-item header__sub-menu-item--list">
										<h2 class="header___sub-menu-item-title">{{ $item->title }}</h2>
										<div class="header__sub-menu-item-wrapper">
											<ul>
												@foreach($item->children as $child)

													@if(isset($child->children) && count($child->children))

														<li class="extra-menu__wrapper" onclick="this.classList.toggle('active')">
															<a href="{{ route('site.page', ['slug' => $categories['category']->slug.'/'.$item->slug.'/'.$child->slug]) ?? '#' }}" class="extra-menu__title">
																<span>{{ $child->title }}</span>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#add') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#minus') }}"></use>
																</svg>
															</a>
															<ul class="extra-menu">
																@foreach($child->children as $ch)
																	<li><a href="{{ route('site.page', ['slug' => $categories['category']->slug.'/'.$item->slug.'/'.$child->slug.'/'.$ch->slug]) ?? '#' }}">{{ $ch->title }}</a></li>
																@endforeach
															</ul>
														</li>
													@else
														<li><a href="{{ route('site.page', ['slug' => $categories['category']->slug.'/'.$item->slug.'/'.$child->slug]) ?? '#' }}">{{ $child->title }}</a></li>
													@endif
												@endforeach
												<li>
													<a href="{{ route('site.page', $categories['category']->slug.'/'.$item->slug) }}" class="link-arrow-right">
														<span>{!! __('menu.all_products') !!}</span>
														<svg>
															<use xlink:href={{ asset('/assets/img/sprite.svg#long-arrow-right') }}></use>
														</svg>
													</a>
												</li>
											</ul>
										</div>
									</div>

									<div class="header__sub-menu-item header__sub-menu-item--images">
										<h2 class="header___sub-menu-item-title">{!! __('menu.current_action') !!}</h2>
										<ul>
											<li>
												<a href="#"><img src="{{ asset('/assets/img/event-1.jpg') }}" alt="" /><span
													>Акция 1</span></a>
											</li>
											<li>
												<a href="#">
													<img src="{{ asset('/assets/img/event-2.jpg') }}" alt="" />
													<span>Акция 2</span>
												</a>
											</li>
											<li>
												<a href="#"><img src="{{ asset('/assets/img/event-3.jpg') }}" alt="" /><span
													>Акция 3</span></a>
											</li>
											<li>
												<a href="#"><img src="{{ asset('/assets/img/event-4.jpg') }}" alt="" /><span
													>Акция 4</span></a>
											</li>
											<li> <a href="#" class="link-arrow-right">
													<span>{!! __('menu.all_actions') !!}</span>
													<svg>
														<use xlink:href={{ asset('/assets/img/sprite.svg#long-arrow-right') }}></use>
													</svg>
												</a></li>
										</ul>
									</div>

									<div class="header__sub-menu-item header__sub-menu-item--with-mini-image">
										<h2 class="header___sub-menu-item-title">{!! __('menu.brands_sale') !!}</h2>
										<ul>
											<li>
												<a href="#" class="weight-600"><img src="{{ asset('/assets/img/brand-1.jpg') }}" alt="" />Бренд 1</a>
											</li>
											<li>
												<a href="#"><img src="{{ asset('/assets/img/brand-2.jpg') }}" alt="" />Бренд 2</a>
											</li>
											<li>
												<a href="#"><img src="{{ asset('/assets/img/brand-3.jpg') }}" alt="" />Бренд 3</a>
											</li>
											<li>
												<a href="#"><img src="{{ asset('/assets/img/brand-4.jpg') }}" alt="" />Бренд 4</a>
											</li>
											<li>
												<a href="#"><img src="{{ asset('/assets/img/brand-5.jpg') }}" alt="" />Бренд 5</a>
											</li>
											<li>
												<a href="#"><img src="{{ asset('/assets/img/brand-6.jpg') }}" alt="" />Бренд 6</a>
											</li>
										</ul>
									</div>

								</div>
							</div>
						</div>
					</li>
				@endforeach

				<li>
					<span class="header__sub-menu-title">{!! __('menu.new_items') !!}</span>
					<div class="header__sub-menu-wrapper">
						<div class="header__sub-menu">
							<div class="header__sub-menu-inner">
								<div class="header__sub-menu-none">
									<p>{!! __('menu.doesnt_have_new_items') !!}</p>
								</div>
							</div>
						</div>
					</div>
				</li>

				<li>
					<span class="header__sub-menu-title">{!! __('menu.sale') !!}</span>
					<div class="header__sub-menu-wrapper">
						<div class="header__sub-menu">
							<div class="header__sub-menu-inner">
								<div class="header__sub-menu-none">
									<p>{!! __('menu.doesnt_have_sale') !!}</p>
								</div>
							</div>
						</div>
					</div>
				</li>

				<li>
					<span class="header__sub-menu-title">{!! __('menu.brands') !!}</span>
					<div class="header__sub-menu-wrapper">
						<div class="header__sub-menu">
							<div class="header__sub-menu-inner">
								<div class="header__sub-menu-item header__sub-menu-item--list">
									<h2 class="header___sub-menu-item-title">{!! __('menu.brands') !!}</h2>
									<div class="header__sub-menu-item-wrapper">
										<ul>
											@foreach($brands as $brand)
												<li><a href="#">{{ $brand->title }}</a></li>
											@endforeach
											<li>
												<a href="{{ route('site.page', $categories['category']->slug) }}" class="link-arrow-right">
													<span>{!! __('menu.all_products') !!}</span>
													<svg>
														<use xlink:href={{ asset('/assets/img/sprite.svg#long-arrow-right') }}></use>
													</svg>
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="header__sub-menu-item header__sub-menu-item--images">
									<h2 class="header___sub-menu-item-title">{!! __('menu.current_action') !!}</h2>
									<ul>
										<li>
											<a href="#"><img src="{{ asset('/assets/img/event-1.jpg') }}" alt="" /><span
												>Акция 1</span></a>
										</li>
										<li>
											<a href="#"><img src="{{ asset('/assets/img/event-2.jpg') }}" alt="" /><span
												>Акция 2</span></a>
										</li>
										<li>
											<a href="#"><img src="{{ asset('/assets/img/event-3.jpg') }}" alt="" /><span
												>Акция 3</span></a>
										</li>
										<li>
											<a href="#"><img src="{{ asset('/assets/img/event-4.jpg') }}" alt="" /><span
												>Акция 4</span></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</li>

			</ul>
		</div>
	</div>
</div>
