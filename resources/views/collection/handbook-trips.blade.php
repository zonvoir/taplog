@extends('layouts.app', ['page' => __('handbook trips'), 'pageSlug' => 'handbook'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title"> Select Beat Plan</h4></div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table  id="site-id-table" class="display" style="width:100%">
						<thead>
							<th scope="col">Effective Date</th>
							<th scope="col">Trip Id</th>
							<th scope="col">Action</th>
						</thead>
						<tbody>
							@if(isset($trips) && !empty($trips))
							@foreach($trips as $trip)
							<tr>
								<td>{{$trip->effective_date}}</td>
								<td>{{$trip->trip_id}}</td>
								<td><a href="{{route('handbook-page',$trip->id)}}">View</a></td>
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