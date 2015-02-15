<?php namespace Mrcore\WorkbenchFramework;

use Mrcore;
use View;


class WorkbenchFrameworkController extends \BaseController {

	public function index()
	{
		\Lifecycle::add(__FILE__.' - '.__FUNCTION__);
		
		$post = Mrcore::post()->prepare();
		return View::make('workbench-framework::index', compact(
			'post'
		));
	}

}
