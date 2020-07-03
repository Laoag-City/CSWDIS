@extends('layout')

@section('main_content')

<div class="six wide column">
	
</div>

<div class="ten wide column">
	<h3 style="text-align: center">User List</h3>

	<table class="ui selectable striped celled center aligned table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Username</th>
				<th>Admin</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->name }}</td>
					<td>{{ $user->username }}</td>
					<td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
					<td>
						
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection