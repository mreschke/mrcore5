<?php

// DO NOT use env() in this view.php as it is used by the mRcore asset manager

return [

	/*
	|--------------------------------------------------------------------------
	| Mrcore Themes
	|--------------------------------------------------------------------------
	|
	| Enabled mrcore themes.  You may specify as many enabled themes as you need.
	| They are all merged and override each other.  Order is critical.  The first
	| asset or view found in this array is used first.  Because of this order
	| the small sub-theme should be defined first, then the larger base theme.
	| Path is relative to your laravel root (no beginning or trailing /).
	|
	*/

	'themes' => [
		#[
		#	'namespace' => 'Mrcore\Themes\Dynatron',
		#	'path' => '../Themes/Dynatron',
		#	'type' => 'subtheme'
		#],
		[
			'namespace' => 'Mrcore\Themes\Bootswatch',
			'path' => '../Themes/Bootswatch',
			'type' => 'basetheme'
		]
	],

	/*
	|--------------------------------------------------------------------------
	| Theme Main CSS
	|--------------------------------------------------------------------------
	|
	| Main Css
	| default cerulean cosmo cyborg darkly flatly journal lumen paper
	| readable sandstone simplex slate spacelab superhero united yeti
	|
	*/	

	'css' => 'paper.min.css',

	/*
	|--------------------------------------------------------------------------
	| Bootstrap Container
	|--------------------------------------------------------------------------
	|
	| Enable or disable the bootstrap containers for the the main body,
	| header and footer navbars.
	|
	*/	
	
	'container' => true,
	'header_container' => true,
	'footer_container' => true,

	/*
	|--------------------------------------------------------------------------
	| Additional Asset Paths
	|--------------------------------------------------------------------------
	|
	| Add additional asset paths to be picked up by the mrcore asset manager.
	| These are added to the end of the asset array, after your themes.
	| Useful when you have mrcore modules that have assets.  Path is relative
	| to your laravel root (no beginning or trailing /).  Point to the actual
	| assets folder of your choice. Example: ../Modules/Wiki/Assets
	|
	*/

	'assets' => [
		'../Modules/Wiki/Assets',
	],


];
