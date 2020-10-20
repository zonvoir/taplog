@extends('v3.layouts.app', ['page' => __('Loads Data'), 'pageSlug' => 'all-load'])
@section('content')
<style type="text/css">
  .table-item-wrap .table td:nth-child(1),
  .table-item-wrap .table th:nth-child(1),
  .table-item-wrap .table th:nth-child(3),
  .table-item-wrap .table td:nth-child(3),
  .table-item-wrap .table td:nth-child(7)  
  {
    border-left-width: 0;
    white-space: nowrap;
  }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-1">
        <!--begin::Page Heading-->
        <div class="d-flex align-items-baseline flex-wrap mr-5">
          <!--begin::Page Title-->
          <h5 class="text-dark font-weight-bold my-1 mr-5">Loads Data</h5>
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
    @include('v3.layouts.navbars.flash-message')
      <!--begin::Card-->
      <div class="card card-custom">
        <div class="card-header">
          <div class="card-title">
            <span class="card-icon">
              <i class="flaticon2-supermarket text-primary"></i>
            </span>
            <h3 class="card-label">Loads Data</h3>
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
                </span>Export</button>
                <!--begin::Dropdown Menu-->
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                  <!--begin::Navigation-->
                  <ul class="navi flex-column navi-hover py-2">
                    <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose an option:</li>
                    <li class="navi-item">
                      <a href="#" id="exportBeattoExcel" class="navi-link">
                        <span class="navi-icon">
                          <i class="la la-file-excel-o"></i>
                        </span>
                        <span class="navi-text">Excel</span>
                      </a>
                    </li>
                    <li class="navi-item">
                      <a href="#" id="exportBeattoPdf" class="navi-link">
                        <span class="navi-icon">
                          <i class="la la-file-pdf-o"></i>
                        </span>
                        <span class="navi-text">PDF</span>
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
            <div class="card-body table-item-wrap">
              <form class="mb-15">
                <div class="row mb-8">
                  <div class="col-lg-3 mb-lg-0 mb-6">
                    <label>Status:</label>
                    <select class="form-control datatable-input" id="status" name="status" data-col-index="9">
                      <option value="">Select</option>
                    </select>
                  </div>
                  <div class="col-lg-4" style="margin-top: 25px;">
                    <button class="btn btn-primary btn-primary--icon" id="kt_search">
                      <span>
                        <i class="la la-search"></i>
                        <span>Search</span>
                      </span>
                    </button>&#160;&#160;
                    <button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
                      <span>
                        <i class="la la-close"></i>
                        <span>Reset</span>
                      </span>
                    </button>
                  </div>
                </div>
                <div class="row mt-8">
                </div>
              </form>
              <!--begin: Datatable-->
              <table class="table table-bordered table-hover table-checkable" id="trip_datatable" style="margin-top: 13px !important">
                <thead>
                  <tr>
					<th>Trip Id</th>
					<th>Site id</th>
					<th>Site Name</th>
					<th>Site Category</th>
					<th>Technician Name</th>
					<th>Technician Number</th>
					<th>Qty</th>
					<th>Driver Name</th>
					<th>Filler Name</th>
					<th>Status</th>
					<th>Action</th>
                  </tr>
                </thead>
              </table>
              <!--end: Datatable-->
            </div>
          </div>
          <!--end::Card-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::Entry-->
