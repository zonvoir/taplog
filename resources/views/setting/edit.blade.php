@extends('layouts.app', ['page' => __('Settings'), 'pageSlug' => 'setting'])
@section('content')
@push('css')
<style type="text/css">
	.div_center_cl{
		max-width: 80%;
		margin: 0 auto;
	}
</style>
@endpush
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="card-body">
             <form class="form" method="post" action="{{ route('setting.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body div_center_cl">
                	<div class="row">
	                    <div class="col-md-12"><h1>Settings</h1></div>
	                </div>
                    <div class="row">
                    	<div class="col-12">
	                       	<div class="form-group">
		                        <label for="logo">{{ __('Site Logo') }}</label>
		                        <input type="file" name="meta[logo]" class="form-control" placeholder="{{ __('Site Title') }}" id="title">
	                   		</div>
	                   		<div class="form-group">
		                        <label for="title">{{ __('Site Title') }}</label>
		                        <input type="text" name="meta[site_title]" class="form-control" placeholder="{{ __('Site Title') }}" id="title" value="{{ $settings['site_title'] ?? ''}}" >
	                   		</div>
	                    	<div class="form-group">
		                        <label for="about">{{ __('About') }}</label>
		                        <input type="text" name="meta[about]" class="form-control" placeholder="{{ __('About') }}" id="about" value="{{ $settings['about'] ?? ''}}" >
	                    	</div>
	                    	<div class="form-group">
		                        <label for="contact_no">{{ __('Contact No.') }}</label>
		                        <input type="text" name="meta[contact_no]" class="form-control" placeholder="{{ __('Contact No.') }}" id="contact_no" value="{{ $settings['contact_no'] ?? ''}}" >
	                    	</div>
	                    	<div class="form-group">
		                        <label for="address">{{ __('Address') }}</label>
		                        <textarea name="meta[address]" id="address" class="form-control">{{ $settings['address'] ?? ''}}</textarea>
	                    	</div>
                			<button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Update') }}</button>
                		</div>
                	</div>
            	</div>
			</form>
        	</div>
			<div class="card-footer">
			    
			</div>
		</div>
	</div>
</div>
@endsection