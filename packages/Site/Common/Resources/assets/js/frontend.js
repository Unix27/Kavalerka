jQuery(document).ready(function ($){

// auth
	$(document).on('submit','#form-authorization',function (e){
		e.preventDefault();

		let formData = new FormData($(this).get(0));
		formData.append('_token',$('meta[name=_token]').attr('content'));

		MY_AJAX('/login',formData,function(data){
			if(data.status == 'success'){
				location.href = data.url;
			}
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);

				$('#form-authorization').find('.authorization__error').html('');
				$('.authorization__input-wrapper').removeClass('authorization__input-wrapper--error');

				$.each(errors.errors, function( key, value){
					if(key == 0){
						$('#form-authorization').find('input[name="email"]').parent().addClass('authorization__input-wrapper--error');
					}
					if(key == 1){
						$('#form-authorization').find('input[name="password"]').parent().addClass('authorization__input-wrapper--error');
					}
					$('#form-authorization').find('.authorization__error').append('<p>' + value + '</p>');
				});
				console.log(errors);
				if(errors.message){
					$('#form-authorization').find('.authorization__error').html('<p>' + errors.message + '</p>');
				}
			}
		});

	});

	$(document).on('submit', '#form-registration', function (e){
		e.preventDefault();

		$(this).find('.authorization__error').html('');

		let formData = new FormData($(this).get(0));
		formData.append('_token', $('meta[name=_token]').attr('content'));

		MY_AJAX('/register', formData, function (data) {
			location.href = data.url;
		}, function (data, exception) {
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				$('.authorization__input-wrapper').removeClass('authorization__input-wrapper--error');
				$.each(errors.errors, function (key, value) {

					if(key == 'confirmation'){
						$('#form-registration').find('.authorization__error').append('<p>'+ value +'</p>');
						return;
					}

					$('#form-registration').find('input[name="'+ key +'"]').parent().addClass('authorization__input-wrapper--error');
					// $('#form-registration').find('input[name="'+ key +'"]').parent().append('<p>'+ value +'</p>');
					$('#form-registration').find('.authorization__error').append('<p>'+ value +'</p>');
				});
			}
		});
	});

	$(document).on('submit','.changePassword',function (e){
		e.preventDefault();

		let formData = new FormData($(this).get(0));
		formData.append('_token',$('meta[name=_token]').attr('content'));

		MY_AJAX('/dashboard/profile/change-password',formData,function(data){
			console.log(data);

			location.reload();

		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				$('.notify.notify--danger').show().html(errors.message);
				$('#js_form_profile_password input').val('');
				$.each(errors, function (key, value) {
					let text = '';
					$.each(value, function (key, value) {
						text += value + '<br>';
					});
					$('.notify.notify--danger').show().html(text);
				});
				setInterval(function(){ $('.notify.notify--danger').hide(); }, 3000);
			}
		});
	});

	$(document).on('submit','.recoverPassword',function (e){
		e.preventDefault();

		let formData = new FormData($(this).get(0));
		formData.append('_token',$('meta[name=_token]').attr('content'));
		formData.append('password','1');

		MY_AJAX('/password/email',formData,function(data){
			console.log(data);
			$('.password-save.errors').text();
			$(".js-modal-password-recovery").fadeOut();
			$('.js-modal-password-recovery-send').show();
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				console.log(errors);

				$('.password-save.errors').show().html(errors.message);

				$.each(errors, function (key, value) {
					console.log(value.email);
					let text = '';
					$.each(value.email, function (key, value) {
						text += value + '<br>';
					});

					$('.password-save.errors').show().html(text);
				});
			}
		});

	});

	$(document).on('submit','.recoverPasswordRepeat',function (e){
		e.preventDefault();

		let formData = new FormData($(this).get(0));
		formData.append('_token',$('meta[name=_token]').attr('content'));
		formData.append('password','1');

		MY_AJAX('/password/email',formData,function(data){
			console.log(data);
			$('.password-save.errors').text();
			$('.js-modal-password-recovery-send').fadeOut();
			// $(".bg-overlay").removeClass("js-active");
			$('.js-modal-comment').show();
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				console.log(errors);

				$('.password-save.errors').show().html(errors.message);

				$.each(errors, function (key, value) {
					console.log(value.email);
					let text = '';
					$.each(value.email, function (key, value) {
						text += value + '<br>';
					});

					$('.password-save.errors').show().html(text);
				});
			}
		});

	});

	$(document).on('submit','.reset-password',function (e){
		e.preventDefault();

		let errorNumber = false;
		let errorValid = false;
		let errorLower = false;

		if(hasNumber($('.validatePassword').val())){
			$('.fit.number').addClass('js-active');
			errorNumber = true;
		}else{
			$('.fit.number').removeClass('js-active');
			errorNumber = false;
		}

		if(isValid($('.validatePassword').val())){
			$('.fit.spec_symbol').addClass('js-active');
			errorValid = true;
		}else{
			$('.fit.spec_symbol').removeClass('js-active');
			errorValid = false;
		}

		if(isLowerCase($('.validatePassword').val())){
			$('.fit.с_symbol').addClass('js-active');
			errorLower = true;
		}else{
			$('.fit.с_symbol').removeClass('js-active');
			errorLower = false;
		}

		if( errorNumber && errorValid && errorLower ){
			let formData = new FormData($(this).get(0));
			formData.append('_token', $('meta[name=_token]').attr('content'));
			formData.append('password', $('.validatePassword').val());
			formData.append('password_confirmation', $('.password_confirmation').val());

			MY_AJAX('/password/reset', formData, function (data) {
				console.log(data);
				location.href = data.url;
			}, function (data, exception) {
				if (data.status === 422) {
					var errors = $.parseJSON(data.responseText);
					console.log(errors);

					$('.password-save.errors').show().html(errors.message);

					$.each(errors, function (key, value) {
						console.log(value);
						let text = '';
						$.each(value.password, function (key, value) {
							text += value + '<br>';
						});
						$.each(value.email, function (key, value) {
							text += value + '<br>';
						});
						$('.password-save.errors').show().html(text);
					});
				}
			});
		} else {
			$('.password-save.errors').show().html('Пожалуйста соблюдите все условия пароля');
		}
	});

	$(document).on('click', '.js-modal-password-recovery-send-exit', function (){
		$('.js-modal-password-recovery-send').hide();
		$(".bg-overlay").removeClass("js-active");
	});

