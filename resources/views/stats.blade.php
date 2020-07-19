@extends('layout')

@section('main_content')

<div class="twelve wide column">
	<div class="ui center aligned segment">
		<h3>Total males: {{ $males }}</h3>
		<h3>Total females: {{ $females }}</h3>
		<h3>Total clients: {{ $all }}</h3>
		<h3>Total records this month: {{ $total_records_this_month }}</h3>
		<h3 class="ui header left aligned">Total per record:</h3>

		<ul style="text-align: left;">
			@foreach($records_by_service as $key => $record)
				@if($record->first()->service != null)
					@if($record->first()->service->is_confidential && (Auth::user()->is_admin || Auth::user()->is_confidential_accessor))
						<li style="margin-bottom: 10px;"><h3>{{ $key }}: {{ $record->count() }}</h3></li>
					@elseif(!$record->first()->service->is_confidential)
						<li style="margin-bottom: 10px;"><h3>{{ $key }}: {{ $record->count() }}</h3></li>
					@else
						@continue
					@endif
				@else
					<li style="margin-bottom: 10px;"><h3><i>Removed/deleted Services</i>: {{ $record->count() }}</h3></li>
				@endif
			@endforeach
		</ul>
	</div>
</div>

@endsection