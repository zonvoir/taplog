@extends('v3.layouts.app', ['page' => __('Create Vehicle'), 'pageSlug' => 'vendors-vehicle'])
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
          <h5 class="text-dark font-weight-bold my-1 mr-5">Vehicle</h5>
          <!--end::Page Title-->
          <!--begin::Breadcrumb-->
          <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item">
              <a href="#" class="text-muted">Vehicles</a>
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
          <div class="row">
            <h3 class="card-title">
              Create Vehicle
            </h3>
            @if(isset($vendor) && !empty($vendor))
            <div style="padding: 20px;"><span class="label label-primary label-inline font-weight-lighter mr-2">Vendor Name:</span> {{$vendor->name}} </div><div style="padding: 20px;"><span class="label label-primary label-inline font-weight-lighter mr-2">Vendor Code:</span> {{$vendor->vendor_code}}</div>
            @endif
          </div>
          <div class="card-toolbar">
            <!--begin::Dropdown-->
            <!--end::Dropdown-->
          </div>
        </div>
        <!--begin::Form-->
        <form class="form" id="vehicle-create-form" action="{{route('vehicle.store')}}" method="post" autocomplete="off">
          @csrf
          <input type="hidden" name="vendor_id" value="{{isset($vendor)?$vendor->id:$vendor_id}}">
          <div class="card-body">
            <div class="form-group row">
              <div class="col-lg-6">
                <label>Vehicle Number: <span class="text-danger">*</span></label>
                <input type="text" name="vehicle_no" class="form-control" placeholder="Enter vehicle number" required="" />
                <span class="form-text text-muted"></span>
              </div>
              <div class="col-lg-6">
                <label>Vehicle R.C.:</label>
                <div class="custom-file">
                 <input type="file" class="custom-file-input" name="rc_doc" id="customFile" autocomplete="off">
                 <label class="custom-file-label" for="customFile">Choose file</label>
               </div>
               <span class="form-text text-muted"></span>
             </div>
           </div>
           <div class="form-group row">
            <div class="col-lg-4">
              <label>Insurance Policy No:</label>
              <input type="text" name="insurance_no" class="form-control" placeholder="Insurance Policy Number"/>
              <span class="form-text text-muted"></span>
            </div>
            <div class="col-lg-4">
              <label>Insurance Policy Doc:</label>
              <div class="custom-file">
               <input type="file" class="custom-file-input" name="insurance_doc" id="customFile" autocomplete="off">
               <label class="custom-file-label" for="customFile">Choose file</label>
             </div>
             <span class="form-text text-muted"></span>
           </div>
           <div class="col-lg-4">
            <label>Insuarnce UpTo:</label>
            <input type="text" id="" name="insurance_upto" class="form-control kt_datepicker_3" placeholder="Insuarnce UpTo"/>
            <span class="form-text text-muted"></span>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-lg-4">
            <label>Fitness Certificate No:</label>
            <input type="text" name="fitness_cert_no" class="form-control" placeholder="Fitness Certificate Number"/>
            <span class="form-text text-muted"></span>
          </div>
          <div class="col-lg-4">
            <label>Fitness Certificate Doc:</label>
            <div class="custom-file">
             <input type="file" class="custom-file-input" name="fitness_cert_doc" id="customFile" autocomplete="off">
             <label class="custom-file-label" for="customFile">Choose file</label>
           </div>
           <span class="form-text text-muted"></span>
         </div>
         <div class="col-lg-4">
          <label>Fitness Certificate Valid Upto:</label>
          <input type="text" id="" name="fitness_cert_upto" class="form-control kt_datepicker_3" placeholder="Fitness Certificate Valid Upto"/>
          <span class="form-text text-muted"></span>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-lg-4">
          <label>Permit No:</label>
          <input type="text" name="permit_no" class="form-control" placeholder="Permit Number"/>
          <span class="form-text text-muted"></span>
        </div>
        <div class="col-lg-4">
          <label>Permit Doc:</label>
          <div class="custom-file">
           <input type="file" class="custom-file-input" name="permit_doc" id="customFile" autocomplete="off">
           <label class="custom-file-label" for="customFile">Choose file</label>
         </div>
         <span class="form-text text-muted"></span>
       </div>
       <div class="col-lg-4">
        <label>Permit Valid Upto:</label>
        <input type="text" id="" name="permit_upto" class="form-control kt_datepicker_3" placeholder="Permit Valid Upto"/>
        <span class="form-text text-muted"></span>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="row">
      <div class="col-lg-2">
        <button style="width: 100%;" type="submit" class="btn font-weight-bold btn-success mr-2">Add</button></div>
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
@endsection
@push('js')
<script type="text/javascript">
  const fv = FormValidation.formValidation(
    document.getElementById('vehicle-create-form'),
    {
      fields: {
        vehicle_no: {
          validators: {
           notEmpty: {
            message: 'Number is required'
          },
          stringLength: {
            min: 10,
            message: 'Vehicle number must be minimum 10 characters!'
          }
        }
      },
      insurance_no: {
        validators: {
         notEmpty: {
          message: 'Number is required'
        },
      }
    },
    fitness_cert_no: {
      validators: {
       notEmpty: {
        message: 'Number is required'
      },
    }
  },
  fitness_cert_upto: {
    validators: {
      notEmpty: {
        message: 'The date is required'
      },
      date: {
        format: 'DD-MM-YYYY',
        message: 'The value is not a valid date'
      },
    }
  },
  permit_no: {
    validators: {
     notEmpty: {
      message: 'Number is required'
    },
  }
},
permit_upto: {
  validators: {
    notEmpty: {
      message: 'The date is required'
    },
    date: {
      format: 'DD-MM-YYYY',
      message: 'The value is not a valid date'
    },
  }
},
insurance_upto: {
  validators: {
    notEmpty: {
      message: 'The date is required'
    },
    date: {
      format: 'DD-MM-YYYY',
      message: 'The value is not a valid date'
    },
  }
},
},

plugins: {
  trigger: new FormValidation.plugins.Trigger(),
            // Bootstrap Framework Integration
            bootstrap: new FormValidation.plugins.Bootstrap(),
           // Validate fields when clicking the Submit button
           submitButton: new FormValidation.plugins.SubmitButton(),
            // Submit the form when all fields are valid
            defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          }
        }
        );
    // Class definition
    var KTBootstrapDatepicker = function () {
      var arrows;
      if (KTUtil.isRTL()) {
        arrows = {
          leftArrow: '<i class="la la-angle-right"></i>',
          rightArrow: '<i class="la la-angle-left"></i>'
        }
      } else {
        arrows = {
          leftArrow: '<i class="la la-angle-left"></i>',
          rightArrow: '<i class="la la-angle-right"></i>'
        }
      }
    // Private functions
    var demos = function () {
        // enable clear button 
        $('.kt_datepicker_3').datepicker({
          format: 'dd-mm-yyyy',
          rtl: KTUtil.isRTL(),
          todayBtn: "linked",
          clearBtn: true,
          todayHighlight: true,
          templates: arrows,
          autoclose: true
        }).on('changeDate', function(e) {
        // Revalidate the date field
        fv.revalidateField('insurance_upto');
        fv.revalidateField('fitness_cert_upto');
        fv.revalidateField('permit_upto');
      });
      }
      return {
        // public functions
        init: function() {
          demos(); 
        }
      };
    }();
    jQuery(document).ready(function() {    
      KTBootstrapDatepicker.init();
    });
  </script>
  @endpush