<?php namespace Mrcore\Facades;

/**
 * @see \Mrcore\Mrcore
 */
class Mrcore extends \Illuminate\Support\Facades\Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'mrcore'; }

}