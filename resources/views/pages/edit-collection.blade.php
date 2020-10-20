@extends('layouts.app', ['page' => __('collections'), 'pageSlug' => 'edit collections'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title"> Edit Collection</h4></div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{route('edit-collection-action')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="verified_load_id" value="{{$collection->verified_load_id}}">
					<input type="hidden" name="id" value="{{$collection->id}}">
					<div class="row">
						<div class="col">
							<label for="exampleInputSiteName">Site Name</label>
							<input type="text" class="form-control" id="exampleInputSiteName" disabled="true" value="{{$collection->verified->site->site_name}}">
						</div>
						<div class="col">
							<label for="exampleInputSiteId">Site Id</label>
							<input type="text" class="form-control" id="exampleInputSiteId" disabled="true" value="{{$collection->verified->site->site_id}}">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">Lifting Start Date & Time</label>
							<input type="datetime-local" name="lifting_start" class="form-control" id="exampleInputLeftingDate" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->loading_start)->format('Y-m-d\TH:i') }}" placeholder="Enter Lifting Date"  required="">
						</div>
						<div class="col">
							<label for="exampleInputLeftingDate">Lifting End Date & Time</label>
							<input type="datetime-local" name="lifting_end" class="form-control" id="exampleInputLeftingDate" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->loading_finish)->format('Y-m-d\TH:i') }}" placeholder="Enter Lifting Date"  required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">Site In Date & Time</label>
							<input type="datetime-local" name="site_in" class="form-control" id="exampleInputLeftingDate" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->site_in)->format('Y-m-d\TH:i') }}" placeholder="Enter Lifting Date"  required="">
						</div>
						<div class="col">
							<label for="exampleInputLeftingDate">Site Out Date & Time</label>
							<input type="datetime-local" name="site_out" class="form-control" id="exampleInputLeftingDate" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->site_out)->format('Y-m-d\TH:i') }}" placeholder="Enter Lifting Date"  required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">Filling Start Date & Time</label>
							<input type="datetime-local" name="filling_start" class="form-control" id="exampleInputSellingDate" placeholder="Enter Filling Date" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->filling_start ?? '')->format('Y-m-d\TH:i') }}" required="">
						</div>
						<div class="col">
							<label for="exampleInputLeftingDate">Filling Finish Date & Time</label>
							<input type="datetime-local" name="filling_finish" class="form-control" id="exampleInputSellingDate" placeholder="Enter Filling Date" value="{{\Carbon\Carbon::parse($collection->verified->trip_data->filling_finish)->format('Y-m-d\TH:i') }}" required="">
						</div>
					</div>
					
					<div class="row">
						<div class="col">
							<label for="exampleInputKWHReading">KWH Reading</label>
							<input type="text" name="kwh_reading" class="form-control" id="exampleInputKWHReading" placeholder="Enter KWH Reading" value="{{$collection->kwh_reading}}" required="">
						</div>
						<div class="col">
							<label for="exampleInputKWHReadingImg">KWH Reading Photo</label>
							<div class="file-drop-area">
								<span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
								<span class="file-msg">or drag and drop files here</span>
								<input class="file-input" name="kwh_reading_img" type="file">
							</div>
							@if($collection->kwh_reading_img)
							<a href="{{ URL::to('/public/images/')}}/{{$collection->kwh_reading_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->kwh_reading_img}}"></a>
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputHMRReading">HMR Reading</label>
							<input type="text" name="hmr_reading" class="form-control" id="exampleInputHMRReading" placeholder="Enter HMR Reading" value="{{$collection->hmr_reading}}" required="">
						</div>
						<div class="col">
							<label for="hmr_reading_img">HMR Reading Photo</label>
							<div class="file-drop-area">
								<span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
								<span class="file-msg">or drag and drop files here</span>
								<input class="file-input" name="hmr_reading_img" type="file">
							</div>
							@if($collection->hmr_reading_img)
							<a href="{{ URL::to('/public/images/')}}/{{$collection->hmr_reading_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->hmr_reading_img}}"></a>
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="gcu_bef_fill_img">GCU Before Filling Photo</label>
							<div class="file-drop-area">
								<span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
								<span class="file-msg">or drag and drop files here</span>
								<input class="file-input" name="gcu_bef_fill_img" type="file">
							</div>
							@if($collection->gcu_bef_fill_img)
							<a href="{{ URL::to('/public/images/')}}/{{$collection->gcu_bef_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->gcu_bef_fill_img}}"></a>
							@endif
						</div>
						<div class="col">
							<label for="gcu_aft_fill_img">GCU After Filling Photo</label>
							<div class="file-drop-area">
								<span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
								<span class="file-msg">or drag and drop files here</span>
								<input class="file-input" name="gcu_aft_fill_img" type="file">
							</div>
							@if($collection->gcu_aft_fill_img)
							<a href="{{ URL::to('/public/images/')}}/{{$collection->gcu_aft_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->gcu_aft_fill_img}}"></a>
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="fuel_stock_bef_fill">Fuel Stock Before Filling</label>
							<input type="text" name="fuel_stock_bef_fill" class="form-control" id="fuel_stock_bef_fill" placeholder="Enter Fuel Stock Before Filling" value="{{$collection->fuel_stock_bef_fill}}" required="">
						</div>
						<div class="col">
							<label for="fuel_stock_aft_fill">Fuel Stock After Filling</label>
							<input type="text" name="fuel_stock_aft_fill" class="form-control" id="fuel_stock_aft_fill" placeholder="Enter Fuel Stock After Filling" value="{{$collection->fuel_stock_aft_fill}}" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="fuel_guage_bef_fill_img">Fuel Gauge Before Filling Photo</label>
							<div class="file-drop-area">
								<span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
								<span class="file-msg">or drag and drop files here</span>
								<input class="file-input" name="fuel_guage_bef_fill_img" type="file">
							</div>
							@if($collection->fuel_guage_bef_fill_img)
							<a href="{{ URL::to('/public/images/')}}/{{$collection->fuel_guage_bef_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->fuel_guage_bef_fill_img}}"></a>
							@endif
						</div>
						<div class="col">
							<label for="fuel_guage_aft_fill_img">Fuel Gauge After Filling Photo</label>
							<div class="file-drop-area">
								<span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
								<span class="file-msg">or drag and drop files here</span>
								<input class="file-input" name="fuel_guage_aft_fill_img" type="file">
							</div>
							@if($collection->fuel_guage_aft_fill_img)
							<a href="{{ URL::to('/public/images/')}}/{{$collection->fuel_guage_aft_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->fuel_guage_aft_fill_img}}"></a>
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="dip_stick_bef_fill_img">Dip Stick Before Filling Photo</label>
							<div class="file-drop-area">
								<span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
								<span class="file-msg">or drag and drop files here</span>
								<input class="file-input" name="dip_stick_bef_fill_img" type="file">
							</div>
							@if($collection->dip_stick_bef_fill_img)
							<a href="{{ URL::to('/public/images/')}}/{{$collection->dip_stick_bef_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->dip_stick_bef_fill_img}}"></a>
							@endif
						</div>
						<div class="col">
							<label for="dip_stick_aft_fill_img">Dip Stick After Filling Photo</label>
							<div class="file-drop-area">
								<span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
								<span class="file-msg">or drag and drop files here</span>
								<input class="file-input" name="dip_stick_aft_fill_img" type="file">
							</div>
							@if($collection->dip_stick_aft_fill_img)
							<a href="{{ URL::to('/public/images/')}}/{{$collection->dip_stick_aft_fill_img}}" /download><img style="height: 30px; width: 20px; cursor: pointer;" src="{{ URL::to('/public/images/')}}/{{$collection->dip_stick_aft_fill_img}}"></a>
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="eb_meter_reading">EB Meter Reading</label>
							<div class="file-drop-area">
								<span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
								<span class="file-msg">or drag and drop files here</span>
								<input class="file-input" name="eb_meter_reading_img" type="file">
							</div>
						</div>
						<div class="col">
							<label for="eb_meter_reading_imgeb_meter_reading_img">EB Meter Reading Photo</label>
							<input type="file" name="eb_meter_reading_img" class="form-control" id="eb_meter_reading_img">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="filling_qty">Filling Qty</label>
							<input type="text" name="filling_qty" class="form-control" id="filling_qty" value="{{$collection->filling_qty}}" required="">
						</div>
						<div class="col">
							<label for="filling_date">Entry Date</label>
							<input type="date" name="filling_date" class="form-control" id="filling_date" value="{{$collection->filling_date ? date('Y-m-d', strtotime($collection->filling_date)): date('Y-m-d')}}" readonly="" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="remark">Remark</label>
							<textarea name="remark" class="form-control" id="remark">{{$collection->remark}}</textarea>
						</div>
					</div>
					<input type="submit" value="Submit" class="btn btn-primary"/>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection