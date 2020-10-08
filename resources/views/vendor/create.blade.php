@extends('layouts.app', ['page' => __('vendors'), 'pageSlug' => 'create vendors'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title"> Create Vendor</h4></div>
				</div>
			</div>
			<div class="card-body">
               <form class="form" id="vendor-form" method="post" action="{{ route('vendors.store') }}">
                @csrf
                <input type="hidden" name="vehicleAdded" value="no">
                <div class="card-body">
                   <div class="input-group{{ $errors->has('vendor_code') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="text" name="vendor_code" class="form-control{{ $errors->has('vendor_code') ? ' is-invalid' : '' }}" placeholder="{{ __('Code') }}" required />
                    @include('alerts.feedback', ['field' => 'vendor_code'])
                </div>
                <div class="input-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" required />
                    @include('alerts.feedback', ['field' => 'name'])
                </div>
                <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" required />
                    @include('alerts.feedback', ['field' => 'email'])
                </div>
                <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" required />
                    @include('alerts.feedback', ['field' => 'password'])
                </div>
                <div class="input-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <select name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" onchange="showHideDiv(this)" required />
                        <option value="">Select Type</option>
                        <option value="vendor">Vendor</option>
                        <option value="client">Client</option>
                    </select>
                    @include('alerts.feedback', ['field' => 'type'])
                </div>
                <div class="input-group{{ $errors->has('billing_address') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <textarea name="billing_address" class="form-control{{ $errors->has('billing_address') ? ' is-invalid' : '' }}" required />{{ __('Billing Address: ') }}</textarea>
                    @include('alerts.feedback', ['field' => 'billing_address'])
                </div>
                <div class="input-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="text" name="state" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" required />
                    @include('alerts.feedback', ['field' => 'state'])
                </div>

                <div class="input-group{{ $errors->has('gst_no') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="text" name="gst_no" class="form-control{{ $errors->has('gst_no') ? ' is-invalid' : '' }}" placeholder="{{ __('GST Number') }}" required />
                    @include('alerts.feedback', ['field' => 'gst_no'])
                </div>
                <div id="vendor-hidden-div" style="display: none;">
                    <div class="input-group{{ $errors->has('latitute') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <input type="text" name="latitute" class="form-control{{ $errors->has('latitute') ? ' is-invalid' : '' }}" placeholder="{{ __('Latitute') }}"/>
                        @include('alerts.feedback', ['field' => 'latitute'])
                    </div>
                    <div class="input-group{{ $errors->has('longitude') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <input type="text" name="longitude" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Longitude') }}"/>
                        @include('alerts.feedback', ['field' => 'longitude'])
                    </div>
                    <div class="input-group{{ $errors->has('vendor_category') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <select name="vendor_category" class="form-control{{ $errors->has('vendor_category') ? ' is-invalid' : '' }}">
                            <option >{{ __('Select Category') }}</option>
                            <option value="PUMP">PUMP</option>
                            <option value="VEHICLE">VEHICLE</option>
                        </select>
                        @include('alerts.feedback', ['field' => 'vendor_category'])
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <!-- <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Create') }}</button> -->
                <button type="button" class="btn btn-primary" onclick="askForVehicle();">{{ __('Create') }}</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="vehicleConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="vehicleConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="vehicleConfirmationModalLabel">Confirm</h5>
    </div>
    <div class="modal-body">
        Do you want to add Vehicle details?
    </div>
    <div class="modal-footer">
        <button type="button" onclick="notToAddVehicle();" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" onclick="vehicleAddedTrue();" class="btn btn-primary">Yes</button>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
    function showHideDiv(el){
        if ($('option:selected',el).val() == 'vendor') {
            $("#vendor-hidden-div").show();
        }else{
            $("#vendor-hidden-div").hide();
        }
    }
    function notToAddVehicle() {
        $("#vendor-form").validate({
          rules: {
            vendor_code: "required",
        },
        messages: {
            vendor_code: "Enter Vender Code"
        }
    });
        $("#vendor-form").submit();
    }

    function askForVehicle() {
        $("#vendor-form").validate({
          rules: {
            vendor_code: "required",
        },
        messages: {
            vendor_code: "Enter Vender Code"
        }
    });
        if($('select[name="type"]').val() == 'vendor' && $('select[name="vendor_category"]').val() == 'VEHICLE'){
             $(this).find('option:selected').text();
            $("#vehicleConfirmationModal").modal('show');
        }else{
            $("#vendor-form").submit();
        }
    }

    function vehicleAddedTrue() {
        $('input[name="vehicleAdded"]').val('yes');
        $("#vendor-form").submit();
    }

</script>
@endsection