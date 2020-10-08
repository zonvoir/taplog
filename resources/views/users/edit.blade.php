
@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Edit Profile') }}</h5>
            </div>
            <form method="post" action="{{route('user.update')}}" autocomplete="off">
                <div class="card-body">
                    @csrf
                    @method('put')

                    @include('alerts.success')
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label>{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', 
                        $user->name) }}">
                        @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    @if(auth()->user()->type == 'admin')
                    <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                        <label>{{ __('Type') }}</label>
                        <select name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" onchange="showHideUserSelection(this);" required="">
                            <option value="">Select Type</option>
                            <option value="subadmin" {{$user->type == 'subadmin'?'selected':''}}>Sub Admin</option>
                            <option value="other" {{$user->type != 'subadmin'?'selected':''}}>User</option>
                        </select>
                    </div>
                    @endif
                    @if(auth()->user()->type == 'subadmin')
                    <div class="input-group{{ $errors->has('user_type') ? ' has-danger' : '' }}" style="{{ $user->type == 'admin' ? 'display: none;':''}}" id="select_user_type">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <select name="user_type" class="form-control{{ $errors->has('user_type') ? ' is-invalid' : '' }}">
                            <option value="">Select User Type</option>
                            <option value="mis" {{$user->type=='mis'?'selected':''}}>MIS</option>
                            <option value="field_officer" {{$user->type=='field_officer'?'selected':''}}>Field officer</option>
                            <option value="client" {{$user->type=='client'?'selected':''}}>Client</option>
                            <option value="driver" {{$user->type=='driver'?'selected':''}}>Driver</option>
                            <option value="filler" {{$user->type=='filler'?'selected':''}}>Filler</option>
                        </select>
                        @include('alerts.feedback', ['field' => 'user_type'])
                    </div>
                    @include('alerts.feedback', ['field' => 'type'])
                    @endif
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label>{{ __('Email address') }}</label>
                        <input type="email" name="email" onblur="checkEmailExistOrNot(this);" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email address') }}" value="{{ old('email', $user->email) }}">
                        <span id="errors-email" style="color: red; display: none"></span>
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>
                    <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                        <label>{{ __('status') }}</label>
                        <select name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}">
                            <option value="active" {{$user->status=='active' ? 'selected' : ''}}>Active</option>
                            <option value="deactive" {{$user->status=='deactive' ? 'selected' : ''}}>Deactive</option>
                        </select>
                        @include('alerts.feedback', ['field' => 'name'])
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Password') }}</h5>
            </div>
            <form method="post" action="{{route('update-password')}}" autocomplete="off">
                <div class="card-body">
                    @csrf
                    @method('put')
                    @include('alerts.success', ['key' => 'password_status'])
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>
                    <div class="form-group">
                        <label>{{ __('Confirm New Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm New Password') }}" value="" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Change password') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-user">
            <div class="card-body">
                <p class="card-text">
                    <div class="author">
                        <div class="block block-one"></div>
                        <div class="block block-two"></div>
                        <div class="block block-three"></div>
                        <div class="block block-four"></div>
                        <a href="#">
                            <img class="avatar" src="{{ asset('black') }}/img/emilyz.jpg" alt="">
                            <h5 class="title">{{ auth()->user()->name }}</h5>
                        </a>
                        <p class="description">
                            {{ __('Ceo/Co-Founder') }}
                        </p>
                    </div>
                </p>
                <div class="card-description">
                    {{ __('Do not be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...') }}
                </div>
            </div>
            <div class="card-footer">
                <div class="button-container">
                    <button class="btn btn-icon btn-round btn-facebook">
                        <i class="fab fa-facebook"></i>
                    </button>
                    <button class="btn btn-icon btn-round btn-twitter">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="btn btn-icon btn-round btn-google">
                        <i class="fab fa-google-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        @if(auth()->user()->type == 'subadmin' || auth()->user()->type == 'admin')
        <div class="card card-user">
            <div class="card-body">
                <div class="card-description">
                    <div id="token-div">
                        {{ $user->api_token }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="button-container">
                    @if($user->api_token == null || $user->api_token == '')
                    <button class="btn btn-primary" onclick="regenerateToken({{$user->id}});">Generate Token</button>
                    @else
                    <button class="btn btn-primary" onclick="regenerateToken({{$user->id}});">Refresh Token</button>
                    @endif
                </div>
            </div>
        </div>
        @endif
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
    var tokenPath = "{{route('update-api-token')}}";
    function regenerateToken(userId){
        $.get( tokenPath,{ 'id': userId }, function( data ) {
          $( "#token-div" ).html( data.token );
      });
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