@extends('v3.layouts.app', ['page' => __('All Beats'), 'pageSlug' => 'vehicle'])
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
          <h5 class="text-dark font-weight-bold my-1 mr-5">Beat's</h5>
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
            <h3 class="card-label">All Vehicle's</h3>
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
            <!--begin: Datatable-->
            <table class="table table-striped- table-bordered table-hover table-checkable dataTable dtr-inline" id="all_vehicles_data_table" style="margin-top: 13px !important">
              <thead>
                <tr>
                  <th>Vehicle Number</th>
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
  <!-- Modal-->
  <div class="modal fade" id="contract-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Vehicle Contract</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">
          <form class="form" id="kt_contract_form">
            <input type="hidden" name="vehicle_id">
            <div class="card-body">
             <div class="form-group row">
              <label class="col-lg-4 col-form-label">Vehicle Average:</label>
              <div class="col-lg-6">
               <input type="number" min="0" name="average" class="form-control" placeholder="Enter Vehicle Average"/>
               <span class="form-text text-muted"></span>
             </div>
           </div>
           <div class="form-group row">
            <label class="col-lg-4 col-form-label">Monthly rental:</label>
            <div class="col-lg-6">
             <input type="number" min="0" name="rental" class="form-control" placeholder="Enter Monthly rental"/>
             <span class="form-text text-muted"></span>
           </div>
         </div>
         <div class="form-group row">
          <label class="col-lg-4 col-form-label">Salary By:</label>
          <div class="col-lg-6">
           <select class="form-control" name="salary_by">
             <option value="vendor">Vendor</option>
             <option value="admin">Admin</option>
           </select>
           <span class="form-text text-muted"></span>
         </div>
       </div>
     </div>
   </form>
 </div>
 <div class="modal-footer">
  <button type="button" id="contract-cancel-btn" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
  <button type="button" id="contract-submit-btn" class="btn btn-primary font-weight-bold">Update</button>
</div>
</div>
</div>
</div>
@endsection
@push('js')
<script src="{{ asset('public') }}/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="{{ asset('public') }}/assets/js/pages/crud/datatables/data-sources/all-vehicles-data-ajax.js"></script>
<script type="text/javascript">
  "use strict";
// Class Definition
var KTContract = function() {
  var _handleContractForm = function(e) {
    var validation;
    validation = FormValidation.formValidation(
     KTUtil.getById('kt_contract_form'),
     {
      fields: {
       average: {
        validators: {
         notEmpty: {
          message: 'Average is required'
        }
      }
    },
    rental: {
      validators: {
       notEmpty: {
        message: 'Rental is required'
      }
    }
  },
  salary_by: {
    validators: {
     notEmpty: {
      message: 'Salary By is required'
    }
  }
}
},
plugins: {
 trigger: new FormValidation.plugins.Trigger(),
 bootstrap: new FormValidation.plugins.Bootstrap()
}
}
);
  // Handle submit button
  $('#contract-submit-btn').on('click', function (e) {
    e.preventDefault();
    validation.validate().then(function(status) {
      if (status == 'Valid') {
        var form_data = $("#kt_contract_form").serialize();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.post( HOST_URL+"vendor/vehicle-update-agreement", form_data, function( resp ) {
          if(resp == 'success'){
            Swal.fire("Updated!");
            $("#contract-modal").modal("toggle");
          }else{
            swal.fire({
              text: "Sorry, network issue, please try again.",
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn font-weight-bold btn-light-primary"
              }
            }).then(function() {
            KTUtil.scrollTop();
          });
          }
        });
        KTUtil.scrollTop();
      } else {
       swal.fire({
        text: "Sorry, enter correct input, please try again.",
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
          confirmButton: "btn font-weight-bold btn-light-primary"
        }
      }).then(function() {
       // KTUtil.scrollTop();
     });
    }
  });
  });
  // Handle cancel button
  $('#contract-cancel-btn').on('click', function (e) {
    e.preventDefault();
    validation.enableValidator('rental','notEmpty');
    validation.enableValidator('average','notEmpty');
    validation.enableValidator('salary_by','notEmpty');
  });
}
// Public Functions
return {
    // public functions
    init: function() {
      _handleContractForm();
    }
  };
}();
// Class Initialization
jQuery(document).ready(function() {
  KTContract.init();
});
function contractModal(id) {
  $("input[name='vehicle_id']").val(id);
  $.get( HOST_URL+"vendor/vehicle-agreement", {vehicle_id:id}, function( resp ) {
    if(resp){
      $("input[name='rental']").val(resp.rental);
      $("input[name='average']").val(resp.average);
      $("select[name='salary_by']").val(resp.salary_by);
      $("#contract-modal").modal("show");
    }
  });
}
</script>
@endpush