// Personal cabinet

	$(document).on('submit','.save_profile',function (e){
		e.preventDefault();

		let formData = new FormData($(this).get(0));
		formData.append('_token',$('meta[name=_token]').attr('content'));
		formData.append('ref-city', $('.city-picker option:selected').attr('data-ref'));
		formData.append('ref-warehouse', $('.warehouse-picker option:selected').attr('data-ref'));

		console.log($('.warehouse-picker option:selected').attr('data-ref'));

		MY_AJAX('/dashboard/profile',formData,function(data){
			console.log(data);
			location.reload();
		});
	});

	$(document).on('click', '.notify-close.input-delete', function (){
		$(this).parent().remove();
	});

	$(document).on('change', 'input[name="is_wholesale"]', function(){
		let formData = new FormData();

		formData.append('_token',$('meta[name=_token]').attr('content'));
		formData.append('status', $(this).prop('checked'));

		console.log($(this).prop('checked'));
		MY_AJAX('/dashboard/wholesale', formData, function (data) {
			console.log(data);
			// if(data == 1){
			// 	$('.profile__opt ul').css('display', 'block');
			// 	console.log(1);
			// } else {
			// 	$('.profile__opt ul').css('display', 'none');
			// 	console.log(2);
			// }
		}, function (data, exception) {
			if (data.status === 422) {
				var errors = $.parseJSON(data.responseText);
				console.log(errors);
			}
		});
	});

	$(document).on('click', '.js-remove-favorite', function (e){

		let formData = new FormData();

		formData.append('_token',$('meta[name=_token]').attr('content'));
		formData.append('product_id', $(this).attr('data-id'));

		let current_product = $(this).parents('.profile__product');

		MY_AJAX('/remove/favorite-product', formData,function(data){
				current_product.remove();
				$('.header__button--heart span').html($('.header__button--heart span').text() - 1);
				$('.profile__span.span').html('(' + (Number($('.profile__span.span').attr('data-count')) - 1) + ' ' + $('.profile__span.span').attr('data-text') + ')');
				$('.profile__span.span').attr('data-count', Number($('.profile__span.span').attr('data-count')) - 1);
				if(data == 'all'){
					$('.profile__product').remove();
					$('.header__button--heart span').html(0);
				}

				if($('.profile__product').length == 0 || data == 'all'){
					$('.profile__pagination').remove();
					$('.profile__top-buttons').remove();
					$('.profile__top .profile__span').remove();
					$('.profile__content-none').css('display', 'block');
				}
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				console.log('please, update this page');
			}
		});

	});

	$(document).on('click', '.js-add-to-favorite', function (e){
		e.preventDefault();

		let formData = new FormData();

		formData.append('_token',$('meta[name=_token]').attr('content'));
		formData.append('product_id', $(this).attr('data-id'));
		console.log($(this).attr('data-id'));
		let current_product = $(this).parents('.profile__product');

		MY_AJAX('/add/favorite-product', formData,function(data){
				console.log(data);
				if(data == 'all'){
					$('.profile__product').remove();
				}

				if(data == 'delete'){
					$('.header__button--heart span').html(Number($('.header__button--heart span').text()) - 1);
					$('.profile__span span').html(Number($('.profile__span span').attr('data-count')) - 1 + $('.profile__span span').attr('data-text'));
				}

				if(data == 'success'){
					$('.header__button--heart span').html(Number($('.header__button--heart span').text()) + 1);
					$('.profile__span span').html(Number($('.profile__span span').attr('data-count')) + 1 + $('.profile__span span').attr('data-text'));
				}

				if($('.profile__product').length == 0 || data == 'all'){
					$('.profile__pagination').remove();
					$('.profile__top-buttons').remove();
					$('.profile__top .profile__span').remove();
					$('.profile__content-none').css('display', 'block');
				}
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				console.log('please, update this page');
			}
		});

	});

	$(document).on('click', '.js-more-product', function (e){
		e.preventDefault();

		let take = $(this).attr('data-take');
		let button = $(this);
		let formData = new FormData();

		formData.append('_token',$('meta[name=_token]').attr('content'));
		formData.append('type', $(this).attr('data-method'));
		formData.append('count', $('.card-product').length);
		formData.append('take', take);
		formData.append('current_page', $('.js-active.page-link').text());

		MY_AJAX('/get-more-product', formData,function(data){
			console.log(data);
			$('.js-favorites-inner').append(data.html);
			if( data.count < take){
				button.remove();
			}
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);

				console.log(errors);

			}
		});
	});

	$(document).on('submit', '.js-leave-reviews', function (e){
		e.preventDefault();

		let formData = new FormData($(this).get(0))
		formData.append('_token', $('meta[name=_token]').attr('content'));

		MY_AJAX('/send-reviews', formData, function(data){
			console.log(data);
			if($('input[name="product_id"]').length){
				toggleModal('modal-give-feedback-product');
				toggleModal('modal-give-feedback-success');
			} else {
				toggleModal('modal-give-feedback');
				toggleModal('modal-give-feedback-success');
			}

			setInterval(function(){ location.reload(); }, 2000);
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				console.log(errors);
			}
		});
	});

	$(document).on('click', '.js-goto-review', function(e){
		e.preventDefault();

		$('.product__tabs-content').removeClass('active');
		$('.product__tabs-btn').removeClass('active');
		$('#reviews').addClass('active');
		$('.js-review-goto').addClass('active');
		$('html, body').animate({scrollTop: $('#reviews').offset().top}, 'slow');
	});

	$(document).on('click', '.notify-close',function(){
		$(this).closest('.notify').hide();
	});

	$(document).on('click', '.notify-close', function(){
		$(this).closest('.notify').hide();
	});

