@extends('layouts.app', ['page' => __('vehicle master'), 'pageSlug' => 'vehicle'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h3 class="card-title">Vehicle Current Running Status</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                   	<h4>Vehicle: {{ $vehicle_status->vehicle->vehicle_no }}</h4>
                   	<h4>Trip ID: {{ $vehicle_status->trip->trip_id }}</h4>
                   	<h4>Last Location: Lat: {{ $vehicle_status->lat }}, Lng: {{ $vehicle_status->lng }}</h4>
                    <div class="table-responsive">
					<table class="table tablesorter " id="">
						<thead class=" text-primary">
						  <tr>
							<th class="text-center">Effective Date</th>
							<th scope="col">Site id</th>
							<th scope="col">Site Name</th>
							<th scope="col">Site Category</th>
							<th scope="col">Technician Name</th>
							<th scope="col">Technician Number</th>
							<th scope="col">Qty</th>
							<th scope="col">Current Status</th>
						  </tr>
						</thead>
						<tbody>
						  @if(isset($vehicle_status->trip->trip_data) && !empty($vehicle_status->trip->trip_data))
						  @foreach($vehicle_status->trip->trip_data as $trip_data)
						  <tr>
							<td>
							  {{ $vehicle_status->trip->effective_date }}</a>
							</td>
							<td>
							  {{ $trip_data->site->site_id }}
							</td>
							<td>
							  {{ $trip_data->site->site_name }}
							</td>
							<td>
							  {{ $trip_data->site->site_category }}
							</td>
							<td>
							  {{ $trip_data->site->technician_name }}
							</td>
							<td>
							  {{ $trip_data->site->technician_contact1 }}, {{ $trip_data->site->technician_contact2 }}
							</td>
							<td>
							  {{ $trip_data->beat_plan_data()?$trip_data->beat_plan_data()->quantity:'' }}
							</td>
							<td>
							  {{ $trip_data->status }}
							</td>
							
						  </tr>
						  @endforeach
						  @endif
						</tbody>
					  </table>
					</div>
                </div>
            </div>
        </div>
    </div>
    @endsection