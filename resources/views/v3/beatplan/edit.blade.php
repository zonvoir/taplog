@extends('v3.layouts.app', ['page' => __('Create Beat Plan'), 'pageSlug' => 'beatplan'])
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
					<h5 class="text-dark font-weight-bold my-1 mr-5">Beat Plan</h5>
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
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Card-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="row">
						<h3 class="card-title">
							Edit Plan
						</h3>
					</div>
				</div>
				<!--begin::Form-->
				<form class="form" action="{{route('update-beat-plan')}}" method="POST" autocomplete="off">
					@csrf
					<div class="card-body">
						<div class="form-group row">
							<input type="hidden" name="beatplan_id" value="{{$plan->id}}">
							<div class="col-lg-4">
								<label>Client:</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
									<input type="hidden" name="client_id" value="{{$plan->client_id}}">
									<input type="text" id="clientname" class="form-control" placeholder="Enter client name" value="{{$plan->client->name}}" required=""/>
								</div>
								<span class="form-text text-muted">Please enter client name and select from suggetions</span>
							</div>
							<div class="col-lg-4">
								<label>Current Date:</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="la la-calendar"></i></span></div>
									<input type="text" name="current_date" class="form-control" readonly placeholder="Enter date" value="{{$plan->added_date}}" />
								</div>
								<span class="form-text text-muted">Date of Today's</span>
							</div>
							<div class="col-lg-4">
								<label>Zone:</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="la la-map-marker"></i></span></div>
									<input type="text" name="zone" id="zone" class="form-control" placeholder="Enter Mp/Zone name" value="{{ $plan->mp_zone }}" required="" />
								</div>
								<span class="form-text text-muted">Please enter zone and select from suggetions</span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Effective Date:</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text"><i class="la la-calendar"></i></span></div>
									<input type="text" name="effective_date" id="kt_datepicker_3" class="form-control" readonly placeholder="Enter date" value="{{$plan->effective_date}}"/>
								</div>
								<span class="form-text text-muted">Please enter plan date</span>
							</div>
							<div class="col-lg-6">
								<label for="selectMode">Mode <span class="text-danger">*</span></label>
								<select class="form-control" name="mode" id="selectMode" required="">
									<option value="normal" {{$plan->mode == 'normal'? 'selected' : ''}}>Normal</option>
									<option value="emergancy" {{$plan->mode == 'emergency'? 'selected' : ''}}>Emergancy</option>
								</select>
								<span class="form-text text-muted">Please select Mode</span>
							</div>
						</div>

						<div class="separator separator-dashed my-8"></div>

						<div id="kt_repeater_1">
							<div class="form-group row" id="kt_repeater_1">
								<label class="col-lg-12 col-form-label text-left">
									<strong>Sites:</strong>
								</label>

								<div data-repeater-list="siteArray" class="col-lg-12">
									@if(isset($plan->beatplan_data) && !empty($plan->beatplan_data) && count($plan->beatplan_data))
									@foreach($plan->beatplan_data as $site) 
									<div data-repeater-item class="form-group row align-items-center">
										<div class="col">
											<label>Site Id:</label>
											<input type="hidden" name="siteid" class="siteid" value="{{$site->site_id}}">
                  							<input type="hidden" name="plandata_id" class="plandata_id" value="{{$site->id}}">
											<input type="text" class="sites form-control" placeholder="Enter site id" required="" value="{{$site->site->site_id}}"/>
											<div class="invalid-feedback"></div>
											<div class="d-md-none mb-2"></div>
										</div>

										<div class="col">
											<label>Site Name:</label>
											<input type="text" class="site_name form-control" placeholder="Site name not found!" readonly="" value="{{$site->site->site_name}}" />
											<div class="d-md-none mb-2"></div>
										</div>

										<div class="col">
											<label>Technician:</label>
											<input readonly="" type="text" class="tech_name form-control" placeholder="Technician name not found!" value="{{$site->site->technician_name}}"/>
											<div class="d-md-none mb-2"></div>
										</div>
										<div class="col">
											<label>Quantity:</label>
											<input type="number" name="quantity" class="form-control" min="0" placeholder="Enter Quantity" required="" value="{{$site->quantity}}"/>
											<div class="d-md-none mb-2"></div>
										</div>
										<div class="col-md-2">
											<div class="">
												<p>Action</p>
												<a  href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
													<i class="la la-trash-o"></i> Delete
												</a>
											</div>
										</div>
									</div>
									@endforeach
									@else
									<div data-repeater-item class="form-group row align-items-center">
										<div class="col">
											<label>Site Id:</label>
											<input type="hidden" name="siteid" class="siteid" value="">
											<input type="text" class="sites form-control" placeholder="Enter site id" required="" value=""/>
											<div class="invalid-feedback"></div>
											<div class="d-md-none mb-2"></div>
										</div>

										<div class="col">
											<label>Site Name:</label>
											<input type="text" class="site_name form-control" placeholder="Site name not found!" readonly="" value="" />
											<div class="d-md-none mb-2"></div>
										</div>

										<div class="col">
											<label>Technician:</label>
											<input readonly="" type="text" class="tech_name form-control" placeholder="Technician name not found!" value=""/>
											<div class="d-md-none mb-2"></div>
										</div>
										<div class="col">
											<label>Quantity:</label>
											<input type="number" name="quantity" class="form-control" min="0" placeholder="Enter Quantity" required="" value=""/>
											<div class="d-md-none mb-2"></div>
										</div>
										<div class="col-md-2">
											<div class="">
												<p>Action</p>
												<a  href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
													<i class="la la-trash-o"></i> Delete
												</a>
											</div>
										</div>
									</div>
									@endif
								</div>
							</div>
							<div>
								<label style="opacity: 0">s</label>
								<a style="width: 13%;margin-bottom: 20px;" href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
									<i class="la la-plus"></i>Add
								</a>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-lg-2">
								<button style="width: 100%;" type="submit" class="btn font-weight-bold btn-success mr-2">Create</button></div>
								<div class="col-lg-2">
									<button style="width: 100%;" type="reset" class="btn font-weight-bold btn-secondary">Reset</button>
								</div>
							</div>
						</div>
					</form>
					<!--end::Form-->
				</div>
			</div>
		</div>
	</div>
	<!-- Modal-->
	<div class="modal fade" id="importModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="importModal">Import CSV File</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<div class="col-lg-12 col-md-9 col-sm-12">
							<div class="dropzone dropzone-default dz-clickable" id="beat-csv-upload">
								<div class="dropzone-msg dz-message needsclick">
									<h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
									<span class="dropzone-msg-desc">This is just a demo dropzone. Selected files are
										<strong>not</strong>actually uploaded.</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		@endsection
		@push('js')
		<script src="{{ asset('public') }}/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
		<script src="{{ asset('public') }}/assets/js/bootstrap3-typeahead.min.js"></script>
		<script type="text/javascript">
	// Class definition
	var KTFormRepeater = function() {

    // Private functions
    var demo1 = function() {
    	$('#kt_repeater_1').repeater({
    		initEmpty: false,

    		defaultValues: {
    			'text-input': 'foo'
    		},

    		show: function () {
    			$(this).slideDown();
    			$(this).children('div.col').find('.plandata_id').remove();
    			$(this).children('div.col').find('.siteid').val('');
    			$(this).children('div.col').find('.sites').val('');
    			$(this).children('div.col').find('input.site_name').val('');
    			$(this).children('div.col').find('input.tech_name').val('');
    			let siteIdPath = "{{route('site-list-plan')}}/";
    			siteIdPath += $("#zone").val()+"/"+$('input[name="client_id"]').val();
    			$('.sites').typeahead({
    				source: function(query, process) {
    					return $.get(siteIdPath, {
    						name: query
    					}, function(data) {
    						return process(data);
    					});
    				}
    			});
    			$('.sites').change(function() {
    				var current = $(this).typeahead("getActive");
    				if (current) {
    					if (current.name == $(this).val()) {
    						//console.log(siteIdExist(current.id));
    						if(!siteIdExist(current.id)){
    							$(this).siblings('.siteid').val(current.id);
    							$(this).parent('div.col').siblings('div.col').find('input.site_name').val(current.site_name);
    							$(this).parent('div.col').siblings('div.col').find('input.tech_name').val(current.technician_name);
    							$(this).removeClass( "sites form-control is-invalid" ).addClass( "sites form-control" );
    							$(this).siblings('.invalid-feedback').html('')
    						}else{
    							$(this).siblings('.siteid').val('');
    							$(this).removeClass( "sites form-control" ).addClass( "sites form-control is-invalid" );
    							$(this).siblings('.invalid-feedback').html('This id already added.')
    							$(this).val('');
    						}
    					}else{
    						$(this).siblings('.siteid').val('');
    						$(this).parent('div.col').siblings('div.col').find('input.site_name').val('');
    						$(this).parent('div.col').siblings('div.col').find('input.tech_name').val('');
    					}
    				} else {
    					$(this).siblings('.siteid').val('');
    					$(this).parent('div.col').siblings('div.col').find('input.site_name').val('');
    					$(this).parent('div.col').siblings('div.col').find('input.tech_name').val('');
    				} 
    			});
    		},

    		hide: function (deleteElement) {
    			$(this).slideUp(deleteElement);
    			console.log($(this).siblings());
    		}
    	});
    }

    return {
        // public functions
        init: function() {
        	demo1();
        }
    };
}();

