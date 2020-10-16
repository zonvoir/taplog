@extends('v3.layouts.app', ['page' => __('Edit User'), 'pageSlug' => 'users'])
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Profile 1</h5>
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
                                    <h3 class="card-label font-weight-bolder text-dark">Contact Information</h3>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">Update your Contact informaiton</span>
                                </div>
                                <!-- <div class="card-toolbar">
                                    <button type="button" class="btn btn-success mr-2">Save Changes</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div> -->
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form class="form" id="contact-form" action="{{route('user.update')}}" method="POST" autocomplete="off">
                                @csrf
                                @method('put')
                                <!--begin::Body-->
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <input type="hidden" name="form" value="contact">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Contact Phone <span class="text-danger">*</span></label>
                                            <input class="form-control form-control-lg form-control-solid" type="text" name="contact" value="{{isset($user->contact) ? $user->contact : ''}}" />
                                        </div>
                                        <div class="col-lg-6">
                                           <label>Email Address <span class="text-danger">*</span></label>
                                           <input class="form-control form-control-lg form-control-solid" type="text" name="email" value="{{strtolower(strtolower($user->email))}}" />
                                       </div>
                                   </div>
                                   <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>in emergency contact person</label>
                                        <input class="form-control form-control-lg form-control-solid" type="text" name="emergency_contact_person_name" value="{{isset($user->emergency_contact_person_name) ? $user->emergency_contact_person_name : ''}}" />
                                    </div>
                                    <div class="col-lg-6">
                                       <label>in emergency contact</label>
                                       <input class="form-control form-control-lg form-control-solid" type="text" name="emergency_contact" value="{{isset($user->emergency_contact) ? $user->emergency_contact : ''}}" />
                                   </div>
                               </div>
                               <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" name="address" value="{{isset($user->details->address) ? $user->details->address : ''}}" />
                                </div>
                                <div class="col-lg-6">
                                   <label>Address proof</label>
                                   @if(isset($user->details->address_proof_doc))
                                   <div class="row">
                                       <div class="custom-file">
                                         <input type="file" class="custom-file-input" name="address_proof_doc" id="customFile"/>
                                         <label class="custom-file-label" for="customFile">Choose file</label>
                                     </div>
                                     <a href="{{isset($user->details->address_proof_doc) ? asset('public/').'/'.$user->details->address_proof_doc : ''}}" /download><span><i></i></span>File</a>
                                 </div>
                                 @else
                                 <div class="custom-file">
                                     <input type="file" class="custom-file-input" name="address_proof_doc" id="customFile"/>
                                     <label class="custom-file-label" for="customFile">Choose file</label>
                                 </div>
                                 @endif
                             </div>
                         </div>
                         <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Correspondence Address</label>
                                <input class="form-control form-control-lg form-control-solid" type="text" value="{{isset($user->details->correspond_address) ? $user->details->correspond_address : ''}}" />
                            </div>
                            <div class="col-lg-6">
                               <label>Correspondence Address Proof</label>
                               @if(isset($user->details->correspond_address_proof))
                               <div class="row">
                                   <div class="custom-file">
                                     <input type="file" class="custom-file-input" name="correspond_address_proof" id="customFile"/>
                                     <label class="custom-file-label" for="customFile">Choose file</label>
                                 </div>
                                 <a href="{{isset($user->details->correspond_address_proof) ? asset('public/').'/'.$user->details->correspond_address_proof : ''}}" /download><span><i></i></span>File</a>
                             </div>
                             @else
                             <div class="custom-file">
                                 <input type="file" class="custom-file-input" name="correspond_address_proof" id="customFile"/>
                                 <label class="custom-file-label" for="customFile">Choose file</label>
                             </div>
                             @endif
                         </div>
                     </div>
                     <div class="form-group row">
                        <div class="col-lg-6">
                           <label>Police Verification proof</label>
                           @if(isset($user->details->police_verified_doc))
                           <div class="row">
                               <div class="custom-file">
                                 <input type="file" class="custom-file-input" name="police_verified_doc" id="customFile"/>
                                 <label class="custom-file-label" for="customFile">Choose file</label>
                             </div>
                             <a href="{{isset($user->details->police_verified_doc) ? asset('public/').'/'.$user->details->police_verified_doc : ''}}" /download><span><i></i></span>File</a>
                         </div>
                         @else
                         <div class="custom-file">
                             <input type="file" class="custom-file-input" name="police_verified_doc" id="customFile"/>
                             <label class="custom-file-label" for="customFile">Choose file</label>
                         </div>
                         @endif
                     </div>
                     <div class="col-lg-6">
                        <label>Other contact</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="other_contact" value="{{isset($user->other_contact) ? $user->other_contact : ''}}" />
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
<script type="text/javascript">
    const fv = FormValidation.formValidation(
        document.getElementById('contact-form'),
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
other_contact: {
    validators: {
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
</script>
@endpush