// Cities & NovaPoshta
	if($('.city-picker').length){
		$('.city-picker').addClass('js-city-picker').selectpicker();
		// $('.warehouse-picker').selectpicker();

		$(document).on('input', 'div.js-city-picker input[type="search"]',function (){
			console.log($(this).val());

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: 'http://api.novaposhta.ua/v2.0/json/Address/searchSettlements/',
				data: JSON.stringify({
					modelName: 'Address',
					calledMethod: 'searchSettlements',
					methodProperties: {
						CityName: $(this).val(),
						Limit: 555
					},
					apiKey: '6ad3d90c2aa9c57b0ad65b5526c1a386'
				}),
				headers: {
					'Content-Type': 'application/json'
				},
				xhrFields: {
					withCredentials: false
				},
				success: function(texts) {
					console.log(1);
					$('select[name="address[city]"]').html('');
					// $('.filter-option-inner-inner').css('border', 'none');
					$.each(texts.data[0].Addresses, function (item, value){
						// console.log(item);
						if(item > 155){
							return false;
						}
						if(value.SettlementTypeCode == 'м.'){
							$('select[name="address[city]"]').append('<option value="'+ value.MainDescription +'" data-ref="'+ value.Ref +'">'+ value.MainDescription +'</option>');
						}
					});
					$('.city-picker').selectpicker('refresh');
					$('.city-picker').change();
					// $('.delivery_warehouse').change();// ???
				},
			});

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: 'https://api.justin.ua/justin_pms/hs/v2/runRequest',
				data: JSON.stringify({
					"api_key": "dfce840b-3013-11eb-abe5-0050569b1d4d",
					"keyAccount": "VlasyukNA",
					"sign": "udLh#z^!",
					"request": "getData",
					"type": "request",
					"name": "req_DepartmentsLang",
					"language": "UA",
					"TOP": 50,
					"desc": $(this).val(),
					"params": {
						"language": "UA"
					},
					// "filter": [
					// 	{
					// 		"name": "region",
					// 		"comparison": "equal",
					// 		"leftValue": "e7ebcef8-dbfb-11e7-80c6-00155dfbfb00"
					// 	}
					// ]
				}),
				headers: {
					'Content-Type': 'application/json'
				},
				xhrFields: {
					withCredentials: false
				},
				success: function(texts) {
					console.log(1);

				},
			});
		});

		$(document).on('change', '.city-picker', function (){

			let ref = $('.city-picker option:selected').attr('data-ref');

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: 'http://api.novaposhta.ua/v2.0/json/AddressGeneral/getWarehouses/',
				data: JSON.stringify({
					modelName: 'AddressGeneral',
					calledMethod: 'getWarehouses',
					methodProperties: {
						"SettlementRef": ref,
					},
					apiKey: '6ad3d90c2aa9c57b0ad65b5526c1a386'
				}),
				headers: {
					'Content-Type': 'application/json'
				},
				xhrFields: {
					withCredentials: false
				},
				success: function(warehouses) {
					// console.log(warehouses);
					// $('.delivery_warehouse').css('display', 'inline-block');
					$('.warehouse-picker').html('');
					$.each(warehouses.data, function (item, value){
						if(item > 155){
							return false;
						}
						$('select.warehouse-picker').append('<option value="'+ value.Description +'" data-ref="'+ value.CityRef +'">'+ value.Description +'</option>');
					});
					$('.city-picker').selectpicker('refresh');
				},
			});
		});
	}

