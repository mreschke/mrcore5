@section('user-menu')

	@if (User::isAuthenticated())
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				
				@if (User::isAuthenticated())
					<img class="navbar-user" src="{{ asset('uploads/'.Auth::user()->avatar) }}" alt="avatar" />
				@else
					Sign In
				@endif
				<b class="caret"></b>
			</a>

			<ul class="dropdown-menu">
				@if (User::hasPermission('create'))
					<li>
						<a href="{{ URL::route('new') }}">
							<!--<i class="fa fa-plus"></i>-->
							New Post
						</a>
					</li>
					<li class="divider"></li>
				@endif

				@if (User::isAdmin())
					<li class="dropdown-header">Administrator</li>
					<li>
						<a href="{{ URL::route('adminBadge') }}">
							<!--<i class="fa fa-lock"></i>-->
							Admin
						</a>
					</li>
					<li>
						<a href="{{ URL::route('router') }}">
							<!--<i class="fa fa-link"></i>-->
							Router
						</a>
					</li>
					<li class="divider"></li>
				@endif
				<li>
					<a href="{{ route('logout') }}">
						<!--<i class="fa fa-power-off"></i>-->
						Sign Out
					</a>
				</li>
			</ul>
		</li>
	@else
		<li>
			<a href="{{ route('login') }}">
				Sign In
			</a>
		</li>
	@endif


@stop