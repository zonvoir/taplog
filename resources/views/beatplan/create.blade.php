@extends('layouts.app', ['page' => __('Create Beat Plan'), 'pageSlug' => 'beatplan'])
@section('content')
@push('css')
<style type="text/css">
	.navigation-wrap {
	    position: relative !important;
	}
</style>
@endpush
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col">
						<h4 class="card-title">Create Beat Plan</h4>
					</div>
					<div class="col">
						<button type="button" class="btn btn-fill btn-primary" style="float: right;" data-toggle="modal" data-target="#exampleModal">Import CSV</button>
						<a href="{{ asset('public/beatplan-sample.csv') }}" target="_blank" class="btn btn-fill btn-primary" style="float: right;">View Sample</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{route('add-beat-plan')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col">
							<label for="clientname">Select Client</label>
							<input type="hidden" name="client_id">
							<input type="text" id="clientname" name="clientname" value="{{ (isset($qparams['name']) ? $qparams['name'] : '') }}" class="typeahead form-control" placeholder="Enter Client Name" required="" />
						</div>
						<div class="col">
							<label for="current_date">Current Date</label>
							<input type="text" name="current_date" class="form-control" id="current_date" placeholder="Enter Date" required="" value="{{date('d-m-Y')}}" readonly="">
						</div>
						<div class="col">
							<label for="zone">Mp/Zone</label>
							<input type="text" name="zone" class="typeahead form-control" id="zone" placeholder="Enter Mp/Zone name" required="" value="{{ (isset($qparams['name']) ? $qparams['name'] : '') }}">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="effective_date">Effective Date</label>
							<input type="text" name="effective_date" class="form-control datepicker" placeholder="Proposed date for beat plan" required="">
						</div>
						<div class="col">
							<label for="mode">Mode</label>
							<select name="mode" class="form-control" id="mode" required="">
								<option>Normal</option>
								<option>Emergency</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="add_site_btn">
								<button type="button" onclick="addMoreSites();" class="btn btn-primary form-control">Add Sites</button>
							</div>
						</div>
					</div>
					<div id="site-list">
					<!-- <div class="row">
						<div class="col">
							<label for="site_name">Site Name</label>
							<input type="hidden" name="site_id">
							<input type="text" name="site_name" class="form-control" id="site_name" placeholder="Enter Site Name" required="">
						</div>
						<div class="col" id="hidden-div" style="display: none;">
							<label for="qty">Quantity</label>
							<input type="text" name="qty" class="form-control" id="qty" placeholder="Enter Quantity" required="">
						</div>
					</div> -->
				</div>
				<input type="submit" value="Submit" class="btn btn-primary"/>
			</form>
		</div>
	</div>
</div>
</div>
<div class="modal modal-black fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="exampleInputCSV">Choose file</label>
						<input type="file" name="file" class="form-control" id="exampleInputCSV" aria-describedby="CSVHelp" placeholder="" required="">
						<small id="CSVHelp" class="form-text text-muted">Click any where here for choose file.</small>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script type="text/javascript">
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
		new_input += '<div class="row" id="site_row_'+siteElemCount+'">';
		new_input += '<div class="col">';
		new_input += '<label for="site_id_'+siteElemCount+'">Site Id</label>';
		new_input += '<input type="hidden" name="siteid[]" id="siteid_'+siteElemCount+'">';
		new_input += '<input type="text" autocomplete="off" class="typeahead form-control" id="site_id_'+siteElemCount+'" placeholder="Enter Site Id" value="" required="">';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label for="site_name_'+siteElemCount+'">Site Name : </label><br>';
		new_input += '<label id="site_name_'+siteElemCount+'"></label>';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label for="tech_name_'+siteElemCount+'">Technician Name : </label><br>';
		new_input += '<label id="tech_name_'+siteElemCount+'"></label>';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label for="quantity_'+siteElemCount+'">Quantity : </label>';
		new_input += '<input type="text" name="quantity[]" class="form-control" id="quantity_'+siteElemCount+'" placeholder="Enter Quantity" required="">';
		new_input += '</div>';
		new_input += '<div class="col">';
		new_input += '<label for="">Action</label>';
		new_input += '<button type="button" id="rm_btn_'+siteElemCount+'" data-value="" onclick="removeSite('+siteElemCount+');" class="btn btn-danger form-control">Remove</button>';
		new_input += '</div>';
		new_input += '</div>';
		$('#site-list').append(new_input);
		let siteIdPath = "{{'site-list-plan'}}/"+$("#zone").val()+"/"+$('input[name="client_id"]').val();
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
              $("#rm_btn_"+siteElemCount).attr('data-value',current.id);

              //console.log(current.id);
              if(addedSites.includes(current.id)){
              	alert('Already added!')
              	$('#site_id_'+siteElemCount).val('');
              	$("#siteid_"+siteElemCount).val('');
              	$("#site_name_"+siteElemCount).html('');
              	$("#tech_name_"+siteElemCount).html('');
              	$("#rm_btn_"+siteElemCount).attr('data-value','');
              }else{
              	//console.log(false);
              	addedSites.push(current.id);
              }
              console.log(addedSites);
          } else {
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
		let siteId = $('#rm_btn_'+row).attr('data-value');
		const index = addedSites.findIndex(function(site){ return site == siteId; });
		if (index > -1) {
			addedSites.splice(index, 1);
		}
		$('#site_row_'+row).remove();
	}
	function extractNumVal(str){
		var matches = str.match(/(\d+)/); 
		if (matches) { 
			return matches[0]; 
		} 
	}

</script>
@endpush