</div>

	<div class="modal fade" id="transferLoadModel" tabindex="-1" role="dialog" aria-labelledby="transferLoadModelLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="transferLoadModelLabel">Load Transfer</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form>
	        	<div class="row">
					<div class="col">
						<label for="vehicale_number">Vehicle Number</label>
						<input type="hidden" name="vehicle_id" id="vehicle_id">
						<input type="text" name="vehicale_number" class="typeahead form-control vehicale_number" id="vehicale_number" placeholder="Enter Vehicle Number" required="">
					</div>
					<div class="col">
						<label for="driver">Driver</label>
						<select name="driver" id="driver" class="form-control">
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
						<label for="filler">Fillers</label>
						<select name="filler" id="filler" class="form-control">
							<option>Select Filler</option>
							@if(isset($fillers) && !empty($fillers))
							@foreach($fillers as $filler)
							<option value="{{$filler->id}}">{{$filler->name}}({{$filler->contact ? $filler->contact : 'NA'}})</option>
							@endforeach
							@endif
						</select>
					</div>
				</div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary transfer_load dis_btn" verified_id="">Transfer</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade" id="divertLoadModel" tabindex="-1" role="dialog" aria-labelledby="divertLoadModelLabelD" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabelD">Divert</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
		  
	      <div class="modal-body">
	        <form id="divert_form">
					<div class="row">
						<input type="hidden" name="from_site[]" id="from_site" value="" />
						<input type="hidden" class="form-control" name="old_qty[]" id="old_qty" placeholder="Qty" value="">
						<div class="col-12">
							<p>
								<strong>
									Site: <span class="sName"></span> <span class="sID"></span>
								</strong>
							</p>
							<p>
								<strong>Qty: <span class="sQty"></span></strong>	
							</p>
							
						</div>
						<div class="col-12 mb-2">
							<label><strong>Divert to Site</strong></label>
							<select class="form-control" name="to_site[]">
								@foreach($sites as $key=>$site1)
								
								<option value="{{$site1->id}}">
								
								{{$site1->site_name}} ({{$site1->site_id}})
								</option>
								@endforeach
							</select>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label><strong>Qty</strong></label>
								<input type="number" class="form-control" name="qty[]" id="new_qty" placeholder="Qty" value="" />
							</div>
						</div>
					</div>	
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary divert_load dis_btn" row_id="">Save</button>
	      </div>
	    </div>
	  </div>
	</div>

