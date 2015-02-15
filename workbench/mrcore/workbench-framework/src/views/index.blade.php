@extends('workbench-framework::layout')


@section('wb-menu')

	<h1>Welcome</h1>
	<center>
		<img class="workbench-image" src="{{{ Workbench::asset('images/workbench.png') }}}" />
	</center>

	<h2>Get Ready!</h2>
	<p>You have just successfully created a mRcore Workbench powerhouse!</p>

	<p>With a mRcore workbench you can create the most amazing, efficient and infinitely powerful
	wiki applications, with all the comforts and mind numbing awesomeness of Laravel 4!</p>

	<p>mRcore workbenches are esseitnally Laravel 4 workbenches wrapped up and integrated into the mRcore stack!
	This means you can take advantage of <a href="http://laravel.com/docs" target="_blank">Laravel's awesome documentation</a>.</p>


	To see all mRcore specific documentation please visit <a href="http://mrcore.mreschke.com" target="_blank">http://mrcore.mreschke.com</a>!

@stop


@section('wb-content')

	<h1>mRcore/Laravel Workbench</h1>

	This is a live Lifecycle dump so you can see the order in which this workbench is registered and booted. 
	The power of the workbench is the order in which they are instantiated within mRcore itself.  Because these
	workbenches are booted early in the Laravel bootstrap you have all the power!  At this point, you control mRcore!

	{{ \Lifecycle::dump() }}
	
@stop
