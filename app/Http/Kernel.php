<?php namespace Mrcore\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		#'Mrcore\Http\Middleware\VerifyCsrfToken',
		'Mrcore\Modules\Wiki\Http\Middleware\AnalyzeRoute',
		'Mrcore\Modules\Foundation\Http\Middleware\LoadModules',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'Mrcore\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		#'auth.digest' => 'Mrcore\Http\Middleware\AuthenticateWithDigestAuth',
		'guest' => 'Mrcore\Http\Middleware\RedirectIfAuthenticated',
	];

}
