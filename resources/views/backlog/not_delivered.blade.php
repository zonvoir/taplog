@extends('layouts.app', ['page' => __('Trip Data'), 'pageSlug' => 'backlog'])
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6"><h4 class="card-title">Trip Data</h4></div>
					</div>
				</div>
				<div class="card-body ">
					@if($beat_plan)
					<h5 style="color: #000;">Effective Date: {{ $beat_plan->effective_date }}</h5>
					<h5 style="color: #000;">Client: {{ $beat_plan->client->name }}</h5>
                    <div class="hg_cl_m">
					<div class="table-responsive">
						<table class="table tablesorter " id="">
							<thead class=" text-primary">
								<tr>
									<th scope="col">Trip Id</th>
									<th scope="col">Site id</th>
									<th scope="col">Site Name</th>
									<th scope="col">Site Category</th>
									<th scope="col">Technician Name</th>
									<th scope="col">Technician Number</th>
									<th scope="col">Qty</th>
									<th scope="col">Current Status</th>
									<th scope="col">Loading Date</th>
									<th scope="col">Loading Start Time</th>
									<th scope="col">Loading Finish Time</th>
									<th scope="col">Filling Date</th>
									<th scope="col">Site In Time</th>
									<th scope="col">Site Out Time</th>
									<th scope="col">Vehicle No</th>
									<th scope="col">Driver Name</th>
									<th scope="col">Driver Number</th>
									<th scope="col">Filler Name</th>
									<th scope="col">Filler Number</th>
									<th scope="col">Remark</th>
									<!-- <th scope="col"></th> -->
								</tr>
							</thead>
							<tbody>
								@if(isset($beat_plan) && !empty($beat_plan) && isset($beat_plan->beatplan_data))
								@foreach($beat_plan->beatplan_data as $key=>$beatplan_data)
								
								<tr>
									<td>
									@if($beatplan_data->trip_data())
									{{$beat_plan->uniqueTrip($beatplan_data->beatplan_id, $beatplan_data->site_id)}}
									@endif
									</td>
									<td>{{$beatplan_data->site->site_id}}</td>
									<td>{{$beatplan_data->site->site_name}}</td>
									<td>{{$beatplan_data->site->site_category}}</td>
									<td>
										{{ $beatplan_data->site->technician_name??'' }}
									</td>
									<td>
										{{ $beatplan_data->site->technician_contact1??''
										}},
										{{ $beatplan_data->site->technician_contact2??''
										}}
									</td>
									<td>{{$beatplan_data->quantity}}</td>
									<td>
									@if($beatplan_data->trip_data())
											{{$beatplan_data->trip_data()->status}}
										@if($beatplan_data->trip_data()->status != 'unloaded')
										@else
											
										@endif
									@else	
										{{$beatplan_data->status}}
									@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
											@if($beatplan_data->trip_data()->loading_start)
										   {{  \Carbon\Carbon::parse($beatplan_data->trip_data()->loading_start)->format('d-m-y')
											}}
											@endif
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
											@if($beatplan_data->trip_data()->loading_start)
										   {{ 
											\Carbon\Carbon::parse($beatplan_data->trip_data()->loading_start)->format('H:i:s')
											}}
											@endif
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
											@if($beatplan_data->trip_data()->loading_finish)
										   {{ 
											\Carbon\Carbon::parse($beatplan_data->trip_data()->loading_finish)->format('H:i:s')
											}}
											@endif
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
											@if($beatplan_data->trip_data()->filling_finish)
										   {{  \Carbon\Carbon::parse($beatplan_data->trip_data()->filling_finish)->format('d-m-y')
											}}
											@endif
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
											@if($beatplan_data->trip_data()->site_in)
										   {{ 
											\Carbon\Carbon::parse($beatplan_data->trip_data()->site_in)->format('H:i:s')
											}}
											@endif
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
											@if($beatplan_data->trip_data()->site_out)
										   {{ 
											\Carbon\Carbon::parse($beatplan_data->trip_data()->site_out)->format('H:i:s')
											}}
											@endif
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
										{{ $beatplan_data->trip_data()->trip->vechile->vehicle_no??'' }}
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
										{{ $beatplan_data->trip_data()->trip->driver->name??'' }}
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
										{{ $beatplan_data->trip_data()->trip->driver->contact??'' }}
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
										{{ $beatplan_data->trip_data()->trip->filler->name ??''}}
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
										{{ $beatplan_data->trip_data()->trip->filler->contact??'' }}
										@endif
									</td>
									<td>
										@if($beatplan_data->trip_data())
											@if($beatplan_data->trip_data()->divert_from_tripdata_id)
												@if($beatplan_data->check_divert($beatplan_data->trip_data()->divert_from_tripdata_id))
												Diverted From: {{ $beatplan_data->site_data('from')->site_name}}
												@endif
											@endif
											@if($beatplan_data->trip_data()->divert_to_tripdata_id)
												@if($beatplan_data->check_divert($beatplan_data->trip_data()->divert_to_tripdata_id))
												Diverted To: {{ $beatplan_data->site_data('to')->site_name}}
												@endif
											@endif
											@if($beatplan_data->trip_data()->divert_qty)
												@if($beatplan_data->check_divert($beatplan_data->trip_data()->divert_to_tripdata_id) || $beatplan_data->check_divert($beatplan_data->trip_data()->divert_from_tripdata_id))
												Qty: {{ $beatplan_data->trip_data()->divert_qty }}
												@endif
											@endif
										@endif
										<p><strong>{{$beatplan_data->remarks}}</strong></p>
										<p class="action_btn_cust">
										<a href="javascript:void(0);" class="" data-toggle="modal" data-target="#addRemarkModal{{$beatplan_data->id}}">Add Remark</a>
										</p>
									</td>
								</tr>
								
								

								<!-- Add Remark -->
								<div id="addRemarkModal{{$beatplan_data->id}}" class="modal fade" role="dialog">
								  <div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Remark</h4>
									  </div>
									  <div class="modal-body">
										<form id="remarkForm{{$beatplan_data->id}}">
											<div class="form-group">
												<textarea name="remark{{$beatplan_data->id}}" class="form-control" id="remark{{$beatplan_data->id}}">{{$beatplan_data->remarks}}</textarea>
											</div>
										</form>
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
								        <button type="button" class="btn btn-primary remark_update dis_btn" beatplandata_id="{{$beatplan_data->id}}">Update</button>
									  </div>
									</div>

								  </div>
								</div>

								<div class="modal fade" id="assignTripModel{{$beatplan_data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="exampleModalLabel{{$beatplan_data->id}}">Assign To Trip</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body">
								        <form>
								        	<input type="hidden" id="verified_id{{$beatplan_data->id}}" value="{{ $beatplan_data->id }}">
								        	<input type="hidden" id="trip_id{{$beatplan_data->id}}" value="{{$beatplan_data->trip_id}}">
								        	<div class="form-group">
								        		
								        	</div>
								        </form>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
								        <button type="button" class="btn btn-primary assign_trip dis_btn" backlog_id="{{$beatplan_data->id}}">Assign</button>
								      </div>
								    </div>
								  </div>
								</div>
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
                    </div>    
					@else
						<h2>No Data Found!</h2>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js')
