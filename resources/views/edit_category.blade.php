@extends('layout')

@section('main_content')

<div class="sixteen wide column">
	<a href="{{ route('services_dashboard') }}" class="ui blue button" style="float: right;">Back</a>
</div>

<form action="{{ url()->current() }}" method="POST" class="ui text_center segment eight wide column form {{ $errors->any() ? 'error' : 'success' }}">
	@csrf
	@method('PUT')

	@include('message_prompts')

	<div class="field {{ !$errors->has('category') ?: 'error' }}">
		<label>Category</label>
		<input type="text" name="category" value="{{ old('category') ? old('category') : $category->category }}">
	</div>

	<button type="submit" class="ui fluid inverted blue button">Edit Service</button>
</form>

@endsection