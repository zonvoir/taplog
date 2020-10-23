@extends('v3.layouts.app', ['page' => __('All Collections'), 'pageSlug' => 'collections'])
@section('content')
<style type="text/css">
  .table-item-wrap .table td:nth-child(2),
  .table-item-wrap .table th:nth-child(2),
  .table-item-wrap .table td:nth-child(1),
  .table-item-wrap .table td:nth-child(3),
  .table-item-wrap .table th:nth-child(3)
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
          <h5 class="text-dark font-weight-bold my-1 mr-5">Collections</h5>
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
            <h3 class="card-label">Collections Table</h3>
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
              
              <!--end::Button-->
            </div>
          </div>
          <div class="card-body table-item-wrap">
            <form class="mb-15">
              <div class="row mb-8">
                <div class="col-lg-6 mb-lg-0 mb-6">
                  <label>Plan Date:</label>
                  <div class="input-daterange input-group" id="kt_datepicker">
                    <input type="text" class="form-control datatable-input" name="start" placeholder="From" data-col-index="1" />
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="la la-ellipsis-h"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control datatable-input" name="end" placeholder="To" data-col-index="1" />
                  </div>
                </div>
                <div class="col-lg-3 mb-lg-0 mb-6">
                  <label>Route:</label>
                  <select class="form-control datatable-input" data-col-index="6">
                    <option value="">Select</option>
                  </select>
                </div>
                <div class="col-lg-3" style="margin-top: 25px;">
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
            <table class="table table-bordered table-hover table-checkable" id="collection_data_table" style="margin-top: 13px !important">
              <thead>
                <tr>
                  <th>Action</th>
                  <th>Plan Date</th>
                  <th>Site Id</th>
                  <th>Site</th>
                  <th>Site Category</th>
                  <th>Technician</th>
                  <th>Route</th>
                  <th>Beat Plan(Ltr.)</th>
                  <th>RO/Pump</th>
                  <th>Lift/Load Date</th>
                  <th>Lifting Start Time</th>
                  <th>Lifting Finish Time</th>
                  <th>Site In Time</th>
                  <th>Site Out Time</th>
                  <th>KWH Reading</th>
                  <th>KWH Reading Img</th>
                  <th>HMR Reading</th>
                  <th>HMR Reading Img</th>
                  <th>GCU Before Filling Img</th>
                  <th>Fuel Stock Before Filling</th>
                  <th>GCU After Filling Img</th>
                  <th>Fuel Stock After Filling</th>
                  <th>Fuel Gauge Before Filling Img</th>
                  <th>Fuel Gauge After Filling Img</th>
                  <th>Dip Stick Before Filling</th>
                  <th>Dip Stick After Filling</th>
                  <th>EB Meter Reading</th>
                  <th>EB Meter Reading Img</th>
                  <th>Filling Qty</th>
                  <th>Entry Date</th>
                  <th>Remark</th>
                  <th>Handbook Img</th>
                  <th>Status</th>
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
  @endsection
  @push('js')
  <script src="{{ asset('public') }}/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
  <script src="{{ asset('public') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
  <script src="{{ asset('public') }}/assets/js/pages/crud/datatables/data-sources/collection-data-ajax.js"></script>
  <!-- fancy box -->
  <link rel="stylesheet" href="{{ asset('public') }}/assets/js/fancybox/jquery.fancybox.min.css" />
  <script src="{{ asset('public') }}/assets/js/fancybox/jquery.fancybox.min.js"></script>
  @endpush