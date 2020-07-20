@extends('layout')

@section('main_content')

<div class="ui sixteen wide column">
	<table class="ui selectable striped celled center aligned table">
		<thead>
			<tr>
				<th>Date/Time</th>
				<th>Client</th>
				<th>Record</th>
				<th>User</th>
				<th>Description</th>
			</tr>
		</thead>

		<tbody>
			@foreach($logs as $log)
				@php
					if($log->record_id)
					{
						if($log->record->service_id == null)
							$service = '';
						else
							$service = $log->record->service->service;
					}

					else
						$service = '';
				@endphp

				<tr>
					<td>{{ date('F d, Y / h:i A', strtotime($log->created_at)) }}</td>
					<td><a class="client_link" href="{{ route('client', ['client' => $log->client_id]) }}">{{ $log->client->name }}</a></td>
					<td>{{ $service }}</td>
					<td>{{ $log->user->name }}</td>
					<td>{{ $log->action }}</td>
				</tr>
			@endforeach
		</tbody>

		@if($logs instanceof Illuminate\Pagination\LengthAwarePaginator)
			<tfoot>
				<tr>
					<th colspan="6">{{ $logs->links() }}</th>
				</tr>
			</tfoot>
		@endif
	</table>
</div>

@endsection

@section('custom_css')
<style>
	.client_link
	{
		color: black;
	}

	.client_link:hover
	{
		text-decoration: underline;
	}
</style>
@endsection