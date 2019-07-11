@if(session('success'))
	<div class = 'row'>
		<div class = "">
			<div class = "alert alert-success alert-dismissable" role="alert">
				<button type = "button" class = "close" data-dismiss="alert" aria-label="Close" >
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Success:</strong>
				{{ session('success') }}
			</div>
		</div>
	</div>
@endif

@if(session('failed'))
	<div class = 'row'>
		<div class = "">
			<div class = "alert alert-danger alert-dismissable" role="alert">
				<button type = "button" class = "close" data-dismiss="alert" aria-label="Close" >
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Failed:</strong>{{ session('failed' )}}
			</div>
		</div>
	</div>
@endif

@if(count($errors) > 0)
	<div class = 'row'>
		<div class = "">
			<div class = "alert alert-danger alert-dismissable" role="alert">
				<button type = "button" class = "close" data-dismiss="alert" aria-label="Close" >
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Error:</strong>
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
@endif