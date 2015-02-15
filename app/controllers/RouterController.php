<?php

class RouterController extends BaseController {

	/**
	 * Display a single post, defaults to home page if no $id
	 *
	 * @return Response
	 */
	public function showRouter()
	{
		if (!User::isAdmin()) return Response::denied();

		$router = Router::getRoutes();

		Layout::container(false);

		return View::make('router.show', array(
			'router' => $router,
		));

	}

}