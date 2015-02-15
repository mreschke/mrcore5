<?php namespace Mrcore;

class Crypt {

	/**
	 * Encrypt content if use_encryption enabled in config
	 *
	 * @param string unencrypted $content
	 * @return string encrypted $content
	 */
	public static function encrypt($content)
	{
		if (\Config::get('mrcore.use_encryption')) {
			return \Crypt::encrypt($content);
		} else {
			return $content;
		}
	}


	/**
	 * Decrypt content if use_encryption enabled in config
	 *
	 * @param string encrypted $content
	 * @return string decrypted $content
	 */
	public static function decrypt($content)
	{
		if (\Config::get('mrcore.use_encryption')) {
			return \Crypt::decrypt($content);
		} else {
			return $content;
		}
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