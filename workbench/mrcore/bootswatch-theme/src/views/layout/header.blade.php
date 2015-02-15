@include('layout.menu.user')
@include('layout.menu.post')
@include('layout.menu.search')

@section('style')

	<!-- Header CSS -->
	<style>
		.header {

		}
		.navbar-user {
			width: 40px;
			margin: -15px 0px -12px 0px;
			border: 2px solid #eeeeee;
			border-radius: 4px;
		}
		.navbar {
			border-radius: 0px;
			min-height: 60px;
			margin-bottom: 0px;
		}
		.navbar-nav li a, .navbar-nav li a:hover {
			padding-top: 19.5px;
			padding-bottom: 19.5px;
		}
		.navbar-brand {
			padding: 18.5px 15px 20.5px;
		}
		.navbar .dropdown-menu li a {
			padding: 3px 20px;
		}
		.navbar-toggle {
			margin-top: 12px;
		}
		.yamm .yamm-content {
			padding: 15px 15px 0px 15px;
		}
	</style>
	@parent

@stop



@section('header')

	<!-- Layout Header -->
	<div class="header">
		<header class="navbar navbar-default yamm" id="top">
			<div class="{{ $container }}">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a href="{{ URL::route('home') }}" class="navbar-brand">
						{{ Config::get('mrcore.logo_text') }}
					</a>
				</div>
				<div class="navbar-collapse collapse navbar-responsive-collapse">
					<ul class="nav navbar-nav">
						{{-- Add your custom left side header menus and items here --}}

					</ul>
					<ul class="nav navbar-nav navbar-right">
						{{-- Add your custom right side header menus and items here --}}
						@yield('search-menu')

						@yield('post-menu')

						@yield('user-menu')

					</ul>
				</div>
			</div>
		</header>
	</div>

@stop