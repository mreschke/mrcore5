<?php

// NOTICE: Do not use laravels env() function here.
// This config is loaded by the asset manager which has no such function available.

return [

	/*
	|--------------------------------------------------------------------------
	| Mrcore Modules
	|--------------------------------------------------------------------------
	|
	| Define all mrcore modules.  Order does not matter here.  Path is relative
	| to your laravel root (no leading or trailing /).
	|
	*/

	'modules' => [

		'Foundation' => [
			'type' => 'foundation',
			'namespace' => 'Mrcore\Modules\Foundation',
			'controller_namespace' => 'Mrcore\Modules\Foundation\Http\Controllers',
			'provider' => 'Mrcore\Modules\Foundation\Providers\FoundationServiceProvider',
			'path' => '../Modules/Foundation',
			'routes' => '../Modules/Foundation/Http/routes.php',
			'route_prefix' => null,
			'views' => null,
			'view_prefix' => null,
			'assets' => null,
			'enabled' => true,
		],

		'Auth' =>  [
			'type' => 'module',
			'namespace' => 'Mrcore\Modules\Auth',
			'controller_namespace' => 'Mrcore\Modules\Auth\Http\Controllers',
			'provider' => 'Mrcore\Modules\Auth\Providers\AuthServiceProvider',
			'path' => '../Modules/Auth',
			'routes' => '../Modules/Auth/Http/routes.php',
			'route_prefix' => null,
			'views' => '../Modules/Auth/Views',
			'view_prefix' => null,
			'assets' => '../Modules/Auth/Assets',
			'enabled' => true,
		],

		'Wiki' => [
			'type' => 'module',
			'namespace' => 'Mrcore\Modules\Wiki',
			'controller_namespace' => 'Mrcore\Modules\Wiki\Http\Controllers',
			'provider' => 'Mrcore\Modules\Wiki\Providers\WikiServiceProvider',
			'path' => '../Modules/Wiki',
			'routes' => '../Modules/Wiki/Http/routes.php',
			'route_prefix' => null,
			'views' => '../Modules/Wiki/Views',
			'view_prefix' => null,
			'assets' => '../Modules/Wiki/Assets',
			'enabled' => true,
		],

		/*'%app%' => [
			'type' => 'module',
			'namespace' => 'Mrcore\Apps\Mrcore\Appstub',
			'controller_namespace' => 'Mrcore\Apps\Mrcore\Appstub\Http\Controllers',
			'provider' => 'Mrcore\Apps\Mrcore\Appstub\Providers\AppstubServiceProvider',
			'path' => '../Apps/Mrcore\Appstub',
			'routes' => '../Apps/Mrcore/Appstub/Http/routes.php',
			'route_prefix' => 'appstub',
			'views' => '../Apps/Mrcore/Appstub/Views',
			'view_prefix' => 'appstub',
			'assets' => '../Apps/Mrcore/Appstub/Assets',
			'enabled' => true,
		],*/

		// Bootswatch Themes
		// default cerulean cosmo cyborg darkly flatly journal lumen paper
		// readable sandstone simplex slate spacelab superhero united yeti
		'BaseTheme' => [
			'type' => 'basetheme',
			'namespace' => 'Mrcore\Themes\Bootswatch',
			'controller_namespace' => null,
			'provider' => 'Mrcore\Themes\Bootswatch\Providers\ThemeServiceProvider',
			'path' => '../Themes/Bootswatch',
			'routes' => null,
			'route_prefix' => null,
			'views' => '../Themes/Bootswatch/Views',
			'view_prefix' => null,
			'assets' => '../Themes/Bootswatch/Assets',
			'css' => ['css/bootstrap/simplex.min.css'],
			'container' => [
				'header' => true,
				'body' => true,
				'footer' => true,
			],
			'enabled' => true,
		],

		'SubTheme' => [
			'type' => 'subtheme',
			'namespace' => 'Mrcore\Themes\Dynatron',
			'controller_namespace' => null,
			'provider' => 'Mrcore\Themes\Dynatron\Providers\ThemeServiceProvider',
			'path' => '../Themes/Dynatron',
			'routes' => null,
			'route_prefix' => null,
			'views' => '../Themes/Dynatron/Views',
			'view_prefix' => null,
			'assets' => '../Themes/Dynatron/Assets',
			'css' => [
				'css/bootstrap/dynatron.min.css',
				'css/bootstrap/override/dynatron-dynatron.css',
			],
			'enabled' => false,
		],




		'Helpers' => [
			'type' => 'module',
			'namespace' => 'Mreschke\Helpers',
			'path' => '../Modules/Mreschke/Helpers',
		],

		'Dbal' => [
			'type' => 'module',
			'namespace' => 'Mreschke\Dbal',
			'provider' => 'Mreschke\Dbal\DbalServiceProvider',
			'path' => '../Modules/Mreschke/Dbal',
		],

		'Render' => [
			'type' => 'module',
			'namespace' => 'Mreschke\Render',
			'provider' => 'Mreschke\Render\RenderServiceProvider',
			'path' => '../Modules/Mreschke/Render',
		],

		'Mrcore4Legacy' => [
			'type' => 'module',
			'namespace' => 'Mreschke\Mrcore4Legacy',
			'provider' => 'Mreschke\Mrcore4Legacy\Providers\Mrcore4LegacyServiceProvider',
			'path' => '../Modules/Mreschke/Mrcore4Legacy',
		],

	],

	/*
	|--------------------------------------------------------------------------
	| Loading Order / Override Management
	|--------------------------------------------------------------------------
	|
	| Defines the modules loading order for each item (assets, views, routes).
	| First item found wins. This fine grained control control over module
	| overrides giving you the control.
	| If you have the Mrcore\Modules\Wiki module enabled, then use %app% to define
	| the order of the dynamically loaded wiki application.  Usually apps are first
	| which allows an app to be primary override.  Your actual laravel app is not
	| listed, but always comes first (even above %app%) for assets, views and routes.
	|
	*/

	'assets' => [
		'%app%',
		'SubTheme',
		'Auth',
		'Wiki',
		'BaseTheme',
	],

	'views' => [
		'%app%',
		'SubTheme',
		'Auth',
		'Wiki',
		'BaseTheme',
	],

	'routes' => [
		'%app%',
		'Auth',
		'Wiki',
		'Foundation',
	],

	/*
	|--------------------------------------------------------------------------
	| Debug and Trace
	|--------------------------------------------------------------------------
	|
	| If enabled, each modules boot and register is added to a IoC array for
	| further dump and analysis using dd(Module::trace())
	|
	*/

	'debug' => true,


];