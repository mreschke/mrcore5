<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// Order is Critical
		$this->call('UserSeeder');
		require __DIR__.'/WikiDatabaseSeeder.php';
	
	}

}
