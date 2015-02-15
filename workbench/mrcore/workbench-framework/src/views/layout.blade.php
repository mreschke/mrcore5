@extends('layout.workbench')


@section('css')
	@parent
	<link href="{{ Workbench::asset('css/master.css') }}" rel="stylesheet">
	<style>
	</style>
@stop


@section('content')
	@parent

	<div class="row">
		<div class="wb-menu col-sm-3">
			@yield('wb-menu')
		</div>

		<div class="wb-content col-sm-9">
			@yield('wb-content')
		</div>
	</div>

@stop


@section('script')
	@parent
	<script src="{{ Workbench::asset('js/master.js') }}"></script>
	<script>
		$(function() {
			console.log('hello world!');
		});
	</script>
@stop
