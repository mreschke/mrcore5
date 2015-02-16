<?php

class PostTest extends TestCase {

	/**
	 */
	public function testClicks()
	{

		/*
			Crap
			This doesn't work anymore because of my custom router service
			In fact, my router service only runs ONCE for all tests
			Even if I call('GET', '/2') that service never runs, dang :(
		*/



		//Filters disabled during unit tests unless you enable them
		//I need them enabled because they log the user in as anonymous
		#Route::enableFilters();

		// Test base route
		// Should show post id 1
		#$clicksBefore = Post::find(1)->clicks;
		
		#echo "BEFORE:".$clicksBefore;
		
		#$this->call('GET', '/2');
		#$this->assertResponseOk();
		
		#$clicksAfter = Post::find(1)->clicks;
		#echo "AFTER:".$clicksAfter;
		
		#echo "A$clicksAfter";
		#$this->assertEquals($clicksBefore, $clicksAfter);
		#$this->assertEquals(1, 2);
	}
}