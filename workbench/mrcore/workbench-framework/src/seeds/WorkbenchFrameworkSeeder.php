<?php

class WorkbenchFrameworkSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Allow mass assignment
		#Eloquent::unguard();

		// Order is Critical
		#$this->call('WorkbenchFrameworkUserSeeder');
		
	}

}





