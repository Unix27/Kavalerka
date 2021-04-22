@extends('site::layouts.site')

@php
	$address = auth()->user()->addresses()->first();

	use Daaner\NovaPoshta\Models\Address;
	use Daaner\NovaPoshta\Models\Common;
	use Daaner\NovaPoshta\Models\InternetDocument;
	$adr = new Address;
	$areas = $adr->getAreas();

	$curDate = date('d/m/Y');
	$newPostKey = app()->getLocale() == 'ru' ? 'DescriptionRu' : 'Description';

	$cities =  \Shop\Orders\Models\City::where('area_ref',$areas['result'][1]['Ref'])->orderByTranslation('title','asc')->get();

	$sortCities = array();
	foreach($cities as $value) {
		 $sortCities[(mb_substr($value->title, 0, 1))][] = $value;
	}
	/*$np = new InternetDocument;
	$np->setDateTime('28-03-2021'); //eсли не указано `setDateTimeFrom` - значение будет таким же, как `setDateTimeTo`
	$np->showFullList();
	$lists = $np->getDocumentList();

	dd($lists); */
/*$c = new Common;
//локализация справочника (ru/ua)
$c->setLanguage('ru');
$list = $c->getServiceTypes();

dd($list);
*/
/*$area = $adr->getAreas();

dd($area);
*/
	$deliveries = \Shop\Orders\Models\OrderDelivery::get()->keyBy('id');
	/*$warehouses = $adr->getWarehouses($cities[0]->ref,false);*/
    //dd($warehouses);
/*$cities = $adr->getCities();
dd($cities);
*/
    /*foreach ($cities['result'] as $city){
        $model = \Shop\Orders\Models\City::create([
            'ref' => $city['Ref'],
            'area_ref' => $city['Area']
        ]);
        $model->translateOrNew('uk')->fill([
            'title' => $city['Description']
        ]);
         $model->translateOrNew('ru')->fill([
            'title' => $city['DescriptionRu']
        ]);
        $model->save();
    }
   dd($cities['result'][0]);*/

@endphp

@section('seo')
	<title>{{ $page->meta_title ?? '' }}</title>
	<meta name="description" content="{{ $page->meta_description ??'' }}">
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

