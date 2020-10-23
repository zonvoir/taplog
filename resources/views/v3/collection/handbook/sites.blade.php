@extends('v3.layouts.app', ['page' => __('All Beats'), 'pageSlug' => 'handbook-beats'])
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
          <h5 class="text-dark font-weight-bold my-1 mr-5">Upload Handbook</h5>
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
            <h3 class="card-label">All Sites</h3>
          </div>
          <div class="card-toolbar">
            <!--begin::Dropdown-->
            <div class="dropdown dropdown-inline mr-2">
              <button type="button" id="upload-handbook-btn" class="btn btn-light-success font-weight-bolder" data-toggle="modal" data-target="#importModal" style="display: none;">
                <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo7\dist/../src/media/svg/icons\Files\Upload.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                    <rect fill="#000000" opacity="0.3" x="11" y="2" width="2" height="14" rx="1"/>
                    <path d="M12.0362375,3.37797611 L7.70710678,7.70710678 C7.31658249,8.09763107 6.68341751,8.09763107 6.29289322,7.70710678 C5.90236893,7.31658249 5.90236893,6.68341751 6.29289322,6.29289322 L11.2928932,1.29289322 C11.6689749,0.916811528 12.2736364,0.900910387 12.6689647,1.25670585 L17.6689647,5.75670585 C18.0794748,6.12616487 18.1127532,6.75845471 17.7432941,7.16896473 C17.3738351,7.57947475 16.7415453,7.61275317 16.3310353,7.24329415 L12.0362375,3.37797611 Z" fill="#000000" fill-rule="nonzero"/>
                  </g>
                </svg><!--end::Svg Icon--></span>Upload Handbook</button>
                <!--begin::Dropdown Menu-->

                <!--end::Dropdown Menu-->
              </div>
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
              <!--begin: Datatable-->
              <table class="table table-striped- table-bordered table-hover table-checkable dataTable dtr-inline" id="handbook_site_data_table" style="margin-top: 13px !important">
                <thead>
                  <tr>
                    <th></th>
                    <th>Site Id</th>
                    <th>Site Name</th>
                    <th>Technician Name</th>
                    <th>Technician Contact</th>
                    <th>Status</th>
                    <th>Handbook Status</th>
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
    <div class="modal fade" id="importModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="importModal">Handbook Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i aria-hidden="true" class="ki ki-close"></i>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <div class="col-lg-12 col-md-9 col-sm-12">
                <div class="dropzone dropzone-default dz-clickable" id="handbook-upload">
                  <div class="dropzone-msg dz-message needsclick">
                    <h3 class="dropzone-msg-title">Drop image here or click to upload.</h3>
                    <span class="dropzone-msg-desc">Upload
                      <strong>images</strong> only.</span>
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
      <script type="text/javascript">var ids = [];</script>
      <script src="{{ asset('public') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
      <script src="{{ asset('public') }}/assets/js/pages/crud/datatables/data-sources/handbook-site-data-ajax.js"></script>
      
      <!-- fancy box -->
      <link rel="stylesheet" href="{{ asset('public') }}/assets/js/fancybox/jquery.fancybox.min.css" />
      <script src="{{ asset('public') }}/assets/js/fancybox/jquery.fancybox.min.js"></script>
      @endpush