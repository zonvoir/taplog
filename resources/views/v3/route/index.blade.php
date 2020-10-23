@extends('layouts.app', ['page' => __('Route'), 'pageSlug' => 'route'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">Route</h4></div>
				</div>
			</div>
			<div class="card-body">
				<form action="" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col">
							<label for="zone">Select MP/Zone</label>
							<input type="text" name="zone" value="{{ (isset($qparams['name']) ? $qparams['name'] : '') }}" class="typeahead zone form-control" placeholder="Enter MP/Zone Name" required="" />
							<span id="error"></span>
						</div>
						<div class="col" >
							<label for="">Enter Route</label>
							<input type="text" name="route_name" class="form-control" placeholder="Enter Route name" required="">
						</div>
					</div>
					<input type="submit" value="Add" class="btn btn-primary"/>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">Routes</h4></div>
				</div>
			</div>
			<div class="card-body">
				<table class="table tablesorter " id="">
					<thead class=" text-primary">
						<tr>
							<th scope="col">S.No.</th>
							<th scope="col">MP/Zone</th>
							<th scope="col">Route Name</th>
							@if(auth()->user()->type == 'admin')
							<th scope="col">Alloted By</th>
							@endif
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@if(isset($routes) && !empty($routes))
						@foreach($routes as $route)
						<tr>
							<td>{{$i}}</td>
							<td>{{$route->mp_zone}}</td>
							<td>{{$route->route_name}}</td>
							@if(auth()->user()->type == 'admin')
							<td>{{$route->alloted_by}}</td>
							@endif
							<td class="text-left">
								<div class="dropdown_als">
									<a class="" href="#" data-toggle="modal" data-target="#editModal_{{$route->id}}">Edit</a>

									<a class="" onclick="return confirm('Are you sure?')" href="{{route('delete-route',$route->id)}}">Delete</a>
								</div>
							</td>
						</tr>
						<div class="modal fade" id="editModal_{{$route->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Edit Route</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="{{route('route.update',$route->id)}}" method="POST">
										@csrf
										@method('put')
										<div class="modal-body">
											<div class="row">
												<div class="col">
													<label for="zone">Select MP/Zone</label>
													<input type="text" name="zone" value="{{$route->mp_zone}}" class="typeahead zone form-control" placeholder="Enter MP/Zone Name" required="" />
													<span id="error"></span>
												</div>
												<div class="col" >
													<label for="">Enter Route</label>
													<input type="text" name="route_name" class="form-control" placeholder="Enter Route name" value="{{$route->route_name}}" required="">
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary">Save changes</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						@php $i++; @endphp
						@endforeach
						@endif
					</tbody>
				</table>
				{{$routes->links()}}
			</div>
		</div>
	</div>
</div>
@endsection


