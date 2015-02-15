<?php namespace Mrcore\Parser;

Class Php
{
	
	/**
     * Parse this php $data into XHTML
     *
     * @return string of HTML from unparsed data
     */
    public function parse($data)
	{

		$data = preg_replace('"^<\?php"i', '', $data);
		$data = preg_replace('"^<\?"i', '', $data);

        ob_start();
        eval($data);
        $data = ob_get_contents();
        ob_end_clean();

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
