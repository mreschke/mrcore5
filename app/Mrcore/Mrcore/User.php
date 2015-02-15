<?php namespace Mrcore\Mrcore;

/**
 * This is the user API layer used from the Mrcore class/facade
 * This layer allows us to change our model columns/properties while
 * maintaining a consistent interface for the wiki users
 */
class User implements UserInterface
{

	private $model;

	public function id()
	{
		return $this->model->id;
	}

	public function uuid()
	{
		return $this->model->uuid;
	}

	public function email()
	{
		return $this->model->email;
	}

	public function first()
	{
		return $this->model->first;
	}

	public function last()
	{
		return $this->model->last;
	}

	public function name()
	{
		$name = '';
		if ($this->model->first) {
			$name .= $this->model->first;
		}
		if ($this->model->last) {
			if ($name) $name .= " ";
			$name .= $this->model->last;
		}
		return $name;
	}

	public function alias()
	{
		return $this->model->alias;
	}

	public function globalPostID()
	{
		return $this->model->global_post_id;
	}

	public function homePostID()
	{
		return $this->model->home_post_id;
	}

	/**
	 * Return the actual post model object
	 * This is for internal use only.  Using this raw model
	 * negates the efforts of an API, please do not use it.
	 * @return post model object
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * Set the actual post model object
	 * For internal use only
	 * @param post model object $post
	 */
	public function setModel($post)
	{
		if (isset($post)) {
			$this->model = $post;
		}
	}

	/**
	 * This if user is super admin
	 * @return boolean
	 */
	public function isAdmin()
	{
		return $this->model->isAdmin();
	}

	/**
	 * Allows the use of ->id to call ->id()
	 * @param  string $name
	 * @return mixed
	 */
	public function __get($name) {
		return $this->$name();
	}

}