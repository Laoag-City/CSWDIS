@extends('layout')

@section('main_content')

<div class="ui basic modal">
	<div class="ui icon header">
		<i class="remove icon"></i>
		Delete @{{ delete_title }}?
	</div>

	<div class="content">
		<p>Are you sure you want to delete record @{{ delete_name }}?</p>
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

<div class="sixteen wide column">
	<div class="ui buttons" style="float: right;">
		<a href="{{ route('edit_client', ['client' => $client->client_id]) }}" class="ui yellow button">Edit</a>
		@if(Auth::user()->is_admin)
			<a href="#"
				class="ui red button"
				@click="openModal('{{ route('remove_client', ['client' => $client->client_id]) }}', '{{ $client->name }}', 'Client')">
				Remove
			</a>
		@endif
		<a href="{{ route('client_list') }}" class="ui blue button">Back</a>
	</div>
</div>

<div class="row">
	<div class="ten wide column">
		<h3>
			Name:
			<i>{{ $client->name }}</i>
		</h3>
	</div>

	<div class="six wide column">
		<h3>
			Phone No.:
			<i>{{ $client->phone_no }}</i>
		</h3>
	</div>
</div>

<div class="row">
	<div class="ten wide column">
		<h3>
			Address:
			<i>{{ $client->address }}</i>
		</h3>
	</div>

	<div class="six wide column">
		<h3>
			Sex:
			<i>{{ $client->sex }}</i>
		</h3>
	</div>
</div>

<div class="row">
	<div class="sixteen wide column">
		<h3>
			Date of Birth:
			<i>{{ $client->toNiceBirthday() }}</i>
		</h3>
	</div>
</div>

<div class="row">
	<div class="sixteen wide column">
		<h2>Records</h2>
	</div>
</div>

<div class="row">
	<div class="sixteen wide column">
		<div class="ui styled fluid accordion">
			<?php
				foreach($records as $record)
				{
					$to_view_record = false;

					if($record->confidential_viewers->isNotEmpty())
					{
						foreach($record->confidential_viewers as $confidential_viewer)
						{
							if($confidential_viewer->user_id == Auth::user()->user_id || Auth::user()->is_admin)
							{
								$to_view_record = true;
								break;
							}
						}
					}

					else
						$to_view_record = true;

					if($to_view_record)
					{?>
						<div class="title">
							<i class="dropdown icon"></i>
							{{ $record->service ? $record->service->service : '' }} (Date requested: {{ $record->toNiceDate('date_requested') }}, Action Taken Date: {{ $record->toNiceDate('action_taken_date') }})
						</div>

						<div class="content">
							<div class="transition hidden">
								<div class="ui buttons" style="float: right;">
									<a href="{{ route('edit_record', ['record' => $record->record_id]) }}" class="ui yellow button">Edit</a>
									@if(Auth::user()->is_admin)
										<a href="#"
											class="ui red button"
											@click="openModal('{{ route('remove_record', ['record' => $record->record_id]) }}', '{{ $record->service ? $record->service->service : '' }} (Date requested: {{ $record->toNiceDate('date_requested') }}, Action Taken Date: {{ $record->toNiceDate('action_taken_date') }})', 'Record')">
											Remove
										</a>
									@endif
								</div>

								@if($record->confidential_viewers->isNotEmpty())
									<p>
										<b>Personnel In Charge:</b> 
										@foreach($record->confidential_viewers as $viewer)
											<span>{{ $loop->last ? $viewer->user->username : "{$viewer->user->username}, " }}</span>
										@endforeach
									</p>
								@endif

								<p>
									<b>Problem Presented:</b> {{ $record->problem_presented }}
								</p>

								<p>
									<b>Initial Assessment:</b> {{ $record->initial_assessment }}
								</p>

								<p>
									<b>Recommendation: </b>{{ $record->recommendation }}
								</p>

								<p>
									<b>Action Taken:</b> {{ $record->action_taken }}
								</p>
							</div>
						</div>
					<?php }
				}
			?>
		</div>
	</div>
</div>

@endsection

@section('custom_js')
<script>
	const app = new Vue({
		el: '#main',

		data: {
			form_action: '',
			delete_name: '',
			delete_title: ''

		},

		methods: {
			openModal: function(url, name, title){
				this.form_action = url;
				this.delete_name = name;
				this.delete_title = title;
				$('.ui.basic.modal').modal('show');
			},

			closeModal: function(){
				this.form_action = '';
				this.delete_name = '';
				this.delete_title = '';
				$('.ui.basic.modal').modal('hide');
			}
		}
	});

	$('.ui.accordion').accordion();
</script>
@endsection