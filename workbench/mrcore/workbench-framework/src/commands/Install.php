<?php
/**
 * Mrcore Workbench Framework Install Script
 *
 * @author     Matthew Reschke <mail@mreschke.com>
 * @copyright  2014 Matthew Reschke
 * @link       http://mreschke.com
 * @license    http://mreschke.com/topic/317/MITLicense
 * @package    Mrcore\WorkbenchFramework
 * @since      2014-02-25
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mrcore\WorkbenchFramework;

use \Illuminate\Console\Command;
use \Symfony\Component\Console\Input\InputOption;
use \Symfony\Component\Console\Input\InputArgument;

class Install extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'framework:install-workbench';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install a workbench framework into a post';

	/**
	* Other variables
	*/
	protected $console;
	protected $workbench;
	protected $namespace;
	protected $vendor;
	protected $vendorLower;
	protected $package;
	protected $packageLower;
	protected $postID;
	protected $replaceWorkbench = 'mrcore/workbench-framework';
	protected $replaceVendor = 'Mrcore';
	protected $replacePackage = 'WorkbenchFramework';
	protected $replacePackageLower = 'workbench-framework';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Instantiate additional console helpers
		$this->console = new \Mrcore\Helpers\Console();

		// Get our parameters
		$this->workbench = strtolower($this->argument('workbench'));
		$this->postID = $this->argument('postID');
		if ($this->postID) {
			if (!is_numeric($this->postID)) {
				$this->error('PostID must be an integer');
				exit();
			}
		}
		$workbenchBase = base_path().'/workbench/'.$this->workbench;
		$frameworkBase = base_path().'/workbench/mrcore/workbench-framework';
		$filesBase = \Config::get('mrcore.files')."/index/$this->postID";

		if (!file_exists($workbenchBase)) {
			$segments = explode("/", $this->workbench);
			if (count($segments) != 2) {
				$this->error('Workbench must be in vendor/package format');
				exit();
			}
			$this->vendor = studly_case($segments[0]);
			$this->vendorLower = $segments[0];
			$this->package = studly_case($segments[1]);
			$this->packageLower = $segments[1];
			$this->namespace = "$this->vendor\\$this->package";

			$this->info("Installing workbench/$this->workbench");
			$workbenchPostID = \Config::get('mrcore.workbench');
			$this->console->exec("mkdir -p $workbenchBase");

			# Must delete this new autoload.php or the entire site will error because
			# There is a duplicate autoload uuid trying to be called.  Once we dump-autoload, this
			# file will be re-created.
			$this->console->exec("mv $frameworkBase/vendor/autoload.php /tmp/");
			$this->console->exec("cp -a $frameworkBase/* $workbenchBase");
			$this->console->exec("mv /tmp/autoload.php $frameworkBase/vendor/autoload.php");

			if ($this->postID) {
				// Create index/x/app sym link
				if (file_exists("$filesBase/app") && is_link("$filesBase/app")) {
					$this->console->exec("rm '$filesBase/app'");
				}
				if (!file_exists("$filesBase/app")) {
					$this->console->exec("cd $filesBase; ln -s ../../mrcore/workbench/$this->workbench ./app");
				}
			}


			// composer.json
			$this->info("Configuring composer.json");
			$this->replace("$workbenchBase/composer.json");


			// config
			$this->info("Configuring configs");
			$this->replace("$workbenchBase/src/config/config.php");


			// controllers
			$this->info("Configuring contgrollers");
			if (file_exists("$workbenchBase/src/controllers/".$this->replacePackage."Controller.php")) {
				$this->console->exec(
					"mv $workbenchBase/src/controllers/".$this->replacePackage."Controller.php \
					$workbenchBase/src/controllers/".$this->package."Controller.php
				");
			}
			$this->replace("$workbenchBase/src/controllers/".$this->package."Controller.php");


			// views
			$this->replace("$workbenchBase/src/views/index.blade.php");


			// services
			$this->info("Configuring services");
			if (file_exists("$workbenchBase/src/$this->replaceVendor") && $this->vendor != $this->replaceVendor) {
				$this->console->exec("mv $workbenchBase/src/$this->replaceVendor $workbenchBase/src/$this->vendor");
			}
			if (file_exists("$workbenchBase/src/$this->vendor/$this->replacePackage")) {
				$this->console->exec("
					mv $workbenchBase/src/$this->vendor/$this->replacePackage \
					$workbenchBase/src/$this->vendor/$this->package
				");
			}
			if (file_exists("$workbenchBase/src/$this->vendor/$this->package/".$this->replacePackage."ServiceProvider.php")) {
				$this->console->exec("
					mv $workbenchBase/src/$this->vendor/$this->package/".$this->replacePackage."ServiceProvider.php \
					$workbenchBase/src/$this->vendor/$this->package/".$this->package."ServiceProvider.php
				");
			}
			$this->replace("$workbenchBase/src/$this->vendor/$this->package/".$this->package."ServiceProvider.php");


			// routes
			if ($this->postID) {
				$route = \Router::findDefaultByPost($this->postID);
				$this->info("Configuring routes");
				$this->replace("$workbenchBase/src/routes.php");
				if ($route->static) {
					$this->console->inlineSed("/workbench/route", "/".$route->slug, "$workbenchBase/src/routes.php");
				}
			}


			// commands
			$this->console->exec("rm $workbenchBase/src/commands/Install.php");

			
			// Dump workbench autoload
			// I cannot get any composer commands to work when called from the edit page controller
			// it only works when from command line, so I ignore if not from console
			if (\App::runningInConsole()) {
				$this->info("Configuring composer");
				$this->info($this->console->exec("cd $workbenchBase; composer dump-autoload"));
			}

			// Crazy, none of this works, not even nohup, composer just will not run from web :(
			#$this->info($this->console->exec("nohup bash -c 'cd ".$workbenchBase." && composer dump-autoload'"));
			#$this->info($this->console->exec("bash -c 'cd ".$workbenchBase." && ls'"));
			#$this->call('dump-autoload');

			// Tests
			$this->replace("$workbenchBase/src/tests/Bootstrap.php");

			// Models
			$this->replace("$workbenchBase/src/models/User.php");

			// Database
			$this->replace("$workbenchBase/src/seeds/".$this->replacePackage."Seeder.php");
			$this->replace("$workbenchBase/src/seeds/".$this->replacePackage."UserSeeder.php");
			$this->console->exec(
				"mv $workbenchBase/src/seeds/".$this->replacePackage."Seeder.php \
				$workbenchBase/src/seeds/".$this->package."Seeder.php
			");
			$this->console->exec(
				"mv $workbenchBase/src/seeds/".$this->replacePackage."UserSeeder.php \
				$workbenchBase/src/seeds/".$this->package."UserSeeder.php
			");

			// Done
			$this->info("Framework install complete");

		
		} else {
			// Workbench already exists, just link it up to this post
			// And create the files/index/42/app symlink
			$this->info("Workbench exists");
			$this->info("Linking workbench to post");

			// Create app sym link
			if (file_exists("$filesBase/app") && is_link("$filesBase/app")) {
				$this->console->exec("rm '$filesBase/app'");
			}
			if (!file_exists("$filesBase/app")) {
				$this->console->exec("cd $filesBase; ln -s ../../mrcore/workbench/$this->workbench ./app");
			} else {
				$this->info("");
				$this->info("ERROR: Workbench linked successfully!");
				$this->info("BUT files/index/$this->postID/app folder exists so symlink not created, manage link manually.");
			}
		}

	}

	protected function replace($file)
	{
		$this->console->inlineSed($this->replaceWorkbench, $this->workbench, $file);
		$this->console->inlineSed($this->replaceVendor.'\\\\'.$this->replacePackage, $this->vendor.'\\\\'.$this->package, $file);
		$this->console->inlineSed($this->replaceVendor.'\\\\\\\\'.$this->replacePackage, $this->vendor.'\\\\\\\\'.$this->package, $file);
		$this->console->inlineSed($this->replacePackageLower, $this->packageLower, $file);
		$this->console->inlineSed($this->replacePackage.'Controller', $this->package.'Controller', $file);
		$this->console->inlineSed($this->replacePackage.'ServiceProvider', $this->package.'ServiceProvider', $file);
		$this->console->inlineSed($this->replacePackage, $this->package, $file);

		#$this->console->inlineSed($this->replaceVendor, $this->vendor, $file);
		#$this->console->inlineSed($this->replacePackage, $this->package, $file);



	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('workbench', InputArgument::REQUIRED, 'vendor/package'),
			array('postID', InputArgument::OPTIONAL, '42'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			#array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
