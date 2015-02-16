# Mrcore6

A Wiki/CMS built with Laravel 5

See http://mrcore.mreschke.com for details and documentation.


# Install

?



# App Problems

NFS is too slow for /workbench period...way to slow.  This means /workbench
must be local, but if using webfarm, that is a problem.  If you use prod GUI
to make a workbench, it only goes to that servers /workbench, it's not not 
copied to the other webservers, and not shared because of nfs.

This means, for prod, if you have a webfarm, you need to be able to DISABLE
the gui that lets you CREATE a workbench.  Now you must create a workbench
elsewhere, like on your local dev box, then deploy it to all webservers
with rsync, like any other true application.

I find that simple wiki apps that include single .php files over nfs are 
still find and very fast, no lag finding the file.

So make post edit page workbench forge toggle by config, so I can hide in 
dynatron production.

Still want apps dynamically loaded and tied to a post/url so they can be
searched just like any other post.  Still need edit gui to tie post to
a vendor/package, just don't allow CREATION of a workbench unless config
says so.  If you set post as workbench with vendor/package, and it doesn't exist
don't error.  Still require static URL.  I think the /app symlink is pointless
now, becuase over NFS with workbench being local...app is a dead symlink...pointless

Perhaps think about making regular wiki apps more powerful?  Maybe include
them early in the bootstrap somehow? benifits?? don't know...at least make
better snippet docs and get bootstrap 3.0 nice, maybe an app template






# mRcore Modules

Mrcore is composed of modules.  All modules (except one; the %app%) are explicitly
defined in the config/modules.php file.  The mrcore Foundation, Auth, Wiki,
Theme... are all treated as modules.  Modules can have service providers, views,
assets, routes, controllers and anything else.  Because several of these
modules are running at once, we must define their order so Laravel knows
how and which views, routes, assets to load first and which ones override
the others.  This order is how your Theme can override base views, and your
Themes can be overridden by apps...  Not only do you define the modules
information in config/modules.php, you also define the loading order for its
views, assets and routes individually using 3 separate arrays.

If you have the mrcore Wiki module, not only can you write great wiki posts
and documents, but a post itself can be setup as an "application".  This means
it can have code attached to it.  In our case that code is basically just another
module.  We call these "apps" or "applications" or "workbenches".
Mrcore will automatically detect the post contains a workbench.  It will then
treat that workbench exactly as if it were any other module defined statically
in the main config/modules.php file, but it is injected and loaded dynamically,
at run-time.  This means you can have "apps" that only fire up and run based
on the url.  At most, there is only one "app" running on a url.  You have
full control of the order of the app that is running by using the %app% variable
in the three order arrays inside app/module.php.  Generally you want your 
"apps" to override everything.  This lets you override any part of mrcore
and any loaded module by simply creating the proper app!  A logical module
ordering system might look like this:

	'assets' => [
		'%app%',
		'SubTheme',
		'Auth',
		'Wiki',
		'BaseTheme'
	],

	'views' => [
		'%app',
		'SubTheme',
		'Auth',
		'Wiki',
		'BaseTheme'
	],

	'routes' => [
		'%app%',
		'Auth',
		'Wiki',
		'Foundation'
	]

First item found wins. Example, if you have a Themes/BaseTheme/Assets/test.css
and a Module/Auth/Assets/test.css, the Auth css file will win and be loaded.
Notice BaseTheme is last, this lets Wiki override its views, and Auth can 
override Wikis views, and the SumTheme can override all others except the 
all powerful %app%.

The names here are the Module names you defined in the 'modules' => array.  Notice
we actually have two types of themes.  A BaseTheme, and a SubTheme.  This lets
you have an all encompasing base theme, but lets you override bits and pieces
in a sub theme.  Notice too that the order varies slightly between assets, views,
and routes.  This gives you complete override control.



# The Order of Things

How and where mrcore internally loads modules and apps.

