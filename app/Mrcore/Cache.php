<?php namespace Mrcore;

class Cache {


	/**
	 * Mrcore Laravel cache remember function
	 * Use this instead of laravel default Cache::remember
	 * because this one obeys my use_cache config variable and expires time
	 */
	public static function remember($key, \Closure $callback)
	{
		if (\Config::get('mrcore.use_cache')) {
			return \Cache::remember($key, \Config::get('mrcore.cache_expires'), $callback);
		} else {
			return $callback();
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