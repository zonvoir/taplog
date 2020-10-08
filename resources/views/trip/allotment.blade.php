@extends('layouts.app', ['page' => __('Allot Trip'), 'pageSlug' => 'trip'])
@section('content')
<style type="text/css">
	.w3_whatsapp_btn {
		background-image: url('/taplog/public/black/img/whatsapp.png');
		border: 1px solid rgba(0, 0, 0, 0.1);
		display: inline-block !important;
		position: relative;
		font-family: Arial,sans-serif;
		letter-spacing: .4px;
		cursor: pointer;
		font-weight: 400;
		text-transform: none;
		color: #fff;
		border-radius: 2px;
		background-color: #5cbe4a;
		background-repeat: no-repeat;
		line-height: 1.2;
		text-decoration: none;
		text-align: left;
	}
	.w3_whatsapp_btn_small {
		font-size: 12px;
		background-size: 16px;
		background-position: 5px 2px;
		padding: 3px 6px 3px 25px;
	}

	.w3_whatsapp_btn_medium {
		font-size: 16px;
		background-size: 20px;
		background-position: 4px 2px;
		padding: 4px 6px 4px 30px;
	}

	.w3_whatsapp_btn_large {
		font-size: 16px;
		background-size: 20px;
		background-position: 5px 5px;
		padding: 8px 6px 8px 30px;
		color: #fff;
	}
	a.whatsapp { color: #fff;}
	a.email { color: #fff;}
	.w3_email_btn {
		background-image: url('/taplog/public/black/img/whatsapp.png');
		border: 1px solid rgba(0, 0, 0, 0.1);
		display: inline-block !important;
		position: relative;
		font-family: Arial,sans-serif;
		letter-spacing: .4px;
		cursor: pointer;
		font-weight: 400;
		text-transform: none;
		color: #fff;
		border-radius: 2px;
		background-color: #5cbe4a;
		background-repeat: no-repeat;
		line-height: 1.2;
		text-decoration: none;
		text-align: left;
	}
	
	.wrap_model_btn_cl{-ms-flex-pack: justify!important;
		justify-content: space-between!important;
		display: -ms-flexbox!important;
		display: flex!important;}

		.wrap_model_btn_cl button,
		.wrap_model_btn_cl a{border: 0;
			cursor:pointer;
			padding: 10px;
			color: #fff;}

			.m__close{background-color :#f13635}
			.m__whatsapp{background-color :#25d366}
			.m__email{background-color :#f16c63}
			.m__submit{background-color :#1f7cca}

			.email__field{}
			.email__field input{width: 100%;
				padding: 6px;
				border: 1px solid #9e9e9e;}
				.email__field button{    width: 100% !important;
					border: 0;
					background-color: #1f7cca;
					color: #ffffff;
					padding: 7px;}
					.wrap_em{    padding: 8px;
						background-color: #d8d8d8;
						margin-bottom: 10px;
						text-align: center;}

					</style>
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
									<form id="trip-allot-form" action="{{route('allot-trip')}}" method="POST" >
										@csrf
										<input type="hidden" name="beatPlanIdForS" id="beatPlanIdForS" />
										<div class="row">
											<div class="col">
												<label for="current_date">Date</label>
												<input type="text" name="current_date" class="form-control" id="current_date" placeholder="Enter Date" required="" value="{{date('d-m-Y')}}" readonly="">
											</div>
											<div class="col">
												<label for="clientname">MP/Zone</label>
												<input type="text" id="zone" name="zone" value="{{ (isset($qparams['name']) ? $qparams['name'] : '') }}" class="typeahead form-control" placeholder="Enter MP/Zone" required="" />
											</div>

										</div>
										<div class="row">
											<div class="col">
												<label for="effective_date">Beat Plan Date & Client Code</label>
												<input type="text" id="effective_date" name="" value="{{ (isset($qparams['name']) ? $qparams['name'] : '') }}" class="typeahead form-control"  placeholder="Proposed date Ex. dd-mm-yyyy"  required="">
												<input type="hidden" name="effective_date" id="effective_date123" >
											</div>
											<div class="col">
												<label for="mode">Route</label>
												<input type="hidden" name="route_id">
												<input type="hidden" name="route_id_name" id="route_id_name">
												<input type="text" id="route" name="route" class="form-control"  placeholder="Enter Route Name" required="">
											</div>
										</div>
										<div class="row">
											<div class="col">
												<label for="vehicale_number">Vehicle Number</label>
												<input type="hidden" name="vehicale_id">
												<input type="text" name="vehicale_number" class="typeahead form-control" id="vehicale_number" placeholder="Enter Vehicle Number" value="{{ (isset($qparams['name']) ? $qparams['name'] : '') }}" required="">
											</div>
											<div class="col">
												<label for="driver">Driver</label>
												<select name="driver" id="_driver" class="form-control">
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
												<label for="fiiler">Fillers</label>
												<select name="fiiler" id="fiiler" class="form-control">
													<option>Select Filler</option>
													@if(isset($fillers) && !empty($fillers))
													@foreach($fillers as $filler)
													<option value="{{$filler->id}}">{{$filler->name}}({{$filler->contact ? $filler->contact : 'NA'}})</option>
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
													<option value="{{$officer->id}}">{{$officer->name}}({{$officer->contact ? $officer->contact : 'NA'}})</option>
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
													<option value="{{$vendor->id}}">{{$vendor->name}}({{$vendor->vendor_code}})</option>
													@endforeach
													@endif
												</select>
											</div>
											<div class="col">
												<label for="fiiler">Trip ID</label>
												<input type="text" name="trip_id" id="trip_id_value" class="form-control" readonly="" required="">
											</div>
										</div>



										<div class="wrap_tabs">
											<!-- Nav tabs -->
											<ul class="nav nav-tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" data-toggle="tab" href="#home">Add Site</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#menu1">Add Assets</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" data-toggle="tab" href="#menu2">Add Clients</a>
												</li>
											</ul>

											<!-- Tab panes -->
											<div class="tab-content">
												<div id="home" class="tab-pane active">
													<div class="row">
														<div class="col-md-3">
															<div class="add_site_btn_az">
																<!--button type="button" onclick="addMoreSites();" class="btn btn-primary form-control">Add Sites</button-->
															</div>
														</div>
													</div>
													<div id="site-list">

													</div>

												</div>
												<div id="menu1" class="tab-pane fade">
													<div class="row">
														<div class="col-md-3">
															<div class="add_site_btn_az">
																<!--button type="button" onclick="addMoreAssets();" class="btn btn-primary form-control">Add Assets</button-->
															</div>
														</div>
													</div>
													<div id="asset-list">

													</div>
												</div>
												<div id="menu2" class="tab-pane fade">
													<div class="row">
														<div class="col-md-3">
															<div class="add_site_btn_az">
																<!--button type="button" onclick="addMoreClients();" class="btn btn-primary form-control">Add Clients</button-->
															</div>
														</div>
													</div>
													<div id="client-list">

													</div>

												</div>
											</div>
										</div>







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
					<br>
					<input onclick="submitForm();" type="button" value="Submit" class="btn btn-primary"/>
				</form>
			</div>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="tripAllotModal" tabindex="-1" role="dialog" aria-labelledby="tripAllotModalTitle"aria-hidden="true">';
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tripAllotModalTitle">Your Trip</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer" style="display:block">
				<div class="wrap_em" style="display: none;" id="input-mail">
					<div class="row email__field no-gutters" >
						<div class="col-md-9"><input type="text" class="hidden" id="user-email" placeholder="Email"></div>
						<div class="col-md-3"><button class="email-send">send</button></div>
					</div>
				</div>
				<div class="wrap_model_btn_cl">
					<div class="">
						<button type="button" class="m__close" data-dismiss="modal">Close</button>
					</div>
					<div class="">
						<button data-action="share/whatsapp/share" data-text="" class="whatsapp m__whatsapp" target="_blank"><i class="fab fa-whatsapp"></i> Whatsapp</button>
					</div>
					<div class="">
						<button class="email m__email"><i class="far fa-envelope"></i> Email</button>
					</div>
					<div class="">
						<button type="button" onclick="$('#trip-allot-form').submit();" class="m__submit">Proceed</button>
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
		addMoreSites();
		addMoreAssets();
		addMoreClients();
	});
	var addedSites = [];
	var removedIndex = [];
	function addMoreSites() {
		let new_input = '';
		var siteElemCount = 0; 
		if(removedIndex.length == 0){
			siteElemCount = $('#site-list').children().length; 	
		}else{
			siteElemCount = removedIndex[removedIndex.length - 1]; 
			const elemIndex = removedIndex.findIndex(function(elem){ return elem == siteElemCount; });
			if (elemIndex > -1) {
				removedIndex.splice(elemIndex, 1);
			}
			console.log('after Add: '+removedIndex)
		}
		new_input += '<div class="row" row_id="'+siteElemCount+'" id="site_row_'+siteElemCount+'">';
		new_input += '<div class="col">';
		new_input += '<label for="site_id_'+siteElemCount+'">Site Id</label>';
		new_input += '<input type="hidden" name="siteid[]" id="siteid_'+siteElemCount+'">';
		new_input += '<input type="hidden" name="beatplanid[]" id="beatplanid_'+siteElemCount+'">';
		new_input += '<input type="hidden" name="beatplandataid[]" id="beatplandataid_'+siteElemCount+'">';
		new_input += '<input type="text" name="site_id_'+siteElemCount+'" class="typeahead form-control" id="site_id_'+siteElemCount+'" autocomplete="off" placeholder="Enter Site Id" value="" required="">';
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
		new_input += '<button type="button" onclick="addMoreSites();" class="btn btn-primary addSitebtn">Add Sites</button> <button type="button" id="site_btn_'+siteElemCount+'" onclick="removeSite('+siteElemCount+');" class="btn btn-danger removeSiteBtn" data-value="">Remove</button>';
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
              $("#siteid_"+siteElemCount).val(current.id);
              $("#site_name_"+siteElemCount).html(current.sitename);
              $("#quantity_"+siteElemCount).html(current.quantity);
              $("#beatplanid_"+siteElemCount).val(current.beatplanid);
              $("#beatplandataid_"+siteElemCount).val(current.beatplandataid);
              $("#techName_"+siteElemCount).val(current.technician_name);
              $("#technician_name_"+siteElemCount).html(current.technician_name);
              $("#site_btn_"+siteElemCount).attr('data-value',current.id);

              //console.log(current.id);
              if(addedSites.includes(current.id)){
              	alert('Already added!')
              	$('#site_id_'+siteElemCount).val('');
              	$("#siteid_"+siteElemCount).val('');
              	$("#site_name_"+siteElemCount).html('');
              	$("#technician_name_"+siteElemCount).html('');
              	$("#site_btn_"+siteElemCount).attr('data-value','');
              	$("#quantity_"+siteElemCount).html('');
              }else{
              	//console.log(false);
              	addedSites.push(current.id);
              }
              console.log(addedSites);
          } else {
          	$("#siteid_"+siteElemCount).val('');
          	$("#site_name_"+siteElemCount).html('');
          	$("#quantity_"+siteElemCount).html('');
          	$("#beatplanid_"+siteElemCount).val('');
          	$("#beatplandataid_"+siteElemCount).val('');
          	$("#techName_"+siteElemCount).val();
          	$("#technician_name_"+siteElemCount).html('');
          	$("#site_btn_"+siteElemCount).attr('data-value','');
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
	function site_details(){
		let siteIdPath = "{{ route('site-details-trip') }}"+"/"+$("#zone").val()+'/'+$("#effective_date123").val();
		console.log(siteIdPath);
		$('#site_id_'+siteElemCount).typeahead({
			source: function(query, process) {
				return $.get(siteIdPath, {
					name: query, beatPlanIdForS: $("#beatPlanIdForS").val(), route_id_name: $("#route_id_name").val()
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
              $("#siteid_"+siteElemCount).val(current.id);
              $("#site_name_"+siteElemCount).html(current.sitename);
              $("#quantity_"+siteElemCount).html(current.quantity);
              $("#beatplanid_"+siteElemCount).val(current.beatplanid);
              $("#beatplandataid_"+siteElemCount).val(current.beatplandataid);
              $("#techName_"+siteElemCount).val(current.technician_name);
          } else {
          	$("#siteid_"+siteElemCount).val('');
          	$("#site_name_"+siteElemCount).html('');
          	$("#quantity_"+siteElemCount).html('');
          	$("#beatplanid_"+siteElemCount).val('');
          	$("#beatplandataid_"+siteElemCount).val('');
          	$("#techName_"+siteElemCount).val();	
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
		removedIndex.push(row);
		let siteId = $('#site_btn_'+row).attr('data-value');
		const index = addedSites.findIndex(function(site){ return site == siteId; });
		if (index > -1) {
			addedSites.splice(index, 1);
		}
		$('#site_row_'+row).remove();
	}
	function addMoreAssets() {
		let new_input = '';
		let assetElemCount = $('#asset-list').children().length; 
		new_input += '<div class="row" id="asset_row_'+assetElemCount+'">';
		new_input += '<div class="col">';
		new_input += '<label class="qAsset" for="asset_name_"'+assetElemCount+'">Asset Allocated</label>';
		new_input += '<input type="hidden" name="asset_id[]" id="asset_id_'+assetElemCount+'">';
		new_input += '<input type="text" name="asset_name_'+assetElemCount+'" class="typeahead form-control" id="asset_name_'+assetElemCount+'" placeholder="Enter Asset Name" required="">';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label class="qAllocate" for="qty_allocate_"'+assetElemCount+'">Quantity Allocated</label>';
		new_input += '<input type="text" name="qty_allocate[]" id="qty_allocate_'+assetElemCount+'" class="form-control" id="qty_allocate_"'+assetElemCount+'" placeholder="Enter Quantuty" required="">';
		new_input += '</div>';
		new_input += '<div class="col btnDiv">';
		new_input += '<label class="assetAction" for="">Action</label>';
		new_input += '<button type="button" onclick="addMoreAssets();" class="btn btn-primary">Add Assets</button> <button type="button" onclick="removeAssets(asset_row_'+assetElemCount+');" class="btn btn-danger">Remove</button>';
		new_input += '</div></div>';
		$('#asset-list').append(new_input);
		let assetPath = "{{ route('asset-name-list') }}";
		$('#asset_name_'+assetElemCount).typeahead({
			source: function(query, process) {
				return $.get(assetPath, {
					name: query,
					zone: $("#zone").val()
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
		new_input += '<label class="clientName" for="client_name_"'+clientElemCount+'">Client Name</label>';
		new_input += '<input type="text" name="client_name[]" id="client_name_'+clientElemCount+'" class="form-control" id="client_name_'+clientElemCount+'" placeholder="Enter Client Name" required="">';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label class="clientMob" for="client_mobile_"'+clientElemCount+'">Client Mobile</label>';
		new_input += '<input type="text" name="client_mobile[]" id="client_mobile_"'+clientElemCount+'" class="form-control" id="client_mobile_"'+clientElemCount+'" placeholder="Enter Client Mobile number" required="">';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label class="clientEmail" for="client_email_"'+clientElemCount+'">Client Email</label>';
		new_input += '<input type="text" name="client_email_[]" id="client_email_"'+clientElemCount+'" class="form-control" id="client_mobile_"'+clientElemCount+'" placeholder="Enter Client Email" required="">';
		new_input += '</div>';
		new_input += '<div class="col btnDiv">';
		new_input += '<label class="clientAction" for="client_name">Action</label>';
		new_input += '<button type="button" onclick="addMoreClients();" class="btn btn-primary">Add Clients</button><button type="button" onclick="removeClients(client_row_'+clientElemCount+');" class="btn btn-danger">Remove</button>';
		new_input += '</div></div>';
		$('#client-list').append(new_input);
	}
	function removeClients(row) {
		$(row).remove();
	}
	function submitForm(){
		var dataObj = {};
		var modal = '';
		var data = '';
		modal += '<div class="row">';
		modal += '<div class="col"><label>Date: '+$("#current_date").val()+'</label></div>';
		data += 'Date: '+$("#current_date").val();
		dataObj.date = $("#current_date").val();
		modal += '<div class="col"><label>Beat Plan Date: '+$("#effective_date").val()+'</label></div>';
		data += ' Beat Plan Date: '+$("#effective_date").val();
		dataObj.plandate = $("#effective_date").val();
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>MP/Zone: '+$("#zone").val()+'</label></div>';
		data += ' MP/Zone: '+$("#zone").val();
		dataObj.zone = $("#zone").val();
		modal += '<div class="col"><label>Route Plan: '+$("#route").val()+'</label></div>';
		data += ' Route Plan: '+$("#route").val();
		dataObj.route = $("#route").val();
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>Vehicle No.: '+$("#vehicale_number").val();+'</label></div>';
		data += ' Vehicle No.: '+$("#vehicale_number").val();
		dataObj.vehicle = $("#vehicale_number").val();
		modal += '<div class="col"><label>Trip Id: '+$("input[name='trip_id']").val();+'</label></div>';
		data += ' Trip Id: '+$("input[name='trip_id']").val();
		dataObj.trip_id = $("input[name='trip_id']").val();

		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>Driver Name & Contact: '+$("#_driver option:selected").text();+'</label></div>';
		data += ' Driver Name & Contact: '+$("#_driver option:selected").text();
		dataObj.driver = $("#_driver option:selected").text();
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>Filler Name & Contact: '+$("#fiiler option:selected").text();+'</label></div>';
		data += ' Filler Name & Contact: '+$("#fiiler option:selected").text();
		dataObj.filler = $("#fiiler option:selected").text();
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>Loading Point: '+$("#loading_point option:selected").text();+'</label></div>';
		data += ' Loading Point: '+$("#loading_point option:selected").text();
		dataObj.ro = $("#loading_point option:selected").text();
		modal += '</div>';
		modal += '<div class="row">';
		modal += '<div class="col"><label>No Of Sites: '+$('#site-list').children().length+'</label></div>';
		data += ' No Of Sites: '+$('#site-list').children().length;
		dataObj.sitesLength = $('#site-list').children().length;
		var qty = 0;
		dataObj.sites = [];
		$('#site-list').children().each(function(i,elem){
			var row_id = $(elem).attr("row_id");
			qty += parseInt($('#quantity_'+row_id).text());
		});
		modal += '<div class="col"><label>Sites Quantity: '+qty+'</label></div>';
		data += ' Quantity: '+qty;
		dataObj.totalQty = qty;
		modal += '</div>';
		modal += '<table><th>Site Id</th><th>Site Name</th><th>Qty</th><th>Technician Name</th>';
		$('#site-list').children().each(function(i,elem){
			var row_id = $(elem).attr("row_id");
			if($('#site_row_'+row_id).length) {
				let siteId = $('#site_id_'+row_id).val();
				let qty = $('#quantity_'+row_id).text();
				let siteName = $('#site_name_'+row_id).text();
				let techName = $('#techName_'+row_id).val();
				data += ' Site Id: '+siteId+' Site Name: '+siteName+' Qantity: '+qty+' Tecnician: '+techName;
				dataObj.sites.push({
					'siteId': siteId,
					'siteName': siteName,
					'qty': qty,
					'techName': techName
				});
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
		modal += '</table>';
		$(".modal-body").html(modal);
		$(".whatsapp").attr("data-text","https://web.whatsapp.com/send?text="+encodeURIComponent(data));
		$(".email").click(dataObj,function(){
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
		
		$("#tripAllotModal").modal('show');
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
	/* share code whats app*/
	$(document).ready(function() {

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
	});
</script>
@endpush