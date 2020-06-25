@extends('layout')

@section('main_content')

<form class="ui text_center sixteen wide column form" method="GET" action="{{ url()->current() }}">
	<div class="fields">
		<div class="four wide field"></div>

		<div class="eight wide field">
			<label>Search Client</label>
			<div class="ui action input">
				<input type="text" name="client">
				<button class="ui button">Search</button>
			</div>
		</div>
	</div>
</form>

@if(request()->client)
	<h3>Search result(s) for: {{ request()->client }}</h3>
@endif

<table class="ui selectable striped celled center aligned table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Phone Number</th>
			<th>Address</th>
			<th class="collapsing">Sex</th>
			<th class="collapsing">Date of Birth</th>
			<th class="collapsing"></th>
		</tr>
	</thead>

	<tbody>
		@foreach($clients as $client)
			<tr>
				<td>{{ $client->name }}</td>
				<td>{{ $client->phone_no }}</td>
				<td>{{ $client->address }}</td>
				<td>{{ $client->sex }}</td>
				<td>{{ $client->toNiceBirthday() }}</td>
				<td>
					<div class="ui compact menu">
						<div class="ui simple dropdown item">
							<i class="cogs icon"></i>
							<i class="dropdown icon"></i>
							<div class="menu">
								<a href="{{ url("clients/{$client->client_id}") }}" class="item">View</a>
								<a href="{{ url("clients/{$client->client_id}/edit") }}" class="item">Edit</a>
								@if(Auth::user()->is_admin)
									<a href="" class="item">Remove</a>
								@endif
							</div>
						</div>
					</div>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>


@endsection