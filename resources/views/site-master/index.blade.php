@extends('layouts.app', ['page' => __('site master'), 'pageSlug' => 'sites'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <form class="form" action="{{route('site.index')}}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <h4 class="card-title">Sites</h4>
                            </div>
                            <div class="col-2">
                                <input type="text" name="site_id" class="form-control" placeholder="Enter Site Id" required="">
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn btn-primary">Search</button>
                            </div>
                            <div class="col-2">
                                <a href="{{route('site.index')}}" class="btn btn btn-primary">Back</a>
                            </div>
                            <div class="col-2 text-right">
                                <a href="{{route('site.create')}}" class="btn btn-sm btn-primary">Add Site</a>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <tr>
                                        <th scope="col">Site id</th>
                                        <th scope="col">Unique Site ID</th>
                                        <th scope="col">Site Name</th>
                                        <th scope="col">Cluster/JC</th>
                                        <th scope="col">District</th>
                                        <th scope="col">MP / Zone</th>
                                        <th scope="col">Site Address</th>
                                        <th scope="col">Lat</th>
                                        <th scope="col">Long</th>
                                        <th scope="col">Site Type</th>
                                        <th scope="col">BTS</th>
                                        <th scope="col">Site Category</th>
                                        <th scope="col">Battery Bank (AH)</th>
                                        <th scope="col">CPH</th>
                                        <th scope="col">Indoor BTS</th>
                                        <th scope="col">Outdoor BTS</th>
                                        <th scope="col">DG1 Make</th>
                                        <th scope="col">DG2 Make</th>
                                        <th scope="col">DG-1 rate (KVA)</th>
                                        <th scope="col">DG-2 rate (KVA)</th>
                                        <th scope="col">EB Status</th>
                                        <th scope="col">EB Type</th>
                                        <th scope="col">EB Load (KW)</th>
                                        <th scope="col">Technician Name</th>
                                        <th scope="col">Technician Contacts</th>
                                        <th scope="col">Cluster Incharge/Supervisor Name</th>
                                        <th scope="col">Cluster Incharge Contacts</th>
                                        <th scope="col">Cluster Incharge Email</th>
                                        <th scope="col">L2/ZOM Name</th>
                                        <th scope="col">L2/ZOM Contact</th>
                                        <th scope="col">L2/ZOM Email</th>
                                        <th scope="col">Energy Man Name</th>
                                        <th scope="col">Energy Manager Contact</th>
                                        <th scope="col">Energy Manager Email</th>
                                        <th scope="col">Circle Facility Head/O&M Head Name</th>
                                        <th scope="col">Circle Facility Head/O&M Head Contact</th>
                                        <th scope="col">Circle Facility Head/O&M Head Email</th>
                                        <th scope="col">Client Name</th>
                                        <th scope="col">Billing Address</th>
                                        <th scope="col">GST No.</th>
                                        <th scope="col">Added Date</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($sites) && !empty($sites))
                                    @foreach($sites as $site)
                                    <tr>
                                        <td>{{$site->site_id}}</td>
                                        <td>{{$site->unique_site_id}}</td>
                                        <td>{{$site->site_name}}</td>
                                        <td>{{$site->cluster_jc}}</td>
                                        <td>{{$site->district}}</td>
                                        <td>{{$site->mp_zone}}</td>
                                        <td>{{$site->site_address}}</td>
                                        <td>{{$site->latitude}}</td>
                                        <td>{{$site->longitude}}</td>
                                        <td>{{$site->site_type}}</td>
                                        <td>{{$site->bts}}</td>
                                        <td>{{$site->site_category}}</td>
                                        <td>{{$site->battery_bank_ah}}</td>
                                        <td>{{$site->cph}}</td>
                                        <td>{{$site->indoor_bts}}</td>
                                        <td>{{$site->outdoor_bts}}</td>
                                        <td>{{$site->dg1_make}}</td>
                                        <td>{{$site->dg2_make}}</td>
                                        <td>{{$site->dg1_rating_in_kva}}</td>
                                        <td>{{$site->dg2_rating_in_kva}}</td>
                                        <td>{{$site->eb_status}}</td>
                                        <td>{{$site->eb_type}}</td>
                                        <td>{{$site->eb_load_kw}}</td>
                                        <td>{{$site->technician_name}}</td>

                                        <td>{{isset($site->technician_contact1) ? $site->technician_contact1 : ''}} {{!empty($site->technician_contact2) ? '&'.$site->technician_contact2 : '' }} </td>

                                        <td>{{$site->cluster_incharge_name}}</td>
                                        <td>{{isset($site->cluster_incharge_contact1) ? $site->cluster_incharge_contact1 : ''}} {{!empty($site->cluster_incharge_contact2) ? '&'.$site->cluster_incharge_contact2 : '' }}</td>
                                        <td>{{$site->cluster_incharge_email}}</td>
                                        <td>{{$site->zom_name}}</td>
                                        <td>{{$site->zom_contact}}</td>
                                        <td>{{$site->zom_email}}</td>
                                        <td>{{$site->energy_man_name}}</td>
                                        <td>{{$site->energy_man_contact}}</td>
                                        <td>{{$site->energy_man_email}}</td>
                                        <td>{{$site->circle_facility_head_name}}</td>
                                        <td>{{$site->circle_facility_head_contact}}</td>
                                        <td>{{$site->circle_facility_head_email}}</td>
                                        <td>{{$site->client_name}}</td>
                                        <td>{{$site->billing_address}}</td>
                                        <td>{{$site->gst_no}}</td>
                                        <td>{{$site->created_at}}</td>
                                        <td class="action_btn_cust">
                                            <a href="{{route('site.edit',$site->id)}}">Edit</a><a href="{{route('delete-site',$site->id)}}" onclick="return confirm('Are you sure?');">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>

                        </div>
                        {{ $sites->links() }}
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