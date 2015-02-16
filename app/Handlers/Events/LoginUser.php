<?php namespace Mrcore\Handlers\Events;

#use Mrcore\Events\auth.login;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class LoginUser {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param    $event
	 * @return void
	 */
	public function handle($event)
	{
		// just a test, remember laravel Auth already has a 
		// auth.login event, so this was a test to listen to that
		// I actually have more user events than just login, so I made
		// a full UserEventsHandler 
		dd($event);
	}

}
