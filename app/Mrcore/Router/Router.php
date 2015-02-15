<?php namespace Mrcore\Router;

use Mrcore\Router\RouterInterface;
use Request;
use Config;

class Router implements RouterInterface
{
	private $route;
	public $responseCode;
	public $responseRedirect;

	public function __construct()
	{
		$this->responseCode = 200;
		$this->analyzeUrl();
	}


	/**
	 * Was a valid route found from current url upon instantiation
	 * @return bool
	 */
	public function foundRoute()
	{
		return ($this->responseCode == 200);
	}


	/**
	 * Get the current urls route
	 * @return eloquent router object
	 */
	public function currentRoute()
	{
		return $this->route;
	}


	/**
	 * Get the route by post id
	 * @param  int $id
	 * @return eloquent router object
	 */
	public function byPost($id)
	{
		return \Router::byPost($id);
	}


	/**
	 * Get route by examining the current url
	 *
	 * @param array $reserved
	 * @return void
	 */
	private function analyzeUrl()
	{
		$reserved = Config::get('mrcore.reserved_routes');
		$legacy = Config::get('mrcore.legacy_routes');
		$path = Request::path();
		$segments = Request::segments();
		$query = Request::server('QUERY_STRING');
		if ($query) $query = '?' .$query;

		// Check if webdav subdomain
		$isWebdav = preg_match("|".Config::get('mrcore.webdav_base_url')."|i", Request::url());
		if ($isWebdav) {
			$this->responseCode = 202;
			return;
		}

		// Url is /
		if (count($segments) == 0) {
			$this->route = \Router::byPost(Config::get('mrcore.home'));
			if (isset($this->route)) {
				$this->route->incrementClicks($this->route);
			} else {
				$this->responseCode = 404;
			}
			return;
		}

		$firstSegment = strtolower($segments[0]);
		$secondSegment = count($segments) >= 2 ? $segments[1] : '';

		// Check if reserved path
		if (in_array($firstSegment, $reserved)) {
			$this->responseCode = 202;
			return;
		}

		// Url is /42/anything
		if (is_numeric($firstSegment)) {
			$this->route = \Router::byPost($firstSegment);
			if (is_null($this->route)) {
				$this->responseCode = 404;
				return;
			}
		
		} elseif (in_array($firstSegment, $legacy)) {
			// Url is legacy /topic/42/anything
			$this->route = \Router::byPost($secondSegment);
			if (is_null($this->route)) {
				$this->responseCode = 404;
				return;
			}
		}

		if (isset($this->route)) {
			// Route found from /42 or legacy, check if static enabled
			// and redirect if needed
			if ($this->route->static) {
				//Static route is enabled, redirect to /actual-slug
				$this->responseRedirect = array(
					'route' => 'url',
					'params' => array('slug' => $this->route->slug),
					'query' => $query
				);
				$this->responseCode = 301;
				return;
			} else {
				//Static route disabled, use /42/actual-slug
				if ($path != $this->route->post_id . '/' . $this->route->slug) {
					//URL slug is not accurate, redirect to proper /42/actual-slug
					$this->responseRedirect = array(
						'route' => 'permalink',
						'params' => array('id' => $this->route->post_id, 'slug' => $this->route->slug),
						'query' => $query
					);
					$this->responseCode = 301;
					return;
				} else {
					// URL is accurate, good to go as is
					$this->route->incrementClicks($this->route);
					return;
				}
			}

		} else {
			// Look up slug in router table
			$slug = $path;
			for ($i = count($segments)-1; $i >= 0; $i--) {
				$this->route = \Router::bySlug($slug);
				if (isset($this->route)) {
					// Route found
					break;
				} else {
					// Route not found, step backwards in url segment
					array_pop($segments);
					$slug = implode('/', $segments);
				}
			}
			$segments = Request::segments();

			if (isset($this->route)) {
				// Route found
				if ($this->route->url) {
					// Redirect to external URL
					$this->route->incrementClicks($this->route);
					$this->responseRedirect = $this->route->url.$query;
					$this->responseCode = 301;
					return;
				} elseif ($this->route->redirect) {
					// This is a static route with redirect true, redirect to default route
					$route = \Router::byPost($this->route->post_id);
					if (isset($route)) {
						if ($route->static) {
							$this->responseRedirect = array(
								'route' => 'url',
								'params' => array('slug' => $route->slug),
								'query' => $query
							);
						} else {
							$this->responseRedirect = array(
								'route' => 'permalink',
								'params' => array('id' => $route->post_id, 'slug' => $route->slug),
								'query' => $query
							);
						}
						$this->responseCode = 301;
						return;
					} else {
						$this->responseCode = 404;
						return;
					}
				} else {
					// This is a named default round like /about
					// default responseCode is 200 so just increment and return
					$this->route->incrementClicks($this->route);
					return;
				}
			} else {
				// Route not found in router
				$this->responseCode = 404;
				return;
			}
		}

	}

}

/*
analyze url

get tbl router entry for that route
get response code, may 404, 401, 202...canot redirect until later in bootstrap
gets the actual $post
	checks post permissions including uuid, 401 if fail
	updates post clicks and route clicks
	set \Layout stuff including mode from $_GET['viewmode']




*/