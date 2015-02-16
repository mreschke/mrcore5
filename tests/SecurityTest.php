<?php

class SecurityTest extends TestCase {

	public function testRoutePermissions()
	{

		/*//Filters disabled during unit tests unless you enable them
		//I need them enabled because they log the user in as anonymous
		Route::enableFilters();

		// These should be denied to anonumous user
		$this->call('GET', '/mrcore/help');
		$this->assertResponseStatus(401);
		$this->call('GET', '/13/mreschke-home-page');
		$this->assertResponseStatus(401);
		$this->call('GET', '/14/squaethem-home-page');
		$this->assertResponseStatus(401);

		// ##### Login as ally #####
		Auth::login(User::find(3)); Auth::user()->login();

		// These should be denied to ally
		$this->call('GET', '/mrcore/global');
		$this->assertResponseStatus(401);
		$this->call('GET', '/14/squaethem-home-page');
		$this->assertResponseStatus(401);

		// These should be allowed by ally (but not public)
		$response = $this->call('GET', '/mrcore/help');
		$post = $response->original['post'];
		$this->assertResponseOk();
		$this->assertViewHas('post');
		$this->assertEquals(3, $post->id);
		$this->assertEquals('d3a9cefa-bf1b-43b7-97ed-230dc62b51e2', $post->uuid);

		$response = $this->call('GET', '/13/mreschke-home-page');
		$post = $response->original['post'];
		$this->assertResponseOk();
		$this->assertViewHas('post');
		$this->assertEquals(13, $post->id);
		$this->assertEquals('1a52e0e3-3174-7b2b-a582-03a39e52e34a', $post->uuid);


		// ##### Login as squaethem #####
		Auth::login(User::find(6)); Auth::user()->login();

		// These should be denied to squaethem
		$this->call('GET', '/mrcore/global');
		$this->assertResponseStatus(401);


		// These should be allowed by staci (but not public)
		$response = $this->call('GET', '/mrcore/help');
		$post = $response->original['post'];
		$this->assertResponseOk();
		$this->assertViewHas('post');
		$this->assertEquals(3, $post->id);
		$this->assertEquals('d3a9cefa-bf1b-43b7-97ed-230dc62b51e2', $post->uuid);

		$response = $this->call('GET', '/14/squaethem-home-page');
		#$post = $response->original['post'];
		$this->assertResponseOk();
		#$this->assertViewHas('post');
		#$this->assertEquals(13, $post->id);
		#$this->assertEquals('e80e907e-50d4-8ed4-70f7-5d1815672966', $post->uuid);


		// ##### Login as mreschke #####
		// mReschke is super, so can read all
		Auth::login(User::find(2)); Auth::user()->login();

		// These should be allowed by mReschke
		$this->call('GET', '/mrcore/global');
		$this->assertResponseOk();
		$this->call('GET', '/13/mreschke-home-page');
		$this->assertResponseOk();
		$this->call('GET', '/14/squaethem-home-page');
		*/

	}


}
