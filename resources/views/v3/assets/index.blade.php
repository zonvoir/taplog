@extends('v3.layouts.app', ['page' => __('Assets'), 'pageSlug' => 'assets_master'])
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
          <h5 class="text-dark font-weight-bold my-1 mr-5">Assets</h5>
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
            <h3 class="card-label">Assets</h3>
          </div>
          <div class="card-toolbar">
            <!--begin::Dropdown-->
              <!--end::Dropdown-->
              <!--begin::Button-->
              <a href="{{route('assets.create')}}" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                  <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect x="0" y="0" width="24" height="24" />
                      <circle fill="#000000" cx="9" cy="15" r="6" />
                      <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                    </g>
                  </svg>
                  <!--end::Svg Icon-->
                </span>New Record</a>
                <!--end::Button-->
              </div>
          
            </div>
            <div class="card-body table-item-wrap">
              <!--begin: Datatable-->
              <div class="table-responsive">
              <table class="table table-bordered table-hover table-sm" id="asset_datatable">
                <thead>
                  <tr>
                    <th>ITEM NAME</th>
                    <th>QUANTITY</th>
                    <th>UAM</th>
                    <th>SERIALS</th>
                    <th>MASTER LOCATION</th>
                    <th>BASE LOCATION</th>
                    <th>MAPPED WITH MP</th>
                    <th>MAPPED WITH CUSTOMER</th>
                    <th></th>
                  </tr>
                </thead>
              </table>
            </div>
              <!--end: Datatable-->
            </div>
          </div>
          <!--end::Card-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::Entry-->
</div>
@endsection
@push('js')
<script src="{{ asset('public') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script type="text/javascript">
    'use strict';
    var PLANDatatablesDataSourceAjaxServer = function() {

    var initTable1 = function() {
        var table = $('#asset_datatable').DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
            buttons: [
            { 
                extend: 'excel',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            { 
                extend: 'pdf',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }
            ],
            order: [ [1, 'desc'] ],
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
                    url: '{{ route('asset.datatable') }}',
                    type: 'GET',
                    data: function(data){
                        var start_date = $('#start_date').val();
                        var end_date = $('#end_date').val();

                        // Append to data
                        data.start_date = start_date;
                        data.end_date = end_date;
                    },
            },
            columns: [
                {data: 'item_name'},
                {data: 'qty'},
                {data: 'uam'},
                {data: 's_no'},
                {data: 'master_location'},
                {data: 'base_location'},
                {data: 'mapped_with_mp'},
                {data: 'mapped_with_customer'},
                {data: 'action', searchable: false, sortable: false},
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
            table.button( '.buttons-excel' ).trigger();
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
                            );
                            table.draw();
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
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable1();
        },

    };

    }();

    jQuery(document).ready(function() {
    PLANDatatablesDataSourceAjaxServer.init();

    });
</script>
@endpush