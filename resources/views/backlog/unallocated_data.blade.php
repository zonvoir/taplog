@extends('layouts.app', ['page' => __('Backlogs'), 'pageSlug' => 'backlog'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">Unallocated Backlogs</h4></div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table tablesorter " id="">
						<thead class=" text-primary">
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Effective Date</th>
								<th scope="col">Site id</th>
								<th scope="col">Site Name</th>
								<th scope="col">Site Category</th>
								<th scope="col">Technician Name</th>
								<th scope="col">Technician Number</th>
								<th scope="col">Quantity</th>
								<th scope="col">Status</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							@if(isset($backlogs) && !empty($backlogs))
							@foreach($backlogs as $key=>$backlog)
							<tr>
								<td>{{$backlog->id}}</td>
								<td>{{$backlog->beatplan->effective_date}}</td>
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
								<td>{{$backlog->quantity}}</td>
								<td>{{$backlog->status}}</td>
								<td>
									<a href="{{ route('allotment') }}">Allocate</a>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
					{{ $backlogs->links() }}
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