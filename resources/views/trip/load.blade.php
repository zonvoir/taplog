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
				<form id="load-form" action="{{route('load-sites')}}" method="GET" enctype="multipart/form-data">
					
					<div class="row">
						<div class="col">
							<label for="current_date">Date</label>
							<input type="text" name="current_date" class="form-control" id="current_date" placeholder="Enter Date" required="" value="{{date('d-m-Y')}}" readonly="">
						</div>
						<div class="col">
							<label for="effective_date">Beat Plan Date & Client Code</label>
							<input type="hidden" name="effective_date_load" id="effective_date123" />
							<input type="text" id="effective_date_load" name="" value="{{ $beat_date }}" class="typeahead form-control"  placeholder="Proposed date Ex. dd-mm-yyyy"  required="">
						</div>
						
					</div>
					<!--div class="row">
						<div class="col">
							<label for="mode">Trip ID</label>
							<input type="text" id="trip_id" name="trip_id" class="form-control"  placeholder="Enter Trip ID" value="{{ $trip_id }}" required="">
						</div>
						<div class="col">
							<label for="vehicale_number">Vehicle Number</label>
							<input type="hidden" name="vehicle_id">
							<input type="text" name="vehicle_number" class="form-control" placeholder="Enter Vehicle Number" readonly="" required="">
						</div>
					</div-->
					<div class="row">
						<div class="col">
							<input type="submit" class="btn btn-primary" value="Search">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
@endsection