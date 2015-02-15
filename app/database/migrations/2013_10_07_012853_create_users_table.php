<?php

use Illuminate\Database\Migrations\Migration;


/*
|--------------------------------------------------------------------------
| Laravel Help
|--------------------------------------------------------------------------
*/
/*

You should have each table defined in its own migration file
To start a new migration file simply run (substitute users for your table)
php artisan migrate:make create_users_table


To execute these migrations (update your database)
php artisan migrate

To Seed
php artisan db:seed

Drop all, create and seed
php artisan migrate:refresh --seed

To Drop all
-----------
DROP TABLE post_locks;
DROP TABLE post_permissions;
DROP TABLE post_badges;
DROP TABLE post_tags;
DROP TABLE post_indexes;
DROP TABLE post_reads;
DROP TABLE badges;
DROP TABLE tags;
DROP TABLE comments;
DROP TABLE user_roles;
DROP TABLE user_permissions;
DROP TABLE revisions;
DROP TABLE roles;
DROP TABLE hashtags;
DROP TABLE posts;
DROP TABLE modes;
DROP TABLE formats;
DROP TABLE types;
DROP TABLE permissions;
DROP TABLE users;
DROP TABLE router;
DROP TABLE migrations

*/

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create users table
		Schema::create('users', function ($table)
		{
			// MySQL InnoDB Engine
			$table->engine = 'InnoDB';

			// Users id, increments=auto_increment+primary key
			$table->increments('id');

			// Users uuid
			$table->string('uuid', 36)->unique();

			// Will always be a full email address, so 50 chars
			$table->string('email', 50)->unique();

			// Password is 60 because Hash::make('yourpass') is a 60 char hash
			$table->string('password', 60);

			// User first name
			$table->string('first', 25);

			// User first name
			$table->string('last', 25);

			// User alias name
			$table->string('alias', 50)->unique();

			// User alias name
			// Just filename (avatar42.png)
			$table->string('avatar', 20)->default('avatar1.png');

			// Last Login date
			$table->dateTime('login_at');

			// Users Global post id
			$table->integer('global_post_id')->unsigned()->nullable();
			#$table->foreign('global_post_id')->references('id')->on('posts');

			// Users Home post id
			$table->integer('home_post_id')->unsigned()->nullable();
			#$table->foreign('home_post_id')->references('id')->on('posts');

			// Default enabled
			$table->boolean('disabled')->default(false)->index();

			// Created By (user_id)
			$table->integer('created_by');

			// Updated By (user_id)
			$table->integer('updated_by');

			// Automatic created_at and updated_at columns
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}