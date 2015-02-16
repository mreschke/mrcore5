<?php namespace Mrcore\Providers;

use Request;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'Mrcore\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		// Boot Illuminate\Foundation\Support\Providers\RouteServiceProvider
		parent::boot($router);
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function($router)
		{
			require app_path('Http/routes.php');
		});

		// Get list of applications from repository
		$applications = [
			['namespace' => 'Dynatron\Dealer', 'prefix' => 'dealer'],
		];

		// Load application only if the route prefix is matched!
		foreach ($applications as $application) {
			$routeMatched = false;
			if (preg_match("|^$application[prefix]|", Request::path())) $routeMatched = true;
			
			if ($routeMatched) {
				// realpath() returns false if path not found - very helpful
				$application['path'] = realpath(str_replace('\\', '/', __DIR__."/../../../Applications/$application[namespace]"));
				list($application['vendor'], $application['package']) = explode('\\', $application['namespace']);
				if ($application['path']) {

					// Define a route group with this apps prefix and namespace
					$router->group(['namespace' => $application['namespace'], 'prefix' => $application['prefix']], function($router) use($application) {

						// Register the applications autoloader (optional)
						$autoload = realpath("$application[path]/vendor/autoload.php");
						if ($autoload) require $autoload;

						// Register the applications configs
						#$configs = realpath("$application[path]/Configs");
						#if ($configs) {
							//this is not in laravel 5 anymore
							#$this->app['config']->package(snake_case($application['package']), $configs, $application['namespace']);
						#}

						// Register the applications service provider (optional)
						$provider = realpath("$application[path]/Providers/AppServiceProvider.php");
						if ($provider) $this->app->register("$application[namespace]\Providers\AppServiceProvider");

						// Register the applications views
						$views = realpath("$application[path]/Views");
						if ($views) $this->loadViewsFrom("$application[path]/Views", snake_case($application['package']));

						// Register the applications routes (optional)
						$routes = realpath("$application[path]/Http/routes.php");
						if ($routes) require $routes;

					});
				}
				break;
			}
		
		}

	}

}
