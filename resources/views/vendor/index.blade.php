@extends('layouts.app', ['page' => __('vendors'), 'pageSlug' => 'vendors'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Vendors</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('vendors.create')}}" class="btn btn-sm btn-primary">Add Vendor</a>
                        </div>
                    </div>
                </div>
                <div class="card-body h_sg">

                    <div class="table-responsive gfe">
                        <table class="table tablesorter " id="weW">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Billing Address</th>
                                    <th scope="col">State</th>
                                    <th scope="col">GST Number</th>
                                    <th scope="col">Latitude</th>
                                    <th scope="col">Longitude</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr></thead>
                                <tbody>
                                    @if(isset($vendors) && !empty($vendors))
                                    @foreach($vendors as $vendor)
                                    <tr>
                                        <td>{{$vendor->vendor_code}}</td>
                                        <td>{{$vendor->name}}</td>
                                        <td>{{$vendor->type}}</td>
                                        <td>{{$vendor->billing_address}}</td>
                                        <td>{{$vendor->state}}</td>
                                        <td>{{$vendor->gst_no}}</td>
                                        <td>{{$vendor->latitute ? $vendor->latitute : 'NA'}}</td>
                                        <td>{{$vendor->longitude ? $vendor->longitude : 'NA'}}</td>
                                        <td>{{$vendor->vendor_category ? $vendor->vendor_category : 'NA'}}</td>
                                        <td>{{$vendor->created_at}}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{route('vendors.edit',$vendor->id)}}">Edit</a>
                                                    @if($vendor->vendor_category == 'VEHICLE')
                                                    <a class="dropdown-item" href="{{route('vendors.editVehicle',$vendor->id)}}">Update Vehicle</a>
                                                    @endif
                                                    <a class="dropdown-item" onclick="return confirm('Are you sure?');" href="{{route('delete-vendor',$vendor->id)}}">Delete</a>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{ $vendors->links() }}
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