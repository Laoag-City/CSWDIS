@extends('layout')

@section('main_content')

<div id="list" class="sixteen wide column">
	<div class="ui basic modal">
		<div class="ui icon header">
			<i class="remove icon"></i>
			Delete Client?
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
									<a href="{{ route('client', ['client' => $client->client_id]) }}" class="item">View</a>
									<a href="{{ route('edit_client', ['client' => $client->client_id]) }}" class="item">Edit</a>
									@if(Auth::user()->is_admin)
										<a href="#"
											class="item"
											@click="openModal('{{ route('remove_client', ['client' => $client->client_id]) }}', '{{ $client->name }}')">
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

		@if($clients instanceof Illuminate\Pagination\LengthAwarePaginator)
			<tfoot>
				<tr>
					<th colspan="6">{{ $clients->links() }}</th>
				</tr>
			</tfoot>
		@endif
	</table>
</div>

@endsection

@section('custom_js')

	@if(Auth::user()->is_admin)
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
	@endif

@endsection