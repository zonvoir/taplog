@extends('layouts.app', ['page' => __('vehicle master'), 'pageSlug' => 'vehicle'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="card-title">Vehicle Run Data</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
					<h4>Total Trips: {{ count($run_data) }}</h4>
					<h4>Total KM: {{ $total_km??0 }} km</h4>
                    <div class="table-responsive">
                        <table class="table tablesorter" id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">Trip ID</th>
                                    <th scope="col">Vehicle No.</th>
                                    <th scope="col">Effective Date</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Passed KM</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @if(isset($run_data) && !empty($run_data))
                                    @foreach($run_data as $data)
                                    <tr>
                                        <td><a href="{{ route('vehicle-trip-data') }}?trip_id={{$data->trip_id}}&vehicle_id={{ $data->vehicle_id }}">{{$data->trip->trip_id}}</a></td>
                                        <td>{{$data->vehicle->vehicle_no}}</td>
                                        <td>{{$data->trip->effective_date}}</td>
                                        <td>{{$data->beatplan->client->name}}</td>
                                        <td>{{$data->passed_reading}}</td>
                                        <td>--</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                        	{{ $run_data->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection