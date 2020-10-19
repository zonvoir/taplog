@extends('v3.layouts.app', ['page' => __('Personal Info'), 'pageSlug' => 'vendors-personal'])
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Mobile Toggle-->
                <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
                    <span></span>
                </button>
                <!--end::Mobile Toggle-->
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Details</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">Apps</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">Profile</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">Profile 1</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">Personal Information</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Actions-->
                <a href="#" class="btn btn-light-primary font-weight-bolder btn-sm">Actions</a>
                <!--end::Actions-->
                <!--begin::Dropdown-->
                <div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions" data-placement="left">
                    <a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="svg-icon svg-icon-success svg-icon-2x">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Files/File-plus.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 m-0">
                        <!--begin::Navigation-->
                        <ul class="navi navi-hover">
                            <li class="navi-header font-weight-bold py-4">
                                <span class="font-size-lg">Choose Label:</span>
                                <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>
                            </li>
                            <li class="navi-separator mb-3 opacity-70"></li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-text">
                                        <span class="label label-xl label-inline label-light-success">Customer</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-text">
                                        <span class="label label-xl label-inline label-light-danger">Partner</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-text">
                                        <span class="label label-xl label-inline label-light-warning">Suplier</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-text">
                                        <span class="label label-xl label-inline label-light-primary">Member</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-text">
                                        <span class="label label-xl label-inline label-light-dark">Staff</span>
                                    </span>
                                </a>
                            </li>
                            <li class="navi-separator mt-3 opacity-70"></li>
                            <li class="navi-footer py-4">
                                <a class="btn btn-clean font-weight-bold btn-sm" href="#">
                                    <i class="ki ki-plus icon-sm"></i>Add new</a>
                                </li>
                            </ul>
                            <!--end::Navigation-->
                        </div>
                    </div>
                    <!--end::Dropdown-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Profile Personal Information-->
                <div class="d-flex flex-row">
                    <!--begin::Aside-->
                    <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
                        <!--begin::Profile Card-->
                        @include('v3.vendor.profile-sidebar',['pageSlug' => 'vendor-profile'])
                        <!--end::Profile Card-->
                    </div>
                    <!--end::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid ml-lg-8">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch">
                            <!--begin::Header-->
                            <div class="card-header py-3">
                                <div class="card-title align-items-start flex-column">
                                    <h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal informaiton</span>
                                </div>
                                <!-- <div class="card-toolbar">
                                    <button type="button" class="btn btn-success mr-2">Save Changes</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div> -->
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form class="form" id="personal-form" action="{{route('vendors.update',$user->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                @method('put')
                                <!--begin::Body-->
                                <input type="hidden" name="form" value="personal">
                                <div class="card-body">
                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h5 class="font-weight-bold mb-6">{{ucwords($user->type) }} Info</h5>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input class="form-control form-control-lg form-control-solid" type="text" name="name" value="{{$user->name}}" />
                                        </div>
                                        <div class="col-lg-6">
                                          <label>Type(Designation) <span class="text-danger">*</span></label>
                                          <select class="form-control form-control-lg form-control-solid" name="type">
                                            @if(isset($user->type))
                                            <option value="vendor" {{$user->type == 'vendor' ? 'selected' : ''}}>Vendor</option>
                                            <option value="client" {{$user->type == 'client' ? 'selected' : ''}}>Client</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>{{ucwords($user->type) }} Code <span class="text-danger">*</span></label>
                                        <input class="form-control form-control-lg form-control-solid" type="text" name="vendor_code" value="{{$user->vendor_code}}" />
                                    </div>
                                    <div class="col-lg-6">
                                      <label>GST No. <span class="text-danger">*</span></label>
                                      <input class="form-control form-control-lg form-control-solid" type="text" name="gst_no" value="{{$user->gst_no}}" />
                                  </div>
                              </div>
                              <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" name="email" value="{{$user->user->email}}" />
                                </div>
                                <div class="col-lg-6">
                                    <label>Contact <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" name="contact" value="{{$user->user->contact}}" />
                                </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-lg-6">
                                  <label>State <span class="text-danger">*</span></label>
                                  <select class="form-control form-control-lg form-control-solid select2" id="kt_select2_4" name="state">
                                  </select>
                              </div>
                              <div class="col-lg-6">
                                <label>Billing Address <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-lg form-control-solid" name="billing_address">{{$user->billing_address}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row vendor-row" style="{{$user->type == 'client' ? 'display: none;' : ''}}">
                            <div class="col-lg-6">
                                <label>Latitude</label>
                                <input class="form-control form-control-lg form-control-solid" type="text" name="latitude" value="{{$user->latitude}}" placeholder="enter latitude"/>
                            </div>
                            <div class="col-lg-6">
                              <label>Longitude </label>
                              <input class="form-control form-control-lg form-control-solid" type="text" name="longitude" value="{{$user->longitude}}" placeholder="enter longitude"/>
                          </div>
                      </div>
                      <div class="form-group row vendor-row" style="{{$user->type == 'client' ? 'display: none;' : ''}}">
                        <div class="col-lg-6">
                            <label>Vendor Category: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-control" name="vendor_category">
                                    <option value="PUMP" {{$user->vendor_category == 'PUMP' ? 'selected' :''}}>PUMP</option>
                                    <option value="VEHICLE" {{$user->vendor_category == 'VEHICLE' ? 'selected' :''}}>VEHICLE</option>
                                </select>
                            </div>
                            <span class="form-text text-muted"></span>
                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div>
                </div>
                <!--end::Body-->
                <div class="card-footer">
                   <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                   <button type="reset" class="btn btn-secondary">Cancel</button>
               </div>
           </form>
           <!--end::Form-->
       </div>
   </div>
   <!--end::Content-->
