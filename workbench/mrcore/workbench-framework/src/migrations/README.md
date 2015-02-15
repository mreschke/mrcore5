Workbench Migrations
====================
Migrations for workbenches are a bit tricky and much different than standard Laravel.  You have to make sure to use the right connection all the time.

See
* http://fideloper.com/laravel-multiple-database-connections
* https://medium.com/laravel-4/migrations-for-the-conscientious-6e75f99cdb0
* http://www.engine23.com/laravel-workbench-migrations-seeds.html

You also need to use different migration commands.

You CANNOT properly namespace your workbenches migrations so instead you must give them a unique name (use your package name) so the names don't conflict with the mrcore5 root migration table names.

My example below is for a workbench in the app/dashboard namespace with a mysql database connection named 'dashboard'.



Create migration files
----------------------
`./artisan migrate:make create_dashboard_users_table --bench="app/dashboard"`

As long as you use --database=dashboard on all command line migrations then there is not reason to force connection everywhere (ex: Schema::connection('dashboard')->create()...), no need.  Though you do need to specify the connection in your model with `protected $connection = 'dashboard' as in the model/User.php example



Run migrations
--------------
`./artisan migrate --database=dashboard --bench="app/dashboard"`



Reset Migrations
----------------
NOTE the standard migrate:refresh or reset does NOT work, if you run that you will reset and reseed all mrcore5 data

You can roll back the last migration with
`./artisan migrate:rollback --database=dashboard`

None of the existing artisan command can reset or refresh a workbench migration properly. Best to simply drop and re-create the database manually, then seed.



Seed
----
NOTE the standard migrate or migrate with --seed does NOT work
`./artisan db:seed --database=dashboard --class="DashboardSeeder"`

