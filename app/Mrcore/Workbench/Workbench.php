<?php namespace Mrcore\Workbench;

use Mrcore;

/**
 * GUI Workbench helper class
 * Service is only registered if post is attached to a GUI workbench
 * Usable from the workbench facade
 */
class Workbench {

	private $vendor;
	private $package;
	private $name;
	private $folder;

	public function package($value = null) {
		return $this->getSet(__function__, $value);
	}	

	public function vendor($value = null) {
		return $this->getSet(__function__, $value);
	}

	public function name($value = null) {
		return $this->getSet(__function__, $value);
	}

	public function folder($value = null) {
		return $this->getSet(__function__, $value);
	}


	/**
	 * Get the workbench base path
	 */
	public function path()
	{
		return base_path().'/workbench/'.strtolower($this->folder);

	}


	/**
	 * Get a workbench asset url using the posts file app folder
	 */
	public function asset($file)
	{
		$post = Mrcore::post()->getModel();
		if (isset($post)) {
			if (str_contains(\Config::get('app.url'), 'https://')) {
				return 'https://'.\Config::get('mrcore.file_base_url').'/'.$post->id.'/app/public/'.$file;
			} else {
				return 'http://'.\Config::get('mrcore.file_base_url').'/'.$post->id.'/app/public/'.$file;
			}
		} else {
			return $file;
		}
	}


	/**
	 * Generic getter setter helper function
	 */
	private function getSet($key, $value = null)
	{
		if (isset($value)) {
			$this->$key = $value;
		} else {
			return $this->$key;
		}
	}


	/**
	 * Test proper class instantiation
	 *
	 * @return Hello World success text string
	 */
	public static function test()
	{
		return "Hello World from ".get_class();
	}

}