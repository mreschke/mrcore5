<?php namespace Mrcore\Services;

use Illuminate\Support\ServiceProvider;
use Mrcore;
use App;
use View;
use Layout;

/**
 * Fires up a the post workbench if one is defined for this route
 */
class WorkbenchServiceProvider extends ServiceProvider
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

		// Bind workbench to the Container
		$this->app->bindShared('workbench', function() {
			return new \Mrcore\Workbench\Workbench();
		});

	}	


	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		\Lifecycle::add(__FILE__.' - '.__FUNCTION__);

		// If a workbench is defined and readable for this post then fire it up!
		if (Mrcore::router()->responseCode == 200) {
			$post = Mrcore::post()->getModel();
			if (isset($post)) {
				if ($post->workbench) {
					$id = $post->post_id;
					$workbench = strtolower($post->workbench);
					$segments = explode("/", $workbench);
					if (count($segments) == 2) {
						$namespace = ''; $vendor = ''; $package = '';
						$vendor = studly_case($segments[0]);
						$package = studly_case($segments[1]);
						$namespace = "$vendor\\$package";

						$workbenchBase = base_path()."/workbench/$workbench";
						$workbenchService = "$namespace\\${package}ServiceProvider";

						if (file_exists("$workbenchBase/composer.json")) {
							\Workbench::vendor($vendor);
							\Workbench::package($package);
							\Workbench::name($namespace);
							\Workbench::folder($workbench);

							// Register this workbench service
							if (file_exists("$workbenchBase/vendor/autoload.php")) {
								App::register("$workbenchService");

							} else {
								exit("
									<b>Workbench contains no autoload ($workbenchBase/vendor/autoload.php)</b>
									<br />Please dump-autoload for this workbench by running:<br />
									<pre>composer dump-autoload -d $workbenchBase</pre>
								");

							}

							// If this is a laravel specific workbench add view location
							if (file_exists("$workbenchBase/src/views/")) {
								// All workbenches have no container (apps are fullscreen)
								// You can override this per workbench in the workbench's service provider
								Layout::container(false);

								// Add package view namespace
								View::addNamespace("$package", "$workbenchBase/src/views/");
							}
						}
					}
				}
			}
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