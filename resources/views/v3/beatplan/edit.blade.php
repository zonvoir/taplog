@extends('v3.app', ['page' => __('Edit Beat Plan'), 'pageSlug' => 'beatplan'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col">
						<h4 class="card-title">Edit Beat Plan</h4>
					</div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{route('update-beat-plan')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="beatplan_id" value="{{$plan->id}}">
					<div class="row">
						<div class="col">
							<label for="clientname">Select Client</label>
							<input type="hidden" name="client_id" value="{{$plan->client_id}}">
							<input type="text" id="clientname" name="clientname" value="{{$plan->client->name}}" class="typeahead form-control" placeholder="Enter Client Name" required="" />
						</div>
						<div class="col">
							<label for="current_date">Current Date</label>
							<input type="text" name="current_date" class="datepicker form-control" id="current_date" placeholder="Enter Date" required="" value="{{$plan->added_date}}">
						</div>
						<div class="col">
							<label for="zone">Mp/Zone</label>
							<input type="text" name="zone" class="typeahead form-control" id="zone" placeholder="Enter Mp/Zone name" required="" value="{{ $plan->mp_zone }}">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="effective_date">Effective Date</label>
							<input type="text" name="effective_date" class="form-control datepicker" placeholder="Proposed date for beat plan" value="{{$plan->effective_date}}" required="">
						</div>
						<div class="col">
							<label for="mode">Mode</label>
							<select name="mode" class="form-control" id="mode" required="">
								<option {{$plan->mode == 'normal'? 'selected' : ''}}>Normal</option>
								<option {{$plan->mode == 'emergency'? 'selected' : ''}}>Emergency</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<!--div class="add_site_btn">
                              <button type="button" onclick="addMoreSites();" class="btn btn-primary form-control">Add Sites</button>
                          </div-->
                      </div>
                  </div>
                  <div id="site-list">
                  	@php $sites = $plan->beatplan_data; $i=1; @endphp
                  	@if(isset($sites) && !empty($sites))
                  	@foreach($sites as $site) 
                  	<div class="row" id="site_row_{{$i}}">
                  		<div class="col">
                  			<input type="hidden" name="plandata_id[]" value="{{$site->id}}">
                  			<label for="site_id_{{$i}}">Site Id</label>
                  			<input type="hidden" name="siteid[]" id="siteid_{{$i}}" value="{{$site->site_id}}">
                  			<input type="text" class="typeahead form-control" id="site_id_{{$i}}" placeholder="Enter Site Id"  value="{{$site->site->site_id}}" required="">
                  		</div>
                  		<div class="col">
                  			<label class="siteL" for="site_name_{{$i}}">Site Name : </label><br>
                  			<label class="siteV" id="site_name_{{$i}}">{{$site->site->site_name}}</label>
                  		</div>
                  		<div class="col">
                  			<label class="siteTL" for="site_name_{{$i}}">Technician Name : </label><br>
                  			<label class="siteTV" id="tech_name_{{$i}}">{{$site->site->technician_name}}</label>
                  		</div>
                  		<div class="col">
                  			<label class="siteQL" for="quantity_{{$i}}">Quantity : </label>
                  			<input type="text" name="quantity[]" class="form-control" id="quantity_{{$i}}" placeholder="Enter Quantity" required="" value="{{$site->quantity}}">
                  		</div>
                  		<div class="col btnDiv">
                  			<label class="siteAction" for="">Action</label>
                  			<button type="button" onclick="addMoreSites();" class="btn btn-primary">Add Sites</button>
                  			<button type="button" id="site_btn_{{$i}}" onclick="removeSite(site_row_{{$i}},{{$site->id}});" class="btn btn-danger">Remove</button>
                  		</div>
                  	</div>
                  	@php $i++; @endphp
                  	@endforeach
                  	@endif
                  </div>
                  <input type="submit" value="Update" class="btn btn-primary"/>
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
<script type="text/javascript">
	var removedIndex = [];
	function addMoreSites() {
		let new_input = '';
		var siteElemCount = 0;
		if(removedIndex.length == 0){
			siteElemCount = parseInt($('#site-list').children().length)+1;
		}else{
			siteElemCount = removedIndex[removedIndex.length - 1]; 
			const elemIndex = removedIndex.findIndex(function(elem){ return elem == siteElemCount; });
			if (elemIndex > -1) {
				removedIndex.splice(elemIndex, 1);
			}
			console.log('after Add: '+removedIndex)
		}
		new_input += '<div class="row" id="site_row_'+siteElemCount+'">';
		new_input += '<div class="col">';
		new_input += '<input type="hidden" name="plandata_id[]">';
		new_input += '<label for="site_id_'+siteElemCount+'">Site Id</label>';
		new_input += '<input type="hidden" name="siteid[]" id="siteid_'+siteElemCount+'">';
		new_input += '<input type="text" class="typeahead form-control" id="site_id_'+siteElemCount+'" placeholder="Enter Site Id" value="" required="">';
		new_input += '</div>';
		new_input += '<div class="col siteName">';
		new_input += '<label class="siteL" for="site_name_'+siteElemCount+'">Site Name : </label><br>';
		new_input += '<label class="siteV" id="site_name_'+siteElemCount+'"></label>';
		new_input += '</div>';
		new_input += '<div class="col sTechnician">';
		new_input += '<label class="siteTL" for="tech_name_'+siteElemCount+'">Technician Name : </label><br>';
		new_input += '<label class="siteTV" id="tech_name_'+siteElemCount+'"></label>';
		new_input += '</div>';
		new_input += '<div class="col sQuantity">';
		new_input += '<label class="siteQL" for="quantity_'+siteElemCount+'">Quantity : </label>';
		new_input += '<input type="text" name="quantity[]" class="form-control" id="quantity_'+siteElemCount+'" placeholder="Enter Quantity" required="">';
		new_input += '</div>';
		new_input += '<div class="col btnDiv">';
		new_input += '<label class="siteAction" for="">Action</label>';
		new_input += '<button type="button" onclick="addMoreSites();" class="btn btn-primary">Add Sites</button><button type="button" id="site_btn_'+siteElemCount+'" onclick="removeSite(site_row_'+siteElemCount+','+null+');" class="btn btn-danger">Remove</button>';
		new_input += '</div>';
		new_input += '</div>';
		$('#site-list').append(new_input);
		let siteIdPath = "{{route('site-list-plan')}}/"+$("#zone").val()+"/"+$('input[name="client_id"]').val();
		$('#site_id_'+siteElemCount).typeahead({
			source: function(query, process) {
				return $.get(siteIdPath, {
					name: query
				}, function(data) {
					//console.log('sds'+siteElemCount, data);
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
              $("#site_name_"+siteElemCount).html(current.site_name);
              $("#tech_name_"+siteElemCount).html(current.technician_name);
              $("#siteid_"+siteElemCount).val(current.id);
              // check added or not
              let return_val =  addedSites.includes(''+current.id+'');
              if(return_val == true){
              	alert('Already added!');
              	$('#site_id_'+siteElemCount).val('');
              	$("#siteid_"+siteElemCount).val('');
              	$("#site_name_"+siteElemCount).html('');
              	$("#tech_name_"+siteElemCount).html('');
              }else{
              	addedSites.push(current.id);
              }
              
          } else {
              // This means it is only a partial match, you can either add a new item
              // or take the active if you don't want new items
          }
      } else {
            // Nothing is active so it is a new value (or maybe empty value)
            $('#site_id_'+siteElemCount).val('');
            $("#site_name_"+siteElemCount).html('');
            $("#tech_name_"+siteElemCount).html('');
            $("#siteid_"+siteElemCount).val('');
        }
    }); 
	}
	function removeSite(row,dataId) {
		if(confirm("Are you sure ?")){
			let sites = $(row).attr('id').split('site_row_');
			let rowIndex = sites[1];
			removedIndex.push(rowIndex);
			let siteId = $('#siteid_'+rowIndex).val();
			if(dataId){
				let token = $('meta[name="csrf-token"]').attr('content');
				$.post( "{{route('remove-sites')}}", {'_token':token,dataId:dataId}, function( data ) {
					if(data.status == 'ok')
						$(row).remove();
					else
						console.log(data);
				});
			}else{
				$(row).remove();
			}
			const index = addedSites.findIndex(function(site){ return site == siteId; });
			if (index > -1) {
				addedSites.splice(index, 1);
			}
		}else{
			console.log("cancel");
		}
	}
</script>
@push('js')
<script type="text/javascript">
	var addedSites = [];
	$(document).ready(function(){
		let size = $("#site-list").children().length;
		for (var i = size; i >= 1; i--) {
			addedSites[i] = $("#siteid_"+i).val();
		}
	});
</script>
@endpush