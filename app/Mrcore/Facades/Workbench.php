<?php namespace Mrcore\Facades;

/**
 * @see \Mrcore\Workbench
 */
class Workbench extends \Illuminate\Support\Facades\Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'workbench'; }

}