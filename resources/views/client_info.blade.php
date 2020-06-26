@extends('layout')

@section('main_content')

<div class="sixteen wide column">
	<a href="{{ url()->previous() }}" class="ui blue button" style="float: right;">Back</a>
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
				$to_view_record = false;

				foreach($records as $record)
				{
					if($record->confidential_viewers->isNotEmpty())
					{
						foreach($record->confidential_viewers as $confidential_viewer)
						{
							if($confidential_viewer->user_id == Auth::user()->user_id)
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
							{{ $record->service->service }} (Date requested: {{ $record->toNiceDate('date_requested') }}, Action Taken Date: {{ $record->toNiceDate('action_taken_date') }})
						</div>

						<div class="content">
							<div class="transition hidden">
								<div class="ui buttons" style="float: right;">
									<a href="" class="ui mini yellow button">Edit</a>
									<a href="" class="ui mini red button">Remove</a>
								</div>


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
	$('.ui.accordion').accordion();
</script>
@endsection