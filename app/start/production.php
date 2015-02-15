<?php
\Lifecycle::add(__FILE__);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
	return Response::view('error.500', array('exception' => $exception), 500);
});


/*
|--------------------------------------------------------------------------
| Application 404 Handler
|--------------------------------------------------------------------------
|
| Handle all 404 errors
|
*/

App::missing(function($exception)
{
    return Response::view('error.404', array(), 404);
});