{{--						<div class="notify notify--success" role="alert">--}}
{{--							<strong>Success!</strong> This is a success notification!--}}
{{--							<button type="button" class="notify-close">&times;</button>--}}
{{--						</div>--}}
					<form action="#" method="POST" class="profile__data save_profile" id="js_form_personal_data" onclick="toggleActiveByButton(this, event)">
						<div class="profile__data-top">
							<h3 class="profile__data-title">{!! __('site.personal_data') !!}</h3>
							<button type="button" class="profile__edit"><span>{!! __('site.edit') !!}</span></button>
						</div>
						<div class="profile__data-body">
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.name') !!}</span>
								<span class="profile__data-item-content">{{ auth()->user()->first_name ?? '' }}</span>
								<input type="text" name="first_name" value="{{ auth()->user()->first_name ?? '' }}" placeholder="{!! __('site.name') !!}">
							</div>
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.last_name') !!}</span>
								<span class="profile__data-item-content">{{ auth()->user()->last_name ?? __('site.unknown') }}</span>
								<input type="text" name="last_name" value="{{ auth()->user()->last_name ?? '' }}" placeholder="{!! __('site.last_name') !!}">
							</div>
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.middle_name') !!}</span>
								<span class="profile__data-item-content">{{ auth()->user()->middle_name ?? __('site.unknown') }}</span>
								<input type="text" name="middle_name" value="{{ auth()->user()->middle_name ?? 'Не указано' }}" placeholder="{!! __('site.middle_name') !!}">
							</div>
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.date_of_birth') !!}</span>
								<span class="profile__data-item-content">{{ auth()->user()->getDateOfBirth() ?? __('site.unknown') }}</span>
								<input type="text" name="date_of_birth" class="input-date" value="{{ auth()->user()->getDateOfBirth() ?? '' }}" placeholder="{!! __('site.date_of_birth') !!}">
							</div>
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.gender') !!}</span>
								<span class="profile__data-item-content">@if(auth()->user()->gender == 'man') {!! __('site.gender_man') !!} @elseif(auth()->user()->gender == 'woman') {!! __('site.gender_woman') !!} @else {!! __('site.unknown') !!} @endif</span>
{{--								<input type="text" name="gender" value="{{ auth()->user()->gender ?? '' }}" placeholder="{!! __('site.gender') !!}">--}}
								<select name="gender">
{{--									<option name="gender" disabled selected>{!! __('site.gender') !!}</option>--}}
									<option value="woman">{!! __('site.gender_woman') !!}</option>
									<option value="man">{!! __('site.gender_man') !!}</option>
								</select>
							</div>
							<div class="profile__data-buttons">
								<button type="submit" class="profile__data-submit accent-btn">{!! __('site.save') !!}</button>
								<button type="reset" class="profile__data-cancel accent-btn-grey">{!! __('site.cancel') !!}</button>
							</div>
						</div>
					</form>

					<form action="#" method="POST" class="profile__data save_profile" id="js_form_contacts" onclick="toggleActiveByButton(this, event)">
						<div class="profile__data-top">
							<h3 class="profile__data-title">{!! __('site.contacts') !!}</h3>
							<button type="button" class="profile__edit"><span>{!! __('site.edit') !!}</span></button>
						</div>
						<div class="profile__data-body">
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.phone_number') !!}</span>
								<span class="profile__data-item-content">{{ auth()->user()->phone ?? '' }}</span>
								<input type="text" class="input-tel" name="phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="{!! __('site.phone_number') !!}">
							</div>
							<div class="profile__data-item">
								<span class="profile__data-item-title">Email</span>
								<span class="profile__data-item-content">{{ auth()->user()->email ?? '' }}</span>
								<input type="text" name="email" value="{{ auth()->user()->email ?? '' }}" placeholder="Email">
							</div>
							<div class="profile__data-buttons">
								<button type="submit" class="profile__data-submit accent-btn">{!! __('site.save') !!}</button>
								<button type="reset" class="profile__data-cancel accent-btn-grey">{!! __('site.cancel') !!}</button>
							</div>
						</div>
					</form>

					<form action="#" method="POST" class="profile__data save_profile" id="js_form_delivery_address" onclick="toggleActiveByButton(this, event)">
						<div class="profile__data-top">
							<h3 class="profile__data-title">{!! __('site.address_delivery') !!}</h3>
							<button type="button" class="profile__edit"><span>{!! __('site.edit') !!}</span></button>
						</div>
						<div class="profile__data-body">
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.city') !!}</span>
								<span class="profile__data-item-content">{{ $address->city ?? __('site.unknown') }}</span>
								<select name="address[city]" class="city-picker" data-live-search="true">
									@if(isset($address->city) && $address->city)
										<option value="{{ $address->city }}" data-ref="{{ $address->np_city_code }}" selected>{{ $address->city }}</option>
									@else
										<option>{!! __('site.city') !!}</option>
									@endif
								</select>
							</div>
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.street') !!}</span>
								<span class="profile__data-item-content">{{ $address->street ?? __('site.unknown') }}</span>
								<input type="text" name="address[street]" value="{{ $address->street ?? __('site.unknown') }}" placeholder="{!! __('site.street') !!}">
							</div>
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.house') !!}</span>
								<span class="profile__data-item-content">{{ $address->build ?? __('site.unknown') }}</span>
								<input type="text" name="address[build]" value="{{ $address->build ?? __('site.unknown') }}" placeholder="{!! __('site.house') !!}">
							</div>
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.apartment') !!}</span>
								<span class="profile__data-item-content">{{ $address->apartment ?? __('site.unknown') }}</span>
								<input type="text" name="address[apartment]" value="{{ $address->apartment ?? __('site.unknown') }}" placeholder="{!! __('site.apartment') !!}">
							</div>
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.warehouse_new_poshta') !!}</span>
								<span class="profile__data-item-content">{{ $address->nova_poshta ?? __('site.unknown') }}</span>
								<select name="address[nova_poshta]" class="warehouse-picker">
									@if(isset($address->nova_poshta) && $address->nova_poshta)
										<option selected value="{{ $address->nova_poshta }}" data-ref="{{ $address->np_warehouse_code ?? '' }}">{{ $address->nova_poshta }}</option>
									@else
										<option disabled>{!! __('site.warehouse_new_poshta') !!}</option>
									@endif
								</select>
							</div>
							<div class="profile__data-item">
								<span class="profile__data-item-title">{!! __('site.warehouse_justin') !!}</span>
								<span class="profile__data-item-content">{{ $address->justin ?? __('site.unknown') }}</span>
								<input type="text" name="address[justin]" value="{{ $address->justin ?? __('site.unknown') }}" placeholder="{!! __('site.warehouse_justin') !!}">
							</div>
							<div class="profile__data-buttons">
								<button type="submit" class="profile__data-submit accent-btn">{!! __('site.save') !!}</button>
								<button type="reset" class="profile__data-cancel accent-btn-grey">{!! __('site.cancel') !!}</button>
							</div>
						</div>
					</form>

					<form action="#" method="POST" class="profile__data profile__password changePassword" id="js_form_profile_password" onclick="toggleActiveByButton(this, event)">
						<div class="profile__data-top">
							<h3 class="profile__data-title">{!! __('site.change_password') !!}</h3>
							<button type="button" class="profile__edit"><span>{!! __('site.edit') !!}</span></button>
						</div>
						<div class="profile__data-body">
							<div class="profile__data-item">
								<input type="password" name="old_password" placeholder="{!! __('site.current_password') !!}">
							</div>
							<div class="profile__data-item">
								<input type="password" name="password" placeholder="{!! __('site.enter_new_password') !!}">
							</div>
							<div class="profile__data-item">
								<input type="password" name="password_confirmation" placeholder="{!! __('site.repeat_new_password') !!}">
							</div>
							<div class="profile__data-buttons">
								<button type="submit" class="profile__data-submit accent-btn">{!! __('site.save') !!}</button>
								<button type="reset" class="profile__data-cancel accent-btn-grey">{!! __('site.cancel') !!}</button>
							</div>
						</div>
					</form>
					<div class="notify notify--danger" role="alert" style="display: none;">
						<span></span>
						<button type="button" class="notify-close">&times;</button>
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
