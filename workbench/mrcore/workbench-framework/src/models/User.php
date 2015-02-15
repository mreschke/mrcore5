<?php namespace Mrcore\WorkbenchFramework;

class User extends \Eloquent {

	/**
	 * The database connection used by the model.
	 *
	 * @var string
	 */
	protected $connection = 'myworkbenchdb';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

}
