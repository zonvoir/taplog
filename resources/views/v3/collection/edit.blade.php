@extends('v3.layouts.app', ['page' => __('Edit Collection'), 'pageSlug' => 'collection-edit'])
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
		<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<div class="d-flex align-items-baseline flex-wrap mr-5">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold my-1 mr-5">Collections</h5>
					<!--end::Page Title-->
					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
						<li class="breadcrumb-item">
							<a href="{{route('collections')}}" class="text-muted">All collection's</a>
						</li>
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<!--end::Page Heading-->
			</div>
			<!--end::Info-->
			<!--begin::Toolbar-->

			<!--end::Toolbar-->
		</div>
	</div>
	<!--end::Subheader-->
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Card-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="row">
						<h3 class="card-title">
							Edit Collection
						</h3>
					</div>
				</div>
				<!--begin::Form-->
				<form class="form" action="{{route('edit-collection-action')}}" method="POST" autocomplete="off">
					@csrf
					<div class="card-body">
						<input type="hidden" name="verified_load_id" value="{{$collection->verified_load_id}}">
						<input type="hidden" name="id" value="{{$collection->id}}">
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Site Name:</label>
								<input type="text" class="form-control" placeholder="Enter site name" value="{{$collection->verified->site->site_name}}" disabled="true" required=""/>
								<span class="form-text text-muted"></span>
							</div>
							<div class="col-lg-6">
								<label>Site Id:</label>
								<input type="text" class="form-control" disabled="true" placeholder="Enter site id" value="{{$collection->verified->site->site_id}}" />
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Lifting Start Date & Time:</label>
								<input type="datetime-local" name="lifting_start" class="form-control" id="exampleInputLeftingDate" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->loading_start)->format('Y-m-d\TH:i') }}" placeholder="Enter Lifting Date"  required="">
								<span class="form-text text-muted"></span>
							</div>
							<div class="col-lg-6">
								<label >Lifting End Date & Time</label>
								<input type="datetime-local" name="lifting_end" class="form-control" id="exampleInputLeftingDate" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->loading_finish)->format('Y-m-d\TH:i') }}" placeholder="Enter Lifting Date"  required="">
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label >Site In Date & Time</label>
								<input type="datetime-local" name="site_in" class="form-control" id="exampleInputLeftingDate" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->site_in)->format('Y-m-d\TH:i') }}" placeholder="Enter Lifting Date"  required="">
								<span class="form-text text-muted"></span>
							</div>
							<div class="col-lg-6">
								<label >Site Out Date & Time</label>
								<input type="datetime-local" name="site_out" class="form-control" id="exampleInputLeftingDate" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->site_out)->format('Y-m-d\TH:i') }}" placeholder="Enter Lifting Date"  required="">
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label >Filling Start Date & Time</label>
								<input type="datetime-local" name="filling_start" class="form-control" id="exampleInputSellingDate" placeholder="Enter Filling Date" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->filling_start ?? '')->format('Y-m-d\TH:i') }}" required="">
								<span class="form-text text-muted"></span>
							</div>
							<div class="col-lg-6">
								<label >Filling Finish Date & Time</label>
								<input type="datetime-local" name="filling_finish" class="form-control" id="exampleInputSellingDate" placeholder="Enter Filling Date" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->filling_finish)->format('Y-m-d\TH:i') }}" required="">
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label >KWH Reading</label>
								<input type="text" name="kwh_reading" class="form-control" id="exampleInputKWHReading" placeholder="Enter KWH Reading" value="{{$collection->kwh_reading}}" required="">
								<span class="form-text text-muted"></span>
							</div>
							<div class="col-lg-6">
								<label >KWH Reading Photo</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="kwh_reading_img" id="customFile" autocomplete="off">
									<label class="custom-file-label" for="customFile">Choose file</label>
								</div>
								@if($collection->kwh_reading_img)
								<a href="{{ URL::to('/public/images/')}}/{{$collection->kwh_reading_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->kwh_reading_img}}"></a>
								@endif
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label for="hmr_reading">HMR Reading</label>
								<input type="text" name="hmr_reading" class="form-control" id="hmr_reading" placeholder="Enter HMR Reading" value="{{$collection->hmr_reading}}" required="">
								<span class="form-text text-muted"></span>
							</div>
							<div class="col-lg-6">
								<label >HMR Reading Photo</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="hmr_reading_img" id="customFile" autocomplete="off">
									<label class="custom-file-label" for="customFile">Choose file</label>
								</div>
								@if($collection->hmr_reading_img)
								<a href="{{ URL::to('/public/images/')}}/{{$collection->hmr_reading_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->hmr_reading_img}}"></a>
								@endif
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label for="gcu_bef_fill_img">GCU Before Filling Photo</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="gcu_bef_fill_img" id="customFile" autocomplete="off">
									<label class="custom-file-label" for="customFile">Choose file</label>
								</div>
								@if($collection->gcu_bef_fill_img)
								<a href="{{ URL::to('/public/images/')}}/{{$collection->gcu_bef_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->gcu_bef_fill_img}}"></a>
								@endif
								<span class="form-text text-muted"></span>
							</div>
							<div class="col-lg-6">
								<label for="gcu_aft_fill_img">GCU After Filling Photo</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="gcu_aft_fill_img" id="customFile" autocomplete="off">
									<label class="custom-file-label" for="customFile">Choose file</label>
								</div>
								@if($collection->gcu_aft_fill_img)
								<a href="{{ URL::to('/public/images/')}}/{{$collection->gcu_aft_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->gcu_aft_fill_img}}"></a>
								@endif
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label for="fuel_stock_bef_fill">Fuel Stock Before Filling</label>
								<input type="text" name="fuel_stock_bef_fill" class="form-control" id="fuel_stock_bef_fill" placeholder="Enter Fuel Stock Before Filling" value="{{$collection->fuel_stock_bef_fill}}" required="">
								<span class="form-text text-muted"></span>
							</div>
							<div class="col-lg-6">
								<label for="fuel_stock_aft_fill">Fuel Stock After Filling</label>
								<input type="text" name="fuel_stock_aft_fill" class="form-control" id="fuel_stock_aft_fill" placeholder="Enter Fuel Stock After Filling" value="{{$collection->fuel_stock_aft_fill}}" required="">
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label for="fuel_guage_bef_fill_img">Fuel Gauge Before Filling Photo</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="fuel_guage_bef_fill_img" id="customFile" autocomplete="off">
									<label class="custom-file-label" for="customFile">Choose file</label>
								</div>
								@if($collection->fuel_guage_bef_fill_img)
								<a href="{{ URL::to('/public/images/')}}/{{$collection->fuel_guage_bef_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->fuel_guage_bef_fill_img}}"></a>
								@endif
							</div>
							<div class="col-lg-6">
								<label for="fuel_stock_aft_fill">Fuel Stock After Filling</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="fuel_stock_aft_fill" id="customFile" autocomplete="off">
									<label class="custom-file-label" for="customFile">Choose file</label>
								</div>
								@if($collection->fuel_stock_aft_fill)
								<a href="{{ URL::to('/public/images/')}}/{{$collection->fuel_stock_aft_fill}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->fuel_stock_aft_fill}}"></a>
								@endif
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label for="dip_stick_bef_fill_img">Dip Stick Before Filling Photo</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="dip_stick_bef_fill_img" id="customFile" autocomplete="off">
									<label class="custom-file-label" for="customFile">Choose file</label>
								</div>
								@if($collection->dip_stick_bef_fill_img)
								<a href="{{ URL::to('/public/images/')}}/{{$collection->dip_stick_bef_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->dip_stick_bef_fill_img}}"></a>
								@endif
							</div>
							<div class="col-lg-6">
								<label for="dip_stick_aft_fill_img">Dip Stick After Filling Photo</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="dip_stick_aft_fill_img" id="customFile" autocomplete="off">
									<label class="custom-file-label" for="customFile">Choose file</label>
								</div>
								@if($collection->dip_stick_aft_fill_img)
								<a href="{{ URL::to('/public/images/')}}/{{$collection->dip_stick_aft_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->dip_stick_aft_fill_img}}"></a>
								@endif
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label for="eb_meter_reading">EB Meter Reading</label>
								<input type="text" name="eb_meter_reading" class="form-control" id="eb_meter_reading" value="{{$collection->eb_meter_reading}}" required="" placeholder="Enter EB Meter Reading">
							</div>
							<div class="col-lg-6">
								<label for="eb_meter_reading_img">EB Meter Reading Photo</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="eb_meter_reading_img" id="customFile" autocomplete="off">
									<label class="custom-file-label" for="customFile">Choose file</label>
								</div>
								@if($collection->eb_meter_reading_img)
								<a href="{{ URL::to('/public/images/')}}/{{$collection->eb_meter_reading_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->eb_meter_reading_img}}"></a>
								@endif
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label for="filling_qty">Filling Qty</label>
								<input type="text" name="filling_qty" class="form-control" id="filling_qty" value="{{$collection->filling_qty}}" required="">
							</div>
							<div class="col-lg-6">
								<label for="filling_date">Entry Date</label>
								<input type="text" name="filling_date" class="form-control" id="filling_date" value="{{!empty($collection->filling_date) ? \Carbon\Carbon::parse($collection->filling_date)->format('d/m/Y'): \Carbon\Carbon::now('Asia/Kolkata')->format('d/m/Y')}}" disabled="" required="">
								<span class="form-text text-muted"></span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-12">
								<label for="remark">Remark</label>
								<textarea name="remark" class="form-control" id="remark">{{$collection->remark}}</textarea>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-lg-2">
								<button style="width: 100%;" type="submit" class="btn font-weight-bold btn-success mr-2">Update</button></div>
								<div class="col-lg-2">
									<button style="width: 100%;" type="reset" class="btn font-weight-bold btn-secondary">Reset</button>
								</div>
							</div>
						</div>
					</form>
					<!--end::Form-->
				</div>
			</div>
		</div>
	</div>
	@endsection