@extends('layout')

@section('main_content')

<div class="sixteen wide column">
	<a href="{{ route('services_dashboard') }}" class="ui blue button" style="float: right;">Back</a>
</div>

<form action="{{ url()->current() }}" method="POST" class="ui text_center segment eight wide column form {{ $errors->any() ? 'error' : 'success' }}">
	@csrf
	@method('PUT')

	@include('message_prompts')

	@php
		if(old('category') != null)
			$selected_category = old('category');
		else
			$selected_category = $service->category->category_id;

		if(old('confidential_service') != null)
			$selected_confidential_service = old('confidential_service');
		else
			$selected_confidential_service = $service->is_confidential;
	@endphp
	<input type="hidden" name="new_category" v-model="category_field_new">

	<div class="field {{ !$errors->has('category') ?: 'error' }}">
		<label>Category</label>
		
		<div class="ui action input" v-if="category_field_new">
			<input type="text" name="category" value="{{ old('category') }}">
			<button type="button" class="ui button" @click="category_field_new = false">Switch to Existing Categories</button>
		</div>

		<div class="ui action input" v-if="!category_field_new">
			<select name="category">
				<option value="" {{ $selected_category == '' ? 'selected' : '' }}></option>

				@foreach($categories as $category)
					<option 
						value="{{ $category->category_id }}" {{ $selected_category == $category->category_id ? 'selected' : '' }}>
							{{ $category->category }}
					</option>
				@endforeach
			</select>
			<button type="button" class="ui button" @click="category_field_new = true">Switch to New Category</button>
		</div>
	</div>

	<div class="field {{ !$errors->has('service') ?: 'error' }}">
		<label>Service</label>
		<input type="text" name="service" value="{{ old('service') ? old('service') : $service->service }}">
	</div>

	<div class="field {{ !$errors->has('confidential_service') ?: 'error' }}">
		<label>Confidential Service</label>
		<select name="confidential_service">
			<option value="" {{ $selected_confidential_service == '' ? 'selected' : '' }}></option>
			<option value="1" {{ $selected_confidential_service == '1' ? 'selected' : '' }}>Yes</option>
			<option value="0" {{ $selected_confidential_service == '0' ? 'selected' : '' }}>No</option>
		</select>
	</div>

	<button type="submit" class="ui fluid inverted blue button">Edit Service</button>
</form>

@endsection

@section('custom_js')

<script>
	const app = new Vue({
		el: '#main',

		data: {
			category_field_new: {!! old('new_category') != null ? old('new_category') : 'false' !!}

		}
	});
</script>

@endsection