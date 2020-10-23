@extends('layouts.app', ['page' => __('site master'), 'pageSlug' => 'sites'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Site</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('site.create')}}" class="btn btn-sm btn-primary">Add Site</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter " id="site-tbl">
                            <thead class=" text-primary">
                                <tr>
                                     <th scope="col">Action</th>
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
                                </tr>
                            </thead>
                                <tbody>
                                    
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