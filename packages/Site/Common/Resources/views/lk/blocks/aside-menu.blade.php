<aside class="profile__aside">

	<ul>
		<li><a href="{{ route('site.dashboard.profile') }}" {{ url()->current() == route('site.dashboard.profile') ? 'class="active"' : '' }}>{!! __('menu.my_profile') !!}</a></li>
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

</aside>
