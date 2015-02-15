@extends('admin.layout')


@section('title')
	Users
@stop


@section('css')
<style>
</style>
@stop

@section('admin-content')
	
	<h1>User Management</h1>

	{{-- Render::datatables('userTable', $userTable); --}}

@stop


@section('script')
<script>
//$(document).bind('keyup', '/', function() {
	//$('#search').focus();
//});
</script>
@stop