@extends('layouts.app', ['page' => __('Search Vehicle for Trip'), 'pageSlug' => 'vehicle'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title"> Search Vehicle Trips</h4></div>
				</div>
			</div>
			<div class="card-body">
				<div class="table__wraper_cl">
					<table class="table" style="width:100%">
						<thead>
							<th scope="col">Vehicle Number</th>
							<th scope="col">Action</th>
						</thead>
						<tbody>
							@if(isset($vehicles) && !empty($vehicles))
							@foreach($vehicles as $trip)
							<tr>
								<td>{{$trip->vehicle_no}}</td>
								<td>
									<div class="action_btn_cust">
										<a href="{{route('trips-details',$trip->vehicle_id)}}">View</a>
										<a href="javascript:void(0);" class="update_agreement" data-id="{{ $trip->id }}">Aggrement</a>
									</div>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
					{{ $vehicles->links() }}
				</div>
				<!-- Modal -->
				<div id="agreementModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Agreement</h4>
						</div>
						<div class="modal-body">
							<form action="javascript:void(0);" id="agreementForm" method="POST">
							  <div class="form-group">
							  	<input type="hidden" name="vehicle_id" id="vehicle_id">
							    <label for="average">Vehicle Average:</label>
							    <input type="text" class="form-control" id="average" name="average">
							  </div>
							  <div class="form-group">
							    <label for="rental">Monthly rental:</label>
							    <input type="text" class="form-control" id="rental" name="rental">
							  </div>
							  <div class="form-group">
							    <label for="salary_by">Salary By:</label>
							    <select name="salary_by" id="salary_by" class="form-control">
							    	<option value="vendor">Vendor</option>
							    	<option value="admin">Admin</option>
							    </select>
							  </div>
							  <button type="button" class="btn btn-default" id="agreementUpdate">Update</button>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
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
		$(".update_agreement").click(function(){
			var vehicle_id = $(this).data('id');
			$("#vehicle_id").val(vehicle_id);
			$.ajax({
				url: "{{route('vehicle-agreement')}}",
				data: { _token: csrf_token, vehicle_id: vehicle_id },
				type: 'GET',
				success: function(response){
					if (!jQuery.isEmptyObject(response))
				   	{
						$("#average").val(response.average);
						$("#rental").val(response.rental);
						$("#salary_by").val(response.salary_by);
				    }else{
				    	$("#average").val('');
						$("#rental").val('');
						$("#salary_by").val('');
				    }
					
					$("#agreementModal").modal();
				}    
			});
		});
		$("#agreementUpdate").click(function(){
			var form_data = $("#agreementForm").serialize();
			
			$('.modal-content').find('input, textarea, button, select').attr('disabled','disabled');
			$('.modal-content').css('cursor', 'wait');
				//console.log(form_data123);
			$.ajax({
				url: "{{route('vehicle-update-agreement')}}",
				data: form_data+'&_token='+csrf_token,
				type: 'POST',
				success: function(response){
					$('.modal-content').find('input, textarea, button, select').removeAttr('disabled');
					$('.modal-content').css('cursor', 'default');
					$("#agreementModal").modal('hide');
				}    
			});
		});
	});
</script>
@endpush