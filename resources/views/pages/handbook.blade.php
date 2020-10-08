@extends('layouts.app', ['page' => __('upload handbook'), 'pageSlug' => 'handbook'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title"> Upload Pending Handbook</h4></div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{route('upload-handbook')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<div id="">
						<div class="table_cl_tag">    
							<table class="table">
								<tbody>
									<tr id="site-id-serched">

									</tr>

								</tbody>
							</table>
						</div>    
					</div>
					<div class="row">
						<div class="col new__handje">
							<label for="handbook_image">Handbook Image</label>
							<input type="file" name="handbook_image" class="form-control" id="handbook_image" required="">
						</div>
					</div>
					<input type="submit" value="Submit" class="btn btn-primary"/>

					<br>
					<br>
				</form>	
				<div class="table__wraper_cl">
				<table  id="site-id-table" class="display" style="width:100%">
					<thead>
						<th scope="col">ID</th>
						<th scope="col">Site Nate</th>
						<th scope="col">Date</th>
					</thead>
					<tbody>
						@if(isset($plans) && !empty($plans))
						@foreach($plans as $plan)
						<tr>
							<td>
								<label class="form-check-label">
									<input class="form-check-input" onclick="siteIdAppend(this);" type="checkbox" value="{{$plan->id}}" site-id="{{$plan->site_id}}">
									<span class="form-check-sign"></span>
									<b> {{$plan->site_id}}</b>
								</label>
							</td>
							<td>{{$plan->site_name}}</td>
							<td>{{$plan->plan_date}}</td>
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