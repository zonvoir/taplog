@extends('layouts.app', ['page' => __('upload handbook'), 'pageSlug' => 'handbook'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6"><h4 class="card-title"> Create Collection</h4></div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{route('create-collection-action')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="verified_loads_id" value="{{$verified_loads_id}}">
					<div class="row">
						<div class="col">
							<label for="exampleInputSiteName">Site Name</label>
							<input type="text" class="form-control" id="exampleInputSiteName" disabled="true" value="{{$loads->site->site_name}}">
						</div>
						<div class="col">
							<label for="exampleInputSiteId">Site Id</label>
							<input type="text" class="form-control" id="exampleInputSiteId" disabled="true" value="{{$loads->site->site_id}}">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">Lifting Start Date & Time</label>
							<input type="datetime-local" name="lifting_start" class="form-control" id="exampleInputLeftingDate" value="{{\Carbon\Carbon::parse($loads->trip_data->loading_start)->format('Y-m-d\TH:i') }}" placeholder="Enter Lifting Date"  required="" readonly>
						</div>
						<div class="col">
							<label for="exampleInputLeftingDate">Lifting End Date & Time</label>
							<input type="datetime-local" name="lifting_end" class="form-control" id="exampleInputLeftingDate" value="{{\Carbon\Carbon::parse($loads->trip_data->loading_finish)->format('Y-m-d\TH:i') }}" placeholder="Enter Lifting Date"  required="" readonly="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">Site In Date & Time</label>
							<input type="datetime-local" name="site_in" class="form-control" id="exampleInputLeftingDate" placeholder="Enter Lifting Date"  required="">
						</div>
						<div class="col">
							<label for="exampleInputLeftingDate">Site Out Date & Time</label>
							<input type="datetime-local" name="site_out" class="form-control" id="exampleInputLeftingDate" placeholder="Enter Lifting Date"  required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">Filling Start Date & Time</label>
							<input type="datetime-local" name="filling_start" class="form-control" id="exampleInputSellingDate" placeholder="Enter Filling Date"}" required="">
						</div>
						<div class="col">
							<label for="exampleInputLeftingDate">Filling Finish Date & Time</label>
							<input type="datetime-local" name="filling_finish" class="form-control" id="exampleInputSellingDate" placeholder="Enter Filling Date" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">KWH Reading</label>
							<input type="number" name="kwh_reading" min="0" class="form-control" onblur="validatePreviousReading(this);" placeholder="Enter KWH Reading" required="">
							<span class="invalid-feedback" role="alert"></span>
						</div>
						<div class="col">
                            <label for="exampleInputLeftingDate">KWH Reading Photo</label>
                            <div class="file-drop-area">
                                <span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
                                <span class="file-msg">or drag and drop files here</span>
                                <input class="file-input" name="kwh_reading_img" type="file">
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">HMR Reading</label>
							<input type="number" name="hmr_reading" min="0" class="form-control" onblur="validatePreviousReading(this);"  id="exampleInputHMRReading" placeholder="Enter HMR Reading" required="">
							<span class="invalid-feedback" role="alert"></span>
						</div>
						<div class="col">
                            <label for="exampleInputLeftingDate">HMR Reading Photo</label>
                            <div class="file-drop-area">
                                <span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
                                <span class="file-msg">or drag and drop files here</span>
                                <input class="file-input" name="hmr_reading_img" type="file">
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="col">
                            <label for="exampleInputLeftingDate">GCU Before Filling Photo</label>
                            <div class="file-drop-area">
                                <span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
                                <span class="file-msg">or drag and drop files here</span>
                                <input class="file-input" name="gcu_bef_fill_img" type="file">
                            </div>
                        </div>
						<div class="col">
                            <label for="exampleInputLeftingDate">GCU After Filling Photo</label>
                            <div class="file-drop-area">
                                <span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
                                <span class="file-msg">or drag and drop files here</span>
                                <input class="file-input" name="gcu_aft_fill_img" type="file">
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">Fuel Stock Before Filling</label>
							<input type="number" min="0" name="fuel_stock_bef_fill" class="form-control" onkeyup="sum()" id="fuel_stock_bef_fill" placeholder="Enter Fuel Stock Before Filling" required="">
						</div>
						<div class="col">
							<label for="exampleInputLeftingDate">Filling Qty</label>
							<input type="number" min="0" name="filling_qty" class="form-control" onkeyup="sum()" id="filling_qty" placeholder="Enter Filling Qty" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
                            <label for="exampleInputLeftingDate">Fuel Gauge Before Filling Photo</label>
                            <div class="file-drop-area">
                                <span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
                                <span class="file-msg">or drag and drop files here</span>
                                <input class="file-input" name="fuel_guage_bef_fill_img" type="file">
                            </div>
                        </div>
						<div class="col">
							<label for="exampleInputLeftingDate">Fuel Gauge After Filling Photo</label>
							<div class="file-drop-area">
                                <span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
                                <span class="file-msg">or drag and drop files here</span>
                                <input class="file-input" name="fuel_guage_aft_fill_img" type="file">
                            </div>
						</div>
					</div>
					<div class="row">
						
						<div class="col">
							<label for="exampleInputLeftingDate">Dip Stick Before Filling Photo</label>
							<div class="file-drop-area">
                                <span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
                                <span class="file-msg">or drag and drop files here</span>
                                <input class="file-input" name="dip_stick_bef_fill_img" type="file">
                            </div>
						</div>
						<div class="col">
							<label for="exampleInputLeftingDate">Dip Stick After Filling Photo</label>
							<div class="file-drop-area">
                                <span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
                                <span class="file-msg">or drag and drop files here</span>
                                <input class="file-input" name="dip_stick_aft_fill_img" type="file">
                            </div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">EB Meter Reading</label>
							<input type="number" min="0" name="eb_meter_reading" class="form-control" onblur="validatePreviousReading(this);" placeholder="Enter EB Meter Reading" required="">
							<span class="invalid-feedback" role="alert"></span>
						</div>
						<div class="col">
							<label for="exampleInputLeftingDate">EB Meter Reading Photo</label>
							<div class="file-drop-area">
                                <span class="fake-btn">Choose file <i class="fas fa-upload"></i></span>
                                <span class="file-msg">or drag and drop files here</span>
                                <input class="file-input" name="eb_meter_reading_img" type="file">
                            </div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="exampleInputLeftingDate">Fuel Stock After Filling</label>
							<input type="text" name="fuel_stock_aft_fill" class="form-control" id="fuel_stock_aft_fill" placeholder="Enter Fuel Stock After Filling" readonly="" required="">
						</div>
						<div class="col">
							<label for="exampleInputLeftingDate">Entry Date</label>
							<input type="text" name="filling_date" class="form-control" id="" value="{{\Carbon\Carbon::now()->format('d-m-Y')}}" readonly="" required="">
						</div>
					</div>
					<div class="row">
						<div class="col">
						<label for="exampleInputLeftingDate">Remark</label>
							<textarea name="remark" class="form-control"></textarea>
						</div>
					</div>
					<input type="submit" value="Submit" class="btn btn-primary"/>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function sum() {
       var txtFirstNumberValue = document.getElementById('fuel_stock_bef_fill').value;
       var txtSecondNumberValue = document.getElementById('filling_qty').value;
       if (txtFirstNumberValue == "")
           txtFirstNumberValue = 0;
       if (txtSecondNumberValue == "")
           txtSecondNumberValue = 0;
       var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
       if (!isNaN(result)) {
           document.getElementById('fuel_stock_aft_fill').value = result;
       }
   }
</script>
@endsection