<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Site Host
	|--------------------------------------------------------------------------
	|
	| This is the sites host only address, so if you site is
	| http://wiki.example.com then this value should be just example.com
	|
	*/

	'host' => substr(env('APP_URL', 'localhost'), strpos(env('APP_URL', 'localhost'), '://') + 3),

	/*
	|--------------------------------------------------------------------------
	| Site Base URL
	|--------------------------------------------------------------------------
	|
	| This is the base url of your mrcore installation.  If you access the
	| site using http://wiki.example.com then this should be
	| //wiki.example.com (do NOT use http:// or https://)
	|
	*/

	'base_url' => substr(env('APP_URL', 'localhost'), strpos(env('APP_URL', 'localhost'), '://') + 1),

	/*
	|--------------------------------------------------------------------------
	| File Base URL
	|--------------------------------------------------------------------------
	|
	| This is the base url of the main file script.  This should be your main
	| base_url + /file but should NOT be prefixed with // or http:// or https://
	| No / at end
	| Example: wiki.example.com/file
	|
	*/

	'file_base_url' => env('MRCORE_FILE_URL', 'localhost/file'),

	/*
	|--------------------------------------------------------------------------
	| Webdav Base URL
	|--------------------------------------------------------------------------
	|
	| This is the base url of the main webdav file location.  This should be
	| a subdomain not a /webdav (path) because many webdav clients require
	| webdav to be accessible on the root of the domain.  It is advised
	| to use apache and create a ServerAlias on your same mrcore directive.
	| This value should NOT be prefixed with // or http:// or https://
	| No / at end
	| Example: webdav.example.com
	|
	*/

	'webdav_base_url' => env('MRCORE_WEBDAV_URL', 'webdav.localhost'),

	/*
	|--------------------------------------------------------------------------
	| Main mRcore Files Directory
	|--------------------------------------------------------------------------
	|
	| This is the root directory of where all mrcore files reside
	| This directory must contain an index directory where the actual
	| post ID integer directories reside.  No / at end
	|
	*/

	'files' => env('MRCORE_FILE_PATH', '/var/www/mrcore5/Files'),

	/*
	|--------------------------------------------------------------------------
	| Post Encryption
	|--------------------------------------------------------------------------
	|
	| Enable this site to encrypt all post data
	| This must be set before any post data is created, even seed data
	| You must NEVER change this once you have it set or all posts will be
	| un readable.  You must also set your own 'key' value in app/config/app.php
	|
	*/

	'use_encryption' => env('MRCORE_ENCRYPTION', true),

	/*
	|--------------------------------------------------------------------------
	| Internal Laravel Caching
	|--------------------------------------------------------------------------
	|
	| Cache posts and various other queries to help speed things up
	| Cache provider is set in app/config/cache.php (redis is a good choice)
	| cache_expires is in minutes
	|
	*/

	'use_cache' => env('MRCORE_CACHE', true),
	'cache_expires' => env('MRCORE_CACHE_EXPIRES', 60),

	/*
	|--------------------------------------------------------------------------
	| Search Page Size
	|--------------------------------------------------------------------------
	|
	| Number of search results returned per page
	|
	*/

	'search_pagesize' => env('MRCORE_SEARCH_PAGESIZE', 10),

	/*
	|--------------------------------------------------------------------------
	| Teaser Length
	|--------------------------------------------------------------------------
	|
	| Max length of auto generated post teaser
	|
	*/

	'teaser_length' => env('MRCORE_TEASER_LENGTH', 500),

	/*
	|--------------------------------------------------------------------------
	| Home Page Post ID
	|--------------------------------------------------------------------------
	|
	| The main home page post id
	| Used as a default redirect and for the / route
	|
	*/

	'home' => env('MRCORE_HOME', 1),

	/*
	|--------------------------------------------------------------------------
	| mRcore Help URL
	|--------------------------------------------------------------------------
	|
	| This is the main mrcore help url.  You should make this the mrcore wiki
	| manual documentation.
	|
	*/

	'help' => env('MRCORE_HELP', 'http://mrcore.mreschke.com/mrcore/help'),

	/*
	|--------------------------------------------------------------------------
	| mRcore Cheat Sheet URL
	|--------------------------------------------------------------------------
	|
	| This is the main mrcore cheat sheet url.  You should make this the
	| mrcore syntax help documentation.  This document is the one linked from
	| the main edit page.
	|
	*/

	'cheat' => env('MRCORE_CHEAT', 'http://mrcore.mreschke.com/mrcore/cheatsheet'),

	/*
	|--------------------------------------------------------------------------
	| Workbench Post ID
	|--------------------------------------------------------------------------
	|
	| This is the post ID that contains your workbench code
	|
	*/

	'workbench' => env('MRCORE_WORKBENCH', 5),

	/*
	|-------------------e------------------------------------------------------
	| Site Global Post ID
	|--------------------------------------------------------------------------
	|
	| This is your master site global post ID.  Every request will include
	| and parse the contents of this post id before being rendered.  This allows
	| you to override css or internal variables with ever reqiest.  This allows
	| you to extend mrcore in a way other than mrcore services.
	|
	*/

	'global' => env('MRCORE_GLOBAL', 2),

	/*
	|--------------------------------------------------------------------------
	| User Info Post ID
	|--------------------------------------------------------------------------
	|
	| This post ID content is displayed when users click the avatar user
	| dropdown.  This allows you to customze the user dropdown menu.
	|
	*/

	'userinfo' => env('MRCORE_USERINFO', 6),

	/*
	|--------------------------------------------------------------------------
	| Search Menu Post ID
	|--------------------------------------------------------------------------
	|
	| This post ID content is displayed when users click the search textbox.
	| This allows you to customze the search dropdown menu.
	|
	*/

	'searchmenu' => env('MRCORE_SEARCHMENU', 7),

	/*
	|--------------------------------------------------------------------------
	| Document Template Post ID
	|--------------------------------------------------------------------------
	|
	| Post ID of the doc type template.  When you create a new post of type
	| doc this posts contents are set as your default new post template
	|
	*/

	'doc_template' => env('MRCORE_DOC_TEMPLATE', 8),

	/*
	|--------------------------------------------------------------------------
	| Page Template Post ID
	|--------------------------------------------------------------------------
	|
	| Post ID of the page type template.  When you create a new post of type
	| page this posts contents are set as your default new post template
	|
	*/

	'page_template' => env('MRCORE_PAGE_TEMPLATE', 9),

	/*
	|--------------------------------------------------------------------------
	| App Template Post ID
	|--------------------------------------------------------------------------
	|
	| Post ID of the app type template.  When you create a new post of type
	| app this posts contents are set as your default new post template
	|
	*/

	'app_template' => env('MRCORE_APP_TEMPLATE', 10),

	/*
	|--------------------------------------------------------------------------
	| Anonymous User ID
	|--------------------------------------------------------------------------
	|
	| The anonymous user ID (in users database table, usually 1).  This will
	| usually always be 1
	|
	*/

	'anonymous' => 1,

	/*
	|--------------------------------------------------------------------------
	| App Type ID
	|--------------------------------------------------------------------------
	|
	| Static ID for the app post type.  Must be the same as the app
	| entry in your "types" database table.  This will generally be the same
	| for every installation.
	|
	*/

	'app_type' => 3,

	/*
	|--------------------------------------------------------------------------
	| Default View Mode ID
	|--------------------------------------------------------------------------
	|
	| Static ID for the default view most.  Must be the same as the entry
	| in your "modes" database table wiht the constant "default"
	| This will generally be the same for every installation.
	|
	*/

	'default_mode' => 1, #default mode id

];
