<?php

class BaseController extends Controller {

	// I prefer not to add any logic in this base controller or else all derived
	// controllers will need to call __parent.
	public function __construct()
	{
		//
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
