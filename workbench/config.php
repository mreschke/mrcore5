<?php
\Lifecycle::add(__FILE__);

/*
|--------------------------------------------------------------------------
| Workbench Service Provider Config Registration
|--------------------------------------------------------------------------
|
| Register your custom configs here or define them in the app/config dir
| Each individual workbench may have its own config section but
| this is where you register your global configs, these are always
| available across all workbenches.
|
*/

// Database Connections
// Do not use the reserved sqlite, mysql, pgsql, sqlsrv in connections.xxxx
/*Config::set('database.connections.mrcore4', array(
	'driver'    => 'mysql',
	'host'      => 'localhost',
	'database'  => 'mrcore4',
	'username'  => 'root',
	'password'  => 'password',
	'charset'   => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix'    => '',
	// Set max query to 128mb
	'options'   => array(PDO::MYSQL_ATTR_MAX_BUFFER_SIZE => 128 * 1024 * 1024),
));*/

// Custom Configs
// Do not use the reserved config names already in laravel, see laravels app/config dir
// Reserved are: app, auth, cache, compile, database, mail, mrcore, queue, remote, session, view, workbench
Config::set('my', array(

	#'test' => 'testhere',

));


// Database Configs for Mreschke\Dbal
Config::set('my.db', array(

	// Default Database Type
	'default_type' => 'mysql',

	// MSSQL Connections
	#'mssql' => '{"server":"sqlsrv","database":"mydb","username":"myuser","password":"mypass","type":"mssql"}',

));
