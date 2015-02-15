<?php

class AdminController extends BaseController {

	/**
	 * Displays the search page
	 *
	 * @return Response
	 */
	public function showBadges()
	{
		return View::make('admin.badges', array(
		));
	}


	/**
	 * Get the search dropdown menu
	 * Handles via ajax only
	 */
	public function searchMenu()
	{
		// Ajax only controller
		if (!Request::ajax()) return Response::notFound();

		$post = Post::find(Config::get('mrcore.searchmenu'));
		if (!isset($post)) return Response::notFound();

		// Parse Post Now!
		$post->parse();

		return $post->content;
	}

	public function userMenu()
	{
		return "dd";
	}

}

