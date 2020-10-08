@extends('layouts.app', ['page' => __('Trip Data'), 'pageSlug' => 'backlog'])
@section('content')
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header">
<div class="row">
<div class="col-md-6"><h4 class="card-title">Trip Data</h4></div>
</div>
</div>
<div class="card-body ">
@if($beat_plan)
<h5 style="color: #000;">Effective Date: {{ $beat_plan->effective_date }}</h5>
<h5 style="color: #000;">Client: {{ $beat_plan->client->name }}</h5>
<div class="hg_cl_m">
<div class="table-responsive">
<table class="table tablesorter " id="">
<thead class=" text-primary">
<tr>
<th scope="col">Trip Id</th>
<th scope="col">Site id</th>
<th scope="col">Site Name</th>
<th scope="col">Site Category</th>
<th scope="col">Technician Name</th>
<th scope="col">Technician Number</th>
<th scope="col">Qty</th>
<th scope="col">Current Status</th>
<th scope="col">Loading Date</th>
<th scope="col">Loading Start Time</th>
<th scope="col">Loading Finish Time</th>
<th scope="col">Filling Date</th>
<th scope="col">Site In Time</th>
<th scope="col">Site Out Time</th>
<th scope="col">Vehicle No</th>
<th scope="col">Driver Name</th>
<th scope="col">Driver Number</th>
<th scope="col">Filler Name</th>
<th scope="col">Filler Number</th>
<th scope="col">Remark</th>
<!-- <th scope="col"></th> -->
</tr>
</thead>
<tbody>
@if(isset($beat_plan) && !empty($beat_plan) && isset($beat_plan->beatplan_data))
@foreach($beat_plan->beatplan_data as $key=>$beatplan_data)

<tr>
<td>
@if($beatplan_data->trip_data())
{{$beat_plan->uniqueTrip($beatplan_data->beatplan_id, $beatplan_data->site_id)}}
@endif
</td>
<td>{{$beatplan_data->site->site_id}}</td>
<td>{{$beatplan_data->site->site_name}}</td>
<td>{{$beatplan_data->site->site_category}}</td>
<td>
{{ $beatplan_data->site->technician_name }}
</td>
<td>
{{ $beatplan_data->site->technician_contact1
}},
{{ $beatplan_data->site->technician_contact2
}}
</td>
<td>{{$beatplan_data->quantity}}</td>
<td>
@if($beatplan_data->trip_data())
{{$beatplan_data->trip_data()->status}}
@if($beatplan_data->trip_data()->status != 'unloaded')
@else

@endif
@else
{{$beatplan_data->status}}
@endif
</td>
<td>
@if($beatplan_data->trip_data())
@if($beatplan_data->trip_data()->loading_start)
{{ \Carbon\Carbon::parse($beatplan_data->trip_data()->loading_start)->format('d-m-y')
}}
@endif
@endif
</td>
<td>
@if($beatplan_data->trip_data())
@if($beatplan_data->trip_data()->loading_start)
{{
\Carbon\Carbon::parse($beatplan_data->trip_data()->loading_start)->format('H:i:s')
}}
@endif
@endif
</td>
<td>
@if($beatplan_data->trip_data())
@if($beatplan_data->trip_data()->loading_finish)
{{
\Carbon\Carbon::parse($beatplan_data->trip_data()->loading_finish)->format('H:i:s')
}}
@endif
@endif
</td>
<td>
@if($beatplan_data->trip_data())
@if($beatplan_data->trip_data()->filling_start)
{{ \Carbon\Carbon::parse($beatplan_data->trip_data()->filling_start)->format('d-m-y')
}}
@endif
@endif
</td>
<td>
@if($beatplan_data->trip_data())
@if($beatplan_data->trip_data()->site_in)
{{
\Carbon\Carbon::parse($beatplan_data->trip_data()->site_in)->format('H:i:s')
}}
@endif
@endif
</td>
<td>
@if($beatplan_data->trip_data())
@if($beatplan_data->trip_data()->site_out)
{{
\Carbon\Carbon::parse($beatplan_data->trip_data()->site_out)->format('H:i:s')
}}
@endif
@endif
</td>
<td>
@if($beatplan_data->trip_data())
{{ $beatplan_data->trip->vechile->vehicle_no }}
@endif
</td>
<td>
@if($beatplan_data->trip_data())
{{ $beatplan_data->trip->driver->name }}
@endif
</td>
<td>
@if($beatplan_data->trip_data())
{{ $beatplan_data->trip->driver->contact }}
@endif
</td>
<td>
@if($beatplan_data->trip_data())
{{ $beatplan_data->trip->filler->name }}
@endif
</td>
<td>
@if($beatplan_data->trip_data())
{{ $beatplan_data->trip->filler->contact }}
@endif
</td>
<td>
@if($beatplan_data->trip_data())
@if($beatplan_data->trip_data()->divert_from_tripdata_id)
@if($beatplan_data->check_divert($beatplan_data->trip_data()->divert_from_tripdata_id))
Diverted From: {{ $beatplan_data->site_data('from')->site_name}}
@endif
@endif
@if($beatplan_data->trip_data()->divert_to_tripdata_id)
@if($beatplan_data->check_divert($beatplan_data->trip_data()->divert_to_tripdata_id))
Diverted To: {{ $beatplan_data->site_data('to')->site_name}}
@endif
@endif
@if($beatplan_data->trip_data()->divert_qty)
@if($beatplan_data->check_divert($beatplan_data->trip_data()->divert_to_tripdata_id) || $beatplan_data->check_divert($beatplan_data->trip_data()->divert_from_tripdata_id))
Qty: {{ $beatplan_data->trip_data()->divert_qty }}
@endif
@endif
@endif
<p><strong>{{$beatplan_data->remarks}}</strong></p>
</td>
</tr>
@endforeach
@endif
</tbody>
</table>
</div>
</div>
@else
<h2>No Data Found!</h2>
@endif
</div>
</div>
</div>
</div>
@endsection
