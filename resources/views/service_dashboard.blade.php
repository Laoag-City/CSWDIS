@extends('layout')

@section('main_content')

<div class="ui basic modal">
	<div class="ui icon header">
		<i class="remove icon"></i>
		Delete @{{ modal_title }}?
	</div>

	<div class="content">
		<p>Are you sure you want to delete @{{ delete_name }}?</p>
	</div>

	<form method="POST" :action="form_action" class="actions">
		@csrf
		@method('DELETE')
		
		<div class="ui grey basic cancel inverted button" @click="closeModal">
			<i class="remove icon"></i>
			No
		</div>
		<button type="submit" class="ui red ok inverted button">
			<i class="checkmark icon"></i>
			Yes
		</button>
	</form>
</div>

<div class="row">
	<div class="ten wide column">
		<h3 style="text-align: center">New Service</h3>

		<form class="ui form {{ $errors->any() ? 'error' : 'success' }}" method="POST" action="{{ route('new_service') }}">
			@csrf

			@include('message_prompts')

			<input type="hidden" name="new_category" v-model="category_field_new">

			<div class="field {{ !$errors->has('category') ?: 'error' }}">
				<label>Category</label>
				
				<div class="ui action input" v-if="category_field_new">
					<input type="text" name="category" value="{{ old('category') }}">
					<button type="button" class="ui mini button" @click="category_field_new = false">Switch to Existing Categories</button>
				</div>

				<div class="ui action input" v-if="!category_field_new">
					<select name="category">
						<option value="" {{ old('category') == '' ? 'selected' : '' }}></option>

						@foreach($categories as $category)
							<option 
								value="{{ $category->category_id }}" {{ old('category') == $category->category_id ? 'selected' : '' }}>
									{{ $category->category }}
							</option>
						@endforeach
					</select>
					<button type="button" class="ui mini button" @click="category_field_new = true">Switch to New Category</button>
				</div>
			</div>

			<div class="field {{ !$errors->has('service') ?: 'error' }}">
				<label>Service</label>
				<input type="text" name="service" value="{{ old('service') }}">
			</div>

			<div class="field {{ !$errors->has('confidential_service') ?: 'error' }}">
				<label>Confidential Service</label>
				<select name="confidential_service">
					<option value="" {{ old('confidential_service') == '' ? 'selected' : '' }}></option>
					<option value="1" {{ old('confidential_service') == '1' ? 'selected' : '' }}>Yes</option>
					<option value="0" {{ old('confidential_service') == '0' ? 'selected' : '' }}>No</option>
				</select>
			</div>

			<button type="submit" class="ui fluid inverted blue button">Add Service</button>
		</form>
	</div>
</div>

<div class="row" style="margin-top: 25px;">
	<div class="sixteen wide column">
		<h3 style="text-align: center">Service List</h3>

		<table class="ui selectable striped celled center aligned table">
			<thead>
				<tr>
					<th>Service</th>
					<th>Category</th>
					<th class="collapsing">Confidential</th>
					<th class="collapsing"></th>
				</tr>
			</thead>

			<tbody>
				@foreach($services as $service)
					<tr>
						<td>{{ $service->service }}</td>
						<td>{{ $service->category->category }}</td>
						<td>{{ $service->is_confidential ? 'Yes' : 'No' }}</td>
						<td>
							<div class="ui mini compact menu">
								<div class="ui simple dropdown item">
									<i class="cogs icon"></i>
									<i class="dropdown icon"></i>
									<div class="menu">
										<a href="{{ route('edit_service', ['service' => $service->service_id]) }}" class="item">Edit</a>
										<a href="#"
											class="item"
											@click="openModal('{{ route('remove_service', ['service' => $service->service_id]) }}', '{{ $service->service }}', 'Service')">
											Remove
										</a>
									</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<div class="row" style="margin-top: 25px;">
	<div class="sixteen wide column">
		<h3 style="text-align: center">Category List</h3>

		<table class="ui selectable striped celled center aligned table" style="margin-bottom: 50px;">
			<thead>
				<tr>
					<th>Category</th>
					<th class="collapsing"></th>
				</tr>
			</thead>

			<tbody>
				@foreach($categories as $category)
					<tr>
						<td>{{ $category->category }}</td>
						<td>
							<div class="ui mini compact menu">
								<div class="ui simple dropdown item">
									<i class="cogs icon"></i>
									<i class="dropdown icon"></i>
									<div class="menu">
										<a href="{{ route('edit_category', ['category' => $category->category_id]) }}" class="item">Edit</a>
										<a href="#"
											class="item"
											@click="openModal('{{ route('remove_category', ['category' => $category->category_id]) }}', '{{ $category->category }}', 'Category')">
											Remove
										</a>
									</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection

@section('custom_js')

<script>
	const app = new Vue({
		el: '#main',

		data: {
			modal_title: '',
			form_action: '',
			delete_name: '',
			category_field_new: false

		},

		methods: {
			openModal: function(url, name, title){
				this.modal_title = title;
				this.form_action = url;
				this.delete_name = name;
				$('.ui.basic.modal').modal('show');
			},

			closeModal: function(){
				this.modal_title = '';
				this.form_action = '';
				this.delete_name = '';
				$('.ui.basic.modal').modal('hide');
			}
		}
	});
</script>

@endsection