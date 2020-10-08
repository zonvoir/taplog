@extends('layouts.appClients', ['page' => __('users'), 'pageSlug' => 'users'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Users</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('clients.create')}}" class="btn btn-sm btn-primary">Add user</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{__('MIS Page')}}
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">

                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection