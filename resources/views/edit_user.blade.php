@extends('layout')

@section('main_content')

<div class="sixteen wide column">
	<a href="{{ route('users_dashboard') }}" class="ui blue button" style="float: right;">Back</a>
</div>

<form action="{{ url()->current() }}" method="POST" class="ui text_center segment eight wide column form {{ $errors->any() ? 'error' : 'success' }}">
	@csrf
	@method('PUT')

	@include('message_prompts')

	<div class="field {{ !$errors->has('name') ?: 'error' }}">
		<label>Name</label>
		<input type="text" name="name" value="{{ old('name') ? old('name') : $user->name }}">
	</div>

	<div class="field {{ !$errors->has('username') ?: 'error' }}">
		<label>Username</label>
		<input type="text" name="username" value="{{ old('username') ? old('username') : $user->username }}">
	</div>

	<div class="field {{ !$errors->has('password') ?: 'error' }}">
		<label>New Password</label>
		<input type="password" name="password">
	</div>

	<div class="field {{ !$errors->has('password_confirmation') ?: 'error' }}">
		<label>New Password Confirmation</label>
		<input type="password" name="password_confirmation">
	</div>

	@php
		if(old('admin_level') != null)
			$selected_admin_level = old('admin_level');
		else
			$selected_admin_level = $user->is_admin;

		if(old('admin_level') != null)
			$selected_confidential_accessor = old('confidential_accessor');
		else
			$selected_confidential_accessor = $user->is_confidential_accessor;
	@endphp

	<div class="field {{ !$errors->has('admin_level') ?: 'error' }}">
		<label>Admin Level</label>
		<select name="admin_level" v-model="admin_level">
			<option value=""></option>
			<option value="1" >Yes</option>
			<option value="0" >No</option>
		</select>
	</div>

	<div class="field {{ !$errors->has('confidential_accessor') ?: 'error' }}" v-if="admin_level == '0' && admin_level != ''">
		<label>Confidential Accessor</label>
		<select name="confidential_accessor">
			<option value="" {{ $selected_confidential_accessor == '' ? 'selected' : '' }}></option>
			<option value="1" {{ $selected_confidential_accessor == '1' ? 'selected' : '' }}>Yes</option>
			<option value="0" {{ $selected_confidential_accessor == '0' ? 'selected' : '' }}>No</option>
		</select>
	</div>

	<button type="submit" class="ui fluid inverted blue button">Edit User</button>
</form>

@endsection

@section('custom_js')

<script>
	const app = new Vue({
		el: '#main',

		data: {
			admin_level: {!! $selected_admin_level == '1' ? '"1"' : '"0"' !!},
		}
	});
</script>

@endsection