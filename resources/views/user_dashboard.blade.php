@extends('layout')

@section('main_content')

<div class="six wide column">
	<h3 style="text-align: center">New User</h3>

	<form class="ui form {{ $errors->any() ? 'error' : 'success' }}" method="POST" action="{{ route('new_user') }}">
		@csrf

		@include('message_prompts')

		<div class="field {{ !$errors->has('name') ?: 'error' }}">
			<label>Name</label>
			<input type="text" name="name" value="{{ old('name') }}">
		</div>

		<div class="field {{ !$errors->has('username') ?: 'error' }}">
			<label>Username</label>
			<input type="text" name="username" value="{{ old('username') }}">
		</div>

		<div class="field {{ !$errors->has('password') ?: 'error' }}">
			<label>Password</label>
			<input type="password" name="password">
		</div>

		<div class="field {{ !$errors->has('password_confirmation') ?: 'error' }}">
			<label>Password Confirmation</label>
			<input type="password" name="password_confirmation">
		</div>

		<div class="field {{ !$errors->has('admin_level') ?: 'error' }}">
			<label>Admin Level</label>
			<select name="admin_level">
				<option value="" {{ old('admin_level') == '' ? 'selected' : '' }}></option>
				<option value="1" {{ old('admin_level') == '1' ? 'selected' : '' }}>Yes</option>
				<option value="0" {{ old('admin_level') == '0' ? 'selected' : '' }}>No</option>
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

	<h3 style="text-align: center">User List</h3>

	<table class="ui selectable striped celled center aligned table" style="margin-bottom: 50px;">
		<thead>
			<tr>
				<th>Name</th>
				<th>Username</th>
				<th class="collapsing">Admin</th>
				<th class="collapsing"></th>
			</tr>
		</thead>

		<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->name }}</td>
					<td>{{ $user->username }}</td>
					<td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
					<td>
						<div class="ui mini compact menu">
							<div class="ui simple dropdown item">
								<i class="cogs icon"></i>
								<i class="dropdown icon"></i>
								<div class="menu">
									<a href="{{ route('edit_user', ['user' => $user->user_id]) }}" class="item">Edit</a>
									@if($user->user_id != Auth::user()->user_id)
										<a href="#"
											class="item"
											@click="openModal('{{ route('remove_user', ['user' => $user->user_id]) }}', '{{ $user->name }}')">
											Remove
										</a>
									@endif
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