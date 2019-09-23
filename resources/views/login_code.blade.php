@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card mx-auto mt-5" style="max-width: 25em;">
		<div class="card-header">Enter code</div>
		<div class="card-body">
			<form method="post">
				<input type="text" name="phone">
				<br><button type="submit">send</button>
			</form>
		</div>
	</div>
</div>
@endsection
