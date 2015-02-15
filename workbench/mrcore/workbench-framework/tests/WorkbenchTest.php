<?php

include_once __DIR__ . '/TestCase.php';

/**
 * This is a basic phpunit test file
 * Each test file must end in Test.php
 * Each function must either begin with the word test (testMe or test_me) or have the @test annotaion
 * or phpunit will not call the function at all.  There is a workbench helper script
 * in workbench/yourbench/test, just run ./test to execute the tests for this workbench.
 * Remember to make the functions descriptive like below, they can be as long as you want.
 * See laravel http://laravel.com/docs/4.2/testing for more
 */
class WorkbenchTest extends TestCase {
	public function createApplication() { return createApplication(); }

	/**
	 * Run some test
	 */
	public function testOneThing()
	{
		$this->assertEquals(1, 1);
	}

	/**
	 * Run another test
	 * @return @test
	 */
	public function it_produces_pdf_from_html()
	{
		$this->assertEquals(1, 2);
	}

	/** @test */
	public function it_redirects_to_google()
	{
		$this->assertEquals(1, 2);
	}	

}
