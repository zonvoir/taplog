@extends('layouts.app', ['page' => __('upload handbook'), 'pageSlug' => 'handbook'])
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
							<th scope="col">Client Name</th>
							<th scope="col">Date</th>
							<th scope="col">Zone</th>
							<th scope="col">Action</th>
						</thead>
						<tbody>
							@if(isset($plans) && !empty($plans))
							@foreach($plans as $plan)
							<tr>
								<td>{{$plan->clientname}}</td>
								<td>{{$plan->effective_date}}</td>
								<td>{{$plan->mp_zone}}</td>
								<td><a href="{{route('handbook-trips',$plan->id)}}">View</a></td>
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