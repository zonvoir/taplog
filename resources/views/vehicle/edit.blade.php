@extends('layouts.app', ['page' => __('Update vehicle'), 'pageSlug' => 'vehicle'])
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title"> Update Vehicle</h4></div>
                </div>
            </div>
            <div class="card-body">
             <form class="form" method="post" action="{{ route('vehicle.update',$vehicle->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="vendor_id" value="{{isset($vehicle->vendor_id) ? $vehicle->vendor_id : ''}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 pr-md-1">
                          <div class="form-group">
                            <label>{{ __('Vehicle No') }}</label>
                            <input type="text" name="vehicle_no" class="form-control{{ $errors->has('vehicle_no') ? ' is-invalid' : '' }}" placeholder="{{ __('*Vehicle No') }}" value="{{$vehicle->vehicle_no}}" required="">
                        </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>Registration Certificate</label>
                        <input type="file" name="rc_doc" class="form-control{{ $errors->has('rc_doc') ? ' is-invalid' : '' }}" placeholder="{{ __('Registration Certificate') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pr-md-1">
                  <div class="form-group">
                    <label>{{ __('Insurance Policy No') }}</label>
                    <input type="text" name="insurance_no" class="form-control{{ $errors->has('insurance_no') ? ' is-invalid' : '' }}" placeholder="{{ __('Insurance Policy No') }}" value="{{$vehicle->insurance_no}}" required="">
                </div>
            </div>
            <div class="col-md-6 pl-md-1">
              <div class="form-group">
                <label>Insurance Policy Doc</label>
                <input type="file" name="insurance_doc" class="form-control{{ $errors->has('insurance_doc') ? ' is-invalid' : '' }}" placeholder="{{ __('Insurance Policy Doc') }}" >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 pr-md-1">
          <div class="form-group">
            <label>{{ __('Insuarnce UpTo') }}</label>
            <input type="text" name="insurance_upto" class="datepicker form-control{{ $errors->has('insurance_upto') ? ' is-invalid' : '' }}" placeholder="{{ __('Insuarnce UpTo') }}" required="" value="{{$vehicle->insurance_upto}}">
        </div>
    </div>
    <div class="col-md-6 pl-md-1">
      <div class="form-group">
        <label>{{ __('Fitness Certificate No') }}</label>
        <input type="text" name="fitness_cert_no" class="form-control{{ $errors->has('fitness_cert_no') ? ' is-invalid' : '' }}" placeholder="{{ __('Fitness Certificate No') }}" value="{{$vehicle->fitness_cert_no}}" required="">
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-6 pr-md-1">
      <div class="form-group">
        <label>{{ __('Fitness Certificate Doc') }}</label>
        <input type="file" name="fitness_cert_doc" class="form-control{{ $errors->has('fitness_cert_doc') ? ' is-invalid' : '' }}" placeholder="{{ __('Fitness Certificate Doc') }}" >
    </div>
</div>
<div class="col-md-6 pl-md-1">
  <div class="form-group">
    <label>{{ __('Fitness Certificate Valid Upto') }}</label>
    <input type="text" name="fitness_cert_upto" class="datepicker form-control{{ $errors->has('fitness_cert_upto') ? ' is-invalid' : '' }}" value="{{$vehicle->fitness_cert_upto}}" placeholder="{{ __('Fitness Certificate Valid Upto') }}" required="">
</div>
</div>
</div>
<div class="row">
    <div class="col-md-6 pr-md-1">
      <div class="form-group">
        <label>{{ __('Permit No') }}</label>
        <input type="text" name="permit_no" class="form-control{{ $errors->has('permit_no') ? ' is-invalid' : '' }}" placeholder="{{ __('Permit No') }}" value="{{$vehicle->permit_no}}" required="">
    </div>
</div>
<div class="col-md-6 pl-md-1">
  <div class="form-group">
    <label>{{ __('Permit Doc') }}</label>
    <input type="file" name="permit_doc" class="form-control{{ $errors->has('permit_doc') ? ' is-invalid' : '' }}" placeholder="{{ __('Permit Doc') }}">
</div>
</div>
</div>
<div class="row">
    <div class="col-md-6 pl-md-1">
  <div class="form-group">
    <label>{{ __('Permit Valid Upto') }}</label>
    <input type="text" name="permit_upto" class="datepicker form-control{{ $errors->has('permit_upto') ? ' is-invalid' : '' }}" placeholder="{{ __('Permit Valid Upto') }}" value="{{$vehicle->permit_upto}}" required="">
</div>
</div>
<div class="col-md-6 pl-md-1"></div>
</div>

</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Update') }}</button>
</div>
</form>
</div>
</div>
</div>
</div>
@endsection