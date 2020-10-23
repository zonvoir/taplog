@extends('layouts.app', ['class' => 'login-page', 'page' => __(''), 'contentClass' => 'login-page'])
@section('content')
<!--
    <div class="col-md-10 text-center ml-auto mr-auto">
        <h3 class="mb-5">Log in to see how you can speed up your web development with out of the box CRUD for #User Management and more.</h3>
    </div>
-->
<div class="col-lg-4 col-md-6 ml-auto mr-auto">
    <form class="form" method="post" action="{{ route('login') }}">
        @csrf
        <div class="card card-login card-white">
            <div class="card-header">
                <img src="http://rottweilerservices.com/v2admin/public/black/img/card-primary.png" alt="">
                <h1 class="card-title">{{ __('Log in') }}</h1>
            </div>
            <div class="card-body">
                @include('layouts.navbars.flash-message')
                <div class="input-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Email or Contact') }}">
                    @include('alerts.feedback', ['field' => 'username'])
                </div>
                <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-lock-circle"></i>
                        </div>
                    </div>
                    <input type="password" placeholder="{{ __('Password') }}" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
                    @include('alerts.feedback', ['field' => 'password'])
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" href="" class="btn btn-primary btn-lg btn-block mb-3">{{ __('Get Started') }}</button>
                    <!--<div class="pull-left">
                        <h6>
                            <a href="{{ route('register') }}" class="link footer-link">{{ __('Create Account') }}</a>
                        </h6>
                    </div>
                    <div class="pull-right">
                        <h6>
                            <a href="{{ route('password.request') }}" class="link footer-link">{{ __('Forgot password?') }}</a>
                        </h6>
                    </div>-->
                </div>
            </div>
        </form>
    </div>

    <style>
        .fixed-top{display: none}
        .full-page>.content {
            padding-bottom: 0px;
            padding-top: 70px;
        }

        .full-page.pricing-page, .full-page.login-page, .full-page.lock-page, .full-page.register-page {
            background: #e4e4e4;
        }


    </style>

    @endsection
