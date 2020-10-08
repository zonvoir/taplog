@extends('layouts.app', ['page' => __('Load Verification'), 'pageSlug' => 'trip'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">Load Verification</h4></div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{route('load-sites-verify')}}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="unique_trip_id" value="{{$unique_tripid}}">
					<input type="hidden" name="beatplan_id" value="{{$trips->beatplan_id}}">
					<input type="hidden" name="trip_id" value="{{$trips->id}}">
					@csrf
					@if(isset($trips->trip_data) &!empty($trips->trip_data))
					@foreach($trips->trip_data as $site)
					@if($site->status != 'loaded')
					<div class="row">
						<input type="hidden" name="trip_data_id[]" value="{{$site->id}}">
						<div class="col">
							<label for="site_id">Site ID</label>
							<input type="text" class="form-control" id="site_id" placeholder="Enter Site Id" required="" value="{{$site->site->site_id}}" readonly="">
						</div>
						<div class="col">
							<label for="site_name">Site Name</label>
							<input type="text" class="form-control" id="site_name" placeholder="Enter Site Name" required="" value="{{$site->site->site_name}}" readonly="">
						</div>
						
						<div class="col">
							<label for="quantity">Quantity</label>
							<input type="text" class="form-control" id="quantity" placeholder="Enter Site Quantity" required="" value="{{$trips->getQuantity($trips->effective_date,$site->site->id)->quantity??''}}" readonly="">
						</div>
						<div class="col">
							<label for="loading_done">Loading Done</label>
							<select name="loading_done[]" class="form-control" required>
								<option value="unloaded">No</option>
								<option value="loaded">Yes</option>
							</select>
						</div>
					</div>
					<input type="hidden" name="sites[]" value="{{$site->site->id}}">
					<input type="hidden" name="auto_trip_id[]" value="{{$trips->id}}">
					@endif
					@endforeach
					@endif
					<input type="submit" class="btn btn-primary" value="Verify">
				</form>
			</div>
		</div>
	</div>
</div>
</div>
@endsection