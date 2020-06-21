@if($errors->any())
	<div class="ui error message message_prompts">
		<i class="close icon message_prompts_close"></i>

		<div class="header">
		There were errors in your input.
		</div>

		<ul class="list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@elseif(session('success') != null)
<div class="ui success message message_prompts">
		<i class="close icon message_prompts_close"></i>

		<div class="header">{{ session('success') }}</div>
	</div>
@endif