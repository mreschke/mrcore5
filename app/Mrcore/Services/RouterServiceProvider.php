<?php namespace Mrcore\Services;

use Illuminate\Support\ServiceProvider;
use Mrcore\Router\Router;
use Config;
use Mrcore;
use Post;
use User;

/**
 * Provides mrcore custom router services
 * This analyzes the url route very early in laravels bootstrap.
 * This allows me to inject custom workbench services early.
 */
class RouterServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		\Lifecycle::add(__FILE__.' - '.__FUNCTION__);
	}	


	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		\Lifecycle::add(__FILE__.' - '.__FUNCTION__);

		try {
			// Analyze url and find route
			$router = new Router();
			if ($router->foundRoute()) {

				// Get post defined by route
				$post = Post::get($router->currentRoute()->post_id);

				// ###################################################
				// This really needs refactored and moved around

				// Check deleted
				if ($post->deleted && !User::isAdmin()) {
					$router->responseCode = 401;
				}

				// Check post permissions including UUID
				if (!$post->uuidPermission()) {
					$router->responseCode = 401;
				}

				// Update clicks
				if ($router->responseCode == 200) {
					$post->incrementClicks();
				}

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
				\Layout::title($post->title);
				if ($post->mode_id <> \Config::get('mrcore.default_mode')) {
					\Layout::mode($post->mode->constant);	
				}

				// ####################################################

				// Store post and router in the IoC for future usage
				Mrcore::post()->setModel($post);
			} else {
				// If not foundRoute() then we are on a non-post page like /search or /login, fine!
			}

			// Set some Mrcore API data
			Mrcore::router()->setModel($router->currentRoute());
			Mrcore::router()->responseCode($router->responseCode);
			Mrcore::router()->responseRedirect($router->responseRedirect);
		} catch (\Illuminate\Database\QueryException $e) {
			//
		}
	}


	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
