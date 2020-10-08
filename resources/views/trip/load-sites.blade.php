@extends('layouts.app', ['page' => __('Load Verification'), 'pageSlug' => 'trip'])
@push('css')
<link href="{{ asset('public/black/css/datetimepicker.css') }}" rel="stylesheet" />
<style>
.action_btn_cust1 a {
    background: #1f7cca;
    background-size: 210% 210%;
    background-position: top right;
    background-color: #1f7cca;
    transition: all 0.15s ease;
    box-shadow: none;
    color: #ffffff;
    border-radius: 0;
    padding: 11px;
    display: inline-block;
    white-space: nowrap;
}
</style>
@endpush
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
				<div class="row">
					<div class="col">
						<table>
							<tr>
								<th style="color: #000">Zones</th>
							</tr>
							@foreach($mp_zone as $zone)
							<tr>
								<td>
								<a href="{{ route('load-sites',request( )->except('client')) }}&zone={{$zone->mp_zone}}&action=trip">{{ $zone->mp_zone }}</a>
								</td>
							</tr>
							@endforeach
						</table>
					</div>
					<div class="col">
						<table>
							<tr>
								<th style="color: #000">Clients</th>
							</tr>
							@foreach($client as $client)
							<tr>
								<td>
								<a href="{{ route('load-sites',request( )->except('zone')) }}&client={{$client->client_id}}&action=trip">{{ $client->client->name }}</a>
								</td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
				<hr>
				@if($action && isset($trips) &&!empty($trips))
					<div class="row">
						<div class="col-12">
							<table>
								<tr>
									<th>Trip ID</th>
								</tr>
								@foreach($trips as $trip)
									<tr>
										<td>
											<a href="{{ route('load-sites',request( )->except('trip_id')) }}&trip_id={{$trip->id}}">
											{{ $trip->trip_id }}
											</a>
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					</div>
					<hr>
				@endif
				<form action="{{route('load-sites-verify')}}" method="POST" enctype="multipart/form-data">
					@csrf
					@php
						$trip_data = false;
					@endphp
					@if(isset($trips1) && !empty($trips1))
					@foreach($trips1 as $trip)
					@if(isset($trip->trip_data) &!empty($trip->trip_data))
					@foreach($trip->trip_data as $site)
					@if(($site->status == 'unloaded' || $site->status == 'loaded') && $site->beat_plan_data() )
						@php
							$trip_data = true;
						@endphp
					<div class="row">
						<input type="hidden" name="unique_trip_id[]" value="{{$trip->trip_id}}">
						<input type="hidden" name="beatplan_id[]" value="{{$trip->beatplan_id}}">
						<input type="hidden" name="trip_id[]" value="{{$trip->id}}">
						<input type="hidden" name="trip_data_id[]" value="{{$site->id}}">
						<div class="col">
							<label for="trip_id">Trip ID</label>
							<label>{{$trip->trip_id}}</label>
						</div>
						<div class="col">
							<label for="zone">MP Zone</label>
							<label>{{$trip->mp_zone}}</label>
						</div>
						<div class="col">
							<label for="client">Client</label>
							<label for="client">{{$site->beat_plan_data()->beatplan->client->name??''}}</label>
						</div>
						<div class="col">
							<label for="vehicle">Vehicle</label>
							<label for="vehicle">{{$trip->vechile->vehicle_no}}</label>
						</div>
						<div class="col">
							<label for="site_id">Site ID</label>
							<label for="site_id">{{$site->site->site_id}}</label>
						</div>
						<div class="col">
							<label for="site_name">Site Name</label>
							<label for="site_name">{{$site->site->site_name}}</label>
						</div>
						
						<div class="col">
							<label for="quantity">Quantity</label>
							<label for="quantity">{{$trip->getQuantity($trip->effective_date,$site->site->id)->quantity??''}}</label>
						</div>
						<div class="col">
							<label for="loading_done">Loading Done</label>
							<select name="loading_done[]" class="form-control" required>
								<option value="unloaded" {{ $site->status=='unloaded'?'selected':'' }}>No</option>
								<option value="loaded" {{ $site->status=='loaded'?'selected':'' }}>Yes</option>
							</select>
						</div>
						<div class="col">
							<label for="start_time{{$site->id}}">Loading Start</label>
							@if(!$site->loading_start)
								<button type="button" id="loading_start_action{{$site->id}}" class="loading_start btn btn-primary" tripdata_id="{{$site->id}}" action="start">Start</button>
							@endif
							<label for="site_name" id="start_time{{$site->id}}">{{ $site->loading_start }}</label>
							@if($site->verified_load() && $site->loading_start)
							<input type="text" name="start_time[]" class="datetimepicker" id="start_time{{$site->id}}" value="{{ $site->loading_start }}">
							@endif
						</div>
						<div class="col">
							<label for="end_time{{$site->id}}">
								Loading End
								@if(!$site->loading_finish)
									<button type="button" id="loading_stop_action{{$site->id}}" class="loading_end btn btn-primary" tripdata_id="{{$site->id}}" action="end" style="display: {{ $site->loading_start?'block':'none' }};">End</button>
								@endif
							</label>
							<label for="site_name" id="end_time{{$site->id}}">{{  $site->loading_finish }}</label>
							@if($site->verified_load() && $site->loading_finish)
							<input type="text" name="end_time[]" id="end_time{{$site->id}}" class="datetimepicker" value="{{ $site->loading_finish }}" >
							@endif
						</div>
						<div class="col">
							<div class="action_btn_cust1">
								@if($site->status != 'filled' && $site->status != 'unloaded')
								<a href="javascript: void(0);" data-toggle="modal" data-target="#transferLoadModel{{$site->verified_load()->id}}">Load Transfer</a>
								<a href="javascript: void(0);" data-toggle="modal" data-target="#divertLoadModel{{$site->verified_load()->id}}">Divert</a>
								@endif
							</div>
							@if($site->verified_load())
							<div class="modal fade" id="transferLoadModel{{$site->verified_load()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$site->verified_load()->id}}" aria-hidden="true">
								<div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel{{$site->verified_load()->id}}">Load Transfer</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<div>
										<div class="row">
											<div class="col">
												<label for="vehicale_number{{$site->verified_load()->id}}">Vehicle Number</label>
												<input type="hidden" name="vehicle_id" id="vehicle_id{{$site->verified_load()->id}}">
												<input type="text" name="vehicale_number" class="typeahead form-control vehicale_number" id="vehicale_number{{$site->verified_load()->id}}" placeholder="Enter Vehicle Number">
											</div>
											<div class="col">
												<label for="driver{{$site->verified_load()->id}}">Driver</label>
												<select name="driver" id="driver{{$site->verified_load()->id}}" class="form-control">
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
												<label for="filler{{$site->verified_load()->id}}">Fillers</label>
												<select name="filler" id="filler{{$site->verified_load()->id}}" class="form-control">
													<option>Select Filler</option>
													@if(isset($fillers) && !empty($fillers))
													@foreach($fillers as $filler)
													<option value="{{$filler->id}}">{{$filler->name}}({{$filler->contact ? $filler->contact : 'NA'}})</option>
													@endforeach
													@endif
												</select>
											</div>
										</div>
									</div>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary transfer_load dis_btn" verified_id="{{$site->verified_load()->id}}">Transfer</button>
								  </div>
								</div>
								</div>
							</div>
							
							<div class="modal fade" id="divertLoadModel{{$site->verified_load()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelD{{$site->verified_load()->id}}" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabelD{{$site->verified_load()->id}}">Divert</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  
								  <div class="modal-body">
									<div id="divert_form{{$site->verified_load()->id}}">
											<div class="row">
												<input type="hidden" name="from_site[]" value="{{ $site->verified_load()->sites}}" />
												<input type="hidden" class="form-control" name="old_qty[]" id="old_qty{{ $site->verified_load()->id}}" placeholder="Qty" value="{{$site->beat_plan_data()->quantity??''}}">
												<div class="col-12">
													<p><strong>Site: </strong>{{$site->beat_plan_data()->site->site_id??''}}
													{{$site->beat_plan_data()->site->site_name??''}}
													{{$site->beat_plan_data()->site->technician_name??''}} 
													<strong>Qty: </strong>	{{$site->beat_plan_data()->quantity??''}}
													
													</p>
												</div>
												<div class="col-12">
													<label>Divert to Site</label>
													<select class="form-control" name="to_site[]">
													@foreach($sites as $key=>$site1)
													@if($site1->id != $site->data_id)
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
													name="qty[]" id="new_qty{{$site->verified_load()->id}}" placeholder="Qty" value="" />
												</div>
												</div>
												
									</div>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary divert_load dis_btn" row_id="{{$site->verified_load()->id}}">Save</button>
								  </div>
								</div>
							  </div>
							</div>
							@endif

						</div>
						<input type="hidden" name="sites[]" value="{{$site->site->id}}">
						<input type="hidden" name="auto_trip_id[]" value="{{$trip->id}}">
					</div>
					<hr>
					@endif
					@endforeach
					@endif
					@endforeach
					@endif
					
					@if(isset($trips1) && !empty($trips1) && $trip_data)
						<input type="submit" class="btn btn-primary" value="Verify">
					@else
						<h3 class="text-center">No Sites Found!</h3>
					@endif
				</form>
			</div>
		</div>
	</div>
