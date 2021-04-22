@php
	$str = explode('://',route('site.page',['slug'=>$slug]));
@endphp
<li>
	<a href="{{$str[0]."://".str_replace('//','/',$str[1])}}">{{$page->title}}</a>
</li>
