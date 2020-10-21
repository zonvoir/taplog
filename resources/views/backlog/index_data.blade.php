@extends('layouts.app', ['page' => __('Backlogs'), 'pageSlug' => 'backlog'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">Unloaded Backlogs</h4></div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table tablesorter " id="">
						<thead class=" text-primary">
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Trip Id</th>
								<th scope="col">Site id</th>
								<th scope="col">Site Name</th>
								<th scope="col">Site Category</th>
								<th scope="col">Technician Name</th>
								<th scope="col">Technician Number</th>
								<th scope="col">Driver Name</th>
								<th scope="col">Filler Name</th>
								<th scope="col">Status</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							@if(isset($backlogs) && !empty($backlogs))
							@foreach($backlogs as $key=>$backlog)
							<tr>
								<td>{{$backlog->id}}</td>
								<td>{{$backlog->trip->trip_id}}</td>
								<td>{{$backlog->site->site_id}}</td>
								<td>{{$backlog->site->site_name}}</td>
								<td>{{$backlog->site->site_category}}</td>
								<td>
									{{ $backlog->site->technician_name }}
								</td>
								<td>
									{{ $backlog->site->technician_contact1
									}},
									{{ $backlog->site->technician_contact2
									}}
								</td>
								<td>{{$backlog->trip->driver?$backlog->trip->driver->name:''}}</td>
								<td>{{$backlog->trip->filler->name}}</td>
								<td>{{$backlog->status}}</td>
								<td>
									@if($backlog->is_assigned())
									<a>Assigned</a>
									@else
									<!--a href="javascript: void(0);" data-toggle="modal" data-target="#assignTripModel{{$backlog->id}}">Assign</a-->
									<!--a href="javascript: void(0);" data-toggle="modal" data-target="#updateLoadModel{{$backlog->id}}"> | Update Load</a-->
									@endif
									<a href="{{ route('load-verification') }}">Load Verification</a>
								</td>
							</tr>
							<div class="modal fade" id="assignTripModel{{$backlog->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel{{$backlog->id}}">Assign To Trip</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							        <form>
							        	<input type="hidden" id="verified_id{{$backlog->id}}" value="{{ $backlog->id }}">
							        	<input type="hidden" id="trip_id{{$backlog->id}}" value="{{$backlog->trip_id}}">
							        	<div class="form-group">
							        		<select class="form-control" id="assign_to_trip_id{{$backlog->id}}">
							        			@if($trips)
							        				@foreach($trips as $key=>$value)
							        					@if($backlog->trip_id != $value->id)
							        					<option value="{{ $value->id }}" beatplan_id="{{ $value->beatplan_id }}">{{$value->trip_id}}</option>
							        					@endif
							        				@endforeach
							        			@endif
							        		</select>
							        	</div>
							        </form>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
							        <button type="button" class="btn btn-primary assign_trip dis_btn" backlog_id="{{$backlog->id}}">Assign</button>
							      </div>
							    </div>
							  </div>
							</div>

							<div class="modal fade" id="updateLoadModel{{$backlog->id}}" tabindex="-1" role="dialog" aria-labelledby="updateLoadModalLabel{{$backlog->id}}" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="updateLoadModalLabel{{$backlog->id}}">Update Load</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							        <form>
							        	<div class="form-group">
							        		<input type="number" id="newLoad{{$backlog->id}}" value="{{$backlog->beat_plan_data()->quantity??0}}">
							        	</div>
							        </form>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
							        <button type="button" class="btn btn-primary update_load dis_btn" backlog_id="{{$backlog->id}}" beatplan_data_id="{{$backlog->beat_plan_data()->id??''}}">Update</button>
							      </div>
							    </div>
							  </div>
							</div>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
					@if(isset($backlogs) && !empty($backlogs))
					{{ $backlogs->appends(request()->except('page'))->links() }}
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
		            
		        }    
		    });
		});

		$('.update_load ').click(function(){
			var backlog_id 		= $(this).attr('backlog_id');
			var beatplan_data_id= $(this).attr('beatplan_data_id');
			var newLoad 		= $("#newLoad"+backlog_id).val();

			$('.modal-content').find('input, textarea, button, select').attr('disabled','disabled');
			$('.modal-content').css('cursor', 'wait');
			$.ajax({
		        url: "{{route('backlog.update_load')}}",
		        data: {_token: csrf_token, backlog_id: backlog_id, beatplan_data_id: beatplan_data_id, newLoad: newLoad},
		        type: 'POST',
		        success: function(response){
		        	location.reload(true);
		        }    
		    });
		});
	})
</script>
@endpush