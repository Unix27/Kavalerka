<?php

return array (
	'required'    => ':attribute це обов\'язкове поле',
	'unique'      => 'Цей :attribute вже використовується',
	'required_if' => 'Не задано 1',
	'attributes'  => [
		'phone'        => 'Телефон',
		'first_name'   => "Ім'я",
		'last_name'    => "Прізвище",
		'middle_name'  => "Ім'я по батькові",
		'city'         => 'Город',
		'email'        => 'E-mail',
		'password'     => 'Пароль',
		'confirmation' => 'Згода на обробку персональних даних',

	],
	'confirmed' => 'Паролі не совпадають',
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
