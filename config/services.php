<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => env('SERVICES_MAILGUN_DOMAIN', ''),
		'secret' => env('SERVICES_MAILGUN_SECRET', ''),
	],

	'mandrill' => [
		'secret' => env('SERVICES_MANDRILL_SECRET', 'xyz'),
	],

	'ses' => [
		'key' => env('SERVICES_SES_KEY', ''),
		'secret' => env('SERVICES_SES_SECRET', ''),
		'region' => env('SERVICES_SES_REGION', 'us-east-1'),
	],

	'stripe' => [
		'model'  => env('SERVICES_STRIPE_MODEL', 'User'),
		'secret' => env('SERVICES_STRIPE_SECRET', ''),
	],

];
