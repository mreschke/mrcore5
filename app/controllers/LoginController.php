<?php

class LoginController extends BaseController {

	/**
	 * Displays the login page
	 *
	 * @return Response
	 */
	public function login()
	{
		if (Session::has('referer')) {
			$referer = Session::get('referer');
		} else {
			$referer = Request::server('HTTP_REFERER');
		}

		// Get Site and User Globals
		#$post = Post::get(\Config::get('mrcore.global'));
		#Mrcore::post()->setModel($post);
		#$post->prepare();

		return View::make('login', array(
			'referer' => $referer
		));
	}

	/** 
	 * Validate login
	 */
	public function validateLogin()
	{
		$app = app();
		$username = Input::get('username');
		$password = Input::get('password');
		if (Input::has('referer')) {
			$referer = Input::get('referer');
		} else {
			$referer = route('home');
		}

		if (isset($app['login'])) {
			// Login override service provider exists, use it!
			$login = app::make('login');
			return $login->validate($username, $password, $referer);

		} else {
			// Default mrcore login
			$userField = 'email';
			if (strpos($username, '@') === false) {
				$userField = 'alias';
			}

			if (Auth::attempt(array($userField => $username, 'password' => $password, 'disabled' => false)))
			{
				//Authentication Successful
				Auth::user()->login();

				// Redirect to indended url or home page if not found
				return Redirect::to($referer);
			} else {
				// Invalid Login
				sleep(5);
				return Redirect::route('login')
					->with('message', 'Invalid username/password')
					->with('referer', $referer);
			}
		}
	}

	public function resetLogin()
	{
		echo Input::get('email');
		return " - Under Construction";
	}


	/**
	 * Logout
	 */
	public function logout()
	{
		Auth::logout();
		Session::flush();
		return Redirect::route('home');
	}
}
