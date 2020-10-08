@extends('layouts.app', ['page' => __('Edit Trip'), 'pageSlug' => 'trip'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">Trip Allotment</h4></div>
				</div>
			</div>
			<div class="card-body">
				@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				
				<form id="trip-allot-form" action="{{route('trip.update',$trip)}}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="beatPlanIdForS" id="beatPlanIdForS" value="{{ $trip->beatplan_id }}" />
					<input type="hidden" name="tripID" id="tripID" value="{{ $trip->id }}" />
					<div class="row">
						<div class="col">
							<label for="current_date">Date</label>
							<input type="text" name="current_date" class="form-control" id="current_date" placeholder="Enter Date" required="" value="{{date('d-m-Y')}}" readonly="">
						</div>
						<div class="col">
							<label for="clientname">MP/Zone</label>
							<input type="text" id="zone" name="zone" value="{{ $trip->beat_plan->mp_zone }}" class="typeahead form-control" placeholder="Enter MP/Zone" required="" />
						</div>
						
					</div>
					<div class="row">
						<div class="col">
							<label for="effective_date">Beat Plan Date & Client Code</label>
							<input type="text" id="effective_date" name="" value="{{ $trip->effective_date }} {{ $trip->beat_plan->client->vendor_code }}" class="typeahead form-control"  placeholder="Proposed date Ex. dd-mm-yyyy"  required="" readonly>
							<input type="hidden" name="effective_date" id="effective_date123" value="{{ $trip->effective_date }}" readonly>
						</div>
						<div class="col">
							<label for="mode">Route</label>
							<input type="hidden" name="route_id" value="{{ $trip->route_id }}">
							<input type="hidden" name="route_id_name" id="route_id_name" value="{{ $trip->route_id }}">
							<input type="text" id="route1" name="route" class="form-control route1" value="{{ $trip->route->route_name }}"  placeholder="Enter Route Name" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="vehicale_number">Vehicle Number</label>
							<input type="hidden" name="vehicale_id" value="{{ $trip->vehicle_id }}">
							<input type="text" name="vehicale_number" class="typeahead form-control" id="vehicale_number" placeholder="Enter Vehicle Number" value="{{ $trip->vechile->vehicle_no }}" required="">
						</div>
						<div class="col">
							<label for="driver">Driver</label>
							<select name="driver" id="driver" class="form-control">
								<option>Select Driver</option>
								@if(isset($drivers) && !empty($drivers))
								@foreach($drivers as $driver)
								<option  value="{{$driver->id}}" {{ $driver->id == $trip->driver_id ? 'selected':'' }}>{{$driver->name}}({{$driver->contact ? $driver->contact : 'NA'}})</option>
								@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="fiiler">Fillers</label>
							<select name="fiiler" id="fiiler" class="form-control">
								<option>Select Filler</option>
								@if(isset($fillers) && !empty($fillers))
								@foreach($fillers as $filler)
								<option value="{{$filler->id}}" {{ $filler->id == $trip->filler_id ? 'selected':'' }}>{{$filler->name}}({{$filler->contact ? $filler->contact : 'NA'}})</option>
								@endforeach
								@endif
							</select>
						</div>
						<div class="col">
							<label for="area_officer">Area Officer</label>
							<select name="area_officer" id="area_officer" class="form-control">
								<option>Select Area Officer</option>
								@if(isset($areaOfficers) && !empty($areaOfficers))
								@foreach($areaOfficers as $officer)
								<option value="{{$officer->id}}" {{ $officer->id == $trip->field_officer_id ? 'selected':'' }}>{{$officer->name}}({{$officer->contact ? $officer->contact : 'NA'}})</option>
								@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="fiiler">Loading Point</label>
							<select name="loading_point" id="loading_point" onchange="createTripId();" class="form-control" required>
								<option value="">Select Vendor Pump</option>
								@if(isset($vendors) && !empty($vendors))
								@foreach($vendors as $vendor)
								<option value="{{$vendor->id}}" {{ $vendor->id == $trip->loading_point_id ? 'selected':'' }}>{{$vendor->name}}({{$vendor->vendor_code}})</option>
								@endforeach
								@endif
							</select>
						</div>
						<div class="col">
							<label for="fiiler">Trip ID</label>
							<input type="text" name="trip_id" id="trip_id_value90" class="form-control" value="{{ $trip->trip_id }}" readonly="" required="">
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<!--button type="button" onclick="addMoreSites();" class="btn btn-primary form-control">Add Sites</button-->
						</div>
					</div>
					<div id="site-list">
						@if($trip->trip_data)
						@foreach($trip->trip_data as $key=>$trip_data)
						@if($trip_data->quantity())
						<div class="row" row_id="{{ $key }}" id="site_row_{{ $key }}">
							<div class="col">
								<label for="site_id_{{ $key }}">Site Id</label>
								<input type="hidden" name="tripdataid[]" id="tripdataid_{{ $key }}" value="{{ $trip_data->id }}">
								<input type="hidden" name="siteid[]" id="siteid_{{ $key }}" value="{{ $trip_data->data_id }}">
								<input type="hidden" name="beatplanid[]" id="beatplanid_{{ $key }}" value="{{ $trip_data->beatplan_id }}">
								<input type="hidden" name="beatplandataid[]" id="beatplandataid_{{ $key }}" value="{{ $trip_data->quantity()->id }}">
								<input type="text" name="site_id_{{ $key }}" class="typeahead form-control type_head_old" id="site_id_{{ $key }}" placeholder="Enter Site Id" value="{{ $trip_data->site->site_id }}" required="" autocomplete="off" row_id = "{{ $key }}">
							</div>
							<div class="col siteName">
								<label class="siteL" for="site_name_{{ $key }}">Site Name : </label>
								<label class="siteV" id="site_name_{{ $key }}">{{ $trip_data->site->site_name }}</label>
							</div>
							<div class="col sQuantity">
								<label class="siteQL" for="quantity_{{ $key }}">Quantity : </label>
								<label class="siteQV" id="quantity_{{ $key }}">{{ $trip_data->quantity()->quantity }}</label>
								<input type="hidden" id="techName_{{ $key }}" value="{{ $trip_data->site->technician_name }}">
							</div>
							<div class="col sTechnician">
								<label class="siteTL" for="technician_name_{{ $key }}">Technician Name :</label>
								<label class="siteTV" id="technician_name_{{ $key }}">{{ $trip_data->site->technician_name }}</label>
								
							</div>
							<div class="col btnDiv">
								<label class="siteAction" for="">Action</label>
								<button type="button" onclick="addMoreSites();" class="btn btn-primary">Add Sites</button>
								<button type="button" id="site_btn_{{ $key }}" class="old_site btn btn-danger" onclick="removeSite(site_row_{{ $key }});" data_id="{{ $trip->id }}">Remove</button>
							</div>
						</div>
						@endif
						@endforeach
						@endif
					</div>
					<!--div class="row">
						<div class="col-md-3">
							<button type="button" onclick="addMoreAssets();" class="btn btn-primary form-control">Add Assets</button>
						</div>
					</div>
					<div id="asset-list">
						
					</div>
					<div class="row">
						<div class="col-md-3">
							<button type="button" onclick="addMoreClients();" class="btn btn-primary form-control">Add Clients</button>
						</div>
					</div>
					<div id="client-list">
						
					</div-->
					<!-- <div class="row">
						<div class="col">
							<label>Client Name</label>
							<input type="text" id="client_name" name="client_name" class="form-control" placeholder="Enter Client Name">
						</div>
						<div class="col">
							<label>Mobile Numer</label>
							<input type="text" class="form-control" name="client_contact" placeholder="Enter Mobile Number">
						</div>
						<div class="col">
							<label>Action</label>
							<button type="button" class="btn btn-primary form-control">Add More</button>
						</div>
					</div> -->
					<input onclick="submitForm();" type="button" value="Update" class="btn btn-primary"/>
				</form>
			</div>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="tripAllotModal" tabindex="-1" role="dialog" aria-labelledby="tripAllotModalTitle"aria-hidden="true">';
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tripAllotModalTitle">Your Trip</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" onclick="$('#trip-allot-form').submit();" class="btn btn-primary">Proceed</button>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
<script type="text/javascript">
	$(document).ready(function(){
		addMoreSites();
	});
	function ID() {
	  return (Date.now().toString(36) + Math.random().toString(36).substr(2, 5)).toUpperCase();
	}
	function addMoreSites() {
		let new_input = '';
		//let siteElemCount = $('#site-list').children().length; 
		var siteElemCount = ID();
		
		new_input += '<div class="row" row_id="'+siteElemCount+'" id="site_row_'+siteElemCount+'">';
		new_input += '<div class="col">';
		new_input += '<label for="site_id_'+siteElemCount+'">Site Id</label>';
		new_input += '<input type="hidden" name="tripdataid[]" id="tripdataid_'+siteElemCount+'">';
		new_input += '<input type="hidden" name="siteid[]" id="siteid_'+siteElemCount+'">';
		new_input += '<input type="hidden" name="beatplanid[]" id="beatplanid_'+siteElemCount+'">';
		new_input += '<input type="hidden" name="beatplandataid[]" id="beatplandataid_'+siteElemCount+'">';
		new_input += '<input type="text" name="site_id_'+siteElemCount+'" class="typeahead form-control" id="site_id_'+siteElemCount+'" placeholder="Enter Site Id" value="" required="">';
		new_input += '</div>';
		new_input += '<div class="col siteName">';
		new_input += '<label class="siteL" for="site_name_'+siteElemCount+'">Site Name : </label>';
		new_input += '<label class="siteV" id="site_name_'+siteElemCount+'"></label>';
		new_input += '</div>';
		new_input += '<div class="col sQuantity">';
		new_input += '<label class="siteQL" for="quantity_'+siteElemCount+'">Quantity : </label>';
		new_input += '<label class="siteQV" id="quantity_'+siteElemCount+'"></label>';
		new_input += '<input type="hidden" id="techName_'+siteElemCount+'">';

		new_input += '</div>';
		new_input += '<div class="col sTechnician">';
		new_input += '<label class="siteTL" for="technician_name_'+siteElemCount+'">Technician Name : </label>';
		new_input += '<label class="siteTV" id="technician_name_'+siteElemCount+'"></label>';
		new_input += '</div>';
		new_input += '<div class="col btnDiv">';
		new_input += '<label class="siteAction" for="">Action</label>';
		new_input += '<button type="button" onclick="addMoreSites();" class="btn btn-primary">Add Sites</button><button type="button" id="site_btn_'+siteElemCount+'" onclick="removeSite(site_row_'+siteElemCount+');" class="btn btn-danger">Remove</button>';
		new_input += '</div>';
		new_input += '</div>';
		$('#site-list').append(new_input);
		let siteIdPath = "{{ route('site-details-trip') }}"+"/"+$("#zone").val()+'/'+$("#effective_date123").val();
		console.log(siteIdPath);
		$('#site_id_'+siteElemCount).typeahead({
			source: function(query, process) {
				return $.get(siteIdPath, {
					name: query, beatPlanIdForS: $("#beatPlanIdForS").val(), route_id_name: $("#route_id_name").val()
					, date: $("#effective_date123").val()
					, zone: $("#zone").val()
				}, function(data) {
					return process(data);
				});
			}
		});
		$('#site_id_'+siteElemCount).change(function() {
			var current = $(this).typeahead("getActive");
			if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
			  console.log(current);
              $("#siteid_"+siteElemCount).val(current.id);
              $("#site_name_"+siteElemCount).html(current.sitename);
              $("#quantity_"+siteElemCount).html(current.quantity);
              $("#beatplanid_"+siteElemCount).val(current.beatplanid);
              $("#beatplandataid_"+siteElemCount).val(current.beatplandataid);
              $("#techName_"+siteElemCount).val(current.technician_name);
			  $("#technician_name_"+siteElemCount).html(current.technician_name);
          } else {
          	$("#siteid_"+siteElemCount).val('');
          	$("#site_name_"+siteElemCount).html('');
          	$("#quantity_"+siteElemCount).html('');
          	$("#beatplanid_"+siteElemCount).val('');
          	$("#beatplandataid_"+siteElemCount).val('');
          	$("#techName_"+siteElemCount).val();
			$("#technician_name_"+siteElemCount).html('');			
          	$(this).val('');
          	$(this).focus();
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
			  }
		  } else {
				// Nothing is active so it is a new value (or maybe empty value)
			}
		}); 
	}
	function removeSite(row) {
		if(confirm("Are you sure ?")){
			$(row).remove();
		}else{
			console.log("cancel");
		}
	}
	function addMoreAssets() {
		let new_input = '';
		let assetElemCount = $('#asset-list').children().length; 
		new_input += '<div class="row" id="asset_row_'+assetElemCount+'">';
		new_input += '<div class="col">';
		new_input += '<label for="asset_name_"'+assetElemCount+'">Asset Allocated</label>';
		new_input += '<input type="hidden" name="asset_id[]" id="asset_id_'+assetElemCount+'">';
		new_input += '<input type="text" name="asset_name_'+assetElemCount+'" class="typeahead form-control" id="asset_name_'+assetElemCount+'" placeholder="Enter Asset Name" required="">';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label for="qty_allocate_"'+assetElemCount+'">Quantity Allocated</label>';
		new_input += '<input type="text" name="qty_allocate[]" id="qty_allocate_'+assetElemCount+'" class="form-control" id="qty_allocate_"'+assetElemCount+'" placeholder="Enter Quantuty" required="">';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label for="asset_name">Action</label>';
		new_input += '<button type="button" onclick="removeAssets(asset_row_'+assetElemCount+');" class="btn btn-danger form-control">Remove</button>';
		new_input += '</div></div>';
		$('#asset-list').append(new_input);
		let assetPath = "{{ route('asset-name-list') }}"+"/"+$("#zone").val();
		$('#asset_name_'+assetElemCount).typeahead({
			source: function(query, process) {
				return $.get(assetPath, {
					name: query
				}, function(data) {
					return process(data);
				});
			}
		});
		$('#asset_name_'+assetElemCount).change(function() {
			var current = $(this).typeahead("getActive");
			if (current) {
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              $("#asset_id_"+assetElemCount).val(current.id);
              
          } else {
          	$("#asset_id_"+assetElemCount).val('');
          	$("#qty_allocate_"+assetElemCount).val('');
          	$(this).val('');
          	$(this).focus();
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
          }
      } else {
            // Nothing is active so it is a new value (or maybe empty value)
        }
    }); 
	}
	function removeAssets(row) {
		$(row).remove();
	}
	function addMoreClients() {
		let new_input = '';
		let clientElemCount = $('#client-list').children().length; 
		new_input += '<div class="row" id="client_row_'+clientElemCount+'">';
		new_input += '<div class="col">';
		new_input += '<label for="client_name_"'+clientElemCount+'">Client Name</label>';
		new_input += '<input type="text" name="client_name[]" id="client_name_'+clientElemCount+'" class="form-control" id="client_name_'+clientElemCount+'" placeholder="Enter Client Name" required="">';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label for="client_mobile_"'+clientElemCount+'">Client Mobile</label>';
		new_input += '<input type="text" name="client_mobile[]" id="client_mobile_"'+clientElemCount+'" class="form-control" id="client_mobile_"'+clientElemCount+'" placeholder="Enter Client Mobile number" required="">';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label for="client_name">Action</label>';
		new_input += '<button type="button" onclick="removeClients(client_row_'+clientElemCount+');" class="btn btn-danger form-control">Remove</button>';
		new_input += '</div></div>';
		$('#client-list').append(new_input);
	}
	function removeClients(row) {
		$(row).remove();
	}
	function submitForm(){
		/*var formData =  $("#trip-allot-form").serialize();
		$.get( "{{route('trip-modal-data')}}",{formData}, function( data ) {
			console.log(data);
		});*/
		var modal = '';
		modal += '<div class="row">';
		modal += '<div class="col"><label>Date: '+$("#current_date").val()+'</label></div>';
		modal += '<div class="col"><label>Beat Plan Date: '+$("#effective_date").val()+'</label></div>';
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>MP/Zone: '+$("#zone").val()+'</label></div>';
		modal += '<div class="col"><label>Route Plan: '+$("#route1").val()+'</label></div>';
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>Vehicle No.: '+$("#vehicale_number").val();+'</label></div>';
		modal += '<div class="col"><label>Trip Id: '+$("input[name='trip_id']").val();+'</label></div>';
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>Driver Name & Contact: '+$("#driver option:selected").text();+'</label></div>';
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>Filler Name & Contact: '+$("#fiiler option:selected").text();+'</label></div>';
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>Loading Point: '+$("#loading_point option:selected").text();+'</label></div>';
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>No Of Sites: '+$('#site-list').children().length+'</label></div>';
		var qty = 0;
		$('#site-list').children().each(function(i,elem){
			var row_id = $(elem).attr("row_id");
			qty += parseInt($('#quantity_'+row_id).text());
		});
		modal += '<div class="col"><label>Sites Quantity: '+qty+'</label></div>';
		modal += '</div>';
		modal += '</div></div></div><div class="row"><table><th>Site Id</th><th>Site Name</th><th>Qty</th><th>Technician Name</th>';
		$('#site-list').children().each(function(i,elem){
			var row_id = $(elem).attr("row_id");
			if($('#site_row_'+row_id).length) {
				let siteId = $('#site_id_'+row_id).val();
				let qty = $('#quantity_'+row_id).text();
				let siteName = $('#site_name_'+row_id).text();
				let techName = $('#techName_'+row_id).val();
				modal += '<tr>';
				modal += '<td>'+siteId+'</td>';
				modal += '<td>'+siteName+'</td>';
				modal += '<td>'+qty+'</td>';
				modal += '<td>'+techName+'</td>';
				modal += '</tr>';
			}else{
				console.log(i+'dddd');
			}
		});
		modal += '</table></div>';
		$(".modal-body").html(modal);
		$("#tripAllotModal").modal('show');
	}
	function createTripId(){
		var zone = $("#zone").val();
		var route = $("#route").val();
		var effective_date = $("#effective_date123").val();
		if(zone != '' || route != '' || effective_date != ''){
			var tripId = zone+'-'+route+'-'+effective_date; 
			$("input[name='trip_id']").val(tripId);
		}
	}
	
	$(document).ready(function(){
		let siteIdPath1 = "{{ route('site-details-trip') }}"+"/"+$("#zone").val()+'/'+$("#effective_date123").val();
		$('.type_head_old').typeahead({
			source: function(query, process) {
				return $.get(siteIdPath1, {
					name: query, beatPlanIdForS: $("#beatPlanIdForS").val(), route_id_name: $("#route_id_name").val()
				}, function(data) {
					return process(data);
				});
			}
		});
		$('.type_head_old').change(function() {
			var current = $(this).typeahead("getActive");
			console.log(current);
			if (current) {
			var currentId = $(this).attr('row_id');
			//console.log(currentId);
            // Some item from your model is active!
            if (current.name == $(this).val()) {
              // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
              $("#siteid_"+currentId).val(current.id);
              $("#site_name_"+currentId).html(current.sitename);
              $("#quantity_"+currentId).html(current.quantity);
              $("#beatplanid_"+currentId).val(current.beatplanid);
              $("#beatplandataid_"+currentId).val(current.beatplandataid);
              $("#techName_"+currentId).val(current.technician_name);
          } else {
          	$("#siteid_"+currentId).val('');
          	$("#site_name_"+currentId).html('');
          	$("#quantity_"+currentId).html('');
          	$("#beatplanid_"+currentId).val('');
          	$("#beatplandataid_"+currentId).val('');
          	$("#techName_"+currentId).val();	
          	$(this).val('');
          	$(this).focus();
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
			  }
		  } else {
				// Nothing is active so it is a new value (or maybe empty value)
			}
		}); 
	});
	routePath1 = routeBasePath+'/'+$("#zone").val();
	//console.log(routePath1);
	$('.route1').typeahead({
		source: function(query, process) {
			return $.get(routePath1, {
				name: query
			}, function(data) {
				return process(data);
			});
		}
	});
	$('.route1').change(function() {
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
</script>
@endpush