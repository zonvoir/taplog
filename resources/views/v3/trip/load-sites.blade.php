@extends('v3.layouts.app', ['page' => __('Load Sites'), 'pageSlug' => 'load-sites'])
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
													<a class="text-dark text-hover-primary mb-1 font-size-lg" href="{{ route('load-sites',request( )->except('client')) }}&zone={{$zone->mp_zone}}&action=trip">{{ $zone->mp_zone }}</a>
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
							<div class="col">
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
													<a class="text-dark text-hover-primary mb-1 font-size-lg" href="{{ route('load-sites',request( )->except('zone')) }}&client={{$client->client_id}}&action=trip">
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
					<div class="card-footer">
						<div class="row">
							<div class="col-lg-6">
								<button type="submit" class="btn btn-primary mr-2">Search</button>
							</div>
						</div>
					</div>
				
			</div>
		</div>
	</div>
</div>

@endsection
@push('js')
	<script type="text/javascript">
		$(document).ready(function(){
			var effectiveDateLoadPath = "{{ route('effective-date-load') }}";
			var tripIdLoadPath = '';
			var tripIdLoadBasePath = "{{ route('trip-id-load') }}";
	        $('#effective_date_load').typeahead({
	            source: function(query, process) {
	                return $.get(effectiveDateLoadPath, {
	                    name: query
	                }, function(data) {
	                    return process(data);
	                });
	            }
	        });
        	$('#effective_date_load').change(function() {
	          var current = $(this).typeahead("getActive");
				if (current) {
					// Some item from your model is active!
					if (current.name == $(this).val()) {
						$("#effective_date123").val(current.effective_date);
					  // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
					  // console.log(current.id);
					  tripIdLoadPath = tripIdLoadBasePath+'/'+current.effective_date;
					} else {
					  // This means it is only a partial match, you can either add a new item
					  // or take the active if you don't want new items
					}
				} else {
					// Nothing is active so it is a new value (or maybe empty value)
				}
			});
		});
	</script>
@endpush