// Catalog

	$('li label input:checked').each(function(){
		let title = $(this).next().next().text();
		let id = $(this).attr('id');
		$('<a href="#" class="catalog__btn clear-btn filter_close" data-id="' + id +'">' +
			'<span>' + title + '</span>' +
			'<svg>' +
			'<use xlink:href="/assets/img/sprite.svg#delete"></use>' +
			'</svg>' +
			'</a>').insertBefore($('.catalog__buttons .clear_filters'));
	});

	$(document).on('submit','.filter-catalog',function (e) {
		e.preventDefault();

		let formData = new FormData($(this).get(0));
		formData.append('_token', $('meta[name=_token]').attr('content'));
		formData.append('type', $('input[name="sort"]:checked').val());
		formData.append('page', 1);

		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		for (var i = 0; i < sURLVariables.length; i++)
		{
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == 'q') {
				formData.append('q', sParameterName[1]);
			}
		}

		const searchParams = new URLSearchParams(formData);
		searchParams.delete('_token');

		let sortUrl = {};
		for (var [p,i] of searchParams.entries()){
			if(!sortUrl.hasOwnProperty(p)) {
				sortUrl[p] = searchParams.getAll(p);
			}
		}

		let newQuery = '';
		for(let params in sortUrl){
			newQuery+= params.replaceAll('[]','')+"-";

			newQuery+= sortUrl[params].join('_');
			// for(let x of sortUrl[params]){
			//     newQuery+= x+"_";
			// }
			newQuery+= '/';
		}

		console.log(newQuery);

		let queryString = searchParams.toString();

		// queryString = queryString.replaceAll('&','/');
		// queryString = queryString.replaceAll('=','_');

		console.log(queryString.hash);

		window.history.pushState(null, null, "?" + queryString);

		getPosts(formData,1);

	});

	function findGetParameter(parameterName) {
		var result = null,
			tmp = [];
		var items = location.search.substr(1).split("&");
		for (var index = 0; index < items.length; index++) {
			tmp = items[index].split("=");
			if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
		}
		return result;
	}

	$(document).on('click','.filter_close',function (e){
		e.preventDefault();
		$(this).remove();
		$('#'+$(this).attr('data-id')).prop('checked', false);

		if(!$('.catalog__buttons .catalog__btn').length){
			$('.catalog__clear.clear_filters').css('display', 'none');
		}

		$('.filter-catalog').submit();
	});

	$(document).on('click','.clear_filters',function (e){
		e.preventDefault();
		$('label input:checked').each(function(){
			$($(this)).prop('checked', false);
		});
		$('.clear-btn.filter_close').remove();
		$('.catalog__clear.clear_filters').css('display', 'none');

		$('.filter-catalog').submit();
	});

	$(document).on('change','.checkbox__input',function (e){
		e.preventDefault();

		let title = $(this).next().next().text();
		let id = $(this).attr('id');

		if(!$(this).is(':checked')){

			$('.filter_close[data-id="'+id+'"]').remove();

		}else{
			$('.clear_filters').css('display', 'inline-block');
			if($('.filter_close').length){
				$('<a href="#" class="catalog__btn clear-btn filter_close" data-id="' + id +'">' +
					'<span>' + title + '</span>' +
					'<svg>' +
					'<use xlink:href="/assets/img/sprite.svg#delete"></use>' +
					'</svg>' +
					'</a>').insertAfter($('.catalog__buttons .clear-btn').last());
			} else {

				$('<a href="#" class="catalog__btn clear-btn filter_close" data-id="' + id +'">' +
					'<span>' + title + '</span>' +
					'<svg>' +
					'<use xlink:href="/assets/img/sprite.svg#delete"></use>' +
					'</svg>' +
					'</a>').insertBefore($('.catalog__buttons .clear_filters'));
			}
		}

		$('.filter-catalog').submit();
	});

	$(document).on('change', 'input[type=radio][name=sort]', function(e) {
		e.preventDefault();

		let title = $(this).next().next().text();
		let id = $(this).attr('data-id');
		console.log($(this));
		$('.filter_close[data-id="1"]').remove();
		$('.js-sort-delete.filter_close').remove();
		if($('.filter_close').length){
			$('<a href="#" class="catalog__btn clear-btn js-sort-delete filter_close">' +
				'<span>' + title + '</span>' +
				'<svg>' +
				'<use xlink:href="/assets/img/sprite.svg#delete"></use>' +
				'</svg>' +
				'</a>').insertAfter($('.catalog__buttons .clear-btn').last());
		} else {
			$('<a href="#" class="catalog__btn clear-btn js-sort-delete filter_close">' +
				'<span>' + title + '</span>' +
				'<svg>' +
				'<use xlink:href="/assets/img/sprite.svg#delete"></use>' +
				'</svg>' +
				'</a>').insertBefore($('.catalog__buttons .clear_filters'));
		}

		$('.filter-catalog').submit();
	});

	var page = 1;
	$(window).on('hashchange', function() {
		if (window.location.hash) {
			page = window.location.hash.replace('#', '');
			if (page == Number.NaN || page <= 0) {
				return false;
			} else {
				let formData = new FormData($('.filter-catalog').get(0));

				formData.append('_token',$('meta[name=_token]').attr('content'));
				formData.append('type',$('.sorting-category__item.js-active').data('val'));

				getPosts(formData,page);
			}
		}
	});

	$(document).ready(function() {
		$(document).on('click', '.js-catalog-pagination a', function (e) {
			e.preventDefault();

			page = $(this).attr('href').split('page=')[1];

			let formData = new FormData($('.filter-catalog').get(0));
			formData.append('_token',$('meta[name=_token]').attr('content'));
			formData.append('type',$('.sorting-category__item.js-active').data('val'));
			formData.append('page',page);

			var sPageURL = window.location.search.substring(1);
			var sURLVariables = sPageURL.split('&');
			for (var i = 0; i < sURLVariables.length; i++)
			{
				var sParameterName = sURLVariables[i].split('=');
				if (sParameterName[0] == 'q') {
					formData.append('q', sParameterName[1]);
				}
			}

			const searchParams = new URLSearchParams(formData);
			searchParams.delete('_token');

			let queryString = searchParams.toString();

			window.history.pushState(null, null, "?" + queryString);


			getPosts(formData,page);
		});
	});

	function getPosts(formData,page) {
		MY_AJAX(window.location.pathname+'?page=' + page,formData,function(data){
			console.log(data);
			if(data.categories.length > 0){
				$('.js-category-list').find('ul').html('');
				$('.js-category-list').css('display', 'block');
				$.each(data.categories, function(key,item){
					console.log(item);
					$('.js-category-list').find('ul').append(`<li><label>
																							<input class="checkbox__input"
 																								type="checkbox"
																							 	name="categories[]"
																							 	id="categories-`+ item.id +`"
																							 	value="`+ item.id +`">
																							<svg>
																								<use xlink:href="/assets/img/sprite.svg#check"></use>
																							</svg>
																							<span>`+ item.title +`</span>
																						</label></li>`);
				});
			}

			let curentNumber = data.products.current_page == data.products.last_page ? data.products.total : data.products.current_page * data.products.per_page;
			$('.catalog__top .catalog__span.span span').html(`${data.products.total}`);

			$('.catalog__inner').html(data.html);
		});
	}

