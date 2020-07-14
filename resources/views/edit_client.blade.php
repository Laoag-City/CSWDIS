@extends('layout')

@section('main_content')

<div class="sixteen wide column">
	<a href="{{ route('client', ['client' => $client->client_id]) }}" class="ui blue button" style="float: right;">Back</a>
</div>

<form action="{{ url()->current() }}" method="POST" class="ui text_center sixteen wide column form {{ $errors->any() ? 'error' : 'success' }}">
	@csrf
	@method('PUT')

	@include('message_prompts')

	<div class="fields">
		<div class="ten wide field ui search {{ !$errors->has('name') ?: 'error' }}">
			<label>Name</label>
			<input id="client_name" type="text" name="name" class="prompt" value="{{ old('name') ? old('name') : $client->name }}">

			<div class="results" style="width: 100%; text-align: center;"></div>
		</div>

		<div class="six wide field {{ !$errors->has('phone_no') ?: 'error' }}">
			<label>Phone No.</label>
			<input type="text" name="phone_no" value="{{ old('phone_no') ? old('phone_no') : $client->phone_no }}">
		</div>
	</div>

	<div class="fields">
		<div class="ten wide field {{ !$errors->has('address') ?: 'error' }}">
			<label>Address</label>
			<input type="text" name="address" value="{{ old('address') ? old('address') : $client->address }}">
		</div>

		@php
			if(old('sex'))
				$selected_sex = old('sex');
			else
				$selected_sex = $client->sex;
		@endphp

		<div class="two wide field {{ !$errors->has('sex') ?: 'error' }}">
			<label>Sex</label>
			<select name="sex">
				<option value="" {{ $selected_sex == '' ? 'selected' : '' }}></option>
				<option value="M" {{ $selected_sex == 'M' ? 'selected' : '' }}>Male</option>
				<option value="F" {{ $selected_sex == 'F' ? 'selected' : '' }}>Female</option>
			</select>
		</div>

		<div class="four wide field {{ !$errors->has('date_of_birth') ?: 'error' }}">
			<label>Date of Birth</label>
			<input type="date" name="date_of_birth" value="{{ old('date_of_birth') ? old('date_of_birth') : $client->date_of_birth }}">
		</div>
	</div>

	<div class="field">
		<button type="submit" class="ui fluid inverted blue button">Update Client Info</button>
	</div>
</form>

@endsection