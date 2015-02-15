<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Default Cache Driver
	|--------------------------------------------------------------------------
	|
	| This option controls the default cache "driver" that will be used when
	| using the Caching library. Of course, you may use other drivers any
	| time you wish. This is the default when another is not specified.
	|
	| Supported: "file", "database", "apc", "memcached", "redis", "array"
	|
	*/

	// OH crap, problams with this idea and unit testing
	// because in the web, requests run in issolation, so all classes are new
	// but in a unit test classes are in the same memory space, so this $post class
	// persists across each unit test :(, so $this->permissions is set once and then never
	// changed for the entire unit test, so all post permissions are out of wake
	// See http://developers.blog.box.com/2012/07/03/unit-testing-with-static-variables/

	// See Post.php getPermissions() note too, this is the problem.
	// I noticed if I comment out this drive line then the 
	// persistant class problem goes away, thats probably because
	// PHP has no memory now, so each processes must be isolated
	'driver' => 'array',

	// Its either comment out that line or in 
	// Posts.php function get() remove that Cache::remember part
	// then it seems to get a new Post class instance on every call.
	// So adding Cache::remember calls broke the current working unit tests

	// I chose to leave this enabled but have a use_cache config variable

);