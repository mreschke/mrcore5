<?php

class EditController extends BaseController {

	/**
	 * Show Post Edit Form
	 */
	public function editPost($id)
	{
		$post = Post::get($id);
		if (!isset($post)) return Response::notFound();
		if (!$post->hasPermission('write')) return Response::denied();

		// Adjust layout
		Layout::title($post->title);
		Layout::hideAll(true);
		Layout::container(false);


		// Decrypt content
		$post->content = Mrcore\Crypt::decrypt($post->content);

		// Check for uncommited revisions
		$uncommitted = Revision::where('post_id', '=', $id)->where('revision', '=', 0)->get();

		// Get all formats
		$formats = Format::allArray('id');

		// Get all types
		$types = Type::allArray();

		// Get all frameworks
		$frameworks = Framework::allArray();

		// Get all modes
		$modes = Mode::allArray();

		// Get all badges
		$badges = Badge::allArray();
		$postBadges = $post->badges->lists('id');

		// Get all tags
		$tags = Tag::allArray();
		$postTags = $post->tags->lists('id');

		// Get hashtag
		$hashtag = Hashtag::findByPost($id);

		// Get Roles
		$roles = Role::orderBy('name')->get();

		// Get Permissions
		$perms = Permission::where('user_permission', '=', false)->get();

		// Get Post Permissions
		$postPerms = PostPermission::where('post_id', '=', $id)->get();

		// Get Post Routes
		$route = Router::findDefaultByPost($id);
		if ($route->static) {
			$defaultSlug = '/'.$route->slug;
		} else {
			$defaultSlug = '/'.$id.'/'.$route->slug;
		}

		return View::make('edit.edit', array(
			'post' => $post,
			'uncommitted' => $uncommitted,
			'formats' => $formats,
			'types' => $types,
			'frameworks' => $frameworks,
			'modes' => $modes,
			'badges' => $badges,
			'postBadges' => $postBadges,
			'tags' => $tags,
			'postTags' => $postTags,
			'hashtag' => $hashtag,
			'roles' => $roles,
			'perms' => $perms,
			'postPerms' => $postPerms,
			'route' => $route,
			'defaultSlug' => $defaultSlug,
		));
	}


	/**
	 * Update post content only
	 * Handles ajax $.post autosaves and actual publishing
	 */
	public function updatePost($id)
	{
		// Ajax only controller
		if (!Request::ajax()) return Response::notFound();

		$post = Post::get($id);
		if (!isset($post)) return Response::notFound();
		if (!$post->hasPermission('write')) return Response::denied();

		$autosave = (Input::get('autosave') == 'true' ? true : false);
		$revision = Revision::where('post_id', '=', $id)
			->where('revision', '=', 0)
			->where('created_by', '=', Auth::user()->id)
			->first();
		if (!isset($revision)) {
			$revision = new Revision;
			$revision->post_id = $id;
			$revision->title = $post->title;
			$revision->created_by = Auth::user()->id;
		}

		if ($autosave) {
			$revision->revision = 0;
		} else {
			// Update post
			$post->content = Mrcore\Crypt::encrypt(Input::get('content'));
			$post->teaser = Mrcore\Crypt::encrypt($post->createTeaser(Input::get('content')));
			$post->save();

			// Clear this posts cache
			Cache::forget("post_$id");

			// Clear Posts Array Cache for Wiki FreeLinks
			Cache::forget("posts_array");

			$lastRevisionNum = 0;
			$lastRevision = Revision::where('post_id', '=', $id)->orderBy('revision', 'desc')->first();
			if (isset($lastRevision)) $lastRevisionNum = $lastRevision->revision;
			$revision->revision = $lastRevisionNum + 1;
		}
		$revision->content = Mrcore\Crypt::encrypt(Input::get('content'));
		$revision->created_at = \Carbon\Carbon::now();
		$revision->save();

		return 'saved';
	}


