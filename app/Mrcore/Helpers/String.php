<?php namespace Mrcore\Helpers;

class String
{

	/**
	 * Generate a new v4 36 (or 38 with brackets) char GUID
	 * Ex: 9778d799-b37b-7bfc-2685-47b3d28aa7af
	 *
	 * @param bool $includeBrackets 
	 * @return string v4 character guid
	 */
	public static function getGuid($includeBrackets = false)
	{
		if (function_exists('com_create_guid')) {
			//If on a windows platform use Windows COM
			if ($includeBrackets) {
				return com_create_guid();
			} else {
				return trim(com_create_guid(), '{}');
			}
		} else {
			//If on a *nix platform, build v4 GUID using PHP
			mt_srand((double)microtime()*10000);
			$charid = md5(uniqid(rand(), true));
			$hyphen = chr(45);
			$uuid =  substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12);
			if ($includeBrackets) {
				$uuid = chr(123) . $uuid . chr(125);
			}
			return $uuid;
		}
	}


	/**
	 * Generate a 32 character md5 hash from a string
	 * If string = null generates from a random string
	 *
	 * @return 32 character md5 hash string
	 */
	public function getMd5($string=null)
	{
		if (!$string) {
			return md5(uniqid(rand(), true));	
		} else {
			return md5($string);
		}
		
	}


	/**
	 * Convert a 32 character uuid (md5 hash) to a 36 character guid
	 * Just adds the proper dashes, does not add brackets
	 *
	 * @param string $uuid
	 * @return string GUID
	 */
	public static function uuidToGuid($uuid)
	{
		if (strlen($uuid) == 32) {
			return
				substr($uuid, 0, 8) . '-' .
				substr($uuid, 8, 4) . '-' .
				substr($uuid, 12, 4) . '-' .
				substr($uuid, 16, 4) . '-' .
				substr($uuid, 20);
		}
	}


	/**
	 * Slugify a string
	 */
	public static function slugify($string)
	{
		$string = trim(strtolower($string));
		$string = preg_replace('/ |_|\/|\\/i', '-', $string); # space_/\ to -
		$string = preg_replace('/[^\w-]+/i', '', $string); # non alpha-numeric
		$string = preg_replace('/-+/i', '-', $string);     # multiple -
		$string = preg_replace('/-$/i', '-', $string);     # trailing -
		$string = preg_replace('/^-/i', '-', $string);     # leading -
		return $string;
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
