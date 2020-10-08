@extends('layouts.app', ['page' => __('vehicle master'), 'pageSlug' => 'vehicle'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Vehicle</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('vehicle.create')}}" class="btn btn-sm btn-primary">Add Vehicle</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">Vehicle No</th>
                                    <th scope="col">Registration Certificate</th>
                                    <th scope="col">Insurance Policy No</th>
                                    <th scope="col">Insurance Policy Doc</th>
                                    <th scope="col">Insuarnce UpTo</th>
                                    <th scope="col">Fitness Certificate No</th>
                                    <th scope="col">Fitness Certificate Doc</th>
                                    <th scope="col">Fitness UpTo</th>
                                    <th scope="col">Permit No</th>
                                    <th scope="col">Permit Doc</th>
                                    <th scope="col">Permit UpTo</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Added Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @if(isset($vehicles) && !empty($vehicles))
                                    @foreach($vehicles as $site)
                                    <tr>
                                        <td>{{$site->vehicle_no}}</td>
                                        <td>{{$site->rc_doc}}</td>
                                        <td>{{$site->insurance_no}}</td>
                                        <td><a href="{{public_path($site->insurance_doc)}}" download>Download</a></td>
                                        <td>{{$site->insurance_upto}}</td>
                                        <td>{{$site->fitness_cert_no}}</td>
                                        <td><a href="{{public_path($site->fitness_cert_doc)}}" download>Download</a></td>
                                        <td>{{$site->fitness_cert_upto}}</td>
                                        <td>{{$site->permit_no}}</td>
                                        <td><a href="{{public_path($site->permit_doc)}}" download>Download</a></td>
                                        <td>{{$site->permit_upto}}</td>
                                        <td>{{$site->created_by_id}}</td>
                                        <td>{{$site->created_at}}</td>
                                        <td><a href="{{route('vehicle.edit',$site->id)}}">Edit</a><a href="{{route('vehicle.destroy',$site->id)}}" onclick="return confirm('Are you sure?');">Delete</a></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
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