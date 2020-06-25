@if($errors->any())
	<div id="message_prompts" class="ui error message">
		<i id="message_prompts_close" class="close icon"></i>

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
<div id="message_prompts" class="ui success message">
		<i id="message_prompts_close" class="close icon"></i>

		<div class="header">{{ session('success') }}</div>
	</div>
@endif