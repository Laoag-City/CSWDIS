@extends('layout')

@section('main_content')

@php
	if($record->service != null)
	{
		if(Auth::user()->is_admin || Auth::user()->is_confidential_accessor)
		{
			$selected_service = App\Service::find(old('service') ? old('service') : $record->service->service_id);

			if($selected_service && $selected_service->is_confidential)
				$selected_service_confidential = 'true';
			else
				$selected_service_confidential = 'false';
		}

		else
			$selected_service_confidential = 'false';

		$service_to_use = old('service') ? old('service') : $record->service->service_id;
	}

	else
	{
		$selected_service_confidential = 'false';
		$service_to_use = '';
	}
@endphp

<div class="sixteen wide column">
	<a href="{{ route('client', ['client' => $record->client]) }}" class="ui blue button" style="float: right;">Back</a>
</div>

<form id="edit_record_form" action="{{ url()->current() }}" method="POST" class="ui text_center sixteen wide column form {{ $errors->any() ? 'error' : 'success' }}">
	@csrf
	@method('PUT')

	@include('message_prompts')

	<div class="fields">
		<div class="three wide field"></div>

		<div class="ten wide field {{ !$errors->has('service') ?: 'error' }}">
			<label>Service</label>

			<select name="service" @change="checkIfSelectedServiceIsConfidential($event)">
				<option value="" {{ $service_to_use == '' ? 'selected' : '' }} data-confidential="false"></option>

				@foreach($services as $category => $services)
					<optgroup label="{{ $category }}">
						@foreach($services as $service)
							<option 
								value="{{ $service->service_id }}" 
								data-confidential="{{ $service->is_confidential ? true : false }}" 
								{{ $service_to_use == $service->service_id ? 'selected' : '' }}
							>
									{{ $service->service }} {{ $service->is_confidential ? '(confidential)' : '' }}
							</option>
						@endforeach
					</optgroup>
				@endforeach
			</select>
		</div>
	</div>

	<div class="ui centered grid" v-if="selected_service_confidential == true">
		<div class="ten wide column">
			<table class="ui selectable striped celled center aligned table">
				<thead>
					<tr>
						<th>Confidential Accessors</th>
						<th class="collapsing">Allow Access</th>
					</tr>
				</thead>

				<tbody>
					@foreach($confidential_accessors as $confidential_accessor)
						@php
							if(old('users'))
							{
								if(isset(old("users")[$loop->iteration]) && old("users")[$loop->iteration] == $confidential_accessor->user_id)
									$checked = 'checked';
								else
									$checked = '';
							}

							else
							{
								if($allowed_confidential_accessors->contains($confidential_accessor->user_id))
									$checked = 'checked';
								else
									$checked = '';
							}
						@endphp
						<tr>
							<td>{{ $confidential_accessor->name }}</td>
							<td class="collapsing">
								<input 
									type="checkbox" 
									name="users[{{ $loop->iteration }}]" 
									value="{{ $confidential_accessor->user_id }}" 
									{{ $checked }}
								>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<br>

	<div class="fields">
		<div class="eight wide field {{ !$errors->has('problem_presented') ?: 'error' }}">
			<label>Problem Presented</label>
			<textarea name="problem_presented" rows="5" maxlength="255" style="resize: none;">{{ old('problem_presented') ? old('problem_presented') : $record->problem_presented }}</textarea>
		</div>

		<div class="eight wide field {{ !$errors->has('initial_assessment') ?: 'error' }}">
			<label>Initial Assessment</label>
			<textarea name="initial_assessment" rows="5" maxlength="255" style="resize: none;">{{ old('initial_assessment') ? old('initial_assessment') : $record->initial_assessment }}</textarea>
		</div>
	</div>

	<div class="fields">
		<div class="eight wide field {{ !$errors->has('recommendation') ?: 'error' }}">
			<label>Recommendation</label>
			<textarea name="recommendation" rows="5" maxlength="255" style="resize: none;">{{ old('recommendation') ? old('recommendation') : $record->recommendation }}</textarea>
		</div>

		<div class="eight wide field {{ !$errors->has('action_taken') ?: 'error' }}">
			<label>Action Taken</label>
			<textarea name="action_taken" rows="5" maxlength="255" style="resize: none;">{{ old('action_taken') ? old('action_taken') : $record->action_taken }}</textarea>
		</div>
	</div>

	<div class="fields">
		<div class="four wide field"></div>

		<div class="four wide field {{ !$errors->has('date_requested') ?: 'error' }}">
			<label>Date Requested</label>
			<input type="date" name="date_requested" value="{{ old('date_requested') ? old('date_requested') : $record->date_requested }}">
		</div>

		<div class="four wide field {{ !$errors->has('action_taken_date') ?: 'error' }}">
			<label>Action Taken Date</label>
			<input type="date" name="action_taken_date" value="{{ old('action_taken_date') ? old('action_taken_date') : $record->action_taken_date }}">
		</div>
	</div>

	<br>

	<div class="field">
		<button type="submit" class="ui fluid inverted blue button">Edit Record</button>
	</div>
</form>

@endsection

@section('custom_js')
<script>
	const app = new Vue({
		el: '#edit_record_form',

		data: {
			selected_service_confidential: {!! $selected_service_confidential !!}
		},

		methods: {
			checkIfSelectedServiceIsConfidential(event)
			{
				if(event.target.selectedOptions[0].attributes['data-confidential'].value == true)
					this.selected_service_confidential = true;
				else
					this.selected_service_confidential = false;
			}
		},

		mounted(){

		}
	});
</script>
@endsection	