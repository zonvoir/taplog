@extends('v3.layouts.app', ['page' => __('Personal Info'), 'pageSlug' => 'users'])
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
                        @include('v3.users.profile-sidebar')
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
                            <form class="form" id="personal-form" action="{{route('user.update')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                @method('put')
                                <!--begin::Body-->
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <input type="hidden" name="form" value="personal">
                                <div class="card-body">
                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h5 class="font-weight-bold mb-6">Employee Info</h5>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Avatar</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url({{asset('public/assets/media/users/')}}/blank.png)">
                                                @if(isset($user->details->profile_img))
                                                <div class="image-input-wrapper" style="background-image: url({{asset('public')}}/{{$user->details->profile_img}})"></div>
                                                @else
                                                <div class="image-input-wrapper" style="background-image: url({{asset('public/assets/media/users/')}}/blank.png)">
                                                </div>
                                                @endif
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="profile_avatar_remove" />
                                                </label>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                            </div>
                                            <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <input class="form-control form-control-lg form-control-solid" type="text" name="first_name" value="{{isset($user->details->first_name) ? $user->details->first_name : $user->name}}" />
                                        </div>
                                        <div class="col-lg-6">
                                           <label>Last Name <span class="text-danger">*</span></label>
                                           <input class="form-control form-control-lg form-control-solid" type="text" name="last_name" value="{{isset($user->details->last_name) ? $user->details->last_name : ''}}" />
                                       </div>
                                   </div>
                                   <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Date Of Birth <span class="text-danger">*</span></label>
                                        <input id="kt_datepicker_3" class="form-control form-control-lg form-control-solid" type="text" name="dob" value="{{isset($user->details->dob) ? $user->details->dob : ''}}" />
                                    </div>
                                    <div class="col-lg-6">
                                       <label>Date Of Join <span class="text-danger">*</span></label>
                                       <input id="kt_datepicker_3" name="doj" class="form-control form-control-lg form-control-solid" type="text" value="{{isset($user->details->doj) ? $user->details->doj : ''}}" />
                                   </div>
                               </div>
                               <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-lg form-control-solid" name="gender">
                                        @if(isset($user->details->gender))
                                        <option value="male" {{$user->details->gender == 'male' ? 'selected' : ''}}>Male</option>
                                        <option value="female" {{$user->details->gender == 'female' ? 'selected' : ''}}>Female</option>
                                        <option value="other" {{$user->details->gender == 'other' ? 'selected' : ''}}>Other</option>  
                                        @else
                                        <option>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>

                                        @endif
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                   <label>Father's Name <span class="text-danger">*</span></label>
                                   <input class="form-control form-control-lg form-control-solid" type="text" name="father_name" value="{{isset($user->details->father_name) ? $user->details->father_name : ''}}" />
                               </div>
                           </div>
                           <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Mother's Name <span class="text-danger">*</span></label>
                                <input class="form-control form-control-lg form-control-solid" type="text" name="mother_name" value="{{isset($user->details->mother_name) ? $user->details->mother_name : ''}}" />
                            </div>
                            <div class="col-lg-6">
                               <label>is Married</label>
                               <select class="form-control form-control-lg form-control-solid" name="married">
                                @if(isset($user->details->marital_status))
                                <option value="yes" {{$user->details->marital_status == 'yes' ? 'selected' : ''}}>Yes</option>
                                <option value="no" {{$user->details->marital_status == 'no' ? 'selected' : ''}}>No</option>
                                @else
                                <option>Select Marital Status</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                           <label>Type(Designation)</label>
                           <select class="form-control form-control-lg form-control-solid" name="type">
                            @if(isset($user->type))
                            <option value="mis" {{$user->type == 'mis' ? 'selected' : ''}}>MIS</option>
                            <option value="field_officer" {{$user->type == 'field_officer' ? 'selected' : ''}}>Area Officer</option>
                            <option value="filler" {{$user->type == 'filler' ? 'selected' : ''}}>Filler</option>
                            <option value="driver" {{$user->type == 'driver' ? 'selected' : ''}}>Driver</option>
                            @endif
                        </select>
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
first_name: {
    validators: {
     notEmpty: {
      message: 'First Name is required'
  },
  stringLength: {
    min: 4,
    message: 'The first name must be greater than 4 characters!'
}
}
},
last_name: {
    validators: {
     notEmpty: {
      message: 'Last Name is required'
  },
  stringLength: {
    min: 4,
    message: 'The last name must be greater than 4 characters!'
}
}
},
dob: {
    validators: {
        notEmpty: {
            message: 'Date of birth is required'
        },
        date: {
            format: 'DD-MM-YYYY',
            message: 'The value is not a valid date',
        }
    }
},
doj: {
    validators: {
        notEmpty: {
            message: 'Date of join is required'
        },
        date: {
            format: 'DD-MM-YYYY',
            message: 'The value is not a valid date',
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
father_name:{
    validators: {
        notEmpty: {
            message: 'Father name is required'
        },
        stringLength: {
            min: 3,
            message: 'Name should be minimum three characters!'
        }
    }
},
mother_name:{
    validators: {
        notEmpty: {
            message: 'Mother name is required'
        },
        stringLength: {
            min: 3,
            message: 'Name should be minimum three characters!'
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
</script>
@endpush