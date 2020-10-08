
@extends('layouts.app', ['page' => __('Edit Vendor'), 'pageSlug' => 'vendors'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="background: #3e77ff;">
                <h5 class="title">{{ __('Edit Profile') }}</h5>
            </div>
            <form method="post" action="{{route('vendors.update',$vendor->id)}}" autocomplete="off">
                <div class="card-body">
                    @csrf
                    @method('put')
                    @include('alerts.success')
                    <div class="row">
                        <div class="col-md-6 pr-md-1">
                          <div class="form-group">
                            <label>{{ __('Code') }}</label>
                            <input type="text" name="vendor_code" class="form-control{{ $errors->has('vendor_code') ? ' is-invalid' : '' }}" placeholder="{{ __('Code') }}" required="" value="{{$vendor->vendor_code}}">
                        </div>
                        </div>
                            <div class="col-md-6 pl-md-1">
                              <div class="form-group">
                                <label>{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" required="" value="{{$vendor->name}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 pr-md-1">
                            <div class="form-group">
                                <label>{{ __('Email') }}</label>
                                <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" required="" value="{{$vendor->user->email??''}}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-1">
                              <div class="form-group">
                                <label>{{ __('Password') }}</label>
                                <input type="password" name="password" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="" autocomplete="new-password">
                            </div>
                        </div>
                    </div>

            <div class="row">
                <div class="col-md-6 pr-md-1">
                  <div class="form-group">
                    <label>{{ __('Type') }}</label>
                    <select name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" onchange="showHideDiv(this)" required="">
                        <option value="">Select Type</option>
                        <option value="vendor" {{$vendor->type == 'vendor' ? 'selected' : ''}}>Vendor</option>
                        <option value="client" {{$vendor->type == 'client' ? 'selected' : ''}}>Client</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 pl-md-1">
              <div class="form-group">
                <label>{{ __('GST Number') }}</label>
                <input type="text" name="gst_no" class="form-control{{ $errors->has('gst_no') ? ' is-invalid' : '' }}" placeholder="{{ __('GST Number') }}" required="" value="{{$vendor->gst_no}}">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 pr-md-1">
          <div class="form-group">
            <label>{{ __('State') }}</label>
            <input type="text" name="state" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" required="" value="{{$vendor->state}}">
        </div>
    </div>
    <div class="col-md-6 pl-md-1">
      <div class="form-group">
        <label>{{ __('Billing Address') }}</label>
        <textarea name="billing_address" class="form-control{{ $errors->has('billing_address') ? ' is-invalid' : '' }}" required="">{{$vendor->billing_address}}</textarea>
    </div>
</div>
</div>
<div id="vendor-hidden-div" style="display: {{$vendor->type == 'client' ? 'none;' : 'block;'}}">
    <div class="row">
        <div class="col-md-6 pr-md-1">
          <div class="form-group">
            <label>{{ __('Latitute') }}</label>
            <input type="text" name="latitute" class="form-control{{ $errors->has('latitute') ? ' is-invalid' : '' }}" value="{{$vendor->latitute}}" placeholder="{{ __('Latitute') }}"/>
        </div>
    </div>
    <div class="col-md-6 pl-md-1">
      <div class="form-group">
        <label>{{ __('Longitude') }}</label>
        <input type="text" name="longitude" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" value="{{$vendor->longitude}}" placeholder="{{ __('Longitude') }}"/>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-6 pr-md-1">
        <div class="form-group">
        <label>{{ __('Vendor Category') }}</label>
        <select name="vendor_category" class="form-control{{ $errors->has('vendor_category') ? ' is-invalid' : '' }}">
            <option >{{ __('Select Category') }}</option>
            <option value="PUMP" {{$vendor->vendor_category == 'PUMP' ? 'selected' : ''}}>PUMP</option>
            <option value="VEHICLE" {{$vendor->vendor_category == 'VEHICLE' ? 'selected' : ''}}>VEHICLE</option>
        </select>
        </div>
    </div>
    <div class="col-md-6 pl-md-1">
        
    </div>
</div>
</div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-fill btn-primary">{{ __('Update') }}</button>
</div>
</form>
</div>

<div class="card">
 <div class="card-header" style="background: #3e77ff;">
    <h5 class="title">{{ __('Edit KYC Details') }}</h5>
</div>
<form method="post" action="{{route('update-kyc')}}" autocomplete="off">
    <div class="card-body">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-6 pr-md-1">
              <div class="form-group">
                <input type="hidden" name="row_id" value="{{isset($vendorkyc['id']) ? $vendorkyc['id'] : ''}}">
                <input type="hidden" name="vendor_id" value="{{$vendor->id}}">
                <label>{{ __('Adhar Number') }}</label>
                <<input type="number" name="adhar_no" class="form-control{{ $errors->has('adhar_no') ? ' is-invalid' : '' }}" placeholder="{{ __('Adhar Number') }}" value="{{isset($vendorkyc['mobile_no']) ? $vendorkyc['mobile_no'] : ''}}" required="">
            </div>
        </div>
        <div class="col-md-6 pl-md-1">
          <div class="form-group">
            <label>{{ __('Mobile Number') }}</label>
            <input type="number" name="longitude" class="form-control{{ $errors->has('mobile_no') ? ' is-invalid' : '' }}" value="{{isset($vendorkyc['mobile_no']) ? $vendorkyc['mobile_no'] : ''}}" placeholder="{{ __('Mobile Number') }}"/ required="">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 pr-md-1">
      <div class="form-group">
        <label>{{ __('PAN Number') }}</label>
        <<input type="text" name="pan_no" class="form-control{{ $errors->has('pan_no') ? ' is-invalid' : '' }}" placeholder="{{ __('PAN Number') }}" value="{{isset($vendorkyc['pan_no']) ? $vendorkyc['pan_no'] : ''}}" required="">
    </div>
</div>
<div class="col-md-6 pl-md-1">
  <div class="form-group">
    <label>{{ __('Email Id') }}</label>
    <input type="email" name="email_id" class="form-control{{ $errors->has('email_id') ? ' is-invalid' : '' }}" value="{{isset($vendorkyc['email_id']) ? $vendorkyc['email_id'] : ''}}" placeholder="{{ __('Email Id') }}"/ required="">
</div>
</div>
</div>
<div class="row">
    <div class="col-md-6 pr-md-1">
      <div class="form-group">
        <label>{{ __('Pincode') }}</label>
        <<input type="number" name="pincode" class="form-control{{ $errors->has('pincode') ? ' is-invalid' : '' }}" placeholder="{{ __('Pincode') }}" value="{{isset($vendorkyc['pincode']) ? $vendorkyc['pincode'] : ''}}" required="">
    </div>
</div>
<div class="col-md-6 pl-md-1">
  <div class="form-group">
    <label>{{ __('Beneficiary Name') }}</label>
    <input type="text" name="beneficiary_name" class="form-control{{ $errors->has('beneficiary_name') ? ' is-invalid' : '' }}" value="{{isset($vendorkyc['beneficiary_name']) ? $vendorkyc['beneficiary_name'] : ''}}" placeholder="{{ __('Beneficiary Name') }}"/ required="">
</div>
</div>
</div>
<div class="row">
    <div class="col-md-6 pr-md-1">
      <div class="form-group">
        <label>{{ __('Bank Name') }}</label>
        <<input type="text" name="bank_name" class="form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" placeholder="{{ __('bank_name') }}" value="{{isset($vendorkyc['bank_name']) ? $vendorkyc['bank_name'] : ''}}" required="">
    </div>
</div>
<div class="col-md-6 pl-md-1">
  <div class="form-group">
    <label>{{ __('Bank Account Number') }}</label>
    <input type="number" name="bank_acc_no" class="form-control{{ $errors->has('bank_acc_no') ? ' is-invalid' : '' }}" value="{{isset($vendorkyc['bank_acc_no']) ? $vendorkyc['bank_acc_no'] : ''}}" placeholder="{{ __('Bank Account Number') }}" required=""/>
</div>
</div>
</div>
<div class="row">
    <div class="col-md-6 pr-md-1">
      <div class="form-group">
        <label>{{ __('Bank IFSC Code') }}</label>
        <<input type="text" name="ifsc_code" class="form-control{{ $errors->has('ifsc_code') ? ' is-invalid' : '' }}" placeholder="{{ __('ifsc_code') }}" value="{{isset($vendorkyc['ifsc_code']) ? $vendorkyc['ifsc_code'] : ''}}" required="">
    </div>
</div>
</div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-fill btn-primary">{{ __('Update KYC') }}</button>
</div>
</form>
</div>
</div>
</div>
@endsection
<script type="text/javascript">
    function showHideDiv(el){
        if ($('option:selected',el).val() == 'vendor') {
            $("#vendor-hidden-div").show();
        }else{
            $("#vendor-hidden-div").hide();
        }
    }
</script>