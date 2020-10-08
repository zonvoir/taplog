@extends('layouts.app', ['page' => __('users'), 'pageSlug' => 'create users'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title"> Create User</h4></div>
				</div>
			</div>
			<div class="card-body">
               <form class="form" method="post" action="{{ route('user.store') }}">
                @csrf

                <div class="card-body">
                    <div class="input-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" required="">
                        @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    @if(auth()->user()->type == 'admin')       
                    <div class="input-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <select name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" onchange="showHideUserSelection(this);" required="">
                            <option value="subadmin" selected="">Sub Admin</option>
                        </select>
                        @include('alerts.feedback', ['field' => 'type'])
                    </div>
                    @endif
                    <div class="input-group{{ $errors->has('user_type') ? ' has-danger' : '' }}" style="{{auth()->user()->type == 'admin' ? 'display: none;' : ''}}" id="select_user_type">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <select name="user_type" class="form-control{{ $errors->has('user_type') ? ' is-invalid' : '' }}">
                            <option value="">Select User Type</option>
                            <option value="mis">MIs</option>
                            <option value="field_officer">Field officer</option>
                            <option value="client">Client</option>
                            <option value="technician">Technician</option>
                            <option value="driver">Driver</option>
                            <option value="filler">Filler</option>
                        </select>
                        @include('alerts.feedback', ['field' => 'user_type'])
                    </div>
                    <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-email-85"></i>
                            </div>
                        </div>
                        <input type="email" name="email" onblur="checkEmailExistOrNot(this);" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" required="">
                        <span id="errors-email" style="color: red; display: none"></span>
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>
                    <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-lock-circle"></i>
                            </div>
                        </div>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" required="">
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-lock-circle"></i>
                            </div>
                        </div>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}">
                    </div>
                    <div class="form-check text-left">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox">
                            <span class="form-check-sign"></span>
                            {{ __('I agree to the') }}
                            <a href="#">{{ __('terms and conditions') }}</a>.
                        </label>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Get Started') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
<script type="text/javascript">
    function showHideUserSelection(e) {
        if($(e).val() == 'other'){
            $("#select_user_type").show();   
        }else{
            $("#select_user_type").hide();   
        }
    }
    function checkEmailExistOrNot(e) {
        var emaiId = $(e).val();
        $.get( "{{ route('is-exits-email') }}", { email: emaiId }, function( data ) {
          if(data.status){
            $(e).val('')
            $('#errors-email').html('Email id already exist!');
            $('#errors-email').show();
        }else{
            $('#errors-email').html('');
            $('#errors-email').hide();
        }
    });
    }
</script>