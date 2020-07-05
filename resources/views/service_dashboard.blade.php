@extends('layout')

@section('main_content')

<div class="six wide column">
	<form class="ui form {{ $errors->any() ? 'error' : 'success' }}" method="POST" action="{{ route('new_service') }}">
		@csrf

		@include('message_prompts')

		<div class="field {{ !$errors->has('name') ?: 'error' }}">
			<label>next here</label>
			<input type="text" name="name" value="{{ old('name') }}">
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

		<button type="submit" class="ui fluid inverted blue button">Add User</button>
	</form>
</div>

<div id="list" class="ten wide column">
	<div class="ui basic modal">
		<div class="ui icon header">
			<i class="remove icon"></i>
			Delete User?
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
										@click="openModal('{{ route('remove_service', ['service' => $service->service_id]) }}', '{{ $service->name }}')">
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

@endsection

@section('custom_js')

<script>
	const app = new Vue({
		el: '#list',

		data: {
			form_action: '',
			delete_name: ''

		},

		methods: {
			openModal: function(url, name){
				this.form_action = url;
				this.delete_name = name;
				$('.ui.basic.modal').modal('show');
			},

			closeModal: function(){
				this.form_action = '';
				this.delete_name = '';
				$('.ui.basic.modal').modal('hide');
			}
		}
	});
</script>

@endsection