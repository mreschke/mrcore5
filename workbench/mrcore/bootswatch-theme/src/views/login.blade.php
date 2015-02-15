@extends('layout')

@section('title')
	{{ Layout::title() }}
@stop

@section('css')
	<style>
		.message {
			margin-top: 10px;
		}
	</style>
@stop

@section('content')

	{{ Form::open(array('route' => 'validateLogin')) }}

		<div class="row">

			<div class="col-sm-4 col-sm-offset-4">
				<div class="form-group">
					<div class="input-group">
						{{ Form::text('username', null, array(
							'id' => 'username',
							'type' => 'email',
							'class' => 'form-control',
							'placeholder' => 'Username/Email',
							'autofocus' => 'autofocus',
						)) }}
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
						{{ Form::password('password', array(
							'id' => 'password',
							'type' => 'password',
							'class' => 'form-control',
							'placeholder' => 'Password',
						)) }}
						<span class="input-group-addon">
							<i class="fa fa-lock"></i>
						</span>
				  </div>
				</div>

				{{
					HTML::decode(
						Form::button(
							'<i class="fa fa-unlock"></i> Sign In',
							array(
								'name' => 'btn-login',
								'id' => 'btn-login',
								'onclick' => 'form.submit()',
								'class' => 'btn btn-lg btn-primary btn-block'
							)
						)
					) 
				}}

				<div class="message text-danger">
					{{ Session::get('message') }}
				</div>
				
				{{ Form::hidden('referer', $referer, array('id' => 'referer')) }}

			</div>
		</div>

	{{ Form::close() }}
@stop
