@extends('v3.layouts.app', ['page' => __('Edit User'), 'pageSlug' => 'users-marital'])
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
                        @include('v3.users.profile-sidebar',['pageSlug' => 'users-marital'])
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
                                    <h3 class="card-label font-weight-bolder text-dark">Marital  Information</h3>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">Update your Marital informaiton</span>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            <form class="form" id="marital-form" action="{{route('user.update')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                @method('put')
                                <!--begin::Body-->
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <input type="hidden" name="form" value="marital">
                                <div class="card-body">
                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h5 class="font-weight-bold mb-6">Marital Info</h5>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Spouse Name:</label>
                                            <input class="form-control form-control-lg form-control-solid" type="text" name="spouse_name" value="{{isset($user->details->spouse_name) ? $user->details->spouse_name : ''}}" placeholder="Enter spous name " />
                                        </div>
                                        <div class="col-lg-6">
                                         <label>Is Child:</label>
                                         <select class="form-control form-control-lg form-control-solid child_status" name="child_status">
                                             @if(isset($user->details->child_status))
                                             <option value="yes" {{$user->details->child_status == 'yes' ? 'selected' : ''}}>Yes</option>
                                             <option value="no" {{$user->details->child_status == 'no' ? 'selected' : ''}}>No</option>
                                             @else
                                             <option>Select Child Status</option>
                                             <option value="yes">Yes</option>
                                             <option value="no">No</option>
                                             @endif
                                         </select>
                                     </div>
                                 </div>
                                 <div class="row children" style="{{isset($user->details) && $user->details->child_status == 'yes' ? 'display: block;' : 'display:none;'}}">
                                    <label class="col-xl-3"></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <h5 class="font-weight-bold mt-10 mb-6">Child Info</h5>
                                    </div>
                                </div>
                                <div id="kt_repeater_1" class="children" style="{{isset($user->details) && $user->details->child_status == 'yes' ? 'display: block;' : 'display:none;'}}">
                                    <div class="form-group row" id="kt_repeater_1">
                                        <label class="col-lg-2 col-form-label text-right">Children:</label>
                                        <div data-repeater-list="children" class="col-lg-10">
                                            @if(isset($user->child) && !empty($user->child) && !$user->child->isEmpty())
                                            @foreach($user->child as $child)
                                            <div data-repeater-item class="form-group row align-items-center">
                                                <div class="col-md-3">
                                                    <label>Name:</label>
                                                    <input type="hidden" class="child_id" name="child_id" value="{{$child->id}}">
                                                    <input type="text" class="form-control child_name" name="name" placeholder="Enter child name" value="{{$child->child_name}}" />
                                                    <div class="d-md-none mb-2"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Age:</label>
                                                    <input type="number" min="0" name="age" class="form-control child_age" placeholder="Enter child age" value="{{$child->child_age}}" />
                                                    <div class="d-md-none mb-2"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="radio-inline">
                                                        <label>Gender:</label>
                                                        <select name="gender" class="form-control">
                                                            <option value="Male" {{$child->gender == 'Male' ? 'selected' : ''}}>Male</option>
                                                            <option value="Female" {{$child->gender == 'Female' ? 'selected' : ''}}>Female</option>
                                                            <option value="Other" {{$child->gender == 'Other' ? 'selected' : ''}}>Other</option>
                                                        </select>
                                                        <div class="d-md-none mb-2"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                                                        <i class="la la-trash-o"></i>Delete
                                                    </a>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <div data-repeater-item class="form-group row align-items-center">
                                                <div class="col-md-3">
                                                    <label>Name:</label>
                                                    <input type="text" name="name" class="form-control child_name" placeholder="Enter child name" value="" />
                                                    <div class="d-md-none mb-2"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Age:</label>
                                                    <input type="number" min="0" name="age" class="form-control child_age" placeholder="Enter child age" value="" />
                                                    <div class="d-md-none mb-2"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="radio-inline">
                                                        <label>Gender:</label>
                                                        <select name="gender" class="form-control">
                                                           <option value="">Select Gender</option>
                                                           <option value="Male">Male</option>
                                                           <option value="Female">Female</option>
                                                           <option value="Other">Other</option>
                                                       </select>
                                                       <div class="d-md-none mb-2"></div>
                                                   </div>
                                               </div>
                                               <div class="col-md-4">
                                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                                                    <i class="la la-trash-o"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label text-right"></label>
                                    <div class="col-lg-4">
                                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                                            <i class="la la-plus"></i>Add
                                        </a>
                                    </div>
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
        document.getElementById('marital-form'),
        {
          fields: {

            spouse_name: {
                validators: {
                    notEmpty: {
                        message: 'Spouse name is required'
                    },
                    stringLength: {
                        min: 4,
                        message: 'The name must have 4 charecters minimum!' 
                    }
                }
            },
            age: {
                validators: {
                    notEmpty: {
                        message: 'Child age is required'
                    },
                }
            },
            name: {
                validators: {
                    notEmpty: {
                        message: 'Child name is required'
                    },
                }
            },
            gender: {
                validators: {
                    notEmpty: {
                        message: 'Child gender is required'
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
    var KTFormRepeater = function() {
                    // Private functions
                    var demo1 = function() {
                        $('#kt_repeater_1').repeater({
                            initEmpty: false,

                            defaultValues: {
                                'text-input': 'foo'
                            },

                            show: function () {
                                $(this).slideDown();
                                $(this).children('div').find('.child_id').remove();
                                $(this).children('div').find('.child_name').val('');
                                $(this).children('div').find('.child_age').val('');
                                fv.enableValidator('name','notEmpty');
                                fv.enableValidator('age','notEmpty');
                                fv.enableValidator('gender','notEmpty');
                            },

                            hide: function (deleteElement) {
                                let childId =  $(this).parent('div').find('.child_id').val();
                                if(childId != undefined){
                                    Swal.fire({
                                        title: "Are you sure?",
                                        text: "You would not be able to revert this!",
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonText: "Yes, delete it!"
                                    }).then(function(result) {
                                        if (result.value) {
                                            $.post( HOST_URL+"child-remove",{'_token' : $('meta[name="csrf-token"]').attr('content'), id: childId }, function( resp ) {
                                                if(resp){
                                                    Swal.fire(
                                                        "Deleted!",
                                                        "Child has been deleted.",
                                                        "success"
                                                        )
                                                    $(this).slideUp(deleteElement);
                                                }
                                            });
                                        }
                                    });
                                }else{
                                    $(this).slideUp(deleteElement);
                                }

                            }
                        });
                    }

                    return {
                        // public functions
                        init: function() {
                            demo1();
                        }
                    };
                }();

                jQuery(document).ready(function() {
                    KTFormRepeater.init();
                });
                $('.child_status').change(function() { 
                    if($(this).val() == 'no'){
                        $(".children").css("display","none");
                        fv.disableValidator('spouse_name','notEmpty');
                        fv.disableValidator('name','notEmpty');
                        fv.disableValidator('age','notEmpty');
                        fv.disableValidator('gender','notEmpty');
                    }else{
                        if($("input[name=spouse_name]").val() !== ''){
                            $(".children").css("display","block");
                            fv.enableValidator('spouse_name','notEmpty');
                        }else{
                            fv.enableValidator('spouse_name','notEmpty');
                            $("input[name=spouse_name]").focus();
                            $(".child_status option[value='no']").attr('selected', 'selected'); 
                            Swal.fire({
                                title: 'Plz enter spouse name first!',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },
                                icon: "error",
                            });
                            $(".children").css("display","block");
                        }
                    }
                });
            </script>
            @endpush