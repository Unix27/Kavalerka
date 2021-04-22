@extends('site::layouts.site')

@section('seo')
	<title>{{ $page->meta_title ??  __('menu.review') }}</title>
	<meta name="description" content="{{ $page->meta_description ?? '' }}">
	<meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">
@endsection

@section('content')
	@include('site::lk.blocks.breadcrumbs')
	<section class="info">
		<div class="container">
			<h2 class="info__title title info__title--mobile-center">{{ $page->title ?? __('menu.review') }}</h2>
			<div class="info__inner">
				<div class="info__reviews">
					<div class="info__box">
						<h3 class="info__box-title subtitle">{!! __('site.count_reviews') !!} - {{ $amount_reviews }}</h3>
						<div class="info__box-descr text">
							<p>
								{!!  $page->content ?? '' !!}
							</p>
						</div>
						<button onclick="toggleModal('modal-give-feedback')" class="accent-btn info__box-btn">{!! __('site.leave_review') !!}</button>
{{--						<a href="#" class="accent-btn info__box-btn">{!! __('site.leave_review') !!}</a>--}}
					</div>
					<div class="info__reviews-inner">
						@if(count($reviews))

							@foreach($reviews as $review)

								@if($review->parent_id > 0)
									@continue
								@endif

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
								 <h3 class="profile__content-none-title">{!! __('site.have_not_reviews') !!}</h3>
							 </div>

						@endif

					</div>

					@if(count($reviews))

						<div class="profile__pagination pagination">
							@if(count($reviews) > 12)
								<a href="#" class="accent-btn pagination__btn">
									{!! __('site.show_more_reviews') !!}
								</a>
							@endif
							<div class="pagination__inner">
								{{ $reviews->links() }}
							</div>
						</div>

					@endif
				</div>
			</div>
		</div>
	</section>
	</main>

@endsection

@section('footer')
	@include('site::layouts.site-footer')
@endsection
