@foreach($category_posts as $article)
	<div class="post blog__item">
		<div class="post__inner">
			<a href="{{ route('site.blog.article', ['category' => $category->slug, 'slug' => $article->slug]) }}" class="post__img post__img--mini">
				<img src="{{ $article->image }}" alt="{{ $article->title }}" loading="lazy">
			</a>
			<div class="post__bottom">
				<h3 class="post__title post__title--upper">{{ $article->title }}</h3>
				<div class="post__descr">
					<p>
						{{ $article->excerpt }}
					</p>
				</div>
			</div>
		</div>
	</div>
	@endforeach

	<div class="blog__pagination pagination">
		<div class="pagination__inner js-pagination-blog">
			{{ $category_posts->links() }}
		</div>
	</div>
