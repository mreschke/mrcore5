<?php
\Lifecycle::add(__FILE__);

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