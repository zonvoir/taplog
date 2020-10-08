@extends('layouts.app', ['page' => __('create site'), 'pageSlug' => 'sites'])
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col"><h4 class="card-title"> Create Site</h4></div>
                    <div class="col"><button class="btn btn-primary" data-toggle="modal" data-target="#sitesImportModal">Import</button></div>
				</div>
			</div>
			<div class="card-body">
               <form class="form" method="post" action="{{ route('site.store') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                       <div class="col">
                          <div class="input-group{{ $errors->has('site_id') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="site_id" class="form-control{{ $errors->has('site_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Site id') }}" required="">
                            @include('alerts.feedback', ['field' => 'site_id'])
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group{{ $errors->has('unique_site_id') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="unique_site_id" class="form-control{{ $errors->has('unique_site_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Unique Site ID') }}">
                            @include('alerts.feedback', ['field' => 'unique_site_id'])
                        </div>
                    </div>
                </div>
                <div class="row">
                 <div class="col">
                    <div class="input-group{{ $errors->has('site_name') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <input type="text" name="site_name" class="form-control{{ $errors->has('site_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Site Name') }}" required="">
                        @include('alerts.feedback', ['field' => 'site_name'])
                    </div>
                </div>
                <div class="col">
                    <div class="input-group{{ $errors->has('cluster_jc') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <input type="text" name="cluster_jc" class="form-control{{ $errors->has('cluster_jc') ? ' is-invalid' : '' }}" placeholder="{{ __('Cluster/JC') }}">
                        @include('alerts.feedback', ['field' => 'cluster_jc'])
                    </div>
                </div>
            </div>
            <div class="row">
             <div class="col">
                <div class="input-group{{ $errors->has('district') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="text" name="district" class="form-control{{ $errors->has('district') ? ' is-invalid' : '' }}" placeholder="{{ __('District') }}">
                    @include('alerts.feedback', ['field' => 'district'])
                </div>
            </div>
            <div class="col">
                <div class="input-group{{ $errors->has('mp_zone') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="text" name="mp_zone" class="form-control{{ $errors->has('mp_zone') ? ' is-invalid' : '' }}" placeholder="{{ __('MP / Zone') }}" required="">
                    @include('alerts.feedback', ['field' => 'mp_zone'])
                </div>
            </div>
        </div>
        <div class="row">
         <div class="col">
            <div class="input-group{{ $errors->has('site_address') ? ' has-danger' : '' }}">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="tim-icons icon-single-02"></i>
                    </div>
                </div>
                <input type="text" name="site_address" class="form-control{{ $errors->has('site_address') ? ' is-invalid' : '' }}" placeholder="{{ __('Site Address') }}">
                @include('alerts.feedback', ['field' => 'site_address'])
            </div>
        </div>
        <div class="col">
            <div class="input-group{{ $errors->has('latitude') ? ' has-danger' : '' }}">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="tim-icons icon-single-02"></i>
                    </div>
                </div>
                <input type="text" name="latitude" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Lat') }}">
                @include('alerts.feedback', ['field' => 'latitude'])
            </div>
        </div>
    </div>
    <div class="row">
     <div class="col">
        <div class="input-group{{ $errors->has('longitude') ? ' has-danger' : '' }}">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="tim-icons icon-single-02"></i>
                </div>
            </div>
            <input type="text" name="longitude" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Long') }}">
            @include('alerts.feedback', ['field' => 'longitude'])
        </div>
    </div>
    <div class="col">
        <div class="input-group{{ $errors->has('site_type') ? ' has-danger' : '' }}">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="tim-icons icon-single-02"></i>
                </div>
            </div>
            <select name="site_type" class="form-control{{ $errors->has('site_type') ? ' is-invalid' : '' }}">
                <option>{{ __('Select Site Type') }}</option>
                <option value="GBT">GBT</option>
                <option value="RTT">RTT</option>
                <option value="RTP">RTP</option>
                <option value="GBM">GBM</option>
                <option value="Building">Building</option>
            </select>
            @include('alerts.feedback', ['field' => 'site_type'])
        </div>
    </div>
</div>
<div class="row">
 <div class="col">
    <div class="input-group{{ $errors->has('bts') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <select name="bts" class="form-control{{ $errors->has('bts') ? ' is-invalid' : '' }}">
            <option >{{ __('Select BTS') }}</option>
            <option value="Indoor">Indoor</option>
            <option value="Outdoor">Outdoor</option>
        </select>
        @include('alerts.feedback', ['field' => 'bts'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('site_category') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <select name="site_category" class="form-control{{ $errors->has('site_category') ? ' is-invalid' : '' }}" required="">
            <option>{{ __('Select Site Category') }}</option>
            <option value="P1">P1</option>
            <option value="RP1">RP1</option>
            <option value="IP Colo">IP Colo</option>
        </select>
        @include('alerts.feedback', ['field' => 'site_category'])
    </div>
</div>
</div>
<div class="row">
 <div class="col">
    <div class="input-group{{ $errors->has('battery_bank_ah') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="battery_bank_ah" class="form-control{{ $errors->has('battery_bank_ah') ? ' is-invalid' : '' }}" placeholder="{{ __('Battery Bank (AH)') }}">
        @include('alerts.feedback', ['field' => 'battery_bank_ah'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('cph') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="cph" class="form-control{{ $errors->has('cph') ? ' is-invalid' : '' }}" placeholder="{{ __('CPH') }}">
        @include('alerts.feedback', ['field' => 'cph'])
    </div>
</div>
</div>
<div class="row">
 <div class="col">
    <div class="input-group{{ $errors->has('indoor_bts') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="indoor_bts" class="form-control{{ $errors->has('indoor_bts') ? ' is-invalid' : '' }}" placeholder="{{ __('Indoor BTS') }}">
        @include('alerts.feedback', ['field' => 'indoor_bts'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('outdoor_bts') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="outdoor_bts" class="form-control{{ $errors->has('outdoor_bts') ? ' is-invalid' : '' }}" placeholder="{{ __('Outdoor BTS') }}">
        @include('alerts.feedback', ['field' => 'outdoor_bts'])
    </div>
</div>
</div>
<div class="row">
   <div class="col">
    <div class="input-group{{ $errors->has('dg1_make') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="dg1_make" class="form-control{{ $errors->has('dg1_make') ? ' is-invalid' : '' }}" placeholder="{{ __('DG1 Make') }}" required>
        @include('alerts.feedback', ['field' => 'dg1_make'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('dg2_make') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="dg2_make" class="form-control{{ $errors->has('dg2_make') ? ' is-invalid' : '' }}" placeholder="{{ __('DG2 Make') }}">
        @include('alerts.feedback', ['field' => 'dg2_make'])
    </div>
</div>
</div>
<div class="row">
   <div class="col">
    <div class="input-group{{ $errors->has('dg1_rating_in_kva') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="dg1_rating_in_kva" class="form-control{{ $errors->has('dg1_rating_in_kva') ? ' is-invalid' : '' }}" placeholder="{{ __('DG1 rating in KVA') }}" required="">
        @include('alerts.feedback', ['field' => 'dg1_rating_in_kva'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('dg2_rating_in_kva') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="dg2_rating_in_kva" class="form-control{{ $errors->has('dg2_rating_in_kva') ? ' is-invalid' : '' }}" placeholder="{{ __('DG2 rating in KVA') }}">
        @include('alerts.feedback', ['field' => 'dg2_rating_in_kva'])
    </div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('eb_status') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <select class="form-control{{ $errors->has('eb_status') ? ' is-invalid' : '' }}" name="eb_status">
            <option>{{ __('Select EB Status') }}</option>
            <option value="EB">EB</option>
            <option value="Non EB">Non EB</option>
            <option value="EB Disconnection">EB Disconnection</option>
        </select>
        @include('alerts.feedback', ['field' => 'eb_status'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('eb_type') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <select name="eb_type" class="form-control{{ $errors->has('eb_type') ? ' is-invalid' : '' }}">
        <option>{{ __('Select EB Type') }}</option>
        <option value="Permanent">Permanent</option>
        <option value="Temporary">Temporary</option>
    </select>
    @include('alerts.feedback', ['field' => 'eb_type'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('eb_load_kw') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="eb_load_kw" class="form-control{{ $errors->has('eb_load_kw') ? ' is-invalid' : '' }}" placeholder="{{ __('EB Load (KW)') }}">
        @include('alerts.feedback', ['field' => 'eb_load_kw'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('technician_name') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="text" name="technician_name" class="form-control{{ $errors->has('technician_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Technician Name') }}" required="">
    @include('alerts.feedback', ['field' => 'technician_name'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('technician_contact1') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="technician_contact1" class="form-control{{ $errors->has('technician_contact1') ? ' is-invalid' : '' }}" placeholder="{{ __('Technician Mo No1') }}" required="">
        @include('alerts.feedback', ['field' => 'technician_contact1'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('technician_contact2') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="text" name="technician_contact2" class="form-control{{ $errors->has('technician_contact2') ? ' is-invalid' : '' }}" placeholder="{{ __('Technician Mo No2') }}">
    @include('alerts.feedback', ['field' => 'technician_contact2'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('cluster_incharge_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="cluster_incharge_name" class="form-control{{ $errors->has('cluster_incharge_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Cluster Incharge/Supervisor Name') }}">
        @include('alerts.feedback', ['field' => 'cluster_incharge_name'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('cluster_incharge_contact1') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="text" name="cluster_incharge_contact1" class="form-control{{ $errors->has('cluster_incharge_contact1') ? ' is-invalid' : '' }}" placeholder="{{ __('Cluster Incharge Nu 1') }}">
    @include('alerts.feedback', ['field' => 'cluster_incharge_contact1'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('cluster_incharge_contact2') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="cluster_incharge_contact2" class="form-control{{ $errors->has('cluster_incharge_contact2') ? ' is-invalid' : '' }}" placeholder="{{ __('Cluster Incharge Nu 2') }}">
        @include('alerts.feedback', ['field' => 'cluster_incharge_contact2'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('cluster_incharge_email') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="email" name="cluster_incharge_email" class="form-control{{ $errors->has('cluster_incharge_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Cluster Incharge Email id') }}">
    @include('alerts.feedback', ['field' => 'cluster_incharge_email'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('zom_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="zom_name" class="form-control{{ $errors->has('zom_name') ? ' is-invalid' : '' }}" placeholder="{{ __('L2/ZOM Name') }}">
        @include('alerts.feedback', ['field' => 'zom_name'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('zom_email') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="email" name="zom_email" class="form-control{{ $errors->has('zom_email') ? ' is-invalid' : '' }}" placeholder="{{ __('L2/ZOM email id') }}">
    @include('alerts.feedback', ['field' => 'zom_email'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('zom_contact') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="zom_contact" class="form-control{{ $errors->has('zom_contact') ? ' is-invalid' : '' }}" placeholder="{{ __('L2/ZOM num') }}">
        @include('alerts.feedback', ['field' => 'zom_contact'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('energy_man_name') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="text" name="energy_man_name" class="form-control{{ $errors->has('energy_man_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Energy Manager Name') }}" required="">
    @include('alerts.feedback', ['field' => 'energy_man_name'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('energy_man_contact') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="energy_man_contact" class="form-control{{ $errors->has('energy_man_contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Energy Manager No') }}" required="">
        @include('alerts.feedback', ['field' => 'energy_man_contact'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('energy_man_email') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="email" name="energy_man_email" class="form-control{{ $errors->has('energy_man_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Energy Manager email') }}">
    @include('alerts.feedback', ['field' => 'energy_man_email'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('circle_facility_head_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="circle_facility_head_name" class="form-control{{ $errors->has('circle_facility_head_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Circle Facility Head/O&M Head Name') }}">
        @include('alerts.feedback', ['field' => 'circle_facility_head_name'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('circle_facility_head_contact') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="number" name="circle_facility_head_contact" class="form-control{{ $errors->has('circle_facility_head_contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Circle Facility Head/O&M Head Number') }}">
    @include('alerts.feedback', ['field' => 'circle_facility_head_contact'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('circle_facility_head_email') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="email" name="circle_facility_head_email" class="form-control{{ $errors->has('circle_facility_head_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Circle Facility Head/O&M Head Email') }}">
        @include('alerts.feedback', ['field' => 'circle_facility_head_email'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('client_name') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="hidden" name="client_id">
    <input type="text" name="client_name" id="clientname" class="typehead form-control{{ $errors->has('client_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Name') }}" required="">
    @include('alerts.feedback', ['field' => 'client_name'])
</div>
</div>
</div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Create') }}</button>
</div>
</form>
</div>
</div>
</div>
</div>
<div class="modal modal-black fade" id="sitesImportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('site.import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="exampleInputCSV">Choose file</label>
            <input type="file" name="file" class="form-control" id="exampleInputCSV" aria-describedby="CSVHelp" placeholder="" required="">
            <small class="form-text text-muted">Click <a href="{{asset('public/importFormats/sitemaster.csv')}}" /download>HERE</a> to see format of csv.</small>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection