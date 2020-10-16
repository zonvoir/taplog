@extends('v3.layouts.app', ['page' => __('Beat Plans'), 'pageSlug' => 'beatplan'])
@section('content')

<style type="text/css">
  .table-item-wrap .table thead tr th;
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
          <h5 class="text-dark font-weight-bold my-1 mr-5">Beat Plans</h5>
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
          <div class="card-title">
            <span class="card-icon">
              <i class="flaticon2-supermarket text-primary"></i>
            </span>
            <h3 class="card-label">Plan Data Table</h3>
          </div>
          <div style="padding: 20px;"><span class="label label-primary label-inline font-weight-lighter mr-2">Effective Date:</span> {{$beat_plan->effective_date}} </div><div style="padding: 20px;"><span class="label label-primary label-inline font-weight-lighter mr-2">Client:</span> {{$beat_plan->client->name}}</div>
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

              <!--end::Button-->
            </div>
          </div>
          <div class="card-body table-item-wrap">
            <input type="hidden" name="beat_id" value="{{request('beat_id')}}">
            <!--start reange filter section -->
            <!--end reange filter section -->
            <!--begin: Datatable-->
            <!-- <table class="table table-bordered table-hover table-checkable" id="plan_data_table" style="margin-top: 13px !important"> -->
              <table class="table table-separate table-head-custom table-checkable" id="plan_data_table">
              <thead>
                <tr>
                  <th>Trip Id</th>
                  <th>Site id</th>
                  <th>Site Name</th>
                  <th>Site Category</th>
                  <th>Technician Name</th>
                  <th>Technician Contact</th>
                  <th>Qty</th>
                  <th>Current Status</th>
                  <th>Loading Date</th>
                  <th>Loading Start Time</th>
                  <th>Loading Finish Time</th>
                  <th>Filling Date</th>
                  <th>Site In Time</th>
                  <th>Site Out Time</th>
                  <th>Vehicle No</th>
                  <th>Driver Name</th>
                  <th>Driver Contact</th>
                  <th>Filler Name</th>
                  <th>Filler Contact</th>
                  <th>Remark</th>
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
  <!-- Modal-->
  <div class="modal fade" id="remarkModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remark</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="beat_data_id">
          <textarea class="form-control" id="content"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary font-weight-bold" onclick="submitRemark()">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  @endsection
  @push('js')
  <script type="text/javascript">
    function addRemarkModal(id) {
      $('input[name="beat_data_id"]').val(id);
      $('#remarkModal').modal('show');
    }
    function submitRemark() {
      $('.modal-content').find('input, textarea, button, select').attr('disabled','disabled');
      $('.modal-content').css('cursor', 'wait');
      let url = "{{route('backlog.update_remark')}}";
      let data = {_token: $('meta[name="csrf-token"]').attr('content'), beatplandata_id:$('input[name="beat_data_id"]').val(), remarks: $('#content').val()}
      $.post( url,data, function( resp ) {
        $('.modal-content').css('cursor', 'auto');
        location.reload(true);
      });
    }
  </script>
  <script src="{{ asset('public') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
  <script src="{{ asset('public') }}/assets/js/pages/crud/datatables/data-sources/beat-plan-data-ajax.js"></script>
  @endpush