<script type="text/javascript">
	$(document).ready(function(){
		$('.assign_trip').click(function(){
			var backlog_id 			= $(this).attr('backlog_id');
			var verified_id 		= $("#verified_id"+backlog_id).val();
			var assign_to_trip_id 	= $("#assign_to_trip_id"+backlog_id).val();
			var trip_id 			= $("#trip_id"+backlog_id).val();

			$('.modal-content').find('input, textarea, button, select').attr('disabled','disabled');
			$('.modal-content').css('cursor', 'wait');
			$.ajax({
		        url: "{{route('backlog.assign_trip')}}",
		        data: {_token: csrf_token, backlog_id: backlog_id, verified_id: verified_id, assign_to_trip_id: assign_to_trip_id, trip_id: trip_id},
		        type: 'POST',
		        success: function(response){
		        	location.reload(true);
		            $("#linkBody").html(response.html);
		        }    
		    });
		});
		
		$('.remark_update').click(function(){
			var beatplandata_id = $(this).attr('beatplandata_id');
			var remarks 		= $("#remark"+beatplandata_id).val();
			
			$('.modal-content').find('input, textarea, button, select').attr('disabled','disabled');
			$('.modal-content').css('cursor', 'wait');
			$.ajax({
		        url: "{{route('backlog.update_remark')}}",
		        data: {_token: csrf_token, beatplandata_id: beatplandata_id, remarks: remarks},
		        type: 'POST',
		        success: function(response){
					$('.modal-content').css('cursor', 'auto');
		        	location.reload(true);
		            //$("#linkBody").html(response.html);
		        }    
		    });
		});
	})
</script>
@endpush