<?php namespace Mrcore\Services;

use Illuminate\Support\ServiceProvider;
use View;
use Layout;


class LayoutServiceProvider extends ServiceProvider {
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
		\Lifecycle::add(__FILE__.' - '.__FUNCTION__, 2);
		
		// Bind api to the container
		$this->app->bindShared('layout', function() {
			return new \Mrcore\Layout\Layout();
		});

		// Tell the IoC How to bind the interfaces for dependency injection
		$this->app->bind('Mrcore\Layout\LayoutInterface', 'Mrcore\Layout\Layout');

	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		\Lifecycle::add(__FILE__.' - '.__FUNCTION__);

	}

}