</div>
<!--end::Profile Personal Information-->
</div>
<!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->
@endsection
@push('js')
<script src="{{ asset('public') }}/assets/js/pages/custom/profile/profile.js"></script>
<script src="{{ asset('public') }}/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    const fv = FormValidation.formValidation(
        document.getElementById('personal-form'),
        {
          fields: {
           email: {
            validators: {
             notEmpty: {
              message: 'Email is required'
          },
          emailAddress: {
              message: 'The value is not a valid email address'
          }
      }
  },
  type: {
    validators: {
     notEmpty: {
      message: 'Type is required'
  }
}
},
vendor_code: {
    validators: {
     notEmpty: {
      message: 'Code is required'
  }
}
},
state: {
    validators: {
     notEmpty: {
      message: 'State is required'
  }
}
},
gst_no: {
    validators: {
     notEmpty: {
      message: 'GST number is required'
  },
  stringLength: {
    min: 15,
    message: 'GST number must be 15 characters!'
}
}
},
billing_address: {
    validators: {
     notEmpty: {
      message: 'Billing address is required'
  },
  stringLength: {
    min: 15,
    message: 'Billing address must be 15 characters!'
}
}
},
vendor_category: {
    validators: {
     notEmpty: {
      message: 'Category is required'
  }
}
},
name: {
    validators: {
     notEmpty: {
      message: 'Name is required'
  },
  stringLength: {
    min: 4,
    message: 'The full name must be 4 characters!'
}
}
},
contact: {
    validators: {
     notEmpty: {
        message: 'Indian phone number is required'
    },
    phone: {
      country: 'IN',
      message: 'The value is not a valid Indian phone number!'
  },
  stringLength: {
    max: 10,
    message: 'The phone number must have 10 digits!'
}
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
    var KTSelect2 = function() {
     var demos = function() {
        $.get( HOST_URL+'all-states', function( resp ) {
            $('#kt_select2_4').select2({
               placeholder: "Select a state",
               data:resp,
               allowClear: true
           });
        });
    }
    return {
        init: function() {
            demos();
        }
    };
}();
jQuery(document).ready(function() {
 KTSelect2.init();
});
let stateid = '{{$user->states->id}}';
let state = '{{$user->states->state}}';
var $newOption = $("<option selected='selected'></option>").val(stateid).text(state)
$("#kt_select2_4").append($newOption).trigger('change');

$('select[name="type"]').change(function(e) {
    if($(this).val() == 'client'){
        $(".vendor-row").css('display','none');
        fv.disableValidator('vendor_category','notEmpty');
    }else if($(this).val() == 'vendor'){
        $(".vendor-row").removeAttr('style');
        fv.enableValidator('vendor_category','notEmpty');
    }
});

</script>
@endpush