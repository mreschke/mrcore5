<?php
\Lifecycle::add(__FILE__, 1);

Route::group(['prefix' => '/workbench/route'], function() {

	Route::get('/', array(
	    'uses' => 'Mrcore\WorkbenchFramework\WorkbenchFrameworkController@index'
	));

});


