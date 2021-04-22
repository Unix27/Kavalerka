@foreach($promotions as $promotion)
	<div class="post catalog__event">
		<div class="post__inner">
			<a href="#" class="post__img">
				<img src="{{ $promotion->image }}" alt="{{ $promotion->title }}" loading="lazy">
				<div class="post__time"><span>{!! __('site.before_and_promotion') !!}: {{ $promotion->remainingDays() }}</span></div>
			</a>
			<div class="post__bottom">
				<h3 class="post__title">{{ $promotion->title }}</h3>
				<div class="post__descr">
					<p>
						{{ $promotion->description }}
					</p>
				</div>
			</div>
		</div>
	</div>
@endforeach

<div class="catalog__pagination pagination js-promotions-pagination">
	{{--				<a href="#" class="accent-btn pagination__btn">--}}
	{{--					Показать еще 10 акций--}}
	{{--				</a>--}}
	<div class="pagination__inner">
		{{ $promotions->links() }}
	</div>
</div>
