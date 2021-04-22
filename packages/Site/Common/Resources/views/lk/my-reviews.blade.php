@extends('site::layouts.site')

@section('seo')
	<title>{{ $page->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $page->meta_description ?? '' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection

@section('content')
	@include('site::lk.blocks.breadcrumbs')
	<section class="profile">
		<div class="container">
			<div class="profile__top">
				<h2 class="profile__title title">{{ $page->title ?? '' }}</h2>
			</div>
			<div class="profile__inner">

				@include('site::lk.blocks.aside-menu')

				<div class="profile__content">
					<div class="profile__reviews">
						<div class="profile__reviews-top" data-trigger=".profile__reviews-trigger" data-content=".profile__reviews-content">
							<button class="white-btn profile__reviews-trigger active" onclick="tabChange(this, 'site-reviews')">
								{!! __('site.shop_reviews') !!}
							</button>
							<button class="white-btn profile__reviews-trigger" onclick="tabChange(this, 'product-reviews')">
								{!! __('site.shop_products_reviews') !!}
							</button>
						</div>
						<div class="profile__reviews-body">
							<div class="profile__reviews-content active" id="site-reviews">

								@if(count($shop_reviews))

									@foreach($shop_reviews as $review)

										@php
											$answer = $review->answer()->first();
										@endphp

										<div class="profile__review">
											<div class="profile__review-inner">
												<div class="profile__review-body">
													<div class="profile__review-top">
														<div class="profile__review-top-left">
															<div class="profile__review-title">{{ $review->name }}</div>
															<div class="profile__review-date">{{ date("d.m.Y", strtotime($review->created_at)) }}</div>
														</div>
														<div class="profile__review-top-right">
															<div class="profile__review-stars js-paint-stars" data-stars="{{ $review->rating }}">
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
															</div>
														</div>
													</div>
													<div class="profile__review-text">
														<p>
															{{ $review->comment }}
														</p>
													</div>

													@if(isset($answer))

														<div class="profile__review-answer">
															<div class="profile__review-answer-title">{!! __('site.admin_answer') !!}</div>
															<div class="profile__review-answer-text">
																<p>
																	{{ $answer->comment }}
																</p>
															</div>
														</div>

													@endif
												</div>
											</div>
										</div>

									@endforeach

								@else

									<div class="profile__content-none">
									 <h3 class="profile__content-none-title">{!! __('site.you_dont_have_any_reviews') !!}</h3>
									</div>

								@endif

							</div>

							<div class="profile__reviews-content" id="product-reviews">

								@if(count($products_reviews))

									@foreach($products_reviews as $review)

										@php
											$answer = $review->answer()->first();
										@endphp

										<div class="profile__review profile__review--img">
											<div class="profile__review-inner">
												<a href="{{ route('catalog.product', $review->product()->first()->slug) }}" class="profile__review-img"><img src="{{ route('catalog.product', $review->product()->first()->image) }}" alt=""></a>
												<div class="profile__review-body">
													<div class="profile__review-top">
														<div class="profile__review-top-left">
															<a href="{{ route('catalog.product', $review->product()->first()->slug) }}" class="profile__review-title">{{ $review->product()->first()->title }}</a>
															<div class="profile__review-author">{{ $review->name }}</div>
														</div>
														<div class="profile__review-top-right">
															<div class="profile__review-date">{{ date("d.m.Y", strtotime($review->created_at)) }}</div>
															<div class="profile__review-stars js-paint-stars" data-stars="{{ $review->rating }}">
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
																<svg>
																	<use xlink:href="{{ asset('/assets/img/sprite.svg#star') }}"></use>
																</svg>
															</div>
														</div>
													</div>
													<div class="profile__review-text">
														<p>
															{{ $review->comment }}
														</p>
													</div>

													@if(isset($answer))

														<div class="profile__review-answer">
															<div class="profile__review-answer-title">{!! __('site.admin_answer') !!}</div>
															<div class="profile__review-answer-text">
																<p>
																	{{ $answer->comment }}
																</p>
															</div>
														</div>

													@endif

												</div>
											</div>
										</div>

									@endforeach

								@else

									<div class="profile__content-none">
										<h3 class="profile__content-none-title">{!! __('site.you_dont_have_any_reviews') !!}</h3>
									</div>

								@endif
							</div>
						</div>
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
