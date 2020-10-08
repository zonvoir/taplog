@extends('layouts.app', ['page' => __('Edit Beat Plan'), 'pageSlug' => 'beatplan'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">Beat Plan Details</h4></div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{route('edit-beat-plan-action')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="id" value="{{$plan->id}}">
					<div class="row">
						<div class="col">
							<label for="site_id">Site Id</label>
							<input type="text" name="site_id" class="form-control" id="site_id" placeholder="Enter Site Id" value="{{$plan->site_id}}" required="">
						</div>
						<div class="col">
							<label for="site_name">Site Name</label>
							<input type="text" name="site_name" class="form-control" id="site_name" placeholder="Enter Site Name" value="{{$plan->site_name}}" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="site_type">Site Type</label>
							<input type="text" name="site_type" class="form-control" id="site_type" placeholder="Enter Site Type" value="{{$plan->site_type}}" required="">
						</div>
						<div class="col">
							<label for="plan_date">Date</label>
							<input type="date" name="plan_date" class="form-control" id="plan_date" placeholder="Enter Date" value="{{date('Y-m-d', strtotime($plan->plan_date))}}" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="maintenance_point">Maintenance Point</label>
							<input type="text" name="maintenance_point" class="form-control" id="maintenance_point" placeholder="Enter Maintenance Point" value="{{$plan->maintenance_point}}" required="">
						</div>
						<div class="col">
							<label for="beat_plan_ltr">Beat Plan(Ltr)</label>
							<input type="text" name="beat_plan_ltr" class="form-control" id="beat_plan_ltr" placeholder="Enter Beat Plan(Ltr)" value="{{$plan->beat_plan_ltr}}" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="technician_name">Technician Name</label>
							<input type="text" name="technician_name" class="form-control" id="technician_name" placeholder="Enter Technician Name" value="{{$plan->technician_name}}" required="">
						</div>
						<div class="col">
							<label for="technician_mobile">Tech Mob No.</label>
							<input type="text" name="technician_mobile" class="form-control" id="technician_mobile" placeholder="Enter Tech Mob No." value="{{$plan->technician_mobile}}" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="route_plan">Route Plan</label>
							<input type="text" name="route_plan" class="form-control" id="route_plan" placeholder="Enter Route Plan" value="{{$plan->route_plan}}" required="">
						</div>
						<div class="col">
							<label for="ro_name">RO Name</label>
							<input type="text" name="ro_name" class="form-control" id="ro_name" placeholder="Enter RO Name" value="{{$plan->ro_name}}" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="latitude">Latitude</label>
							<input type="text" name="latitude" class="form-control" id="latitude" placeholder="Enter Latitude" value="{{$plan->latitude}}" required="">
						</div>
						<div class="col">
							<div class="col">
								<label for="longitude">Longitude</label>
								<input type="text" name="longitude" class="form-control" id="longitude" placeholder="Enter Longitude" value="{{$plan->longitude}}" required="">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="driver_name">Driver Name</label>
							<input type="text" name="driver_name" class="form-control" id="driver_name" placeholder="Driver Name" value="{{$plan->driver_name}}" required="">
						</div>
						<div class="col">
							<div class="col">
								<label for="driver_mobile">Driver Mobile</label>
								<input type="text" name="driver_mobile" class="form-control" id="driver_mobile" placeholder="Driver Mobile" value="{{$plan->driver_mobile}}" required="">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="filler_name">Filler Name</label>
							<input type="text" name="filler_name" class="form-control" id="filler_name" placeholder="Filler Name" value="{{$plan->filler_name}}" required="">
						</div>
						<div class="col">
							<div class="col">
								<label for="filler_mobile">Filler Mobile</label>
								<input type="text" name="filler_mobile" class="form-control" id="filler_mobile" placeholder="Filler Mobile" value="{{$plan->driver_mobile}}" required="">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="vehicle_no">Vehicle No.</label>
							<input type="text" name="vehicle_no" class="form-control" id="vehicle_no" placeholder="Enter Vehicle No." value="{{$plan->vehicle_no}}" required="">
						</div>
						<div class="col">
							<div class="col">
								<label for="alloted_user_id">Alloted User Id</label>
								<input type="text" name="alloted_user_id" class="form-control" id="alloted_user_id" placeholder="Enter Alloted User Id" value="{{$plan->alloted_user_id}}" required="">
							</div>
						</div>
					</div>
					<input type="submit" value="Submit" class="btn btn-primary"/>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection


