@extends('layouts.app', ['page' => __('All Loads'), 'pageSlug' => 'trip'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">All Loads</h4></div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table tablesorter " id="">
						<thead class=" text-primary">
							<tr>
								<th scope="col">Trip Id</th>
								<th scope="col">Vehicle</th>
								<th scope="col">Driver Name</th>
								<th scope="col">Filler Name</th>
								<!--th scope="col">Status</th-->
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							@if(isset($trips) && !empty($trips))
							@foreach($trips as $trip)
							<tr>
								<td><a href="{{ route('all-loads') }}?trip_id={{ $trip->id }}&action=load_data">{{$trip->trip_id??''}}</a></td>
								<td>{{$trip->vechile->vehicle_no??''}}</td>
								<td>{{$trip->driver->name ?? ''}}</td>
								<td>{{$trip->filler->name ?? ''}}</td>
								<!--td>{{$trip->status}}</td-->
								<td>
									
								</td>
							</tr>

							
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
				@if(isset($trips) && !empty($trips))
					{{ $trips->links() }}
				@endif
			</div>
		</div>
	</div>
</div>
</div>
@endsection

@push('js')
<script type="text/javascript">
	$(document).ready(function(){
		$('.divert_load').click(function(){
			var row_id  = $(this).attr('row_id');
			var old_qty  = $("#old_qty"+row_id).val();
			var new_qty  = $("#new_qty"+row_id).val();
			console.log(old_qty);
			if(parseInt(new_qty) <= parseInt(old_qty)){
				var form_data123 = $("#divert_form"+row_id).find("select,input").serialize();
				$('.modal-content').find('input, textarea, button, select').attr('disabled','disabled');
				$('.modal-content').css('cursor', 'wait');
				//console.log(form_data123);
				$.ajax({
					url: "{{route('backlog.save_divert')}}",
					data: form_data123+'&_token='+csrf_token+'&verified_id='+row_id ,
					type: 'POST',
					success: function(response){
						location.reload(true);
					}    
				});
			}else{
				alert('Quantity must be less than or equal to old quantity');
				return;
			}
		});
		$('.transfer_load').click(function(){
			var verified_id  = $(this).attr('verified_id');
			var vehicle_id	 = $("#vehicle_id"+verified_id).val();
			var driver 		 = $("#driver"+verified_id).val();
			var filler 	 	 = $("#filler"+verified_id).val();
			var area_officer = $("#area_officer"+verified_id).val();

			$('.modal-content').find('input, textarea, button, select').attr('disabled','disabled');
			$('.modal-content').css('cursor', 'wait');
			$.ajax({
		        url: "{{route('backlog.load_transfer')}}",
		        data: {_token: csrf_token, verified_id: verified_id, vehicle_id: vehicle_id, driver_id: driver, filler_id: filler, area_officer: area_officer},
		        type: 'POST',
		        success: function(response){
		        	location.reload(true);
		        }    
		    });
		});

		$('.update_status').click(function(){
			
			var row_id  = $(this).attr('row_id');
			var trip_data_id  = $(this).attr('trip_data_id');
			var beatplan_id  = $(this).attr('beatplan_id');
			var site_id  = $(this).attr('site_id');
			var newStatus  = $("#newStatus"+row_id).val();
			var trip_data_id  = $(this).attr('trip_data_id');

			$('.modal-content').find('input, textarea, button, select').attr('disabled','disabled');
			$('.modal-content').css('cursor', 'wait');
			$.ajax({
		        url: "{{route('backlog.update_status')}}",
		        data: {_token: csrf_token, trip_data_id: trip_data_id, beatplan_id: beatplan_id, site_id: site_id, row_id: row_id, status: newStatus, trip_data_id: trip_data_id},
		        type: 'POST',
		        success: function(response){
		        	location.reload(true);
		        }    
		    });
		});
	});

	var vehiclePath = "{{ route('vehicle-number')}}";
        $('.vehicale_number').typeahead({
            source: function(query, process) {
                return $.get(vehiclePath, {
                    name: query
                }, function(data) {
                    return process(data);
                });
            }
        });
        $('.vehicale_number').change(function() {
            var current = $(this).typeahead("getActive");
            if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              $("input[name='vehicle_id']").val(current.id);
              
          } else {
            $("input[name='vehicle_id']").val('');
            $(this).val('');
            $(this).focus();
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
          }
      } else {
            // Nothing is active so it is a new value (or maybe empty value)
        }
    });  
</script>
@endpush