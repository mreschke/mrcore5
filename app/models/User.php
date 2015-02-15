<?php

use Illuminate\Auth\UserInterface;
#use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface { #, RemindableInterface {

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

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the remember me token for the user.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
	    return $this->remember_token;
	}

	/**
	 * Set the remember me token for the user.
	 *
	 */
	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}

	/**
	 * Get the remember me token name
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
	    return 'remember_token';
	}

	/**
	 * Find a model by its primary key.  Mrcore cacheable eloquent override.
	 *
	 * @param  mixed  $id
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Model|static|null
	 */
	public static function find($id, $columns = array('*'))
	{
		return Mrcore\Cache::remember(strtolower(get_class())."_$id", function() use($id, $columns) {
			return parent::find($id, $columns);
		});		
	}

	/**
	 * Login was a success, perform remaining login process
	 */
	public function login()
	{
	    // Save users permissions into session
	    $perms = $this->getPermissions();

	    Session::put('user.admin', false);
	    Session::put('user.perms', array());

	    if (in_array('admin', $perms)) {
	    	//Super admin, don't save anything into user.perms, no need
	    	Session::put('user.admin', true);
	    } else {
	    	Session::put('user.perms', $perms);
	    }

	    // Update last login date
	    $this->login_at = \Carbon\Carbon::now();
	    $this->save();
	}

	/**
	 * Check if user is super admin
	 *
	 * @return boolean
	 */
	public static function isAdmin()
	{
		return Session::get('user.admin');
	}

	/**
	 * This is my auth check function, do not use Auth::check()
	 * because I always login as anonymous
	 *
	 * @return boolean
	 */
	public static function isAuthenticated()
	{
		return Auth::user()->id != Config::get('mrcore.anonymous');
	}

	/**
	 * Get all roles linked to this user
	 *
	 * @return array of Role
	 */
	public function getRoles() {
		#obsolete, I don't wnat user roles, I want the permission those roles are linked to
		# so I just need a getPermissions once, store those constants in a small session array
		#$roles = $this->roles;

		#d($roles);

		#foreach ($roles as $role) {
		#	echo $role->name;
		#}
	}

	/**
	 * Get permissions for this user (not post permissions)
	 * 
	 * @return simple array of permission constants
	 */
	public function getPermissions()
	{
		/*
		SELECT
			DISTINCT p.constant
		FROM
			user_permissions up
			INNER JOIN permissions p on up.permission_id = p.id
		WHERE
			up.user_id = 2
		*/
		$userPermissions = DB::table('user_permissions')
			->join('permissions', 'user_permissions.permission_id', '=', 'permissions.id')
			->where('user_permissions.user_id', '=', $this->id)
			->select('permissions.constant')
			->distinct()
			->get();

		// Convert results to single dimensional array of permission constants
		$perms = array();
		foreach ($userPermissions as $permission) {
			$perms[] = $permission->constant;
		}
		return $perms;
	}

	/**
	 * Check if user has this permission item (by permission constant)
	 * Uses the Session::get('user.perms') array set at login
	 *
	 * @return boolean
	 */
	public static function hasPermission($constant)
	{
		if (User::isAdmin()) {
			return true;
		} else {
			if (Session::has('user.perms')) {
				if (in_array(strtolower($constant), Session::get('user.perms'))) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Check if user has this role constant
	 *
	 * @return boolean
	 */
	public function hasRole($constant) {
		#obsolete?? don't care, I care about permissions
		#required the function roles() to be enabled above, a many-to-many relationship
		#or query it yourself (probably better since I won't really use this function much?)
		
		#make a hasPermission which simply checks the existing session(user.perms) array
		#foreach ($this->roles as $role) {
		#	if (strtolower($constant) == strtolower($role->constant)) {
		#		return true;
		#	}
		#}
		#return false;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	#public function getReminderEmail()
	#{
	#	return $this->email;
	#}

}