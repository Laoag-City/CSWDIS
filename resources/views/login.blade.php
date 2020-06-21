@extends('layout')

@section('main_content')

<form action="{{ url()->current() }}" method="POST" class="ui text_center five wide column form {{ $errors->any() ? 'error' : 'success' }}">
		{{ csrf_field() }}

		@include('message_prompts')

		<div class="field {{ !$errors->has('username') ?: 'error' }}">
			<label>Username</label>
			<input type="text" name="username">
		</div>

		<div class="field {{ !$errors->has('password') ?: 'error' }}">
			<label>Username</label>
			<input type="password" name="password">
		</div>

		<br>

		<div class="field">
			<button type="submit" class="ui fluid inverted blue button">SIGN IN</button>
		</div>
	</form>

@endsection