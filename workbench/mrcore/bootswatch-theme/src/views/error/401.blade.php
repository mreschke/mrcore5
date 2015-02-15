@extends('layout')

@section('title')
	Access Denied
@stop

@section('titlebar-title')
	<i class="icon-lock"></i>
	Access Denied
@stop

@section('content')

<div class="error-container">
	<div class="well">
		<h1 class="grey lighter smaller">
			<span class="blue bigger-125">
				<i class="icon-sitemap"></i>
				401 
			</span>
			Unauthorized
		</h1>

		<hr />
		<h3 class="lighter smaller">Access denied to requested url /{{ Request::path() }}</h3>

		<div>
			<div class="space"></div>
			<h4 class="smaller">Try one of the following:</h4>

			<ul class="list-unstyled spaced inline bigger-110 margin-15">
				<li>
					<i class="icon-hand-right blue"></i>
					Sign in as an authorized user
				</li>
				<li>
					<i class="icon-hand-right blue"></i>
					Re-check the url for typos
				</li>

				<li>
					<i class="icon-hand-right blue"></i>
					Use the search box to find the document
				</li>
			</ul>
		</div>

		<hr />
		<div class="space"></div>

		<div class="center">
			<a href="javascript:window.history.back()" class="btn btn-grey">
				<i class="icon-arrow-left"></i>
				Go Back
			</a>

			<a href="{{ URL::route('home') }}" class="btn btn-primary">
				<i class="icon-home"></i>
				Go Home
			</a>
		</div>
	</div>
</div>

@stop