Service providers defined in the config/app.php are so early in the bootstrap,
they have no access to Auth:: or Cache::... in their register() and boot()
functions. This means you really cannot use service providers as a place for
actual code.  You cannot put the mrcore route analyzer there becuase it cannot
even call the Router:: model, becuase the Router:: model uses Cache:: which
isn't even fired up yet (though the model works). Service providers should
really only register bindings and facades and other "set" type work but should
not really contain any code.  The best place to store this type of pre route,
pre controller "work" is in middleware.

For mrcore, this means the FoundationServiceProvider's register() method will
register all modules register() functions, then all modules boot() functions,
then finally run its own boot() function last in the chain.  At this point
no real work should be done, we just get all of our modules services providers
registered and booted.  Your module shouldn't attempt to do much work in their
register() or boot() functions either.

Becuase service providers are to early to run real code, we cannot run our
mrcore url route analyzer becuase that function uses Models, Cache, Auth and
several other required drivers that simply are not ready yet.  So we are
done with the service providers.  We have registered everything, but
done nothing.

Middleware is what we use to complete our Foundation.  Middleware runs after
all service providers register() and boot() functions.  At at this point, all
of Laravels facilities like Auth:: and Cache:: are ready and waiting.  Here
we analyze the route, determine if the current route has an application attached
and check security/user permission (becuase Auth:: is now available).
If permission is granted, and the route has an application attached, we use
the Module:: facade and dynamically, at run-time, inject the defined application
as a "module", as if it were statically defined in config/modules.php just
like every other module.  Now that we have a nice complete array of modules
accessible from our Module:: facade we simply load up the modules autoloaders
(if vendor/autoload.php is present), views, routes...all in the exact order
defined from config/modules.php including our dynamically loaded application
"module".  This dynamic application module is see as %app% to your
config/modules.php allowing you to define its order too!

This Foundation module/application method fires everthing at the right time,
in the right order and gives you complete control from config/modules.php!





I WANT - first one overrides
----------------------------

routes
	apps
	laravel
	auth
	wiki (must be last or after auth, has catch all)
	foundation (has a / for test, overwritten by wiki or auth above)

views
	laravel
	apps
	subtheme
	auth
	wiki
	basetheme

assets
	apps
	laravel (maybe first like view)
	custom theme
	auth
	wiki
	basetheme
	


-----------------
AppServiceProvider register
RouteServiceProvider register

FoundationServiceProvider register
	SUBTHEME views, assets

AuthServiceProvider register
	n/a

WikiServiceProvider register
	n/a

-----------------
AppServiceProvider boot
RouteServiceProvider boot
	main laravel routes

FoundationServiceProvider boot
	base theme views

AuthServiceProvider boot
	routes, views, assets

WikiServiceProvider boot
	!APPS!
	routes, views, assets






modules = [
	[
		'name' => 'Foundation',
		'namespace' => 'Mrcore\Modules\Foundation',
		'path' => '../Modules/Foundation'
	],
	[
		'name' => 'Auth',
		'namespace' => 'Mrcore\Modules\Auth',
		'path' => '../Modules/Auth'
	],
	[
		'name' => 'Wiki',
		'namespace' => 'Mrcore\Modules\Wiki',
		'path' => '../Modules/Wiki'
	],	



]










# License

This project is open-sourced software licensed under the [MIT license](http://mreschke.com/license/mit)




# Current Laravel 5.0 Porting Issues

Move mrcore services into providers folder, merge nicely...

Look at config/compiled, add my services?

Revisit Middleware\AuthenticateWithDigestAuth.php when ready, port old auth.digest filter

Put back old blade {{ }} even though security issue, fix later

fix all css stuff, I want less and gulp now, but kept old stuff

public symlinks to workbenches?

perhaps $posts->appends($get)->render() instead of $posts->appends($get)->links() in theme/src/view/search/layout.blade.php

All workbench providers must now use Mrcore\Providers\ServiceProvider;