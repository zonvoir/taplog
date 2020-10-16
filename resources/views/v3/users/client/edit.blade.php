
@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Edit Profile') }}</h5>
            </div>
            <form method="post" action="{{route('update-user',$user->id)}}" autocomplete="off">
                <div class="card-body">
                    @csrf
                    @include('alerts.success')
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label>{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', 
                        $user->name) }}">
                        @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="form-group{{ $errors->has('user_type') ? ' has-danger' : '' }}">
                        <label>{{ __('User Type') }}</label>
                        <select name="user_type" class="form-control{{ $errors->has('user_type') ? ' is-invalid' : '' }}">
                            <option value="mis" {{$user->type=='mis'?'selected':''}}>MIS</option>
                            <option value="technician" {{$user->type=='technician'?'selected':''}}>Technician</option>
                        </select>
                        @include('alerts.feedback', ['field' => 'user_type'])
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label>{{ __('Email address') }}</label>
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email address') }}" value="{{ old('email', $user->email) }}">
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>
                    <div class="form-group{{ $errors->has('contact') ? ' has-danger' : '' }}">
                        <label>{{ __('Contact') }}</label>
                        <input type="contact" name="contact" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Mobile Number') }}" value="{{ old('contact', $user->contact) }}">
                        @include('alerts.feedback', ['field' => 'contact'])
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
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Update') }}</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ __('Password') }}</h5>
            </div>
            <form method="post" action="{{route('update-password-client',$user->id)}}" autocomplete="off">
                <div class="card-body">
                    @csrf
                    @include('alerts.success', ['key' => 'password_status'])
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