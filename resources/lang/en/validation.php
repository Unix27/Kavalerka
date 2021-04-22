<?php

return array (
	'required'    => ':attribute is required',
	'unique'      => 'This :attribute already in use',
	'required_if' => 'Not set 1',
	'attributes'  => [
		'phone'        => 'Phone',
		'first_name'   => "Name",
		'last_name'    => "Last name",
		'middle_name'  => "Middle name",
		'city'         => 'City',
		'email'        => 'E-mail',
		'password'     => 'Password',
		'confirmation' => 'Consent to the processing of personal data',

	],
	'confirmed' => 'Passwords do not match',
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