@endsection
@push('js')
<script src="{{ asset('public') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script type="text/javascript">
	'use strict';
	var PLANDatatablesDataSourceAjaxServer = function() {
	$.fn.dataTable.Api.register('column().title()', function() {
		return $(this.header()).text().trim();
	});
	var initTable1 = function() {
		var table = $('#trip_datatable').DataTable({
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			buttons: [
			{ 
				extend: 'csv',
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
			},
			{ 
				extend: 'pdf',
				exportOptions: {
					columns: 'th:not(:last-child)'
				},
				orientation: 'landscape',
        		pageSize: 'A2'
			}
			],
			order: [ [0, 'desc'] ],
			/*dom: 'Bfrtip',*/
			/*buttons: [*/
			/*'copy', 'csv', 'excel', 'pdf', 'print',*/
				/*{
					extend: 'excelHtml5',
					exportOptions: {
						columns: 'th:not(:last-child)'
					},
				},
				{
					extend: 'pdf',
					exportOptions: {
						columns: 'th:not(:last-child)'
					},
				}*/
				/*],*/
				ajax: {
					url: '{{ route('loads_data_datatable') }}',
					type: 'GET',
					data: function(data){
						var trip_id =  "{{ request('trip_id') }}";
						data.trip_id = trip_id;
						data.status = $("#status").val();
					},
			},
			initComplete: function() {
				this.api().columns().every(function() {
					var column = this;

					switch (column.title()) {
						case 'Status':
							column.data().unique().sort().each(function(d, j) {
								$('.datatable-input[data-col-index="9"]').append('<option value="' + d + '">' + d + '</option>');
							});
							break;
					}
				});
			},
			columns: [
				{data: 'trip_id'},
				{data: 'site_id'},
				{data: 'site_name', name: 'site.site_name'},
				{data: 'site_cat', name: 'site.site_category'},
				{data: 'tech_name', name: 'site.technician_name'},
				{data: 'tech_no', name: 'site.technician_contact1'},
				{data: 'qty'},
				{data: 'driver_name', name: 'trip.driver.name' },
				{data: 'filler_name', name: 'trip.filler.name'},
				{data: 'status'},
				{data: 'action'},
			],
		});
		
		$('#kt_search').on('click', function(e) {
			e.preventDefault();
			table.draw();
		});

		$('#kt_reset').on('click', function(e) {
			e.preventDefault();
			$('.datatable-input').each(function() {
				$(this).val('');
				table.column($(this).data('col-index')).search('', false, false);
			});
			table.table().draw();
		});

		$('#kt_datepicker').datepicker({
			format: 'dd-mm-yyyy',
			todayHighlight: true,
			templates: {
				leftArrow: '<i class="la la-angle-left"></i>',
				rightArrow: '<i class="la la-angle-right"></i>',
			},
			autoclose: true
		});

		$("#exportBeattoPdf").on("click", function() {
			table.button( '.buttons-pdf' ).trigger();
		});

		$("#exportBeattoExcel").on("click", function() {
			table.button( '.buttons-csv' ).trigger();
		});

		$('.transfer_load').click(function(){
			var verified_id  = $(this).attr('verified_id');
			var vehicle_id	 = $("#vehicle_id").val();
			var driver 		 = $("#driver").val();
			var filler 	 	 = $("#filler").val();
			var area_officer = $("#area_officer").val();

			$('.modal-content').find('input, textarea, button, select').attr('disabled','disabled');
			$('.modal-content').css('cursor', 'wait');
			$.ajax({
		        url: "{{route('backlog.load_transfer')}}",
		        data: {_token: csrf_token, verified_id: verified_id, vehicle_id: vehicle_id, driver_id: driver, filler_id: filler, area_officer: area_officer},
		        type: 'POST',
		        success: function(response){
		        	//location.reload(true);
		        	$('#transferLoadModel').modal('toggle');
					$('.modal-content').find('input, textarea, button, select').val('').removeAttr('disabled');
					$('.modal-content').css('cursor', 'default');
		        	table.draw();
		        }    
		    });
		});

		$('.divert_load').click(function(){
			var row_id  = $(this).attr('row_id');
			var old_qty  = $("#old_qty").val();
			var new_qty  = $("#new_qty").val();
			
			if(parseInt(new_qty) <= parseInt(old_qty)){
				var form_data123 = $("#divert_form").find("select,input").serialize();
				$('.modal-content').find('input, textarea, button, select').attr('disabled','disabled');
				$('.modal-content').css('cursor', 'wait');
				//console.log(form_data123);
				$.ajax({
					url: "{{route('backlog.save_divert')}}",
					data: form_data123+'&_token='+csrf_token+'&verified_id='+row_id ,
					type: 'POST',
					success: function(response){
						$('#divertLoadModel').modal('toggle');
						$('.modal-content').find('input, textarea, button, select').val('').removeAttr('disabled');
						$('.modal-content').css('cursor', 'default');
						table.draw();
					}    
				});
			}else{
				alert('Quantity must be less than or equal to old quantity');
				return;
			}
		});
		
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

	}();


	$(document).ready(function(){
		PLANDatatablesDataSourceAjaxServer.init();

		$(document).on('click', '.lModal', function(){
			var verified_id = $(this).attr('verified_id');
			$(".transfer_load").attr('verified_id', verified_id);
		});
		$(document).on('click', '.dModal', function(){
			var verified_id = $(this).attr('verified_id');
			$(".divert_load").attr('row_id', verified_id);
			var site_id = $(this).attr('site_id');
			var site_id_primary = $(this).attr('site_id_primary');
			var site_name = $(this).attr('site_name');
			var site_qty = $(this).attr('site_qty');
			$(".divert_load").attr('verified_id', verified_id);
			$("#old_qty").val(site_qty);
			$("#from_site").val(site_id_primary);
			$(".sName").text(site_name);
			$(".sID").text(site_id);
			$(".sQty").text(site_qty);
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