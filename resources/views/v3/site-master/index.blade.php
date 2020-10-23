@extends('v3.layouts.app', ['page' => __('Site Master'), 'pageSlug' => 'site_master'])
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
          <h5 class="text-dark font-weight-bold my-1 mr-5">Site Master</h5>
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
            <h3 class="card-label">Site Master</h3>
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
              <!--begin::Button-->
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
                    <!--end::Dropdown-->
                </div>
                <!--end::Button-->
              </div>
            </div>
            <div class="card-body table-item-wrap">
              <form class="mb-15">
                <div class="row mb-8">
                  <div class="col-lg-8 mb-lg-0 mb-6">
                    <label>Effective Date:</label>
                    <div class="input-daterange input-group" id="kt_datepicker">
                      <input type="text" class="form-control datatable-input" name="start_date" id="start_date" placeholder="From" data-col-index="5" />
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="la la-ellipsis-h"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control datatable-input" id="end_date" name="end_date" placeholder="To" data-col-index="5" />
                    </div>
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
              <div class="table-responsive">
              <table class="table table-bordered table-hover table-checkable" id="site_datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Site id</th>
                        <th>Unique Site ID</th>
                        <th>Site Name</th>
                        <th>Cluster/JC</th>
                        <th>District</th>
                        <th>MP / Zone</th>
                        <th>Site Address</th>
                        <th>Lat</th>
                        <th>Long</th>
                        <th>Site Type</th>
                        <th>BTS</th>
                        <th>Site Category</th>
                        <th>Battery Bank (AH)</th>
                        <th>CPH</th>
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
    <div class="modal fade" id="viewSiteMasterModal" tabindex="-1" role="dialog" aria-labelledby="divertLoadModelLabelD" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelD">Site Master</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body">
                <div data-scroll="true" data-height="300">
                  <div class="row">
                    <div class="col-xs-12 col-md-12">
                      <table class="table table-hover table-sm" id="siteModalData">
                       
                      </table>
                    </div>
                  </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary dis_btn" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary divert_load dis_btn" row_id="">Save</button>
          </div>
        </div>
      </div>
    </div>
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
                            <div class="dropzone dropzone-default dz-clickable" id="site-csv-upload">
                                <div class="dropzone-msg dz-message needsclick">
                                    <h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
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
<script src="{{ asset('public') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script type="text/javascript">
    'use strict';
    var PLANDatatablesDataSourceAjaxServer = function() {
        $.fn.dataTable.Api.register('column().title()', function() {
            return $(this.header()).text().trim();
        });
        var initTable1 = function() {
            var table = $('#site_datatable').DataTable({
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                scrollY: '50vh',
                scrollX: true,
                scrollCollapse: true,
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
                    url: '{{ route('site.datatable') }}',
                    type: 'GET',
                    data: function(data){
                        var trip_id =  "{{ request('trip_id') }}";
                        data.trip_id = trip_id;
                        data.status = $("#status").val();
                    },
                },
                columns: [
                    { "data": "id", "visible": false },
                    { "data": "site_id" },
                    { "data": "unique_site_id" },
                    { "data": "site_name" },
                    { "data": "cluster_jc" },
                    { "data": "district" },
                    { "data": "mp_zone" },
                    { "data": "site_address" },
                    { "data": "latitude" },
                    { "data": "longitude" },
                    { "data": "site_type" },
                    { "data": "bts" },
                    { "data": "site_category" },
                    { "data": "battery_bank_ah" },
                    { "data": "cph" },
               // {data: 'status', name: 'status'},
                    {data: 'action', orderable: false, searchable: false},
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


            $(document).on('click', '.delete', function(e) {
                var url = $(this).data('href')
                // console.log($(this).data('href'));
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: csrf_token
                            },
                            success: function () {
                                Swal.fire(
                                    "Deleted!",
                                    "Your file has been deleted.",
                                    "success"
                                ).then(function(result){
                                    table.draw();
                                });
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                Swal.fire(
                                    "Error deleting!",
                                    "Please try again.",
                                    "error"
                                )
                            }
                        });
                        
                    }
                    
                });
            });

            $(document).on('click', '.sModal', function(e){
                var site_id = $(this).attr('site_id');
                $.ajax({
                    url: "{{route('site.detail')}}",
                    data: { site_id: site_id},
                    type: 'GET',
                    success: function(response){
                        $("#siteModalData").html(response);
                    }    
                });
            });

            var beatsUploadDz = new Dropzone("#site-csv-upload",{
                method: 'POST',
                url: "{{ route('site.import') }}", // Set the url for your upload script location
                paramName: "file", // The name that will be used to transfer the file
               // maxFiles: 10,
               // maxFilesize: 5, // MB
                addRemoveLinks: true,
                acceptedFiles: 'text/csv',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            beatsUploadDz.on("success", function(file,resp) {
                if(resp.status == 1){
                    this.defaultOptions.success(file, resp.message);
                    table.draw();
                }else{
                    this.defaultOptions.error(file, resp.message);
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
});

</script>
@endpush