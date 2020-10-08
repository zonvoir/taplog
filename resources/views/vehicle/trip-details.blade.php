@extends('layouts.app', ['page' => __('Vehicle for Trip'), 'pageSlug' => 'Trips'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">Vehicle Trips</h4></div>
				</div>
			</div>
			<div class="card-body">
				<div class="table__wraper_cl">
					<table  id="site-id-table" class="display" style="width:100%">
						<thead>
							<th scope="col">Trip Id</th>
							<th scope="col">Action</th>
						</thead>
						<tbody>
							@if(isset($trips) && !empty($trips))
							@foreach($trips as $trip)
							<tr>
								<td>{{$trip->trip_id}}</td>
								<td><a href="{{route('trips-data',$trip->id)}}">View</a></td>
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