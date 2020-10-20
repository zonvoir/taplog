@extends('v3.layouts.app', ['page' => __('Backlogs'), 'pageSlug' => 'unallocated'])
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
							<th class="text-center">
							  Effective Date
							</th>
							<th class="text-center">
							 Mp/Zone
							</th>
							 <th class="text-center">
							  Client Name
							</th>
							<!--th class="text-center">
							  Site Name/Id
							</th>
							<th class="text-center">
							  Quantity
							</th-->
							<th class="text-center">
							  Mode
							</th>
							<th class="text-center">
							  Status
							</th>
							<th class="text-center">
							  
							</th>
						  </tr>
						</thead>
						<tbody>
						  @if(isset($plans) && !empty($plans))
						  @foreach($plans as $plan)
						  <tr>
							<td>
							  <a href="{{ route('backlog.index') }}?type=unallocated_data&beat_id={{$plan->plan_id}}">{{ $plan->effective_date }}</a>
							</td>
							<td>
							  {{ $plan->mp_zone }}
							</td>
							<td>
							  {{ $plan->client->name }}
							</td>
						   
							<td class="text-center">
							  {{ $plan->mode }}
							</td>
							<td class="text-center">
								{{ $plan->beatplan_data->count('site_id')??0 }} Sites/
								@if($plan->loaded_count()) 
								  Loading Done({{$plan->loaded_count()}})
								@endif
								@if($plan->filled_count()) 
								  /Filling Done({{$plan->filled_count()}})
								@endif
							</td>
							<td class="text-center">
							 <div class="action_btn_cust">
                                 <a href="{{ route('backlog.trip_data') }}?beat_id={{ $plan->id }}" target="_blank">View</a>   
                             </div>
							</td>
						  </tr>
						  @endforeach
						  @endif
						</tbody>
					  </table>
				</div>
					@if(isset($beatplans) && !empty($beatplans))
					{{ $beatplans->appends(request()->except('page'))->links() }}
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