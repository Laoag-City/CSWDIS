@extends('layout')

@section('main_content')

<form action="{{ url()->current() }}" method="POST" class="ui text_center sixteen wide column form {{ $errors->any() ? 'error' : 'success' }}">
		{{ csrf_field() }}

		@include('message_prompts')

		<div class="fields">
			<div class="four wide field {{ !$errors->has('first_name') ?: 'error' }}">
				<label>First Name</label>
				<input type="text" name="first_name">
			</div>

			<div class="four wide field {{ !$errors->has('last_name') ?: 'error' }}">
				<label>Last Name</label>
				<input type="text" name="last_name">
			</div>
		</div>

		<div class="fields">
			<div class="four wide field {{ !$errors->has('first_name') ?: 'error' }}">
				<label>First Name</label>
				<input type="text" name="first_name">
			</div>

			<div class="four wide field {{ !$errors->has('last_name') ?: 'error' }}">
				<label>Last Name</label>
				<input type="text" name="last_name">
			</div>
		</div>

		<br>

		<div class="field">
			<button type="submit" class="ui fluid inverted blue button">Add Record</button>
		</div>
	</form>

@endsection