	/**
	 * Update post organization settings only
	 * Handles via ajax only
	 */
	public function updatePostOrg($id)
	{
		// Ajax only controller
		if (!Request::ajax()) return Response::notFound();

		$post = Post::get($id);
		if (!isset($post)) return Response::notFound();
		if (!$post->hasPermission('write')) return Response::denied();

		// Update post info
		$post->format_id = Input::get('format');
		$post->type_id = Input::get('type');
		if ($post->type_id == Config::get('mrcore.app_type')) {
			$post->framework_id = Input::get('framework');
		} else {
			$post->framework_id = null;
		}
		$post->mode_id = Input::get('mode');
		if ($post->title != Input::get('title')) {
			// Title Changed
			$post->title = Input::get('title');	
			
			// Update router if not a static route
			$route = Router::findDefaultByPost($id);
			if (!$route->static) {
				$route->slug = Input::get('slug');
				$route->save();
			}

			// Clear Posts Array Cache for Wiki FreeLinks
			Cache::forget("posts_array");
		}
		
		$post->slug = Input::get('slug');
		$post->hidden = (Input::get('hidden') == 'true' ? true : false);
		$post->save();
		Cache::forget("post_$id");

		// Update badges and tags
		PostBadge::set($id, Input::get('badges'));
		PostTag::set($id, Input::get('tags'));

		// New Tags
		$newTags = Input::get('new-tags');
		if ($newTags) {
			$tags = explode(",", $newTags);
			foreach ($tags as $tag) {
				$tag = strtolower(trim(
					preg_replace('/[^\w-]+/i', '', $tag) # non alpha-numeric
				));
				if (strlen($tag) >= 2) {
					$tag = str_limit($tag, 50, '');
					$getTag = Tag::where('name', $tag)->first();
					if (!isset($getTag)) {
						$newTag = new Tag;
						$newTag->name = $tag;
						$newTag->save();

						$postTag = new PostTag;
						$postTag->post_id = $id;
						$postTag->tag_id = $newTag->id;
						$postTag->save();
					}
				}
			}
			Tag::forgetCache();
		}


		// Update hashtag
		if (!Hashtag::updateByPost($id, Input::get('hashtag'))) {
			return "ERROR: Hashtag already exists";
		}

		return "preferences saved";
	}


	/**
	 * Update post permission settings only
	 * Handles via ajax only
	 */
	public function updatePostPerms($id)
	{
		// Ajax only controller
		if (!Request::ajax()) return Response::notFound();

		$post = Post::get($id);
		if (!isset($post)) return Response::notFound();
		if (!$post->hasPermission('write')) return Response::denied();

		// Update post info
		$post->shared = (Input::get('shared') == 'true' ? true : false);
		$post->save();
		Cache::forget("post_$id");

		// Update post permissions
		$perms = json_decode(Input::get('perms'));
		PostPermission::where('post_id', '=', $id)->delete();
		foreach ($perms as $perm) {
			$postPermission = new PostPermission;
			$postPermission->post_id = $id;
			$postPermission->permission_id = $perm->perm_id;
			$postPermission->role_id = $perm->role_id;
			$postPermission->save();
		}

		return "preferences saved";
	}


