<section class="blog-slider">
	<div class="container">
		<h2 class="blog-slider__title accent-title">{!! __('site.new_posts_in_blog_title') !!}</h2>
		<div class="blog-slider__inner">
			<div class="blog-swiper swiper-container" id="blog-swiper">
				<div class="blog-swiper__wrapper swiper-wrapper">
					@foreach($blog as $article)
						@if(isset($article->slug))
							<div class="blog-swiper__slide swiper-slide">
								<a href="{{ route('site.blog.article', ['category' => $article->category()->first()->slug, 'slug' => $article->slug]) }}" class="blog-swiper__slide-img"><img src="{{ $article->image }}" alt="{{ $article->title }}" loading="lazy"></a>
								<div class="blog-swiper__slide-title">{{ $article->title }}</div>
								<div class="blog-swiper__slide-descr">
									<p>
										{{ $article->excerpt }}
									</p>
								</div>
							</div>
						@endif
					@endforeach
				</div>
			</div>
			<div class="accent-arrow swiper-button-prev" id="blog-swiper__button-prev">
				<svg>
					<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-left') }}"></use>
				</svg>
			</div>
			<div class="accent-arrow swiper-button-next" id="blog-swiper__button-next">
				<svg>
					<use xlink:href="{{ asset('/assets/img/sprite.svg#arrow-right') }}"></use>
				</svg>
			</div>
		</div>
	</div>
</section>
