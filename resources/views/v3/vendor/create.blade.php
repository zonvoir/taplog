@extends('v3.layouts.app', ['page' => __('Create Vendor/Client'), 'pageSlug' => 'vendors-create'])
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Vendor/Client</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('user.index')}}" class="text-muted">Vendors/Clients</a>
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
                            Create Vendor/Client
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Dropdown-->
                        <!--end::Dropdown-->
                    </div>
                </div>
                <!--begin::Form-->
                <form class="form" id="vendor-create-form" action="{{route('vendors.store')}}" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="vehicleAdded" value="no">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>Name: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                                    <input type="text" name="name" class="form-control" placeholder="Enter name " required="" />
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                            
                            <div class="col-lg-4">
                                <label>Email: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
                                    <input type="email" name="email" class="form-control" placeholder="Enter email id" required="" />
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>

                            <div class="col-lg-4">
                                <label>Contact: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-mobile"></i></span></div>
                                    <input type="number" name="contact" min='0' class="form-control" placeholder="Enter contact number" required="" />
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>Vendor/Client Code: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-barcode"></i></span></div>
                                    <input type="text" name="vendor_code" class="form-control" placeholder="Enter Vendor/Client code" required="" />
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="col-lg-4">
                                <label>State</label>
                                <div class="input-group">
                                    <select class="form-control select2" id="kt_select2_4" name="state">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>Type: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-control" name="type">
                                        <option value="client">Client</option>
                                        <option value="vendor">Vendor</option>
                                    </select>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                        <div class="form-group row" id="vendor-info-div" style="display: none;">
                            <div class="col-lg-4">
                                <label>Vendor Category: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-control" name="vendor_category">
                                        <option value="">Select</option>
                                        <option value="PUMP">PUMP</option>
                                        <option value="VEHICLE">VEHICLE</option>
                                    </select>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="col-lg-4">
                                <label>Latitude:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-map"></i></span></div>
                                    <input type="text" name="latitute" class="form-control" placeholder="Enter Latitude"/>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="col-lg-4">
                                <label>Logitude:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-map"></i></span></div>
                                    <input type="text" name="longitude" class="form-control" placeholder="Enter Longitude"/>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>GST Number:<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-money"></i></span></div>
                                    <input type="text" name="gst_no" class="form-control" placeholder="Enter gst number"/>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="col-lg-8">
                                <label>Billing Address:<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-building"></i></span></div>
                                    <textarea name="billing_address" class="form-control"></textarea>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>Password:<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-key"></i></span></div>
                                    <input type="password" name="password" class="form-control" placeholder="Enter password"/>
                                </div>
                                <span class="form-text text-muted"></span>
                            </div>
                            <div class="col-lg-4">
                                <label for="selectMode">Confirm Password:<span class="text-danger">*</span></label>
                                <input type="password" name="confirmPassword" class="form-control" placeholder="Please confirm password"/>
                                <span class="form-text text-muted"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-2">
                                <button style="width: 100%;" type="submit" class="btn font-weight-bold btn-success mr-2">Create</button></div>
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
            document.getElementById('vendor-create-form'),
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
password: {
    validators: {
        notEmpty: {
            message: 'The password is required'
        },
        stringLength: {
            min: 6,
            message: 'The password should be minimum 6 characters!'
        }
    }
},
confirmPassword: {
    validators: {
        identical: {
            compare: function() {
                return form.querySelector('[name="password"]').value;
            },
            message: 'The password and its confirm are not the same'
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
        const form = document.getElementById('vendor-create-form');
// Revalidate the confirmation password when changing the password
form.querySelector('[name="password"]').addEventListener('input', function() {
    fv.revalidateField('confirmPassword');
});
fv.disableValidator('vendor_category','notEmpty');
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
$('select[name="type"]').change(function(e) {
    $("#vendor-info-div").toggle();
    if($(this).val() == 'client'){
        fv.disableValidator('vendor_category','notEmpty');
    }else if($(this).val() == 'vendor'){
        fv.enableValidator('vendor_category','notEmpty');
    }
});
$('select[name="vendor_category"]').change(function(e) {
   if($(this).val() == 'VEHICLE'){
    Swal.fire({
        title: "Do you want to add vehicle?",
        text: "You will be redirect on add vehicle page when create vendor!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, i want!",
        cancelButtonText: "No, i do not want add now!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $("input[name='vehicleAdded']").val('yes');
            Swal.fire(
                "Confirmed!",
                "You select to add vehicle.",
                "success"
                )
        } else if (result.dismiss === "cancel") {
            $("input[name='vehicleAdded']").val('no');
            Swal.fire(
                "Cancelled",
                "You don not want to add now :)",
                "error"
                )
        }
    });
}
});
</script>
@endpush