	/**
	 * Update post advanced settings only
	 * Handles via ajax only
	 */
	public function updatePostAdv($id)
	{
		// Ajax only controller
		if (!Request::ajax()) return Response::notFound();

		$post = Post::get($id);
		if (!isset($post)) return Response::notFound();
		if (!$post->hasPermission('write')) return Response::denied();

		$ret = "preferences saved";
		if (User::isAdmin()) {
			$defaultSlug = trim(Input::get('default-slug'));
			$defaultSlug = preg_replace("'//'", "/", $defaultSlug);
			if ($defaultSlug == '/') $defaultSlug = '';
			if ($defaultSlug) {
				$static = true;
			} else {
				$static = false;
			}
			#$static = (Input::get('static') == 'true' ? true : false);
			$symlink = (Input::get('symlink') == 'true' ? true : false);
			if ($static == false) {
				$symlink = false;	
			} 
			$workbench = strtolower(Input::get('workbench'));
			if (!$workbench) $workbench = null;
			if (isset($workbench)) {
				if (substr_count($workbench, '/') != 1) {
					return "ERROR: workbench must be vendor/package format";
				}
			}

			
			if (substr($defaultSlug, 0, 1) == '/') $defaultSlug = substr($defaultSlug, 1);
			if (substr($defaultSlug, -1) == '/') $defaultSlug = substr($defaultSlug, 0, -1);

			// Update post info
			$post->symlink = $symlink;
			$post->workbench = $workbench;
			$post->save();
			Cache::forget("post_$id");

			// Update router
			$route = Router::findDefaultByPost($id);
			$originalRoute = Router::findDefaultByPost($id);
			$valid = true;
			if ($static) {
				$route->slug = $defaultSlug;

				// Don't Allow integer static routes
				if ($valid) {
					$tmp = explode("/", $defaultSlug);
					if (is_numeric($tmp[0])) {
						$ret = "ERROR: Static route cannot begin with an integer";
						$valid = false;
					}
				}

				// Check for duplicate route
				if ($valid) {
					$dup = Router::where('slug', $defaultSlug)
						->where('disabled', false)
						->where('post_id', '!=', $id)
						->first();
					if ($dup) {
						$ret = "ERROR: Route already exists";
						$valid = false;
					}
				}

				// Don't allow url reserved words
				if ($valid) {
					$tmp = explode("/", $defaultSlug);	
					if (in_array($tmp[0], Config::get('mrcore.reserved_routes'))) {
						$ret = "ERROR: Static route cannot be '$tmp[0]', this is a reserved word";
						$valid = false;
					}
				}
				


			} else {
				$route->slug = $post->slug;
			}

			if ($valid) {
				// Save Route
				$route->static = $static;
				$route->save();

				// Symlink Management, only create initially and only if static
				if ($static) {
					$symlink = new \Mrcore\Filemanager\Symlink($post, $originalRoute);
					$symlinkReturn = $symlink->manage();
					if (isset($symlinkReturn)) $ret = $symlinkReturn;
				}
			}

		}

		return $ret;
	}


	public function createApp($id)
	{
		// Ajax only controller
		if (!Request::ajax()) return Response::notFound();

		$post = Post::get($id);
		if (!isset($post)) return Response::notFound();
		if (!$post->hasPermission('write')) return Response::denied();
		if (!isset($post->framework_id)) return "ERROR: No framework selected";

		// Check if static route
		$route = Router::findDefaultByPost($id);
		if (!$route->static) return "ERROR: Post must have a static route";

		
		if ($post->framework->constant == 'workbench') {

			$workbench = strtolower(Input::get('workbench'));
			if (!$workbench) $workbench = null;

			if (isset($workbench)) {
				if (substr_count($workbench, '/') != 1) {
					return "ERROR: workbench must be vendor/package format";
				}

				// Execute install artisan script
				echo "<pre>";
				\Artisan::call(
					"framework:install-".$post->framework->constant,
					array('workbench' => $workbench, 'postID' => $id),
					new \Symfony\Component\Console\Output\StreamOutput(
						fopen('php://output', 'w')
					)
				);

				# Absolutely NONE of these work :(

				#$workbenchBase = base_path()."/workbench/$workbench";
				#exec("rm ".base_path()."/workbench/$workbench/vendor/autoload.php");
				#$this->info($this->console->exec("bash -c 'cd ".$workbenchBase." && composer dump-autoload'"));
				#$this->info($this->console->exec("bash -c 'cd ".$workbenchBase." && composer dump-autoload'"));
				#$this->info($this->console->exec("bash -c 'cd ".$workbenchBase." && composer dump-autoload'"));
				#\Artisan::call('dump-autoload');

				#exec("composer dump-autoload -d $workbenchBase");
				#echo("/usr/local/bin/composer dump-autoload -d $workbenchBase/");
				#var_dump(passthru("/usr/local/bin/composer dump-autoload -d $workbenchBase/"));
				#passthru("/usr/local/bin/composer dumpautoload -d $workbenchBase/");

				#passthru("/usr/local/bin/dump-autoload");
				#sleep(2);
				#var_dump(passthru("/usr/local/bin/dump-autoload"));

				#sleep(5);
				#$x = \App::make('Illuminate\Foundation\Composer');
				#$x->setWorkingPath($workbenchBase);
				#$x->dumpAutoloads("-d $workbenchBase/");
				#echo $x->dumpAutoloads();


			} else {
				// Workbench field empty
				// We don't exit() here because we still want to update the db below
				echo "No workbench defined<br />";
				echo "Unlinking existing workbench";

				// Remove app symlink
				if (is_link(\Config::get('mrcore.files')."/index/$id/app")) {
					exec("rm ".\Config::get('mrcore.files')."/index/$id/app");
				}
			}

			// Update workbench in posts table
			if ($workbench != $post->workbench) {
				$post->workbench = $workbench;
				$post->save();
				Cache::forget("post_$id");
			}
		} else {
			return "ERROR: Framework must be set to workbench";
		}
	}


