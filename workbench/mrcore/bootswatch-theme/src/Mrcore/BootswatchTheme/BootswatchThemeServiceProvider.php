<?php namespace Mrcore\BootswatchTheme;

use Illuminate\Support\ServiceProvider;
use Layout;

class BootswatchThemeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		\Lifecycle::add(__FILE__.' - '.__FUNCTION__);

		$this->package('mrcore/bootswatch-theme');

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		\Lifecycle::add(__FILE__.' - '.__FUNCTION__);

		// Register new view location
		\View::addLocation(base_path()."/workbench/mrcore/bootswatch-theme/src/views/");

		// Register custom css
		# default amelia darkly lumen spacelab cerulean readable superhero
		# cosmo flatly simplex united cyborg journal slate yeti
		Layout::css('css/bootstrap/bootstrap.min.css');
		Layout::css('css/dataTables.bootstrap.css');
		Layout::css('theme/css/yamm.css');
		Layout::css('theme/css/wiki.css'); #should be last

		// Bootstrap Container
		Layout::container(true);


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