// Blog

	$(document).on('click', '.js-blog-category', function (e){
		e.preventDefault();

		let formData = new FormData();

		formData.append('_token',$('meta[name=_token]').attr('content'));
		formData.append('id', $(this).attr('data-id'));
console.log(1);
		let cur_category = $(this);

		MY_AJAX('/get-category-articles', formData,function(data){
			console.log(data);
			$('.js-blog-category').removeClass('active');
			cur_category.addClass('active');
			if(data.count < 9){

			}
			$('.blog__inner').html(data.html);
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				console.log(errors);
			}
		});
	});

	$(document).ready(function() {
		$(document).on('click', '.js-pagination-blog li', function (e) {
			e.preventDefault();

			page = $(this).text();
			console.log(page);

			let formData = new FormData();
			formData.append('_token',$('meta[name=_token]').attr('content'));
			formData.append('category_id',$('.js-blog-category.active').attr('data-id'));
			formData.append('page',page);

			const searchParams = new URLSearchParams(formData);
			searchParams.delete('_token');
			$('.page-item active')
			let queryString = searchParams.toString();

			window.history.pushState(null, null, "?" + queryString);


			MY_AJAX(window.location.pathname+'?page=' + page,formData,function(data){

				$('.blog__inner').html(data.html);
			},function (data, exception){
				if( data.status === 422 ) {
					var errors = $.parseJSON(data.responseText);
				}
			});
		});
	});

