@extends('layouts.app', ['page' => __('MP/Zone Allotment'), 'pageSlug' => 'users'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title">MP/Zone Allotment</h4></div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{route('allot-zone')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="mis_user_id" value="{{$users->id}}">
					<div class="row">
						<div class="col">
							<label for="zone">Select MP/Zone</label>
							<input type="text" id="zone" name="zone" value="{{ (isset($qparams['name']) ? $qparams['name'] : '') }}" class="typeahead form-control" placeholder="Enter MP/Zone Name" required="" />
							<span id="error"></span>
						</div>
						<div class="col" >
							<label for="zone">Select Client</label>
							<input type="hidden" name="client_id">
							<input type="text" id="clientname" class="typeahead form-control" placeholder="Enter Client Name" required="" />
							<span id="error"></span>
						</div>
						<div class="col" >
							<label for="">MIS Name: {{$users->name}}</label>
							<br>
							<label for="">Contact: {{$users->contact == '' ? 'NA' : $users->contact}}</label>
							<label for="">Contact: {{$users->email == '' ? 'NA' : $users->email}}</label>
						</div>
					</div>
					<input type="submit" value="Allot" class="btn btn-primary"/>
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
					<div class="col-md-6"><h4 class="card-title">MP/Zone Alloted</h4></div>
				</div>
			</div>
			<div class="card-body">
				<table class="table tablesorter " id="">
					<thead class=" text-primary">
						<tr>
							<th scope="col">S.No.</th>
							<th scope="col">Alloted MP/Zone</th>
							<th scope="col">Alloted Client</th>
							@if(auth()->user()->type == 'admin')
							<th scope="col">Alloted By</th>
							@endif
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@if(isset($allotments) && !empty($allotments))
						@foreach($allotments as $allot)
						<tr>
							<td>{{$i}}</td>
							<td>{{$allot->mp_zones}}</td>
							<td>{{$allot->client->name}}</td>
							@if(auth()->user()->type == 'admin')
							<td>{{$allot->alloted_by}}</td>
							@endif
							<td class="text-right">
								<div class="dropdown">
									<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#editModal_{{$allot->id}}">Edit</a>
										<a class="dropdown-item" onclick="return confirm('Are you sure?');" href="{{route('mis-delete-zone',$allot->zoneid)}}">Delete</a>
									</div>
								</div>
							</td>
						</tr>
						<div class="modal fade" id="editModal_{{$allot->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Edit Route</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="{{route('mis-update-zone',$allot->zoneid)}}" method="POST">
										@csrf
										<div class="modal-body">
											<div class="row">
												<div class="col">
													<input type="hidden" name="misid" value="{{$users->id}}">
													<label for="zone">Select MP/Zone</label>
													<input type="text" name="zone" value="{{$allot->mp_zones}}" class="typeahead zone form-control" placeholder="Enter MP/Zone Name" required="" />
													<span id="error"></span>
												</div>
												<div class="col">
													<input type="hidden" name="client_id_update" value="{{$allot->client_id}}">
													<label for="clientname">Select Client</label>
													<input type="text" value="{{$allot->client->name}}" class="typeahead clientname form-control" placeholder="Enter Client Name" required="" />
													<span id="error"></span>
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
			</div>
		</div>
	</div>
</div>
@endsection