	/**
	 * Show Post Create Form
	 */
	public function newPost()
	{
		// Controller Security
		if (!User::hasPermission('create')) return Response::denied();

		// Get all formats
		$formats = Format::allArray();

		// Get all types
		$types = Type::allArray();

		// Get all frameworks
		$frameworks = Framework::allArray();

		// Get all badges
		$badges = Badge::allArray();

		// Get all tags
		$tags = Tag::allArray();

		return View::make('edit.new', array(
			'formats' => $formats,
			'types' => $types,
			'frameworks' => $frameworks,
			'badges' => $badges,
			'tags' => $tags,
		));
	}


	/**
	 * Create new post
	 */
	public function createPost()
	{
		// Controller Security
		if (!User::hasPermission('create')) return Response::denied();

		// Get Pre-validated input
		$formatID = Input::get('format');
		$typeID = Input::get('type');
		$frameworkID = null;
		if ($typeID == Config::get('mrcore.app_type')) {
			$frameworkID = Input::get('framework');
		}
		$modeID = Mode::where('constant', '=', 'default')->first()->id;

		// Start new post
		$post = new Post;
		$post->uuid = Mrcore\Helpers\String::getGuid();
		$post->title = Input::get('title');
		$post->slug = Input::get('slug');
		$post->content = Mrcore\Crypt::encrypt('');
		$post->teaser = Mrcore\Crypt::encrypt('');
		$post->contains_script = false;
		$post->contains_html = false;
		$post->format_id = $formatID;
		$post->type_id = $typeID;
		$post->framework_id = $frameworkID;
		$post->mode_id = $modeID;
		$post->symlink = false;
		$post->shared = false;
		$post->hidden = false;
		$post->deleted = false;
		$post->indexed_at = '1900-01-01 00:00:00';
		$post->created_by = Auth::user()->id;
		$post->updated_by = Auth::user()->id;
		$post->save();

		// Create folder
		mkdir(Config::get('mrcore.files')."/index/$post->id");

		// Add route
		$route = new Router;
		$route->slug = Input::get('slug');
		$route->post_id = $post->id;
		$route->save();

		// Clear Posts Array Cache for Wiki FreeLinks
		Cache::forget("posts_array");

		// Updates badges and tags
		PostBadge::set($post->id, Input::get('badges'));
		PostTag::set($post->id, Input::get('tags'));

		// Redirect to full edit page
		return Redirect::route('edit', array('id' => $post->id));

	}

}