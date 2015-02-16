<?php

class RouteTest extends TestCase {

	/**
	 * Test all primary routes
	 * These are routes that do not redirect or are not legacy
	 * These are all anonymouse pages so no authentication is needed
	 */
	public function testPrimaryRoutes()
	{
	/*	//Filters disabled during unit tests unless you enable them
		//I need them enabled because they log the user in as anonymous
		Route::enableFilters();

		// Test base route
		// Should show post id 1
		$response = $this->call('GET', '/');
		$post = $response->original['post'];
		$this->assertResponseOk();
		$this->assertViewHas('post');
		$this->assertEquals(1, $post->id);
		$this->assertEquals('9d3e171a-62a9-e958-bdfa-d6f224ca8cad', $post->uuid);

		// Test /home is post 1
		$clicksBefore = Router::where('slug', '=', 'home')->first()->clicks;
		$response = $this->call('GET', '/home');
		$post = $response->original['post'];
		$this->assertResponseOk();
		$this->assertViewHas('post');
		$this->assertEquals(1, $post->id);
		$this->assertEquals('9d3e171a-62a9-e958-bdfa-d6f224ca8cad', $post->uuid);
		$clicksAfter = Router::where('slug', '=', 'home')->first()->clicks;
		$this->assertEquals(++$clicksBefore, $clicksAfter);

		// Test /about is post 2
		$response = $this->call('GET', '/about');
		$post = $response->original['post'];
		$this->assertResponseOk();
		$this->assertViewHas('post');
		$this->assertEquals(2, $post->id);
		$this->assertEquals('f1112648-782e-aad3-785d-640fcfefaa9b', $post->uuid);


		// ##### Login as mReschke #####
		Auth::login(User::find(2)); Auth::user()->login();

		// Test /13/mreschke-home-page (non named route)
		$response = $this->call('GET', '/13/mreschke-home-page');
		$post = $response->original['post'];
		$this->assertResponseOk();
		$this->assertViewHas('post');
		$this->assertEquals(13, $post->id);
		$this->assertEquals('1a52e0e3-3174-7b2b-a582-03a39e52e34a', $post->uuid);

		// Test /14/squaethem-home-page (non named route)
		$response = $this->call('GET', '/14/squaethem-home-page');
		$post = $response->original['post'];
		$this->assertResponseOk();
		$this->assertViewHas('post');
		$this->assertEquals(14, $post->id);
		$this->assertEquals('e80e907e-50d4-8ed4-70f7-5d1815672966', $post->uuid);
		*/

	}


	/**
	 * Test all secondary routes
	 * These are the routes that redirect to the primarys
	 * Like /guid, or /post/1 or even /1 if static route enabled
	 */
	public function testSecondaryRoutes()
	{
		/*//Filters disabled during unit tests unless you enable them
		//I need them enabled because they log the user in as anonymous
		Route::enableFilters();

		// Test /1 redirects to /home
		$this->call('GET', '/1');
		$this->assertRedirectedTo('/home');

		// Test /1/anything/here redirects to /home
		$this->call('GET', '/1/anything/here');
		$this->assertRedirectedTo('/home');

		// Test /1 redirects to /home
		$this->call('GET', '/post/1');
		$this->assertRedirectedTo('/home');

		// Test /9d3e171a-62a9-e958-bdfa-d6f224ca8cad redirects to /home
		$this->call('GET', '/9d3e171a-62a9-e958-bdfa-d6f224ca8cad');
		$this->assertRedirectedTo('/home');

		// Test /home2 is post 1 (this is an optional route to post 1)
		// /home2 displays post 1, it does not redirect to /home
		$clicksBefore = Router::where('slug', '=', 'home2')->first()->clicks;
		$response = $this->call('GET', '/home2');
		$post = $response->original['post'];
		$this->assertResponseOk();
		$this->assertViewHas('post');
		$this->assertEquals(1, $post->id);
		$this->assertEquals('9d3e171a-62a9-e958-bdfa-d6f224ca8cad', $post->uuid);
		$clicksAfter = Router::where('slug', '=', 'home2')->first()->clicks;
		$this->assertEquals(++$clicksBefore, $clicksAfter);


		// Test /home3 which is a disabled route
		$this->call('GET', '/home3');
		$this->assertResponseStatus(404);


		// ##### Login as mReschke #####
		Auth::login(User::find(2)); Auth::user()->login();

		// Test /13/blah redirects to /13/mreschke-home-page
		$this->call('GET', '/13/blah');
		$this->assertRedirectedTo('/13/mreschke-home-page');

		// Test /13 and /13/ redirects to /13/mreschke-home-page
		$this->call('GET', '/13');
		$this->assertRedirectedTo('/13/mreschke-home-page');
		$this->call('GET', '/13/');
		$this->assertRedirectedTo('/13/mreschke-home-page');

		// Test /13 redirects to /13/mreschke-home-page
		$this->call('GET', '/post/13');
		$this->assertRedirectedTo('/13/mreschke-home-page');
		*/

	}


	/**
	 * Test all legacy routes
	 * These are old mrcore4 routes like /topic/1 or /files/1
	 */
	public function testLegacyRoutes()
	{
		/*//Filters disabled during unit tests unless you enable them
		//I need them enabled because they log the user in as anonymous
		Route::enableFilters();

		// Test /topic/1 redirects to /home
		$this->call('GET', '/topic/1');
		$this->assertRedirectedTo('/home');
		$this->call('GET', '/topic/1/doesnt/matter');
		$this->assertRedirectedTo('/home');

		// ?? files/1 does not currently redirect
		// not sure if it should or not yet
		*/

	}

	/**
	 * Test all other routes
	 */
	public function testOtherRoutes()
	{
		/*//Filters disabled during unit tests unless you enable them
		//I need them enabled because they log the user in as anonymous
		Route::enableFilters();

		// /google redirects to http://google.com
		$clicksBefore = Router::where('slug', '=', 'google')->first()->clicks;
		$this->call('GET', '/google');
		$this->assertRedirectedTo('http://google.com');
		$clicksAfter = Router::where('slug', '=', 'google')->first()->clicks;
		$this->assertEquals(++$clicksBefore, $clicksAfter);

		// /google2 is a disabled route
		$this->call('GET', '/google2');
		$this->assertResponseStatus(404);

		$this->call('GET', '/99/invalid');
		$this->assertResponseStatus(404);

		$this->call('GET', '/this/is/invalid');
		$this->assertResponseStatus(404);
		

		// Test search route
		// ??

		// Test net route
		// ??

		// Test login route
		$this->call('GET', '/login');
		$this->assertResponseOk();

		// Test logout route redirects to /
		$this->call('GET', '/logout');
		$this->assertRedirectedTo('/');
		*/

	}


	/**
	 * Post functional tests
	 *
	 * @return void
	 */
	public function testAdminRoutes()
	{


	}

}






/*
|--------------------------------------------------------------------------
| Larevel Help
|--------------------------------------------------------------------------
|
*/

/*
Functions must begin with the word test (ex: testSomething)

#$this->call($method, $uri, $parameters, $files, $server, $content);

// DOM Crawler Usage
$crawler = $this->client->request('GET', '/home');
$this->assertTrue($this->client->getResponse()->isOk());

// Login as a user
Auth::login(User::find(3)); Auth::user()->login();

// Login as anonymous
// Filters disabled during unit tests unless you enable them
// I need them enabled because they log the user in as anonymous
Route::enableFilters();

*/
