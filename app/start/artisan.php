<?php
\Lifecycle::add(__FILE__);

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

Artisan::add(new IndexPosts);
Artisan::add(new Mrcore\WorkbenchFramework\Install);

/*
|--------------------------------------------------------------------------
| Register Custom Artisan Commands
|--------------------------------------------------------------------------
|
| Register our custom mrcore artisan commands
| This is how I allow developers to extend mrcore without touching code
| mReschke 2014-02-04
|
*/

require base_path().'/workbench/artisan.php';
