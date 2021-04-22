<?php

return array (
	'required'    => ':attribute это обязательное поле',
	'unique'      => 'Этот :attribute уже используется',
	'required_if' => 'Не задано 1',
	'attributes'  => [
		'phone'        => 'Телефон',
		'first_name'   => "Имя",
		'last_name'    => "Фамилия",
		'middle_name'  => "Отчество",
		'city'         => 'Город',
		'email'        => 'E-mail',
		'password'     => 'Пароль',
		'confirmation' => 'Согласие на обработку персональных данных',
	],
	'confirmed' => 'Пароли не совпадають',
);


//
//return array (
//	'custom' =>
//		array (
//			'email' =>
//				array (
//					'required' => 'Обов\'язково',
//					'regex' => 'Не задано',
//				),
//			'password' =>
//				array (
//					'required' => 'Обов\'язково',
//				),
//			'phone' =>
//				array (
//					'required' => 'Обов\'язково',
//				),
//			'first_name' =>
//				array (
//					'required' => 'Обов\'язково',
//				),
//			'confirmation' =>
//				array (
//					'required' => 'Обов\'язково',
//				),
//		),
//	'required' => 'Не задано',
//	'attributes' => 'Не задано',
//	'values' =>
//		array (
//			'email' =>
//				array (
//					'' => 'Не задано',
//					'asdfasf@sdfsdf' => 'Не задано',
//				),
//			'password' =>
//				array (
//					'' => 'Не задано',
//				),
//			'phone' =>
//				array (
//					'' => 'Не задано',
//				),
//			'first_name' =>
//				array (
//					'' => 'Не задано',
//				),
//			'confirmation' =>
//				array (
//					'' => 'Не задано',
//				),
//		),
//	'regex' => 'Не задано',
//);
