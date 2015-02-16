<?php

use Mrcore\Modules\Wiki\Models\Post;
use Mrcore\Modules\Wiki\Models\Router;
use Mrcore\Modules\Wiki\Support\Crypt;
use Mreschke\Helpers\String;
use Illuminate\Database\Seeder;

class WikiPostSeeder extends Seeder
{
	public function run()
	{

		DB::table('posts')->delete();

		#1 Home
		#---------------------------------------------------------------
		Post::create(array(
			'uuid' => String::getGuid(),
			'title' => 'Home',
			'slug' => 'home',
			'content' =>  Crypt::encrypt("<div class='jumbotron'>
	<h1>Welcome to mRcore</h1>
	<p>A Wiki/CMS system built with Laravel</p>
	<p><a class='btn btn-primary btn-lg' onclick=\"window.location='/search'\"><i class='fa fa-search'></i> Browse Posts</a></p>
</div>"),
			'teaser' => Crypt::encrypt(''),
			'contains_script' => false,
			'contains_html' => true,
			'format_id' => 4,#html
			'type_id' => 2,#page
			'mode_id' => 1,
			'symlink' => false,
			'shared' => false,
			'hidden' => false,
			'deleted' => false,
			'indexed_at' => '1900-01-01 00:00:00',
			'created_by' => 2,
			'updated_by' => 2,
		));
		Router::create(array('slug' => 'home', 'post_id' => 1, 'static' => true));



		#2 mRcore Global
		#---------------------------------------------------------------
		Post::create(array(
			'uuid' => String::getGuid(),
			'title' => 'mRcore Global',
			'slug' => 'mrcore-global',
			'content' =>  Crypt::encrypt(''),
			'teaser' => Crypt::encrypt(''),
			'contains_script' => false,
			'contains_html' => false,
			'format_id' => 3,#phpw
			'type_id' => 2,#page
			'mode_id' => 1,
			'symlink' => false,
			'shared' => false,
			'hidden' => true,
			'deleted' => false,
			'indexed_at' => '1900-01-01 00:00:00',
			'created_by' => 2,
			'updated_by' => 2,
		));
		Router::create(array('slug' => 'mrcore/global', 'post_id' => 2, 'static' => true));



		#3 Admin Home
		#---------------------------------------------------------------
		Post::create(array(
			'uuid' => String::getGuid(),
			'title' => 'Admin Home Page',
			'slug' => 'admin-home-page',
			'content' =>  Crypt::encrypt('<info>
[[toc]]
</info>

+ Summary
This is the home page of the admin user.

Every user of mrcore has a dedicated home page and a dedicated user global page.
'),
			'teaser' => Crypt::encrypt(''),
			'contains_script' => false,
			'contains_html' => false,
			'format_id' => 1,#wiki
			'type_id' => 1,#doc
			'mode_id' => 1,
			'symlink' => false,
			'shared' => false,
			'hidden' => false,
			'deleted' => false,
			'indexed_at' => '1900-01-01 00:00:00',
			'created_by' => 2,
			'updated_by' => 2,
		));
		Router::create(array('slug' => 'admin-home-page', 'post_id' => 3));



		#4 Admin Global
		#---------------------------------------------------------------
		Post::create(array(
			'uuid' => String::getGuid(),
			'title' => 'Admin Global',
			'slug' => 'admin-global',
			'content' =>  Crypt::encrypt(''),
			'teaser' => Crypt::encrypt(''),
			'contains_script' => false,
			'contains_html' => false,
			'format_id' => 7,#htmlw
			'type_id' => 2,#page
			'mode_id' => 1,
			'symlink' => false,
			'shared' => false,
			'hidden' => true,
			'deleted' => false,
			'indexed_at' => '1900-01-01 00:00:00',
			'created_by' => 2,
			'updated_by' => 2,
		));
		Router::create(array('slug' => 'admin-global', 'post_id' => 4));



		#5 mRcore Workbench
		#---------------------------------------------------------------
		Post::create(array(
			'uuid' => String::getGuid(),
			'title' => 'mRcore Workbench',
			'slug' => 'mrcore-workbench',
			'content' =>  Crypt::encrypt('<info>
[[toc]]
</info>

+ Summary

This is the mrcore workbench post.  All actual workbench code is symlinked to this post.  You can use this post to keep documentation about your custom workbenches.

See http://mrcore.mreschke.com/doc/advanced/workbench for more info in workbenches.'),
			'teaser' => Crypt::encrypt(''),
			'contains_script' => false,
			'contains_html' => false,
			'format_id' => 1,#wiki
			'type_id' => 1,#doc
			'mode_id' => 1,
			'symlink' => true,
			'shared' => false,
			'hidden' => false,
			'deleted' => false,
			'indexed_at' => '1900-01-01 00:00:00',
			'created_by' => 2,
			'updated_by' => 2,
		));
		Router::create(array('slug' => 'mrcore/workbench', 'post_id' => 5, 'static' => true));


		#6 User Info
		#---------------------------------------------------------------
		Post::create(array(
			'uuid' => String::getGuid(),
			'title' => 'User Info',
			'slug' => 'user-info',
			'content' =>  Crypt::encrypt(''),
			'teaser' => Crypt::encrypt(''),
			'contains_script' => false,
			'contains_html' => false,
			'format_id' => 7,#htmlw
			'type_id' => 2,#page
			'mode_id' => 1,
			'symlink' => false,
			'shared' => false,
			'hidden' => true,
			'deleted' => false,
			'indexed_at' => '1900-01-01 00:00:00',
			'created_by' => 2,
			'updated_by' => 2,
		));
		Router::create(array('slug' => 'mrcore/userinfo', 'post_id' => 6, 'static' => true));



		#7 Search Box
		#---------------------------------------------------------------
		Post::create(array(
			'uuid' => String::getGuid(),
			'title' => 'Search Box',
			'slug' => 'search-box',
			'content' =>  Crypt::encrypt('<?php
$badges = Mrcore\Modules\Wiki\Models\Badge::all();

$admin = array(
	array("name" => "mRcore Workbench", "url" => "/5"),
	array("name" => "Site Global", "url" => "/2"),
	array("name" => "UserInfo Global", "url" => "/6"),
	array("name" => "Search Box", "url" => "/7"),
);

$popular = array (
	array("name" => "Home Page", "url" => "/1"),
);

$private = array ();
?>

<!-- ----------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------- -->
<!-- ----------------------------------------------------------------------- -->
<style type="text/css">
	.navbar .dropdown-menu .search-dropdown li a {
		padding: 0px;
	}
	.navbar .dropdown-menu .search-dropdown a img {
		margin-bottom: 5px;
		margin-right: 5px;
	}
</style>
<style type="text/css">
</style>
<div class="search-dropdown row">

	<div class="col-sm-6">
		<h4>Categories</h4>
		<ul class="list-unstyled">
		<? foreach ($badges as $badge): ?>
			<li>
				<a href="<?= route("search")."?badge".$badge->id."=1" ?>"><img src="<?= asset("uploads/".$badge->image) ?>" width="24px" /></a>
				<a href="<?= route("search")."?badge".$badge->id."=1" ?>"><?= $badge->name ?></a>
			</li>
		<? endforeach ?>
		</ul>

		<? if (Mrcore::user()->isAdmin()): ?>
			<h4>Admin Only</h4>	
			<ul class="list-unstyled">
			<? foreach ($admin as $item): ?>
				<li>
					<a href="<?= $item[url] ?>">
						<?= $item[name] ?>
					</a>
				</li>
			<? endforeach ?>
			</ul>
		<? endif ?>
	</div>
	
	
	<div class="col-sm-6">
		<? if (count($popular) > 0): ?>
			<h4>Popular Links</h4>
			<ul class="list-unstyled">
			<? foreach ($popular as $item): ?>
				<li>
					<a href="<?= $item[url] ?>">
						<?= $item[name] ?>
					</a>
				</li>
			<? endforeach ?>
		<? endif ?>
		<? if (Mrcore::user()->isAuthenticated()): ?>
			<? if (count($private) > 0) echo "<hr />"; ?>
			<? foreach ($private as $item): ?>
				<li>
					<a href="<?= $item[url] ?>">
						<?= $item[name] ?>
					</a>
				</li>
			<? endforeach ?>
		<? endif ?>
	</div>
</div>'),
			'teaser' => Crypt::encrypt(''),
			'contains_script' => true,
			'contains_html' => true,
			'format_id' => 2,#php
			'type_id' => 2,#page
			'mode_id' => 1,
			'symlink' => false,
			'shared' => false,
			'hidden' => true,
			'deleted' => false,
			'indexed_at' => '1900-01-01 00:00:00',
			'created_by' => 2,
			'updated_by' => 2,
		));
		Router::create(array('slug' => 'mrcore/searchbox', 'post_id' => 7, 'static' => true));



		#8 Default Document Template
		#---------------------------------------------------------------
		Post::create(array(
			'uuid' => String::getGuid(),
			'title' => 'Default Document Template',
			'slug' => 'default-document-template',
			'content' =>  Crypt::encrypt('<info>
[[toc]]
</info>

+ Summary

New Document'),
			'teaser' => Crypt::encrypt(''),
			'contains_script' => false,
			'contains_html' => false,
			'format_id' => 1,#wiki
			'type_id' => 1,#doc
			'mode_id' => 1,
			'symlink' => false,
			'shared' => false,
			'hidden' => true,
			'deleted' => false,
			'indexed_at' => '1900-01-01 00:00:00',
			'created_by' => 2,
			'updated_by' => 2,
		));
		Router::create(array('slug' => 'default-document-template', 'post_id' => 8));



		#9 Default Page Template
		#---------------------------------------------------------------
		Post::create(array(
			'uuid' => String::getGuid(),
			'title' => 'Default Page Template',
			'slug' => 'default-page-template',
			'content' =>  Crypt::encrypt(''),
			'teaser' => Crypt::encrypt(''),
			'contains_script' => false,
			'contains_html' => false,
			'format_id' => 1,#wiki
			'type_id' => 1,#doc
			'mode_id' => 1,
			'symlink' => false,
			'shared' => false,
			'hidden' => true,
			'deleted' => false,
			'indexed_at' => '1900-01-01 00:00:00',
			'created_by' => 2,
			'updated_by' => 2,
		));
		Router::create(array('slug' => 'default-page-template', 'post_id' => 9));



		#10 Default App Template
		#---------------------------------------------------------------
		Post::create(array(
			'uuid' => String::getGuid(),
			'title' => 'Default App Template',
			'slug' => 'default-app-template',
			'content' =>  Crypt::encrypt(''),
			'teaser' => Crypt::encrypt(''),
			'contains_script' => true,
			'contains_html' => true,
			'format_id' => 2,#php
			'type_id' => 1,#doc
			'mode_id' => 1,
			'symlink' => false,
			'shared' => false,
			'hidden' => true,
			'deleted' => false,
			'indexed_at' => '1900-01-01 00:00:00',
			'created_by' => 2,
			'updated_by' => 2,
		));
		Router::create(array('slug' => 'default-app-template', 'post_id' => 10));


	}

}
