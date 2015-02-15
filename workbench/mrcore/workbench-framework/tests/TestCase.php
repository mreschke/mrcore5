<?php
function createApplication()
{
	$unitTesting = true;
	$testEnvironment = 'testing';
	
	// Start laravel
	$app = require __DIR__ . '/../../../../bootstrap/start.php';

	// Parse the vendor/package from the current directory 
	$tmp = explode('/', __DIR__);
	$vendor = $tmp[count($tmp)-3];
	$package = $tmp[count($tmp)-2];
	$namespace = studly_case($vendor).'\\'.studly_case($package);
	$workbenchBase = base_path()."/workbench/$vendor/$package";
	$workbenchService = "$namespace\\".studly_case($package)."ServiceProvider";

	// Fireup the workbench
	$app->register("$workbenchService");
	if (file_exists("$workbenchBase/src/views/")) {
		\View::addNamespace(studly_case($package), "$workbenchBase/src/views/");
	}
	return $app;
}
