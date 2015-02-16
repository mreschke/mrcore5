<?php namespace Mrcore\Providers;

use App;
use Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{

		// ??????????????????????? App::error not exist, this was in global/start
		// Mrcore FormValidationException
		#\App::error(function(Mrcore\Exceptions\FormValidationException $exception, $code)
		#{
		#	return Redirect::back()->withInput()->withErrors($exceptions->getErrors());
		#});

	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Illuminate\Contracts\Auth\Registrar', 'Mrcore\Services\Registrar');

		// Mrcore Bindings
		$this->app->bind('mrcore', 'Mrcore\Mrcore\Mrcore');
		$this->app->bind('Mrcore\Mrcore\MrcoreInterface', 'Mrcore\Mrcore\Mrcore');
		$this->app->bind('Mrcore\Mrcore\ConfigInterface', 'Mrcore\Mrcore\Config');
		$this->app->bind('Mrcore\Mrcore\LayoutInterface', 'Mrcore\Mrcore\Layout');
		$this->app->bind('Mrcore\Mrcore\PostInterface', 'Mrcore\Mrcore\Post');
		$this->app->bind('Mrcore\Mrcore\RouterInterface', 'Mrcore\Mrcore\Router');
		$this->app->bind('Mrcore\Mrcore\UserInterface', 'Mrcore\Mrcore\User');		

		// DEBUG ONLY, set PHP error reporting level
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		#error_reporting(E_ERROR | E_WARNING | E_PARSE | E_DEPRECATED);

	}

}