// Cart

	$(document).on('click', '.js-buy-button', function(e){
		e.preventDefault();

		let formData = new FormData();
		let total = 0;

		formData.append('_token',$('meta[name=_token]').attr('content'));
		formData.append('product_id', $(this).parent().attr('data-id'));
		formData.append('variations', $('.select__option.selected').attr('data-id'));
		formData.append('quantity', 1);

		if(!$('.select__option.selected').length && $('.product__size').length){
			$('.product__select.select').addClass('active');
			return;
		}

		MY_AJAX('/cart/add', formData,function(data){
			console.log(data);
			$('.shopping-cart').html(data);
			calculateCart();
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				console.log(errors);
			}
		});
	});

	$(document).on('click', '.select__option', function (){
		$(this).parents('.profile__product').find('.card-product__price-new').html($('.select__option.selected').attr('data-price') + ' ' + $('.js-product__price').attr('data-val'));
	});

	$(document).on('click', '.js-buy-button-favorite', function(e){
		e.preventDefault();

		let formData = new FormData();
		let total = 0;

		formData.append('_token',$('meta[name=_token]').attr('content'));
		formData.append('product_id', $(this).attr('data-id'));
		formData.append('quantity', 1);

		if(!$(this).parents('.card-product').find('.select__option.selected').length && $(this).parents('.card-product').find('.product__size').length){
			$('.product__select.select').addClass('active');
			return;
		} else if($(this).parents('.card-product').find('.select__option.selected').length && $(this).parents('.card-product').find('.product__size').length) {
			formData.append('variations', $('.select__option.selected').attr('data-id'));
		}

		MY_AJAX('/cart/add', formData,function(data){
			console.log(data);
			$('.shopping-cart').html(data);
			calculateCart();
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				console.log(errors);
			}
		});
	});

	calculateCart();

	function calculateCart(){
		let total = 0;
		let quantity = 0;
		$('.js-shop-cart').each(function(){
			total += Number($(this).attr('data-price'));
			quantity += Number($(this).attr('data-quantity'));
		})

		$('.header__button--shopping-cart span').text(quantity);
		$('.shopping-cart__top-span.js-text-count').text(quantity);

		$('.shopping-cart__total-price').text(total + ' ' + $('.shopping-cart__inner').attr('data-val'));
		$('.js-text-count').html('(' + (Number(quantity)) + ' ' + $('.js-text-count').attr('data-text') + ')');
		$('.js-total').attr('data-total', total);
	}

	$(document).on('click', '.js-remove-product', function(e){
		e.preventDefault();

		let formData = new FormData();
		let id = $(this).attr('data-id');
		let thisItem = $(this);
		let total = 0;
		formData.append('_token',$('meta[name=_token]').attr('content'));

		MY_AJAX('/cart/remove/' + id, formData,function(data){
			console.log(data);
			if(data == 'ok'){
				$('.js-remove-product[data-id="'+ id +'"]').parents('li').remove();
				if(!$('.js-shop-cart').length){
					$('.shopping-cart__none.d-none').css('display', 'block');
					$('.shopping-cart__bottom').css('display', 'none');
					$('.shopping-cart__top').css('display', 'none');
					$('.shopping-cart__main-btn').css('display', 'none');

					$('.js-d-none-wrapper').css('display', 'none');
					$('.js-empty-cart').css('display', 'block');
				} else {
					$('.js-shop-cart').each(function () {
						total += Number($(this).attr('data-price'));
					})
					$('.shopping-cart__total-price').text(total + ' ' + $('.js-product__price').attr('data-val'));
					$('.js-text-count').html('(' + (Number($('.js-text-count').attr('data-count')) - 1) + ' ' + $('.js-text-count').attr('data-text') + ')');
				}
					$('.header__button--shopping-cart span').text(Number($('.header__button--shopping-cart span').text()) - 1);
			}
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				console.log(errors);
			}
		});
	});

