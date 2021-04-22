@php
	$category = $product->categories()->with('children')->first();
@endphp
<div class="breadcrumbs">
	<div class="container">
		<div class="breadcrumbs__inner">
			<ol class="breadcrumbs__list">
				<li><a href="{{ route('site.index') }}">{{ __('menu.index') }}</a></li>
				@foreach($category->getParentsAttribute()->reverse() as $key => $parent)
					@include('site::catalog.partials.breadcrumb',['page'=>$parent,'slug' => $parent->getParentsAttribute()->implode('slug','/') . '/'.$parent->slug])
				@endforeach
				<li>{{ $product->title }}</li>
			</ol>
		</div>
	</div>
</div>
