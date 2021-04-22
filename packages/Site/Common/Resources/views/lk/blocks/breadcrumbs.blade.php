<div class="breadcrumbs">
	<div class="container">
		<div class="breadcrumbs__inner">
			<ol class="breadcrumbs__list">
				<li><a href="{{ route('site.index') }}">{{ __('menu.index') }}</a></li>
				@if(isset($page) && $page->slug != '/')
					<li>{{ $page->title }}</li>
				@endif
			</ol>
		</div>
	</div>
</div>