// Order

	$(document).on('submit','#authorization',function (e){
		e.preventDefault();

		let formData = new FormData($(this).get(0));
		formData.append('_token',$('meta[name=_token]').attr('content'));

		MY_AJAX('/login',formData,function(data){
			console.log(data);
			if(data.status == 'success'){
				location.reload();
			}
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);

				$('#authorization').find('.authorization__error').html('');
				$('.authorization__input-wrapper').removeClass('authorization__input-wrapper--error');

				$.each(errors.errors, function( key, value){
					if(key == 0){
						$('#authorization').find('input[name="email"]').parent().addClass('authorization__input-wrapper--error');
					}
					if(key == 1){
						$('#authorization').find('input[name="password"]').parent().addClass('authorization__input-wrapper--error');
					}
					$('#authorization').find('.authorization__error').append('<p>' + value + '</p>');
				});
				console.log(errors);
				if(errors.message){
					$('#authorization').find('.authorization__error').html('<p>' + errors.message + '</p>');
				}
			}
		});

	});

	//Delivery API NovaPoshta, UkrPoshta, JustIn
		if($('.order').length){
			// NovaPoshta
			$('.order-city-picker').addClass('js-city-picker').selectpicker();

			$(document).on('change', 'select[name="method_delivery"]', function(e){

				$('select[name="your_city"]').css('display', 'block');
				$('select[name="your_warehouse"]').css('display', 'none');
				$('.order__selects').addClass('active');
				$('.order-city-picker').selectpicker('refresh');
				$('.js-delivery-warehouse').html('');

			});

			$(document).on('input change', 'div.js-city-picker input[type="search"]',function (){
				if($(this).val().length > 2){
					$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'http://api.novaposhta.ua/v2.0/json/Address/searchSettlements/',
					data: JSON.stringify({
						modelName: 'Address',
						calledMethod: 'searchSettlements',
						methodProperties: {
							CityName: $(this).val(),
							Limit: 555
						},
						apiKey: '6ad3d90c2aa9c57b0ad65b5526c1a386'
					}),
					headers: {
						'Content-Type': 'application/json'
					},
					xhrFields: {
						withCredentials: false
					},
					success: function(texts) {
						console.log(1);
						$('select[name="your_city"]').html('');
						// $('.filter-option-inner-inner').css('border', 'none');
						$.each(texts.data[0].Addresses, function (item, value){
							// console.log(item);
							if(item > 155){
								return false;
							}
							if(value.SettlementTypeCode == 'м.'){
								$('select[name="your_city"]').append('<option value="'+ value.MainDescription +'" data-ref="'+ value.Ref +'">'+ value.MainDescription +'</option>');
							}
						});
						$('.order-city-picker').selectpicker('refresh');
						$('.order-city-picker').change();
						// $('.delivery_warehouse').change();// ???
					},
				});
				}
			});

			$(document).on('change', '.order-city-picker', function (){

				let ref = $('.order-city-picker option:selected').attr('data-ref');

				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'http://api.novaposhta.ua/v2.0/json/AddressGeneral/getWarehouses/',
					data: JSON.stringify({
						modelName: 'AddressGeneral',
						calledMethod: 'getWarehouses',
						methodProperties: {
							"SettlementRef": ref,
						},
						apiKey: '6ad3d90c2aa9c57b0ad65b5526c1a386'
					}),
					headers: {
						'Content-Type': 'application/json'
					},
					xhrFields: {
						withCredentials: false
					},
					success: function(warehouses) {
						$('select[name="your_warehouse"]').html('');
						$('.js-delivery-warehouse').css('display', 'block');
						$.each(warehouses.data, function (item, value){
							if(item > 155){
								return false;
							}
							$('select.js-delivery-warehouse').append('<option value="'+ value.Description +'" data-ref="'+ value.CityRef +'">'+ value.Description +'</option>');
						});
						$('.order-city-picker').selectpicker('refresh');
					},
				});
			});

			$(document).on('change', '.js-delivery-warehouse', function(){
				let point = /[-]{0,1}[\d]*[.]{0,1}[\d]+/g;
				let count = Number($('.js-text-count').attr('data-count'));
				let total = Number($('.js-product__price').text().match(point));
				let weight = 3;

				let total_delivery = 0;

				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'http://api.novaposhta.ua/v2.0/json/AddressGeneral/getWarehouses/',
					data: JSON.stringify({
						"modelName": "InternetDocument",
						"calledMethod": "getDocumentPrice",
						"methodProperties": {
							"CitySender": "8d5a980d-391c-11dd-90d9-001a92567626",
							"CityRecipient": $('.js-delivery-warehouse option:selected').attr('data-ref'),
							"Weight": weight,
							"ServiceType": "WarehouseWarehouse",
							"Cost": total,
							"CargoType": "Parcel",
							"SeatsAmount": count,
						},
						"apiKey": "6ad3d90c2aa9c57b0ad65b5526c1a386"
					}),
					headers: {
						'Content-Type': 'application/json'
					},
					xhrFields: {
						withCredentials: false
					},
					success: function(warehouses) {
						console.log(warehouses);
						$('.js-shipping-cost').html(warehouses.data[0].Cost + ' грн');
						$('.js-shipping-cost').attr('data-shipping-cost', warehouses.data[0].Cost);
						total_delivery = warehouses.data[0].Cost + total;
						$('.js-total').attr('data-total', total_delivery);
						$('.js-product__price').html(total_delivery + ' грн');
					},
				});

			});
		}

	$(document).on('submit', '#js-create-order', function(e){
		e.preventDefault();

		$('.order__inputs input').removeClass('error');
		$('.order__selects select').removeClass('error');

		if(!$('input[name="first_name"]').val()){
			$('input[name="first_name"]').addClass('error');
			return;
		}else if(!$('input[name="phone"]').val() || $('input[name="phone"]').val().length < 19){
			$('input[name="phone"]').addClass('error');
			return;
		} else if(!$('input[name="email"]').val()){
			$('input[name="email"]').addClass('error');
			return;
		} else if(!$('select[name="method_delivery"] option:selected').attr('data-id')){
			$('select[name="method_delivery"]').addClass('error');
			return
		} else if(!$('select[name="your_city"] option:selected').attr('data-ref')){
			$('select[name="your_city"]').addClass('error');
			return
		} else if(!$('select[name="your_warehouse"] option:selected').attr('data-ref')){
			$('select[name="your_warehouse"]').addClass('error');
			return
		} else if(!$('select[name="payment_method"] option:selected').attr('data-id')){
			$('select[name="payment_method"]').addClass('error');
			return
		}

		let formData = new FormData($(this).get(0));
		formData.append('_token', $('meta[name=_token]').attr('content'));
		if($('input[name="create_account"]:checked').length){
			formData.append('create_account', $('input[name="create_account"]').val());
		} else if($('input[name="promocode"]').hasClass('activated')){
			formData.append('promocode', $('input[name="promocode"]').val());
		}

		formData.append('shipping_price', $('.js-shipping-cost').attr('data-shipping-cost'));
		formData.append('method_delivery_id', $('select[name="method_delivery"] option:selected').attr('data-id'));

		MY_AJAX('/checkout', formData,function(data){
			console.log(data);
			$('html').html(data.html);
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				$.each(errors.errors, function( key, value){
					if(key == 'email'){
						$('input[name="email"]').addClass('error');
					} else if(key == 'phone'){
						$('input[name="phone"]').addClass('error');
					} else if(key == 'password'){
						$('input[type="password"]').addClass('error');
					}
				});
				console.log(errors);
			}
		});
	});

	$(document).on('click', '.js-order-submit', function(e){
		e.preventDefault();
		$('#js-create-order').submit();
	})

	$(document).on('click', '.js-submit-promocode', function (e){
		let ids = [];

		$('.js-shop-cart').each(function(){
			ids.push($(this).attr('data-id'));
		});
		let formData = new FormData();
		formData.append('_token', $('meta[name=_token]').attr('content'));
		formData.append('promocode', $(this).parent().find('input').val());
		formData.append('ids', ids);

		MY_AJAX('/use-promocode', formData,function(data){
			console.log(data);
			$('.js-promocode-message').css('display', 'block');
			if(data.error){
				$('.js-promocode-message').text(data.error);
			} else {
				$('.js-promocode-message').text(data.success);
				$('input[name="promocode"]').addClass('activated');
				$('.js-promocode').css('display', 'block');
				$('.js-promocode').attr('data-price', data.discount);
				$('.js-promocode .shopping-cart__price').text(data.discount + ' ' + $('.shopping-cart__inner').attr('data-val'));
				$('.js-product__price').text($('.js-total').attr('data-total') - data.discount + ' ' + $('.shopping-cart__inner').attr('data-val'));
				$('.js-total').text($('.js-total').attr('data-total') - data.discount + ' ' + $('.shopping-cart__inner').attr('data-val'));
				$('.js-total').attr('data-total', $('.js-total').attr('data-total') - data.discount);
			}
		},function (data, exception){
			if( data.status === 422 ) {
				var errors = $.parseJSON(data.responseText);
				console.log(errors);
			}
		});
	});

});

// inputMask

const phoneMaskSelector = 'input[type="tel"]';
const phoneMaskInputs = document.querySelectorAll(phoneMaskSelector);

const masksOptions = {
	phone: {
		mask: '+38 (000) 000-00-00'
	}
};

for(const item of phoneMaskInputs) {
	new IMask(item, masksOptions.phone);
}

function MY_AJAX(url,data,callback,errors = '') {
	$.ajax({
		url: url,
		type: 'post',
		data: data,
		dataType: 'json',
		processData: false,
		contentType: false,
		success: callback,
		error: errors?errors:function (data, exception) {
			console.log(data);
			console.log(exception);
		}
	});
}
