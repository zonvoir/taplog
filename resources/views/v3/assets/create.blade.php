@extends('v3.layouts.app', ['page' => __('Asset Create'), 'pageSlug' => 'assets_master'])
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
          <h5 class="text-dark font-weight-bold my-1 mr-5">Asset Master</h5>
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
          <h3 class="card-label">Asset Master</h3>
      </div>

  </div>
  <div class="card-body table-item-wrap">
    <form id="asset-form" method="post" action="{{ route('assets.store') }}">
        @csrf

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Item Name') }}</label>
                        <input type="text" name="item_name" class="form-control{{ $errors->has('item_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Item Name') }}" required="">
                        @include('alerts.feedback', ['field' => 'item_name'])
                    </div>    
                </div>
                <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Quantity') }}</label>
                        <input type="text" name="qty" class="form-control{{ $errors->has('qty') ? ' is-invalid' : '' }}" placeholder="{{ __('Quantity') }}" required="">
                        @include('alerts.feedback', ['field' => 'qty'])
                    </div>    
                </div>  
            </div>
            <div class="row">
                <div class="col-md-6 pr-md-1">
                    <div class="form-group">
                        <label>{{ __('UAM') }}</label>
                        <input type="text" name="uam" class="form-control{{ $errors->has('uam') ? ' is-invalid' : '' }}" placeholder="{{ __('UAM') }}" required="">
                        @include('alerts.feedback', ['field' => 'uam'])
                    </div>    
                </div>
                <div class="col-md-6 pr-md-1">
                    <div class="form-group">
                        <label>{{ __('S.No.') }}</label>
                        <select name="s_no" class="form-control{{ $errors->has('s_no') ? ' is-invalid' : '' }}" required >
                            <option value="">S. No.</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        @include('alerts.feedback', ['field' => 's_no'])
                    </div>    
                </div>    
            </div>  
            <div class="row">
                <div class="col-md-6 pr-md-1">
                    <div class="form-group">
                        <label>{{ __('Master Location') }}</label>
                        <input type="text" name="master_location" class="form-control{{ $errors->has('master_location') ? ' is-invalid' : '' }}" placeholder="{{ __('Master Location') }}" required="">
                        @include('alerts.feedback', ['field' => 'master_location'])
                    </div>    
                </div>
                <div class="col-md-6 pr-md-1">
                    <div class="form-group">
                            <label>{{ __('Base Location') }}</label>
                        <input type="text" name="base_location" class="form-control{{ $errors->has('base_location') ? ' is-invalid' : '' }}" placeholder="{{ __('Base Location') }}" required="">
                        @include('alerts.feedback', ['field' => 'base_location'])
                    </div>    
                </div>  
            </div>
            <div class="row">
                 <div class="col-md-6 pr-md-1">
                        <div class="form-group">
                            <label>{{ __('Mapped With MP') }}</label>
                        <input type="text" name="mapped_with_mp" class="form-control{{ $errors->has('mapped_with_mp') ? ' is-invalid' : '' }}" placeholder="{{ __('Mapped With MP') }}" required="">
                        @include('alerts.feedback', ['field' => 'mapped_with_mp'])
                    </div>    
                </div>
                <div class="col-md-6 pr-md-1">
                    <div class="form-group">
                        <label>{{ __('Mapping with Customer') }}</label>
                        <input type="text" name="mapped_with_customer" class="form-control{{ $errors->has('mapped_with_customer') ? ' is-invalid' : '' }}" placeholder="{{ __('Mapping with Customer') }}" required="">
                        @include('alerts.feedback', ['field' => 'mapped_with_customer'])
                    </div>    
                </div>  
            </div>
            <input type="hidden" name="serialsData">
        </div>
        <div class="card-footer">
            <button type="button" id="validatate_form" class="btn btn-primary">{{ __('Create') }}</button>
        </div>
    </form>
</div>
<!--end::Card-->
</div>
<!--end::Container-->
</div>
<!--end::Entry-->
</div>
</div>

<div class="modal fade" id="assetDetailsModal" tabindex="-1" role="dialog" aria-labelledby="assetDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="assetDetailsModalLabel">Add Serial Number's asa</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label>Item Name: <span id="item-name"></span></label>
                    </div>
                    <div class="form-group col-12">
                        <label>Quantity: <span id="qty-val"></span></label>
                    </div>
                </div>
                <form id="serial-form">

                </form>
                <div class="modal-footer">
                    <button type="button" id="validateAssetSerial" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script src="{{ asset('public') }}/assets/js/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
            validation = FormValidation.formValidation(
            KTUtil.getById('asset-form'),
            {
                fields: {
                    item_name: {
                        validators: {
                            notEmpty: {
                                message: 'Item Name is required'
                            }
                        }
                    },
                    qty: {
                        validators: {
                            notEmpty: {
                                message: 'Qty is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        ); 

        validation1 = FormValidation.formValidation(
            KTUtil.getById('serial-form'),
            {
                fields: {
                    serial_no: {
                        selector: '.sr',
                        validators: {
                            notEmpty: {
                                message: 'Serial_no is required'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        );

        $('#validatate_form').on('click', function (e) {
            e.preventDefault();

            validation.validate().then(function(status) {
                if (status == 'Valid') {
                   askSerialNoModal();
                } else {
                    swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
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
        });

        $('#validateAssetSerial').on('click', function (e) {
            e.preventDefault();

            validation1.validate().then(function(status) {
                if (status == 'Valid') {
                    addAssetSerial();
                } else {
                    swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
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
        });
    });

    

    function askSerialNoModal() {
        console.log('asdsad');
        var isSerialNo = $('select[name="s_no"]').val();
        var html = '';
        if(isSerialNo == 'yes'){
            $("#item-name").html($('input[name="item_name"]').val());
            $("#qty-val").html($('input[name="qty"]').val());
            var qtyVal = parseInt($('input[name="qty"]').val());
            for(var i = 0; i < qtyVal; i++){
                html += '<div class="row">';
                html += '<div class="form-group col-12"><input type="text" name="serial_no" class="form-control sr" placeholder="{{ __("Serial Number") }}" required/>';
                html += '</div>';
                html += '</div>';
            }
            $("#serial-form").html(html);
            $('input[name="serialsData"]').val('');
            $("#assetDetailsModal").modal('show');
        }else{
            //$("#asset-form").submit();
        }
    }
    function addAssetSerial() {
        $('input', '#serial-form').each(function(){
            $(this).val() == "" && $(this).remove();
        })
        var formData = JSON.stringify($("#serial-form :input[value!=''][value!='.']").serializeArray());
        //console.log(JSON.stringify(formData));
        $('input[name="serialsData"]').val(formData);
        $("#assetDetailsModal").modal('hide');
        $("#asset-form").submit();
    }

</script>
@endpush