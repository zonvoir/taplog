@extends('layouts.app', ['page' => __('Vehicle Trip Data'), 'pageSlug' => 'TripData'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">Trip Data</h4></div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="site-id-table" class="display " style="width:100%">
						<thead>
							<th scope="col">Trip Id</th>
							<th scope="col">Site ID</th>
							<th scope="col">Site Name</th>
							<th scope="col">Technician Name</th>
							<th scope="col">Mobile No</th>
							<th scope="col">Qty</th>
							<th scope="col">RO Name</th>
							<th scope="col">Loading Status</th>
							<th scope="col">Loading Date</th>
							<th scope="col">Loading start Time</th>
							<th scope="col">Loading Finish Time</th>
							<th scope="col">Filling Status</th>
							<th scope="col">Filling Date</th>
							<th scope="col">Site In-Time</th>
							<th scope="col">Site Out Time</th>
							<th scope="col">Remarks</th>
						</thead>
						<tbody>
							@if(isset($trips) && !empty($trips))
							@foreach($trips as $trip)
							<tr>
								<td>{{$trip->trip->trip_id}}</td>
								<td>{{$trip->site_data($trip->data_id)->site_id}}</td>
								<td>{{$trip->site_data($trip->data_id)->site_name}}</td>
								<td>{{$trip->site_data($trip->data_id)->technician_name}}</td>
								<td>{{$trip->site_data($trip->data_id)->technician_contact1}}</td>
								<td>{{!empty($trip->quantity()) ? $trip->quantity()['quantity'] : ''}}</td>
								<td>{{$trip->trip->vendor->name}}</td>
								<td>{{$trip->status}}</td>
								<td>	
									{{$trip->loading_start?date('d-m-Y',strtotime($trip->loading_start)):''}}
								</td>
								<td>
									{{$trip->loading_start?date('H:i',strtotime($trip->loading_start)):''}}
								</td>
								<td>
									{{$trip->loading_finish?date('H:i',strtotime($trip->loading_finish)):''}}
								</td>
								<td></td>
								<td>{{$trip->filling_start}}</td>
								<td>{{$trip->site_in}}</td>
								<td>{{$trip->site_out}}</td>
								<td>
									@if($trip)
										@if($trip->divert_from_tripdata_id)
											@if($trip->beat_plan_data()->check_divert($trip->divert_from_tripdata_id))
											Diverted From: {{ $trip->beat_plan_data()->site_data('from')->site_name}}
											@endif
										@endif
										@if($trip->divert_to_tripdata_id)
												@if($trip->beat_plan_data()->check_divert($trip->divert_to_tripdata_id))
												Diverted To: {{ $trip->beat_plan_data()->site_data('to')->site_name}}
												@endif
										@endif
										@if($trip->divert_qty)
											@if($trip->beat_plan_data()->check_divert($trip->divert_to_tripdata_id) || $trip->beat_plan_data()->check_divert($trip->divert_from_tripdata_id))
											Qty: {{ $trip->divert_qty }}
											@endif
										@endif
									@endif
									{{$trip->remarks}}
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection