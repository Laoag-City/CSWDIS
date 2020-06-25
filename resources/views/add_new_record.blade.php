@extends('layout')

@section('main_content')

<form id="new_record_form" action="{{ url()->current() }}" method="POST" class="ui text_center sixteen wide column form {{ $errors->any() ? 'error' : 'success' }}">
	@csrf

	@include('message_prompts')

	<input type="hidden" name="client_id" value="{{ old('client_id') }}">

	<div class="fields">
		<div class="ten wide field {{ !$errors->has('name') ?: 'error' }}">
			<label>Name</label>
			<input type="text" name="name" value="{{ old('name') }}">
		</div>

		<div class="six wide field {{ !$errors->has('phone_no') ?: 'error' }}">
			<label>Phone No.</label>
			<input type="text" name="phone_no" value="{{ old('phone_no') }}">
		</div>
	</div>

	<div class="fields">
		<div class="eight wide field {{ !$errors->has('address') ?: 'error' }}">
			<label>Address</label>
			<input type="text" name="address" value="{{ old('address') }}">
		</div>

		<div class="two wide field {{ !$errors->has('sex') ?: 'error' }}">
			<label>Sex</label>
			<select name="sex">
				<option value="" {{ old('sex') == '' ? 'selected' : '' }}></option>
				<option value="M" {{ old('sex') == 'M' ? 'selected' : '' }}>Male</option>
				<option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>Female</option>
			</select>
		</div>

		<div class="two wide field {{ !$errors->has('age') ?: 'error' }}">
			<label>Age</label>
			<input type="number" name="age" value="{{ old('age') }}">
		</div>

		<div class="four wide field {{ !$errors->has('date_of_birth') ?: 'error' }}">
			<label>Date of Birth</label>
			<input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
		</div>
	</div>

	<div class="fields">
		<div class="three wide field"></div>

		<div class="ten wide field {{ !$errors->has('service') ?: 'error' }}">
			<label>Service</label>

			<select name="service" @change="checkIfSelectedServiceIsConfidential($event)">
				<option value="" {{ old('service') == '' ? 'selected' : '' }} data-confidential="false"></option>

				@foreach($services as $category => $services)
					<optgroup label="{{ $category }}">
						@foreach($services as $service)
							<option 
								value="{{ $service->service_id }}" 
								data-confidential="{{ $service->is_confidential ? true : false }}" 
								{{ old('service') == $service->service_id ? 'selected' : '' }}
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
						<th>Admins</th>
						<th class="collapsing">Allow Access</th>
					</tr>
				</thead>

				<tbody>
					@foreach($admins as $admin)
						<tr>
							<td>{{ $admin->name }}</td>
							<td class="collapsing">
								<input 
									type="checkbox" 
									name="users[{{ $loop->iteration }}]" 
									value="{{ $admin->user_id }}" 
									{{ old("users[{$loop->iteration}]" == $admin->user_id ? 'checked' : '') }}
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
			<textarea name="problem_presented" rows="5" maxlength="255" style="resize: none;">{{ old('problem_presented') }}</textarea>
		</div>

		<div class="eight wide field {{ !$errors->has('initial_assessment') ?: 'error' }}">
			<label>Initial Assessment</label>
			<textarea name="initial_assessment" rows="5" maxlength="255" style="resize: none;">{{ old('initial_assessment') }}</textarea>
		</div>
	</div>

	<div class="fields">
		<div class="eight wide field {{ !$errors->has('recommendation') ?: 'error' }}">
			<label>Recommendation</label>
			<textarea name="recommendation" rows="5" maxlength="255" style="resize: none;">{{ old('recommendation') }}</textarea>
		</div>

		<div class="eight wide field {{ !$errors->has('action_taken') ?: 'error' }}">
			<label>Action Taken</label>
			<textarea name="action_taken" rows="5" maxlength="255" style="resize: none;">{{ old('action_taken') }}</textarea>
		</div>
	</div>

	<div class="fields">
		<div class="four wide field"></div>

		<div class="four wide field {{ !$errors->has('date_requested') ?: 'error' }}">
			<label>Date Requested</label>
			<input type="date" name="date_requested" value="{{ old('date_requested') }}">
		</div>

		<div class="four wide field {{ !$errors->has('action_taken_date') ?: 'error' }}">
			<label>Action Taken Date</label>
			<input type="date" name="action_taken_date" value="{{ old('action_taken_date') }}">
		</div>
	</div>

	<br>

	<div class="field">
		<button type="submit" class="ui fluid inverted blue button">Add Record</button>
	</div>
</form>

@endsection

@section('custom_js')
<script>
	const app = new Vue({
		el: '#new_record_form',

		data: {
			selected_service_confidential: {!! $selected_service_is_confidential !!}
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