@extends('layouts.app', ['page' => __('Edit Vendor'), 'pageSlug' => 'vendors'])
@section('content')
<style type="text/css">
    .highlight-error {
      border-color: red;
  }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="background: #3e77ff;">
                <h5 class="title">{{ __('Edit Profile') }}</h5>
            </div>
            <form method="post" action="{{route('clients.update',$vendor->id)}}" autocomplete="off">
                <div class="card-body">
                    @csrf
                    @method('put')
                    @include('alerts.success')
                    <div class="row">
                        <div class="col-md-6 ">
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
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label>{{ __('Email') }}</label>
                        <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" required="" value="{{$vendor->user->email??''}}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="form-group">
                        <label>{{ __('Contact') }}</label>
                        <input type="text" name="contact" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Contact') }}" required="" value="{{$vendor->user->contact??''}}" autocomplete="off">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 ">
                  <div class="form-group">
                    <label>{{ __('State') }}</label>
                    <input type="text" name="state" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" required="" value="{{$vendor->state}}">
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>{{ __('GST Number') }}</label>
                <input type="text" name="gst_no" class="form-control{{ $errors->has('gst_no') ? ' is-invalid' : '' }}" placeholder="{{ __('GST Number') }}" required="" value="{{$vendor->gst_no}}">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>{{ __('Billing Address') }}</label>
            <textarea name="billing_address" class="form-control{{ $errors->has('billing_address') ? ' is-invalid' : '' }}" required="">{{$vendor->billing_address}}</textarea>
        </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ __('Password') }}</label>
        <input type="password" name="password" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="" autocomplete="new-password">
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
            <div class="col-md-6 ">
              <div class="form-group">
                <input type="hidden" name="row_id" value="{{isset($vendorkyc['id']) ? $vendorkyc['id'] : ''}}">
                <input type="hidden" name="client_id" value="{{$vendor->id}}">
                <label>{{ __('Adhar Number') }}</label>
                <input type="text" name="adhar_no" class="form-control" placeholder="{{ __('Adhar Number') }}" value="{{isset($vendorkyc['adhar_no']) ? $vendorkyc['adhar_no'] : ''}}" data-type="adhaar-number" maxLength="19" required="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 ">
          <div class="form-group">
            <label>{{ __('Pincode') }}</label>
            <input type="number" min="0" name="pincode" class="form-control{{ $errors->has('pincode') ? ' is-invalid' : '' }}" placeholder="{{ __('Pincode') }}" value="{{isset($vendorkyc['pincode']) ? $vendorkyc['pincode'] : ''}}" required="">
        </div>
    </div>
    <div class="col-md-6 ">
      <div class="form-group">
        <label>{{ __('PAN Number') }}</label>
        <input type="text" name="pan_no" class="form-control{{ $errors->has('pan_no') ? ' is-invalid' : '' }}" placeholder="{{ __('PAN Number') }}" value="{{isset($vendorkyc['pan_no']) ? $vendorkyc['pan_no'] : ''}}" required="">
    </div>
</div>

</div>
<div class="row">
    <div class="col-md-6 ">
      <div class="form-group">
        <label>{{ __('Bank Name') }}</label>
        <input type="text" name="bank_name" class="form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" placeholder="{{ __('bank_name') }}" value="{{isset($vendorkyc['bank_name']) ? $vendorkyc['bank_name'] : ''}}" required="">
    </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>{{ __('Beneficiary Name') }}</label>
    <input type="text" name="beneficiary_name" class="form-control{{ $errors->has('beneficiary_name') ? ' is-invalid' : '' }}" value="{{isset($vendorkyc['beneficiary_name']) ? $vendorkyc['beneficiary_name'] : ''}}" placeholder="{{ __('Beneficiary Name') }}"/ required="">
</div>
</div>
</div>
<div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ __('Bank Account Number') }}</label>
        <input type="number" min="0" name="bank_acc_no" class="form-control{{ $errors->has('bank_acc_no') ? ' is-invalid' : '' }}" value="{{isset($vendorkyc['bank_acc_no']) ? $vendorkyc['bank_acc_no'] : ''}}" placeholder="{{ __('Bank Account Number') }}" required=""/>
    </div>
</div>
<div class="col-md-6 ">
  <div class="form-group">
    <label>{{ __('Bank IFSC Code') }}</label>
    <input type="text" name="ifsc_code" class="form-control{{ $errors->has('ifsc_code') ? ' is-invalid' : '' }}" placeholder="{{ __('ifsc_code') }}" value="{{isset($vendorkyc['ifsc_code']) ? $vendorkyc['ifsc_code'] : ''}}" required="">
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
@push('js')
<script type="text/javascript">
    $('[data-type="adhaar-number"]').keyup(function() {
      var value = $(this).val();
      value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
      $(this).val(value);
  });

    $('[data-type="adhaar-number"]').on("change, blur", function() {
      var value = $(this).val();
      var maxLength = $(this).attr("maxLength");
      if (value.length != maxLength) {

        $(this).addClass("highlight-error");
    } else {
        $(this).removeClass("highlight-error");
    }
});
</script>
@endpush