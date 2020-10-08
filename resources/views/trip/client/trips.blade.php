@extends('layouts.app', ['page' => __('All Loads'), 'pageSlug' => 'trip'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">Trips</h4></div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table tablesorter " id="">
						<thead class=" text-primary">
							<tr>
								<th scope="col">Vehicle</th>
								<th scope="col">Trip Id</th>
								<th scope="col">Status</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($trips) && !empty($trips))
							@foreach($trips as $trip)
							<tr>
							
								<td><a href="{{route('vehicle-status',$trip->vehicle_id)}}" title="click to see current status!">{{$trip->vechile->vehicle_no??''}}</a></td>
								<td>{{$trip->trip_id??''}}</td>
								<td>{{$trip->status??''}}</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
				@if(isset($trips) && !empty($trips))
					{{ 
						$trips->appends(request()->except('page'))->links() 
					}}
				@endif
			</div>
		</div>
	</div>
</div>
</div>
@endsection