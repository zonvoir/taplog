@extends('v3.layouts.app', ['page' => __('Load Sites'), 'pageSlug' => 'load-sites'])
@push('css')
<link href="{{ asset('public/assets/css/datetimepicker.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
		<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold my-1 mr-5">Load Sites</h5>
					<!--end::Page Title-->
					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item">
							<a href="{{route('home')}}" class="text-muted">Home</a>
						</li>
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page Heading-->
			</div>
			<!--end::Info-->
			<!--begin::Toolbar-->

			<!--end::Toolbar-->
		</div>
	</div>
	<!--end::Subheader-->
	<div class="d-flex flex-column-fluid">
		<div class="container">
			@include('v3.layouts.navbars.flash-message')
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<span class="card-icon">
							<i class="flaticon2-chart text-primary"></i>
						</span>
						<h3 class="card-label">Load Sites</h3>
					</div>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<div class="card card-custom card-stretch gutter-b">
								<h2>Effective Date: {{ request('effective_date_load') }}</h2>
							</div>
						</div>
						<div class="col-6">
							<div class="card card-custom card-stretch gutter-b">
								<!--begin::Header-->
								<div class="card-header border-0 pt-5">
									<h3 class="card-title align-items-start flex-column">
										<span class="card-label font-weight-bolder text-dark">Zones</span>
										<span class="text-muted mt-3 font-weight-bold font-size-sm">Alloted Zones</span>
									</h3>
									
								</div>
								<!--end::Header-->
								<!--begin::Body-->
								<div class="card-body pt-8">
									@foreach($mp_zone as $zone)
									<div class="d-flex align-items-center mb-2">

										<div class="d-flex flex-column font-weight-bold">
											<a class="{{ $zone->mp_zone == request('zone') ? 'text-primary':'text-dark' }} text-hover-primary mb-1 font-size-lg" href="{{ route('load-sites',request()->except(['client','zone','trip_id','action'])) }}&zone={{$zone->mp_zone}}&action=trip">{{ $zone->mp_zone }}</a>
											<!--span class="text-muted">QA Managers</span-->
										</div>
										<!--end::Text-->
									</div>
									@endforeach
									<!--end::Item-->
								</div>
								<!--end::Body-->
							</div>
							
						</div>
						<div class="col-6">
							<div class="card card-custom card-stretch gutter-b">
								<!--begin::Header-->
								<div class="card-header border-0 pt-5">
									<h3 class="card-title align-items-start flex-column">
										<span class="card-label font-weight-bolder text-dark">Clients</span>
										<span class="text-muted mt-3 font-weight-bold font-size-sm">Assigned Clients</span>
									</h3>
									
								</div>
								<!--end::Header-->
								<!--begin::Body-->
								<div class="card-body pt-8">
									@foreach($client as $client)
									<div class="d-flex align-items-center mb-2">

										<div class="d-flex flex-column font-weight-bold">
											<a class="{{ $client->client_id == request('client') ? 'text-primary':'text-dark' }} text-hover-primary mb-1 font-size-lg" href="{{ route('load-sites',request( )->except('client')) }}&client={{$client->client_id}}">
												{{ $client->client->name }}
											</a>
											<!--span class="text-muted">QA Managers</span-->
										</div>
										<!--end::Text-->
									</div>
									@endforeach
									<!--end::Item-->
								</div>
								<!--end::Body-->
							</div>
							
						</div>
					</div>
					<hr>
					@if($action && isset($trips) &&!empty($trips))
					<div class="row">
						<div class="col-12">
							<div class="card card-custom card-stretch gutter-b">
								<!--begin::Header-->
								<div class="card-header border-0 pt-5">
									<h3 class="card-title align-items-start flex-column">
										<span class="card-label font-weight-bolder text-dark">Trip ID</span>
										<span class="text-muted mt-3 font-weight-bold font-size-sm">Trip List</span>
									</h3>
								</div>
								<!--end::Header-->
								<!--begin::Body-->
								<div class="card-body pt-8">
									@foreach($trips as $trip)
									<div class="d-flex align-items-center mb-2">
										<div class="d-flex flex-column font-weight-bold">
											<a class="{{ $trip->id == request('trip_id') ? 'text-primary':'text-dark' }} text-hover-primary mb-1 font-size-lg" href="{{ route('load-sites',request( )->except('trip_id')) }}&trip_id={{$trip->id}}">
												{{ $trip->trip_id }}
											</a>
											<!--span class="text-muted">QA Managers</span-->
										</div>
										<!--end::Text-->
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
					<hr>
					@endif
					<form action="{{route('load-sites-verify')}}" method="POST" enctype="multipart/form-data">
						<div class="row">
							@csrf
							@php
							$trip_data = false;
							@endphp
							@if(isset($trips1) && !empty($trips1))
							<div class="table-responsive" >
							<table class="table">
								<thead>
									<td>
										Trip ID
									</td>
									<td>
										MP Zone
									</td>
									<td>
										Client
									</td>
									<td>
										Vehicle
									</td>
									<td>
										Site ID
									</td>
									<td>
										Site Name
									</td>
									<td>
										Quantity
									</td>
									<td>
										Loading Done
									</td>
									<td>
										Loading Start
									</td>
									<td>
										Loading End
									</td>
									<td>
										
									</td>
								</thead>
								@foreach($trips1 as $trip)
								@if(isset($trip->trip_data) &!empty($trip->trip_data))
								@foreach($trip->trip_data as $site)
								@if(($site->status == 'unloaded' || $site->status == 'loaded') && $site->beat_plan_data() )
								@php
								$trip_data = true;
								@endphp
								<tr>
									<input type="hidden" name="unique_trip_id[]" value="{{$trip->trip_id}}">
									<input type="hidden" name="beatplan_id[]" value="{{$trip->beatplan_id}}">
									<input type="hidden" name="trip_id[]" value="{{$trip->id}}">
									<input type="hidden" name="trip_data_id[]" value="{{$site->id}}">
									<td>
										<label>{{$trip->trip_id}}</label>
									</td>
									<td>
										<label>{{$trip->mp_zone}}</label>
									</td>
									<td>
										<label for="client">{{$site->beat_plan_data()->beatplan->client->name??''}}</label>
									</td>
									<td>
										<label for="vehicle">{{$trip->vechile->vehicle_no}}</label>
									</td>
									<td>
										<label for="site_id">{{$site->site->site_id}}</label>
									</td>
									<td>
										<label for="site_name">{{$site->site->site_name}}</label>
									</td>
									<td>
										<label for="quantity">{{$trip->getQuantity($trip->effective_date,$site->site->id)->quantity??''}}</label>
									</td>
									<td style="white-space: nowrap;">
										<select name="loading_done[]" class="form-control" required>
											<option value="unloaded" {{ $site->status=='unloaded'?'selected':'' }}>No</option>
											<option value="loaded" {{ $site->status=='loaded'?'selected':'' }}>Yes</option>
										</select>
									</td>
									<td style="white-space: nowrap;">
										@if(!$site->loading_start)
										<button type="button" id="loading_start_action{{$site->id}}" class="loading_start btn btn-primary" tripdata_id="{{$site->id}}" action="start">Start</button>
										@endif
										<label for="site_name" id="start_time{{$site->id}}">{{ $site->loading_start }}</label>
										@if($site->verified_load() && $site->loading_start)
										<input type="text" name="start_time[]" class="datetimepicker form-control" id="start_time{{$site->id}}" value="{{ $site->loading_start }}">
										@endif
									</td>
									<td style="white-space: nowrap;">
										@if(!$site->loading_finish)
											<button type="button" id="loading_stop_action{{$site->id}}" class="loading_end btn btn-primary" tripdata_id="{{$site->id}}" action="end" style="display: {{ $site->loading_start?'block':'none' }};">End</button>
										@endif
										</label>
										<label for="site_name" id="end_time{{$site->id}}">{{  $site->loading_finish }}</label>
										@if($site->verified_load() && $site->loading_finish)
										<input type="text" name="end_time[]" id="end_time{{$site->id}}" class="datetimepicker form-control" value="{{ $site->loading_finish }}" >
										@endif
									</td>
									<td style="white-space: nowrap;">
										<div class="action_btn_cust1">
											@if($site->status != 'filled' && $site->status != 'unloaded')
											<a href="javascript: void(0);" class="btn btn-primary" data-toggle="modal" data-target="#transferLoadModel{{$site->verified_load()->id}}">Load Transfer</a>
											<a href="javascript: void(0);" class="btn btn-primary" data-toggle="modal" data-target="#divertLoadModel{{$site->verified_load()->id}}">Divert</a>
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
																	</p>
																	<p><strong>Qty: </strong>	{{$site->beat_plan_data()->quantity??''}}

																	</p>
																</div>
																<div class="col-12">
																	<label><strong>Divert to Site</strong></label>
																</div>
																<div class="col-12">
																	<select class="form-control select2" name="to_site[]">
																		@foreach($sites as $key=>$site1)
																		@if($site1->id != $site->data_id)
																		<option value="{{$site1->id}}">
																			@endif
																			{{$site1->site_name}} ({{$site1->site_id}})
																		</option>
																		@endforeach
																	</select>
																</div>
																<div class="col-12">
																	<label><strong>Qty</strong></label>
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

										<input type="hidden" name="sites[]" value="{{$site->site->id}}">
										<input type="hidden" name="auto_trip_id[]" value="{{$trip->id}}">
									</td>
								</tr>
								<!-- <hr> -->
								@endif
								@endforeach
								@endif
								@endforeach
							</table>
						</div>
							@endif
							
							@if(isset($trips1) && !empty($trips1) && $trip_data)
							<input type="submit" class="btn btn-primary" value="Verify">
							@else
							<h3 class="text-center">No Sites Found!</h3>
							@endif
						</div>
					</form>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-6">
							<!-- <button type="submit" class="btn btn-primary mr-2">Search</button> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@push('js')
<script src="{{ asset('public/assets/js/moment.min.js') }}"></script>
<script src="{{ asset('public/assets/js/datetimepicker.min.js') }}"></script>
<script>
	$(function() {
		$('.datetimepicker').datetimepicker({
			format:'Y-m-d H:i:s',
		});

		$('.select2').select2();
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