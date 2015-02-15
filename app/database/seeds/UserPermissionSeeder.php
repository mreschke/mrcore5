<?php

class UserPermissionSeeder extends Seeder
{
	public function run()
	{

		// User Permissions
		UserPermission::create(array('user_id' => 1, 'permission_id' => 3)); # Public Comment

		UserPermission::create(array('user_id' => 2, 'permission_id' => 4)); # Admin Admin

	}

}