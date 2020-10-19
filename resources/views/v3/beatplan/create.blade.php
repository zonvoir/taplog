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
							Create Plan
						</h3>
					</div>
					<div class="card-toolbar">
						<!--begin::Dropdown-->
						<div class="dropdown dropdown-inline mr-2">
							<button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="svg-icon svg-icon-md">
									<!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
											<path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>Import</button>
								<!--begin::Dropdown Menu-->
								<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
									<!--begin::Navigation-->
									<ul class="navi flex-column navi-hover py-2">
										<li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose an option:</li>
										<li class="navi-item">
											<a href="" data-toggle="modal" data-target="#importModal" id="" class="navi-link">
												<span class="navi-icon">
													<i class="la la-file-excel-o"></i>
												</span>
												<span class="navi-text">CSV</span>
											</a>
										</li>
									</ul>
									<!--end::Navigation-->
								</div>
								<!--end::Dropdown Menu-->
							</div>
							<!--end::Dropdown-->
						</div>
					</div>
					<!--begin::Form-->
					<form class="form" action="{{route('add-beat-plan')}}" method="POST" autocomplete="off">
						@csrf
						<div class="card-body">
							<div class="form-group row">
								<div class="col-lg-4">
									<label>Client:</label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
										<input type="hidden" name="client_id">
										<input type="text" id="clientname" class="form-control" placeholder="Enter client name" required=""/>
									</div>
									<span class="form-text text-muted">Please enter client name and select from suggetions</span>
								</div>
								<div class="col-lg-4">
									<label>Current Date:</label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="la la-calendar"></i></span></div>
										<input type="text" name="current_date" class="form-control" readonly placeholder="Enter date" value="{{date('d-m-Y')}}" />
									</div>
									<span class="form-text text-muted">Date of Today's</span>
								</div>
								<div class="col-lg-4">
									<label>Zone:</label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="la la-map-marker"></i></span></div>
										<input type="text" name="zone" id="zone" class="form-control" placeholder="Enter Mp/Zone name" required="" />
									</div>
									<span class="form-text text-muted">Please enter zone and select from suggetions</span>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-6">
									<label>Effective Date:</label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="la la-calendar"></i></span></div>
										<input type="text" name="effective_date" id="kt_datepicker_3" class="form-control" readonly placeholder="Enter date"/>
									</div>
									<span class="form-text text-muted">Please enter plan date</span>
								</div>
								<div class="col-lg-6">
									<label for="selectMode">Mode <span class="text-danger">*</span></label>
									<select class="form-control" name="mode" id="selectMode" required="">
										<option value="normal">Normal</option>
										<option value="emergancy">Emergancy</option>
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
										<div data-repeater-item class="form-group row align-items-center">

											<div class="col">
												<label>Site Id:</label>
												<input type="hidden" name="siteid" class="siteid">
												<input type="text" class="sites form-control" placeholder="Enter site id" required="" />
												<div class="invalid-feedback"></div>
												<div class="d-md-none mb-2"></div>
											</div>

											<div class="col">
												<label>Site Name:</label>
												<input type="text" class="site_name form-control" placeholder="Site name not found!" readonly="" />
												<div class="d-md-none mb-2"></div>
											</div>

											<div class="col">
												<label>Technician:</label>
												<input readonly="" type="text" class="tech_name form-control" placeholder="Technician name not found!" />
												<div class="d-md-none mb-2"></div>
											</div>
											<div class="col">
												<label>Quantity:</label>
												<input type="number" name="quantity" class="form-control" min="0" placeholder="Enter Quantity" required="" />
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
										<span class="dropzone-msg-desc">Import here csv file of
											<strong><a href="{{asset('public/importFormats/beatplan-sample.csv')}}" /download>this</a></strong> format only.</span>
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
	var siteIdPath = '';
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
<script src="{{asset('public')}}/assets/js/pages/crud/file-upload/dropzonejs.js"></script>
@endpush