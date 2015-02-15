<?php namespace Mrcore\Router;

interface RouterInterface
{

	/**
	 * Was a valid route found from current url upon instantiation
	 * @return bool
	 */
	public function foundRoute();

	/**
	 * Get the current urls route
	 * @return eloquent router object
	 */
	public function currentRoute();

	/**
	 * Get the route by post id
	 * @param  int $id
	 * @return eloquent router object
	 */
	public function byPost($id);
}