<?php
\Lifecycle::add(__FILE__);

/*
|--------------------------------------------------------------------------
| Custom Alias (Facade) Registrations
|--------------------------------------------------------------------------
|
| Register your custom aliases/facades here
|
*/

#$loader = \Illuminate\Foundation\AliasLoader::getInstance();
#$loader->alias('Mysql', 'Mreschke\Dbal\Facades\Mysql');
#$loader->alias('Mssql', 'Mreschke\Dbal\Facades\Mssql');
#$loader->alias('Render', 'Mreschke\Render\Facades\Render');



/*
|--------------------------------------------------------------------------
| Custom Service Provider Registrations
|--------------------------------------------------------------------------
|
| Register your custom service provders here
| Service Providers are the primary way to extend your mrcore installation
|
*/

// Provides legacy mrcore4 helpers
#App::register('Mreschke\Mrcore4Legacy\Mrcore4LegacyServiceProvider');

// Provides database layers like MSSQL
#App::register('Mreschke\Dbal\DbalServiceProvider');

// Provides GUI rendering components like dataTables, charts and graphs
// Depends on Mreschke\Dbal
#App::register('Mreschke\Render\RenderServiceProvider');



/*
|--------------------------------------------------------------------------
| Custom Theme and Sub Theme Registrations
|--------------------------------------------------------------------------
|
| Register your themes and sub themes here
| You must always define one base theme and one subtheme
| The main larger "base" theme should be defined LAST, not first
| The symlink in workbench/theme/current-theme should point to that
| "base" theme and the symlink in workbench/theme/sub-theme should point
| to the smaller override theme
|
*/

App::register('Theme\DefaultTheme\DefaultThemeServiceProvider');
App::register('Mrcore\BootswatchTheme\BootswatchThemeServiceProvider');



/*
|--------------------------------------------------------------------------
| Custom Attributes
|--------------------------------------------------------------------------
|
| Register any other small custom items here
| For more customization, use your own service providers
|
*/

// Define Main Theme CSS File
// default amelia darkly lumen spacelab cerulean readable superhero
// cosmo flatly simplex united cyborg journal slate yeti
$theme = 'simplex';
Layout::replaceCss("css/bootstrap/", "css/bootstrap/$theme.min.css");
// Favs: default, darkly, spacelab, superhero, flatly, simplex, cyborg, slate, yeti

