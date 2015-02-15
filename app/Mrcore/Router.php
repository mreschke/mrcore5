<?php namespace Mrcore;

class RouterOBSOLETE {
	public $post;
	public $route;
	public $response;
	public $redirect;

	public function __construct()
	{
		\Lifecycle::add(__FILE__, 1);
		$this->post = null;
		$this->route = null;
		$this->response = 200;
		$this->redirect = array();
	}

	public function analyze()
	{
		$foundReserved = false;
		$reserved = array('admin', 'router', 'file', 'files', 'search', 'login', 'logout');
		$legacyPost = array('post', 'topic');
		$queryString = '';
		if (\Request::server('QUERY_STRING')) $queryString = "?".\Request::server('QUERY_STRING');			

		$segments = \Request::segments();
		if (count($segments) == 0) {
			// URL is /
			$this->route = \Router::
				  where('post_id', \Config::get('mrcore.home'))
				->where('default', true)
				->where('disabled', false)
				->first();
		} else {
			$action = strtolower($segments[0]);
			$action2 = "";
			if (count($segments) >= 2) $action2 = $segments[1];
			$slug = implode('/', $segments);

			// Check if a reserved url
			if (in_array($action, $reserved)) {
				$this->response = 202; return;
			}

			if (is_numeric($action)) {
				// URL is /42/whatever
				$this->route = \Router::
					  where('post_id', $action)
					->where('default', true)
					->where('disabled', false)
					->first();
			} elseif (in_array($action, $legacyPost)) {
				// URL is /post/42/whatever or /topic/42/whatever, redirect
				$this->route = \Router::
					  where('post_id', $action2)
					->where('default', true)
					->where('disabled', false)
					->first();
			}

			if (isset($this->route)) {
				if ($this->route->static) {
					//Static route is enabled, redirect to /actual-slug
					#$url = route('url', array('slug' => $route->slug)).$queryString;
					#return \Redirect::to($url);
					$this->redirect = array(
						'route' => 'url',
						'params' => array('slug' => $this->route->slug),
						'query' => $queryString
					);
					$this->response = 301; return;
				} else {
					//Named route disabled, use /42/actual-slug
					if ($slug != $this->route->post_id.'/'.$this->route->slug) {
						//URL slug is not accurate, redirect to proper /42/actual-slug
						#$url = route('permalink', array('id' => $route->post_id, 'slug' => $route->slug)).$queryString;
						#return \Redirect::to($url);
						$this->redirect = array(
							'route' => 'permalink',
							'params' => array('id' => $this->route->post_id, 'slug' => $this->route->slug),
							'query' => $queryString
						);
						$this->response = 301; return;
					}
				}
			} else {
				// Lookup slug in router table
				for ($i = count($segments)-1; $i >= 0; $i--) {
					$this->route = \Router::
						  where('slug', $slug)
						  ->where('disabled', false)
						  ->where('static', true)
						->first();
					if (isset($this->route)) {
						// Route found
						break;
					} else {
						// Route not found, step backwards in url segment
						array_pop($segments);
						$slug = implode('/', $segments);
					}
				}
				$segments = \Request::segments();
				if (isset($this->route)) {
					// Route found
					if ($this->route->url) {
						// Redirect to external URL
						$this->route->clicks += 1;
						$this->route->save();
						$this->redirect = $this->route->url.$queryString;
						$this->response = 301; return;
					} elseif ($this->route->redirect) {
						// This is a static route with redirect true, redirect to default route
						$route = \Router::
							  where('post_id', $this->route->post_id)
							->where('default', true)
							->where('disabled', false)
							->first();
						if (isset($route)) {
							if ($route->static) {
								$this->redirect = array(
									'route' => 'url',
									'params' => array('slug' => $route->slug),
									'query' => $queryString
								);
							} else {
								$this->redirect = array(
									'route' => 'permalink',
									'params' => array('id' => $route->post_id, 'slug' => $route->slug),
									'query' => $queryString
								);
								
							}
							$this->route->clicks += 1;
							$this->route->save();
							$this->response = 301; return;
						} else {
							$this->response = 404; return;
						}
					}
				} else {
					$this->response = 404; return;
				}
			}
		}


		if ($this->response == 200) {
			// Get Post
			$id = $this->route->post_id;
			$this->post = \Post::get($id);

			if (!isset($this->post)) {
				$this->response = 404; return;
			}

			// Check if Deleted
			if ($this->post->deleted && !\User::isAdmin()) {
				// Deny deleted posts unless admin
				$this->response = 401; return;	
			}

			// UUID Permissions
			if (!$this->post->uuidPermission()) {
				$this->response = 401; return;
			}

			// Update route Clicks
			$this->route->clicks += 1;
			$this->route->save();
			
			// Override posts view mode with URL ?default, ?simple or ?raw
			$defaultMode = \Input::get('default');
			if (isset($defaultMode) || \Input::get('viewmode') == 'default') {
				\Layout::mode('default');
			}
			$simpleMode = \Input::get('simple');
			if (isset($simpleMode) || \Input::get('viewmode') == 'simple') {
				\Layout::mode('simple');
			}
			$rawMode = \Input::get('raw');
			if (isset($rawMode) || \Input::get('viewmode') == 'raw') {
				\Layout::mode('raw');
			}


			// Adjust $view for this $this->post
			\Layout::title($this->post->title);
			if ($this->post->mode_id <> \Config::get('mrcore.default_mode')) {
				\Layout::mode($this->post->mode->constant);	
			}

			// Set API items
			#No need anymore, I won't use API
			#\Mrcore::post()->id($id);
			#\Mrcore::post()->title($this->post->title);

			// Increment Clicks (reads)
			// We cannot do $this->post->clicks += 1; $this->posts->save() because we use caching
			// the returned cached $this->posts is not linked, save() does nothing
			\DB::table('posts')->where('id', $id)->increment('clicks');

			// This is as far as I cna go here, I don't want to actually 
			// parse content here because the parsed content could use
			// routes that are not available yet.  Must parse at the
			// controller level.
			
		}

	}

	public function test()
	{
		return "Hello World from ".get_class();
	}

}