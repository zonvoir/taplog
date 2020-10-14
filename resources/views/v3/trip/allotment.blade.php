@extends('v3.layouts.app', ['page' => __('Trip Allotment'), 'pageSlug' => 'trip-allotment'])
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
          <h5 class="text-dark font-weight-bold my-1 mr-5">Trip Allotment</h5>
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
				<h3 class="card-label">Trip Allotment</h3>
			</div>
		</div>
		<div class="card-body">
			<form class="form" id="trip-allot-form" action="{{route('allot-trip')}}" method="POST" autocomplete="off">
				<div style="overflow: hidden; height: 0px;background: transparent;" data-description="dummyPanel for Chrome auto-fill issue">
			        <input type="text" style="height:0;background: transparent; color: transparent;border: none;" data-description="dummyUsername"></input>
			        <input type="password" style="height:0;background: transparent; color: transparent;border: none;" data-description="dummyPassword"></input>
				</div>
				@csrf
				<input type="hidden" name="beatPlanIdForS" id="beatPlanIdForS" />
				
				<div class="card-body">
					<div class="form-group row">
					   	<div class="col-lg-6">
						    <label for="current_date">Date:</label>
						    <input type="text" class="form-control" id="current_date" name="current_date" placeholder="Date" required="" value="{{date('d-m-Y')}}" readonly=""/>
					   	</div>
					   	<div class="col-lg-6">
						    <label for="zone">MP/Zone:</label>
						    <div class="typeahead">
								
								<input type="text" id="zone" name="zone" class="form-control typeahead" placeholder="MP/Zone" required />
							</div>
							
						    
						    <span class="form-text text-muted">Please type MP/Zone</span>
					   </div>
				  	</div>
					<div class="form-group row">
					   	<div class="col-lg-6">
						    <label>Beat Plan Date & Client Code:</label>
						    <div class="input-group">
						    <input type="text" id="effective_date" name="" value="{{ (isset($qparams['name']) ? $qparams['name'] : '') }}" class="typeahead form-control"  placeholder="Proposed date Ex. dd-mm-yyyy"  required="">
							<input type="hidden" name="effective_date" id="effective_date123" >
						    <div class="input-group-append"><span class="input-group-text"><i class="la la-map-marker"></i></span></div>
						    </div>
						    <span class="form-text text-muted">Please enter your beat plan date</span>
					   	</div>
					   	<div class="col-lg-6">
						    <label for="mode">Route</label>
							<input type="hidden" name="route_id">
							<input type="hidden" name="route_id_name" id="route_id_name">
							
						    <div class="input-group">
						    <input type="text" id="route" name="route" class="form-control"  placeholder="Enter Route Name" required >
						    <div class="input-group-append"><span class="input-group-text"><i class="la la-bookmark-o"></i></span></div>
						    </div>
						    <span class="form-text text-muted">Please enter your route</span>
					   </div>
					</div>
					<div class="form-group row">
					   	<div class="col-lg-6">
						    <label for="vehicale_number">Vehicle Number</label>
							<input type="hidden" name="vehicale_id">
							
						    <div class="input-group">
						     <input type="text" name="vehicale_number" class="typeahead form-control" id="vehicale_number" placeholder="Enter Vehicle Number" value="{{ (isset($qparams['name']) ? $qparams['name'] : '') }}" required="">
						     <div class="input-group-append"><span class="input-group-text"><i class="la la-map-marker"></i></span></div>
						    </div>
						    <span class="form-text text-muted">Please enter vehicle number</span>
					   	</div>
					   	<div class="col-lg-6">
						    <label for="driver">Driver</label>
							<select name="driver" id="driver" class="form-control select2">
								<option>Select Driver</option>
								@if(isset($drivers) && !empty($drivers))
								@foreach($drivers as $driver)
								<option  value="{{$driver->id}}">{{$driver->name}}({{$driver->contact ? $driver->contact : 'NA'}})</option>
								@endforeach
								@endif
							</select>
						    <span class="form-text text-muted">Please enter driver</span>
					   </div>
					</div>
					<div class="form-group row">
					   	<div class="col-lg-6">
						    <label for="filler">Fillers</label>
							<select name="filler" id="filler" class="form-control select2">
								<option>Select Filler</option>
								@if(isset($fillers) && !empty($fillers))
								@foreach($fillers as $filler)
								<option value="{{$filler->id}}">{{$filler->name}}({{$filler->contact ? $filler->contact : 'NA'}})</option>
								@endforeach
								@endif
							</select>
						    <span class="form-text text-muted">Select Filler</span>
					   	</div>
					   	<div class="col-lg-6">
						    <label for="area_officer">Area Officer</label>
							<select name="area_officer" id="area_officer" class="form-control select2">
								<option>Select Area Officer</option>
								@if(isset($areaOfficers) && !empty($areaOfficers))
								@foreach($areaOfficers as $officer)
								<option value="{{$officer->id}}">{{$officer->name}}({{$officer->contact ? $officer->contact : 'NA'}})</option>
								@endforeach
								@endif
							</select>
						    <span class="form-text text-muted">Select Area Officer</span>
					   </div>
					</div>
					<div class="form-group row">
					   	<div class="col-lg-6">
						    <label for="fiiler">Loading Point</label>
							<select name="loading_point" id="loading_point" onchange="createTripId();" class="form-control select2" required>
								<option value="">Select Vendor Pump</option>
								@if(isset($vendors) && !empty($vendors))
								@foreach($vendors as $vendor)
								<option value="{{$vendor->id}}">{{$vendor->name}}({{$vendor->vendor_code}})</option>
								@endforeach
								@endif
							</select>
						    <span class="form-text text-muted">Select Loading Point</span>
					   	</div>
					   	<div class="col-lg-6">
						    <label for="fiiler">Trip ID</label>
							<input type="text" name="trip_id" id="trip_id_value" class="form-control" readonly="" required="">
						    <span class="form-text text-muted">Auto Generated Trip ID</span>
					   </div>
					</div>
					<ul class="nav nav-pills nav-fill">
						<li class="nav-item">
							<a class="nav-link active" id="sites-tab" data-toggle="tab" href="#site-tab-content">
								<span class="nav-icon">
									<i class="flaticon2-chat-1"></i>
								</span>
								<span class="nav-text">Add Sites</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="assets-tab" data-toggle="tab" href="#assets-tab-content" aria-controls="assets">
								<span class="nav-icon">
									<i class="flaticon2-layers-1"></i>
								</span>
								<span class="nav-text">Add Assets</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="clients-tab" data-toggle="tab" href="#client-tab-content" aria-controls="clients">
								<span class="nav-icon">
									<i class="flaticon2-layers-1"></i>
								</span>
								<span class="nav-text">Add Clients</span>
							</a>
						</li>
					</ul>
					<div class="tab-content mt-5" id="tripExtraDataTabContent">
						<div class="tab-pane fade show active" id="site-tab-content" role="tabpanel" aria-labelledby="site-tab">
							<div id="site-repeater">
								<div class="form-group row">
									<!-- <label class="col-lg-2 col-form-label text-right">Sites:</label> -->
									<div data-repeater-list="siteArray" class="col-lg-12">
										<div data-repeater-item class="form-group row align-items-center site_row">
											<div class="col">
												<label>Site Id:</label>
												<input type="hidden" name="siteid" class="siteid">
												<input type="hidden" name="beatplanid" class="beatplanid">
												<input type="hidden" name="beatplandataid" class="beatplandataid">
												<input type="text" name="site_id" class="form-control clone_site_id" placeholder="Site ID" />
												<div class="d-md-none mb-2"></div>
											</div>
											<div class="col">
												<label>Site Name</label>
												<input type="text" class="form-control site_name" name="site_name" placeholder="Site Name" readonly />
												<div class="d-md-none mb-2"></div>
											</div>
											<div class="col">
												<label>Quantity</label>
												<input type="text" name="quantity" class="form-control quantity" placeholder="Quantity" readonly />
												<div class="d-md-none mb-2"></div>
											</div>
											<div class="col">
												<label>Technician Name</label>
												<input type="text" name="technician_name" class="form-control technician_name" placeholder="Technician Name" readonly />
												<div class="d-md-none mb-2"></div>
											</div>
											
											<div class="col">
												<label style="opacity: 0;">L</label>
												<a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
												<i class="la la-trash-o"></i>Delete</a>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-4">
										<a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
										<i class="la la-plus"></i>Add</a>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="assets-tab-content" role="tabpanel" aria-labelledby="assets-tab">
							<div id="asset-repeater">
								<div class="form-group row">
									<!-- <label class="col-lg-2 col-form-label text-right">Sites:</label> -->
									<div data-repeater-list="assetArray" class="col-lg-12">
										<div data-repeater-item class="form-group row align-items-center">
											<div class="col">
												<label>Asset Allocated:</label>
												<input type="text" name="asset_name" class="form-control asset_name" placeholder="Enter Asset Name" />
												<div class="d-md-none mb-2"></div>
											</div>
											<div class="col">
												<label>Quantity Allocated</label>
												<input type="number" name="qty_allocate" class="form-control qty_allocate" placeholder="Enter Quantity" />
												<div class="d-md-none mb-2"></div>
											</div>
											<div class="col">
												<label style="opacity: 0;">L</label>
												<a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
												<i class="la la-trash-o"></i>Delete</a>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-4">
										<a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
										<i class="la la-plus"></i>Add</a>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="client-tab-content" role="tabpanel" aria-labelledby="clients-tab">
							<div id="client-repeater">
								<div class="form-group row">
									<!-- <label class="col-lg-2 col-form-label text-right">Sites:</label> -->
									<div data-repeater-list="clientArray" class="col-lg-12">
										<div data-repeater-item class="form-group row align-items-center">
											<div class="col">
												<label>Client Name:</label>
												<input type="text" name="client_name" class="form-control client_name" placeholder="Client Name" />
												<div class="d-md-none mb-2"></div>
											</div>
											<div class="col">
												<label>Client Mobile</label>
												<input type="text" name="client_mobile" class="form-control client_mobile" placeholder="Client Mobile"  />
												<div class="d-md-none mb-2"></div>
											</div>
											<div class="col">
												<label>Client Email</label>
												<input type="email" name="client_email" class="form-control client_email" placeholder="Client Email"  />
												<div class="d-md-none mb-2"></div>
											</div>
											<div class="col">
												<label style="opacity: 0;">L</label>
												<a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
												<i class="la la-trash-o"></i>Delete</a>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-4">
										<a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
										<i class="la la-plus"></i>Add</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-lg-6">
							<button type="button" onclick="submitForm();" class="btn btn-primary mr-2">Submit</button>
							
						</div>
						<div class="col-lg-6 text-lg-right">
							
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="tripAllotModal" tabindex="-1" role="dialog" aria-labelledby="tripAllotModalTitle"aria-hidden="true">';
	<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tripAllotModalTitle">Your Trip</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div data-scroll="true" data-height="300">
				<div class="row justify-content-center">
					<div class="col-md-12">
						<div class="row">
							<div class="col">
								<div class="font-weight-boldest">
									Date: <span class="current_date_span"></span>
								</div>
							</div>
							<div class="col">
								<div class="font-weight-boldest">
									Beat Plan Date & Client ID: <span class="effective_date_span"></span>
								</div>
							</div>
							<hr>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<div class="font-weight-boldest">
									MP/Zone: <span class="zone_span"></span>
								</div>
							</div>
							<hr>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<div class="font-weight-boldest">
									Route: <span class="route_span"></span>
								</div>
							</div>
							<hr>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<div class="font-weight-boldest">
									Vehicle No.: <span class="vehicale_number_span"></span>
								</div>
							</div>
							<hr>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<div class="font-weight-boldest">
									Trip Id: <span class="trip_id_span"></span>
								</div>
							</div>
							<hr>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<div class="font-weight-boldest">
									Driver Name & Contact: <span class="driver_span"></span>
								</div>
							</div>
							<hr>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<div class="font-weight-boldest">
									Filler Name & Contact: <span class="filler_span"></span>
								</div>
							</div>
							<hr>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<div class="font-weight-boldest">
									Loading Point: <span class="loading_point_span"></span>
								</div>
							</div>
							<hr>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<div class="font-weight-boldest">
									No Of Sites: <span class="site_count_span"></span>
								</div>
							</div>
							<hr>
						</div>
						<hr>
						<div class="row">
							<div class="col">
								<div class="font-weight-boldest">
									Sites Quantity: <span class="site_qty_span"></span>
								</div>
							</div>
							<hr>
						</div>
						<hr>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>Site ID</th>
									<th>Site Name</th>
									<th>Qty</th>
									<th>Technician Name</th>
								</thead>
								<tbody id="siteData">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				</div>
			</div>
			<div class="modal-footer" style="display:block">
				<div class="wrap_em" style="display: none;" id="input-mail">
					<div class="row email__field no-gutters" >
						<div class="col-md-9"><input type="text" class="hidden" id="user-email" placeholder="Email"></div>
						<div class="col-md-3"><button class="email-send">send</button></div>
					</div>
				</div>
				<div class="text-center">
					<button type="button" class="btn btn-success font-weight-bold mr-2" data-dismiss="modal">Close</button>
					<button data-action="share/whatsapp/share" data-text="" class="whatsapp m__whatsapp btn btn-success font-weight-bold mr-2" target="_blank"><i class="fab fa-whatsapp"></i> Whatsapp</button>
					<button class="email m__email btn btn-success font-weight-bold mr-2"><i class="far fa-envelope"></i> Email</button>
					<button type="button" onclick="$('#trip-allot-form').submit();" class="m__submit btn btn-success font-weight-bold mr-2">Proceed</button>
				</div>
				
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script type="text/javascript">
	$(document).ready(function() {
		//$('input').attr('autocomplete','none');

		$('.select2').select2({
			placeholder: "Select a driver",
		});

		/*$('#kt_typeahead').typeahead(null, {
            name: 'countries',
            source: countries
        });*/

		var zone_path = "{{ route('zone-name-list') }}";

	    $('#zone').typeahead({
	    	name: 'zone',
			source: function(query, process) {
				return $.get(zone_path, {
				  name: query
				}, function(data) {
				  return process(data);
				});
			}
	    });

	   /* $('#zone').change(function() {
	        var current = $(this).typeahead("getActive");
	        if (current) {
	        	$('#zone').val(current.name);
	        }
	    });*/


		var effectiveDateLoadPath = "{{route('effective-date-load')}}";
		var tripIdLoadPath = '';
		var tripIdLoadBasePath = "{{route('trip-id-load')}}";
	
        $('#effective_date').typeahead({
            source: function(query, process) {
                return $.get("{{ route('effective-date') }}/"+$('#zone').val(), {
                    name: query
                }, function(data) {
			
                    return process(data);
                });
            }
        });
        var siteIdPath = ''; 
        var siteIdBasePath = "site-details-trip"; 
        $('#effective_date').change(function() {
	          var current = $(this).typeahead("getActive");
	          if (current) {
	            // Some item from your model is active!
	            if (current.name == $(this).val()) {
					$("#beatPlanIdForS").val(current.id);
					$("#effective_date123").val(current.effective_date);
	          } else {
					$(this).val('');
					$("#beatPlanIdForS").val('');
					$("#effective_date123").val('');
	              // This means it is only a partial match, you can either add a new item
	              // or take the active if you don't want new items
	          }
	      	} else {
	            // Nothing is active so it is a new value (or maybe empty value)
	        }
	    });

	    var route_path = "{{ route('route-name') }}";

	    $('#route').typeahead({
            source: function(query, process) {
                return $.get(route_path+'/'+$('#zone').val(), {
                    name: query
                }, function(data) {
                    return process(data);
                });
            }
        });

        $('#route').change(function() {
            var current = $(this).typeahead("getActive");
            if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              $("input[name='route_id']").val(current.id);
              $("input[name='route_id_name']").val(current.name);
              
          } else {
            $("input[name='route_id']").val('');
			$("input[name='route_id_name']").val('');
            $(this).val('');
            $(this).focus();
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
	          }
	      } else {
	            // Nothing is active so it is a new value (or maybe empty value)
	        }
	    });

	    var vehiclePath = "{{ route('vehicle-number')}}";

	    $('#vehicale_number').typeahead({
            source: function(query, process) {
                return $.get(vehiclePath, {
                    name: query
                }, function(data) {
                    return process(data);
                });
            }
        });
        $('#vehicale_number').change(function() {
            var current = $(this).typeahead("getActive");
            if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              $("input[name='vehicale_id']").val(current.id);
              
          } else {
            $("input[name='vehicale_id']").val('');
            $("input[name='vehicale_number']").val('');
            $(this).val('');
            $(this).focus();
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
          }
	      } else {
	            // Nothing is active so it is a new value (or maybe empty value)
	        }
	    });

	    $("#site-repeater").repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
                console.log(this);
                $(this).find('.clone_site_id').typeahead({
					source: function(query, process) {
						return $.get('{{"site-details-trip"}}', {
							name: query, beatPlanIdForS: $("#beatPlanIdForS").val(), route_id_name: $("#route_id_name").val(), siteids: $(".siteid").map(function(){  return this.value; }).get()
							, date: $("#effective_date123").val()
							, zone: $("#zone").val()
						}, function(data) {
							return process(data);
						});
					}
				});

				$('.clone_site_id').change(function() {
					var current = $(this).typeahead("getActive");
					if (current) {
						// Some item from your model is active!
						if (current.name == $(this).val()) {
							if(1){
								$(this).siblings('.siteid').val(current.id);
								$(this).siblings('.beatplanid').val(current.beatplanid);
								$(this).siblings('.beatplandataid').val(current.beatplandataid);
								$(this).parent('div.col').siblings('div.col').find('input.site_name').val(current.sitename);
								$(this).parent('div.col').siblings('div.col').find('input.quantity').val(current.quantity);
								$(this).parent('div.col').siblings('div.col').find('input.technician_name').val(current.technician_name);
							}else{
								$(this).siblings('.siteid').val('');
    							$(this).removeClass( "sites form-control" ).addClass( "sites form-control is-invalid" );
    							$(this).siblings('.invalid-feedback').html('This id already added.')
    							$(this).val('');
							}
						} else {
							$(this).siblings('.siteid').val('');
							$(this).siblings('.beatplanid').val('');
							$(this).siblings('.beatplandataid').val('');
							$(this).parent('div.col').siblings('div.col').find('input.site_name').val('');
							$(this).parent('div.col').siblings('div.col').find('input.quantity').val('');
							$(this).parent('div.col').siblings('div.col').find('input.technician_name').val('');
						}
					} else {
						$(this).siblings('.siteid').val('');
						$(this).siblings('.beatplanid').val('');
						$(this).siblings('.beatplandataid').val('');
						$(this).parent('div.col').siblings('div.col').find('input.site_name').val('');
						$(this).parent('div.col').siblings('div.col').find('input.quantity').val('');
						$(this).parent('div.col').siblings('div.col').find('input.technician_name').val('');
					}
				});
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        $('.clone_site_id').typeahead({
			source: function(query, process) {
				return $.get('{{"site-details-trip"}}', {
					name: query, beatPlanIdForS: $("#beatPlanIdForS").val(), route_id_name: $("#route_id_name").val()
					, date: $("#effective_date123").val(), siteids: $(".siteid").map(function(){  return this.value; }).get(), zone: $("#zone").val()
				}, function(data) {
					return process(data);
				});
			}
		});

		$('.clone_site_id').change(function() {
			var current = $(this).typeahead("getActive");
			if (current) {
				// Some item from your model is active!
				if (current.name == $(this).val()) {
					$(this).siblings('.siteid').val(current.id);
					$(this).siblings('.beatplanid').val(current.beatplanid);
					$(this).siblings('.beatplandataid').val(current.beatplandataid);
					$(this).parent('div.col').siblings('div.col').find('input.site_name').val(current.sitename);
					$(this).parent('div.col').siblings('div.col').find('input.quantity').val(current.quantity);
					$(this).parent('div.col').siblings('div.col').find('input.technician_name').val(current.technician_name);
				} else {
					$(this).siblings('.siteid').val('');
					$(this).siblings('.beatplanid').val('');
					$(this).siblings('.beatplandataid').val('');
					$(this).parent('div.col').siblings('div.col').find('input.site_name').val('');
					$(this).parent('div.col').siblings('div.col').find('input.quantity').val('');
					$(this).parent('div.col').siblings('div.col').find('input.technician_name').val('');
				}
			} else {
				$(this).siblings('.siteid').val('');
				$(this).siblings('.beatplanid').val('');
				$(this).siblings('.beatplandataid').val('');
				$(this).parent('div.col').siblings('div.col').find('input.site_name').val('');
				$(this).parent('div.col').siblings('div.col').find('input.quantity').val('');
				$(this).parent('div.col').siblings('div.col').find('input.technician_name').val('');
			}
		});

		$("#client-repeater").repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
               
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        $("#asset-repeater").repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
               
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        var isMobile = {
			Android: function() {
				return navigator.userAgent.match(/Android/i);
			},
			BlackBerry: function() {
				return navigator.userAgent.match(/BlackBerry/i);
			},
			iOS: function() {
				return navigator.userAgent.match(/iPhone|iPad|iPod/i);
			},
			Opera: function() {
				return navigator.userAgent.match(/Opera Mini/i);
			},
			Windows: function() {
				return navigator.userAgent.match(/IEMobile/i);
			},
			any: function() {
				return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
			}
		};


        $(document).on("click", '.whatsapp', function() {
			if( isMobile.any() ) {
				var text = $(this).attr("data-text");
				var url = $(this).attr("data-link");
				var message = encodeURIComponent(text) + " - " + encodeURIComponent(url);
				var whatsapp_url = "whatsapp://send?text=" + message;
				window.location.href = whatsapp_url;
			} else {
				//alert("Please share this article in mobile device");
				var text = $(this).attr("data-text");
				console.log(text);
				var message = encodeURIComponent(text);
				var whatsapp_url = "https://web.whatsapp.com/send??text=" + message;
				window.open(whatsapp_url);
			}
		});

		$(".email").click(function(){

			k=0;
			$('.clone_site_id').each(function(i, e) {
			  if ($(e).val() != "") k++;
			});

			qty=0;
			$('.quantity').each(function(i, e) {
			  if ($(e).val() != "") {
			  	qty += parseInt($(e).val());
			  }
			});
			
			var dataObj = {};
			dataObj.sites = [];
			$('.site_row').each(function(i, e) {
			 	var siteID = $(e).find('.clone_site_id').val();
			 	var site_name = $(e).find('.site_name').val();
			 	var quantity = $(e).find('.quantity').val();
			 	var technician_name = $(e).find('.technician_name').val();
			 	dataObj.sites.push({
					'siteId': siteID,
					'siteName': site_name,
					'qty': quantity,
					'techName': technician_name
				});
			});

			dataObj.date = $("#current_date").val();
			dataObj.plandate = $("#effective_date").val();
			dataObj.zone = $("#zone").val();
			dataObj.route = $("#route").val();
			dataObj.vehicle = $("#vehicale_number").val();
			dataObj.trip_id = $("input[name='trip_id']").val();
			dataObj.driver = $("#driver option:selected").text();
			dataObj.filler = $("#filler option:selected").text();
			dataObj.ro = $("#loading_point option:selected").text();
			dataObj.sitesLength = k;
			dataObj.totalQty = qty;

			console.log(dataObj)
			$("#input-mail").toggle();
			$(".email-send").click(dataObj,function(event){
				console.log(dataObj);
				let serializeData = JSON.stringify(dataObj);
				let userMail = $("#user-email").val();
				let mailurl = "{{ route('share-on-mail') }}?postData="+encodeURIComponent(serializeData)+"&emailid="+encodeURIComponent(userMail);
				$.get(mailurl)
				.done(function(response){
					console.log(response);
					$("#input-mail").toggle();
				});
				$( this ).off( event );
			});
		});

		
	});

	function siteIdExist(id){
		let returnVal = false;
		$( ".siteid" ).each(function() {
			console.log($( this ).val());
			if($( this ).val() == id){
				returnVal = true;
			}
		});
		return returnVal;
	}

	function createTripId(){
		var zone = $("#zone").val();
		var route = $("#route").val();
		var effective_date = $("#effective_date123").val();
		var cDate = new Date();
		var yr      = cDate.getFullYear();
		var month   = cDate.getMonth() + 1;
		var m  		= month < 10 ? '0' + month : month;
		var day     = cDate.getDate()  < 10 ? '0' + cDate.getDate()  : cDate.getDate();
		var CurrentDate = day + '-' + m + '-' + yr;
		if(effective_date == CurrentDate){
			if(zone != '' || route != '' || effective_date != ''){
				let tripId = zone+'-'+route+'-'+effective_date; 
				$("input[name='trip_id']").val(tripId);
				let tripUrl = "{{ route('check-trip-id') }}?tripId="+encodeURIComponent(tripId);
				$.get(tripUrl)
				.done(function(response){
					console.log(response);
					if(response.message){
						alert("Trip Id already created for other trip. Plz create new one!");
						window.location.reload();
					}
				});
			}
		}else{
			console.log('not equal');
			var planDateStr = effective_date;
			var planDateArr = planDateStr.split("-");
			console.log(planDateArr);
			var planDate = new Date(parseInt(planDateArr[2]), parseInt(planDateArr[1])-1, parseInt(planDateArr[0]));
			var todayDate = new Date();
			console.log(todayDate+' and '+planDate);
			if (todayDate < planDate) {
				console.log('not equal & today date is small');
				if(zone != '' || route != '' || effective_date != ''){
					let tripId = zone+'-'+route+'-'+effective_date; 
					$("input[name='trip_id']").val(tripId);
					let tripUrl = "{{ route('check-trip-id') }}?tripId="+encodeURIComponent(tripId);
					$.get(tripUrl)
					.done(function(response){
						console.log(response);
						if(response.message){
							alert("Trip Id already created for other trip. Plz create new one!");
							window.location.reload();
						}else{
							alert("Remember! this is a advance Trip.")
						}
					});
				}
			}else{
				console.log('not equal & today date is greater than '+effective_date);
				if(zone != '' || route != '' || effective_date != ''){
					let d = todayDate;
					let date = d.getDate();
					let Ndate = date  < 10 ? '0' + date  : date;
					let month = d.getMonth() + 1;
					let m = month < 10 ? '0' + month : month;
					let tripId = zone+'-'+route+'-'+effective_date+'-BTG-'+Ndate+m; 
					$("input[name='trip_id']").val(tripId);
					alert("Remember! this is a backlog Trip.")
				}
			}
		}
	}

	function submitForm(){
		$(".current_date_span").text($("#current_date").val());
		$(".effective_date_span").text($("#effective_date").val());
		$(".zone_span").text($("#zone").val());
		$(".route_span").text($("#route").val());
		$(".vehicale_number_span").text($("#vehicale_number").val());
		$(".filler_span").text($("#filler option:selected").text());
		$(".driver_span").text($("#driver option:selected").text());
		$(".area_officer_span").text($("#area_officer option:selected").text());
		$(".loading_point_span").text($("#loading_point option:selected").text());
		$(".trip_id_span").text($("#trip_id_value").val());


		k=0;
		$('.clone_site_id').each(function(i, e) {
		  if ($(e).val() != "") k++;
		});

		qty=0;
		$('.quantity').each(function(i, e) {
		  if ($(e).val() != "") {
		  	qty += parseInt($(e).val());
		  }
		});
		$(".site_count_span").text(k);
		$(".site_qty_span").text(qty);

		var html = '';
		$('.site_row').each(function(i, e) {
		 	var siteID = $(e).find('.clone_site_id').val();
		 	var site_name = $(e).find('.site_name').val();
		 	var quantity = $(e).find('.quantity').val();
		 	var technician_name = $(e).find('.technician_name').val();
		 	html += '<tr>';
		 	html += '<td>';
		 	html += siteID;
		 	html += '</td>';
		 	html += '<td>';
		 	html += site_name;
		 	html += '</td>';
		 	html += '<td>';
		 	html += quantity;
		 	html += '</td>';
		 	html += '<td>';
		 	html += technician_name;
		 	html += '</td>';
		 	html += '</tr>';
		});
		$("#siteData").html(html);
		
		$("#tripAllotModal").modal('show');


		var data = '';
		data += 'Date: '+$("#current_date").val();
		data += ' Beat Plan Date: '+$("#effective_date").val();
		data += ' MP/Zone: '+$("#zone").val();
		data += ' Route Plan: '+$("#route").val();
		data += ' Vehicle No.: '+$("#vehicale_number").val();
		data += ' Trip Id: '+$("#trip_id_value").val();
		data += ' Driver Name & Contact: '+$("#driver option:selected").text();
		data += ' Filler Name & Contact: '+$("#filler option:selected").text();
		data += ' Loading Point: '+$("#loading_point option:selected").text();
		data += ' No Of Sites: '+k;
		data += ' Quantity: '+qty;

		//console.log(data);

		$(".whatsapp").attr("data-text","https://web.whatsapp.com/send?text="+encodeURIComponent(data));
	}
</script>
@endpush