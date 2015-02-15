<?php

class DatabaseSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Allow mass assignment
		Eloquent::unguard();

		// Order is Critical
		$this->call('UserSeeder');
		$this->call('PostItemsSeeder');
		$this->call('PostSeeder');
		$this->call('RoleSeeder');
		$this->call('PermissionSeeder');
		$this->call('UserPermissionSeeder');
		$this->call('PostPermissionSeeder');
		$this->call('BadgeSeeder');
		$this->call('TagSeeder');
		$this->call('RouterSeeder');
		
	}

}




