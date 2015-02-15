<?php namespace Mrcore\Parser;

Class Html
{
	
	/**
     * Parse this html $data into XHTML
     *
     * @return string of HTML from unparsed data
     */
    public function parse($data)
	{
		return $data;
	}


	/**
	 * Test proper class instantiation
	 *
	 * @return Hello World success text string
	 */
	public static function test()
	{
		return "Hello World from ".get_class();
	}
}