jQuery(document).ready(function() {
	KTFormRepeater.init();
});
$(document).ready(function(){
	let clientPath = "{{ route('client-name-list') }}";
	$('#clientname').typeahead({
		source: function(query, process) {
			return $.get(clientPath, {
				name: query
			}, function(data) {
				return process(data);
			});
		}
	});
	$('#clientname').change(function() {
		let current = $(this).typeahead("getActive");
		if (current) {
			if (current.name == $(this).val()) {
				$("input[name='client_id']").val(current.id);
			} else {
				$(this).val('');
			}
		} else {
            // Nothing is active so it is a new value (or maybe empty value)
        }
    });
	let zonepath = "{{ route('zone-name-list') }}";
	$('#zone').typeahead({
		source: function(query, process) {
			return $.get(zonepath, {
				name: query
			}, function(data) {
				return process(data);
			});
		}
	});
	var siteIdPath = '{{route("site-list-plan")}}/'+$('#zone').val()+'/'+$('input[name="client_id"]').val();
	$('#zone').change(function() {
		let current = $(this).typeahead("getActive");
		if (current) {
			if (current.name == $(this).val()) {
				siteIdPath = '{{route("site-list-plan")}}/'+current.name+"/"+$('input[name="client_id"]').val();
				console.log(siteIdPath);
			} else {
				$(this).val('');
				siteIdPath = '';
			}
		} else {
            // Nothing is active so it is a new value (or maybe empty value)
        }
    });
	$('.sites').typeahead({
		source: function(query, process) {
			return $.get(siteIdPath, {
				name: query
			}, function(data) {
				return process(data);
			});
		}
	});
	$('.sites').change(function() {
		var current = $(this).typeahead("getActive");
		if (current) {
			if (current.name == $(this).val()) {
				$(this).siblings('.siteid').val(current.id);
				$(this).parent('div.col').siblings('div.col').find('input.site_name').val(current.site_name);
				$(this).parent('div.col').siblings('div.col').find('input.tech_name').val(current.technician_name);
			}else{
				$(this).siblings('.siteid').val('');
				$(this).parent('div.col').siblings('div.col').find('input.site_name').val('');
				$(this).parent('div.col').siblings('div.col').find('input.tech_name').val('');
			}
		} else {
			$(this).siblings('.siteid').val('');
			$(this).parent('div.col').siblings('div.col').find('input.site_name').val('');
			$(this).parent('div.col').siblings('div.col').find('input.tech_name').val('');
		} 
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
// validation process
</script>
@endpush