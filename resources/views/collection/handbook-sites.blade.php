@extends('layouts.app', ['page' => __('handbook sites'), 'pageSlug' => 'handbook'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title"> All Sites</h4></div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table  id="site-id-table" class="display" style="width:100%">
						<thead>
							<th scope="col">Site Id</th>
							<th scope="col">Site Name</th>
							<th scope="col">Technician Name</th>
							<th scope="col">Technician Contact</th>
							<th scope="col">Status</th>
							<th scope="col">Action</th>
						</thead>
						<tbody>
							@if(isset($sites) && !empty($sites))
							@foreach($sites as $trip)
							<tr>
								<td>{{$trip->site_data($trip->data_id)->site_id}}</td>
								<td>{{$trip->site_data($trip->data_id)->site_name}}</td>
								<td>{{$trip->site_data($trip->data_id)->technician_name}}</td>
								<td>{{$trip->site_data($trip->data_id)->technician_contact1}}</td>
								<td>{{$trip->status}}</td>
								@if($trip->status == 'filled')
								<td>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadHandbookModal{{$trip->id}}">
										<i class="tim-icons icon-upload"></i>
									</button>
								</td>
								@else
								<td>NA</td>
								@endif
							</tr>
							<div class="modal modal-black fade" id="uploadHandbookModal{{$trip->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header justify-content-center">
											<h5 class="modal-title" id="exampleModalLabel">Upload Handbook</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
										<div class="modal-body">
											<form action="{{route('upload-handbook')}}" method="POST" enctype="multipart/form-data">
												@csrf
												<div class="form-group">
													<input type="hidden" name="trip_data_id" value="{{$trip->id}}">
													<label for="exampleInputCSV">Choose file</label>
													<input type="file" name="handbook_image" class="form-control" id="exampleInputCSV" aria-describedby="CSVHelp" placeholder="" required="">
													<small id="CSVHelp" class="form-text text-muted">Click any where here for choose file.</small>
												</div>
												<button type="submit" class="btn btn-primary">Submit</button>
											</form>
										</div>
									</div>
								</div>
							</div>
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