</div>
					
</div>
@endsection
@push('js')
	
	<script src="{{ asset('public/black/js/plugins/moment.min.js') }}"></script>
	<script src="{{ asset('public/black/js/plugins/datetimepicker.min.js') }}"></script>
	<script>
		$(function() {
		  $('.datetimepicker').datetimepicker({
			  format:'Y-m-d H:i:s',
		  });
		});
					
		$(".loading_start").click(function(){
			var tripdata_id = $(this).attr('tripdata_id');
			loading_update(this);
			$(this).hide();
			$("#loading_stop_action"+tripdata_id).show();
		});
		
		$(".loading_end").click(function(){
			loading_update(this);
			$(this).hide();
		});
		
		function loading_update(thisObj){
			var trip_data_id = $(thisObj).attr('tripdata_id');
			var action = $(thisObj).attr('action');
			var current_date = new Date();
			$.ajax({
		        url: "{{route('update-loading-time')}}",
		        data: {_token: csrf_token,action: action,current_date: current_date, trip_data_id: trip_data_id},
		        type: 'POST',
		        success: function(response){
					if(action == 'start'){
						$('#start_time'+trip_data_id).text(response.trip_data.loading_start);
					}
					if(action == 'end'){
						$('#end_time'+trip_data_id).text(response.trip_data.loading_finish);
					}
		        }    
		    });
		}
		
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