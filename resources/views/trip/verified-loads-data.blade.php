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
								<th scope="col">Site id</th>
								<th scope="col">Site Name</th>
								<th scope="col">Site Category</th>
								<th scope="col">Technician Name</th>
								<th scope="col">Technician Number</th>
								<th scope="col">Qty</th>
								<th scope="col">Driver Name</th>
								<th scope="col">Filler Name</th>
								<th scope="col">Status</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							@if(isset($details) && !empty($details))
							@foreach($details as $site)
							@if($site->trip_data->beat_plan_data())
							<tr>
								<td>{{$site->trip->trip_id??''}}</td>
								<td>{{$site->site->site_id}}</td>
								<td>{{$site->site->site_name}}</td>
								<td>{{$site->site->site_category}}</td>
								<td>{{$site->site->technician_name}}</td>
								<td>
								{{$site->site->technician_contact1}},
								{{$site->site->technician_contact2}}
								</td>
								<td>{{$site->trip_data->beat_plan_data()->quantity??''}}</td>
								<td>{{$site->trip->driver->name ?? ''}}</td>
								<td>{{$site->trip->filler->name ?? ''}}</td>
								<td>{{$site->status}}</td>
								<td>
									<!--a href="javascript: void(0);" data-toggle="modal" data-target="#updateStatusModel{{$site->id}}" trip_data_id="{{ $site->trip_data_id }}" beatplan_id="{{ $site->beatplan_id }}" site_id="{{ $site->sites }}">Update Status</a> | -->
									<a href="javascript: void(0);" data-toggle="modal" data-target="#transferLoadModel{{$site->id}}">Load Transfer</a> 
									@if($site->status != 'filled' && $site->status != 'unloaded')
									| <a href="javascript: void(0);" data-toggle="modal" data-target="#divertLoadModel{{$site->id}}">Divert</a>
									@endif
									<div class="modal fade" id="transferLoadModel{{$site->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$site->id}}" aria-hidden="true">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="exampleModalLabel{{$site->id}}">Load Transfer</h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      <div class="modal-body">
									        <form>
									        	<div class="row">
													<div class="col">
														<label for="vehicale_number{{$site->id}}">Vehicle Number</label>
														<input type="hidden" name="vehicle_id" id="vehicle_id{{$site->id}}">
														<input type="text" name="vehicale_number" class="typeahead form-control vehicale_number" id="vehicale_number{{$site->id}}" placeholder="Enter Vehicle Number" required="">
													</div>
													<div class="col">
														<label for="driver{{$site->id}}">Driver</label>
														<select name="driver" id="driver{{$site->id}}" class="form-control">
															<option>Select Driver</option>
															@if(isset($drivers) && !empty($drivers))
															@foreach($drivers as $driver)
															<option  value="{{$driver->id}}">{{$driver->name}}({{$driver->contact ? $driver->contact : 'NA'}})</option>
															@endforeach
															@endif
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col">
														<label for="filler{{$site->id}}">Fillers</label>
														<select name="filler" id="filler{{$site->id}}" class="form-control">
															<option>Select Filler</option>
															@if(isset($fillers) && !empty($fillers))
															@foreach($fillers as $filler)
															<option value="{{$filler->id}}">{{$filler->name}}({{$filler->contact ? $filler->contact : 'NA'}})</option>
															@endforeach
															@endif
														</select>
													</div>
												</div>
									        </form>
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
									        <button type="button" class="btn btn-primary transfer_load dis_btn" verified_id="{{$site->id}}">Transfer</button>
									      </div>
									    </div>
									  </div>
									</div>

									<div class="modal fade" id="divertLoadModel{{$site->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelD{{$site->id}}" aria-hidden="true">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="exampleModalLabelD{{$site->id}}">Divert</h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
										  
									      <div class="modal-body" {{ $site->sites }}>
									        <form id="divert_form{{$site->id}}">
													<div class="row">
														<input type="hidden" name="from_site[]" value="{{ $site->sites}}" />
														<input type="hidden" class="form-control" name="old_qty[]" id="old_qty{{ $site->id}}" placeholder="Qty" value="{{$site->trip_data->beat_plan_data()->quantity??''}}">
														<div class="col-12">
															<p><strong>Site: </strong>{{$site->trip_data->beat_plan_data()->site->site_id??''}}
															{{$site->trip_data->beat_plan_data()->site->site_name??''}}
															{{$site->trip_data->beat_plan_data()->site->technician_name??''}} 
															<strong>Qty: </strong>	{{$site->trip_data->beat_plan_data()->quantity??''}}
															
															</p>
														</div>
														<div class="col-12">
															<label>Divert to Site</label>
															<select class="form-control" name="to_site[]">
															@foreach($sites as $key=>$site1)
															@if($site1->id != $site->trip_data->beat_plan_data()->site->id)
															<option value="{{$site1->id}}">
															@endif
															{{$site1->site_name}} ({{$site1->site_id}})
															</option>
															@endforeach
															</select>
														</div>
														<div class="col-3">
															<label>Qty</label>
															<input type="number" class="form-control" 
															name="qty[]" id="new_qty{{$site->id}}" placeholder="Qty" value="" />
														</div>
														</div>
														
									        </form>
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
									        <button type="button" class="btn btn-primary divert_load dis_btn" row_id="{{$site->id}}">Save</button>
									      </div>
									    </div>
									  </div>
									</div>

									<div class="modal fade" id="updateStatusModel{{$site->id}}" tabindex="-1" role="dialog" aria-labelledby="updateStatusLabelD{{$site->id}}" aria-hidden="true">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="updateStatusLabelD{{$site->id}}">Update Status</h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      <div class="modal-body">
									        <form>
									        	<div class="form-group">
									        		<select class="form-control" name="newStatus{{$site->id}}" id="newStatus{{$site->id}}">
									        			<option value="filled">Filled</option>
									        			<option value="not_filled">Not Filled</option>
									        		</select>
									        	</div>
									        </form>
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
									        <button type="button" class="btn btn-primary update_status dis_btn" row_id="{{ $site->id }}" trip_data_id="{{ $site->trip_data_id }}" beatplan_id="{{ $site->beatplan_id }}" site_id="{{ $site->sites }}" trip_data_id="{{ $site->trip_data_id }}">Save</button>
									      </div>
									    </div>
									  </div>
									</div>
								</td>
							</tr>
							@endif
							
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
				@if(isset($details) && !empty($details))
					{{ $details->appends(request()->except('page'))->links() }}
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