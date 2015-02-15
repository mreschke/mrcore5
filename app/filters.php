<?php
/**
 * Mrcore Filters
 *
 * @author     Matthew Reschke <mail@mreschke.com>
 * @copyright  2013 Matthew Reschke
 * @link       http://mreschke.com
 * @license    http://mreschke.com/topic/317/MITLicense
 * @version    5.0
 * @package    Mrcore
 * @since      2013-10-06 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

\Lifecycle::add(__FILE__);

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	#echo Route::currentRouteName();
	\Lifecycle::add(__FILE__.' - before');

	#$global = Mrcore::post()->getGlobal();
	#Mrcore::post()->setModel($global);
	#$global->parse();
	


	// NEW SOLID
	// redirect based on analysis of RouterServiceProvider
	#return Redirect::to('http://google.com');
	/*$router = Mrcore::router();
	if (isset($router)) {
		if ($router->responseCode == 404) {
			return Response::notFound();
		} elseif ($router->responseCode == 401) {
			return Response::denied();
		} elseif ($router->responseCode == 301) {
			// Redirect to proper url
			if (is_array($router->responseRedirect)) {
				$url = route(
					$router->responseRedirect['route'],
					$router->responseRedirect['params']
				);
				$url .= $router->responseRedirect['query'];
			} else {
				$url = $router->responseRedirect;
			}
			return Redirect::to($url);
		}
	}*/


	

	# THIS MOVED to MrcoreServierProvider.
	/*$loginAsAnonymous = true;
	#if (Request::is('webdav*')) {
	if (strtolower(Request::server('HTTP_HOST')) == strtolower(Config::get('mrcore.webdav_base_url'))) {	
		$loginAsAnonymous = false;
	} elseif (Request::is('file*') && Request::server('PHP_AUTH_USER')) {
		$loginAsAnonymous = false;
	}
	if ($loginAsAnonymous) {
		//If first time to site, login as anonymous user (public)
		if (!Auth::check()) {
			$user = User::find(Config::get('mrcore.anonymous'));
			Auth::login($user);
			Auth::user()->login();
		}
	}
	*/

	#$router = new \Mrcore\Mrcore\Router();
	#$router->analyze();

	#$router = app('mrcore.router');
	#echo $router->response;



	
	#exit();




	/*
		analyze url, get actual route
		redirect if wrong route
		check perms here, show denied if denied
		save route and post into IoC for efficiency
		This will make PostController simpler which will let me
		duplicate it easily in a workbench
	*/
		/*
	$id = 1;
	$slug = 'home';
	$route = \Router::where('slug', '=', $slug)->where('disabled', '=', false);
	$post = \Post::find($id);
	$allow = true;
	if ($allow) {
		// Services - before router below
		require base_path().'/services/register.php';

		\App::instance('mrcore.post', $post);
		\App::instance('mrcore.route', $route);
		#register workbench that belogs to this post ID (efficient)
		\App::register('Mreschke\Bench\BenchServiceProvider');

	} #else redirect denied
*/
});


App::after(function($request, $response)
{
	\Lifecycle::add(__FILE__.' - before');
	
	# Dump lifecycle
	#echo Lifecycle::dump();

});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});

Route::filter('auth.digest', function()
{
	#Httpauth::secure();
	#Header("WWW-Authenticate: Basic realm=".Config::get('mrcore.host'));
	#$config = array('username' => 'mreschke', 'password' => 'techie');
	#Httpauth::make($config)->secure();
	if (!Auth::check()) {
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
		    header('WWW-Authenticate: Basic realm="My Realm"');
		    header('HTTP/1.0 401 Unauthorized');
		    exit();
		} else {
		    #echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
		    #echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
		    $email = Request::server('PHP_AUTH_USER');
		    $password = Request::server('PHP_AUTH_PW');

		    file_put_contents("/tmp/xx", $email);

	        $userField = 'email';
	        if (!preg_match("/@/", $email)) $userField = 'alias';

			if (Auth::attempt(array($userField => $email, 'password' => $password, 'disabled' => false)))
			{
			    //Authentication Successful
			    Auth::user()->login();

			} else {
				header('HTTP/1.0 401 Unauthorized');
				exit();
			}
		}
	}
});


Route::filter('auth.basic', function()
{
	# I use digest for all now, webdav and /file
	/*
	$isWebdav = preg_match("|".Config::get('mrcore.webdav_base_url')."|i", Request::url());
	$useAuth = false;
	#if (Request::is('webdav*')) {
	#if (strtolower(Request::server('HTTP_HOST')) == strtolower(Config::get('mrcore.webdav_base_url'))) {	
	if ($isWebdav) {
		$useAuth = true;
	} elseif (Request::is('file*') && Request::server('PHP_AUTH_USER')) {
		$useAuth = true;
	}
	if ($useAuth) {
		// Cadavar requires this basic realm setup but browsers don't, in fact it errors in a browser
		// just keeps asking for password over and over if I enable this for anything but cadaver
		// Found that windows netdrive also required this www-authenticate to be set
		// So far everything needs this WWW-Authenticate

		#$browser = \Mrcore\Helpers\Guest::getBrowser();
		#$isCadaver = preg_match("/cadaver/i", $browser);
		#if ($isCadaver) {
			#Header("WWW-Authenticate: Basic realm=".Config::get('mrcore.host'));
		#}
		#

		if (preg_match("/@/", Request::server('PHP_AUTH_USER'))) {
			return Auth::basic('email');
		} else {
			return Auth::basic('alias');
		}
	}
	*/
});


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});


/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


/*
SSL
*/
Route::filter('ssl', function() {
	return Redirect::secure(
		Request::getRequestUrl()
	);
});