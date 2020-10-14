@extends('v3.layouts.app', ['page' => __('Load Verification'), 'pageSlug' => 'load-verification'])
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
          <h5 class="text-dark font-weight-bold my-1 mr-5">Trip Allotment</h5>
          <!--end::Page Title-->
          <!--begin::Breadcrumb-->
          <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
            <li class="breadcrumb-item">
              <a href="{{route('home')}}" class="text-muted">Home</a>
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
	<div class="d-flex flex-column-fluid">
		<div class="container">
			
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<span class="card-icon">
							<i class="flaticon2-chart text-primary"></i>
						</span>
						<h3 class="card-label">Load Verification</h3>
					</div>
				</div>
				<form autocomplete="off" id="load-form" action="{{route('load-sites')}}" method="GET" enctype="multipart/form-data">
					<div style="display: none;">
					 <input type="text" id="PreventChromeAutocomplete" 
					  name="" autocomplete="address-level4" />
					</div>
					<div class="card-body">
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Current Date</label>
								<input type="text" class="form-control" placeholder="Current Date" id="current_date" name="current_date" required="" value="{{date('d-m-Y')}}" readonly="">
								
							</div>
							<div class="col-lg-6">
								<label for="">Beat Plan Date & Client Code</label>
								<input type="hidden" name="effective_date_load" id="effective_date123" />
								<input type="text" id="effective_date_load" name="" value="{{ $beat_date }}" class="typeahead form-control" placeholder="Beat Plan Date" required>
								
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-lg-6">
								<button type="submit" class="btn btn-primary mr-2">Search</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
@push('js')
	<script type="text/javascript">
		$(document).ready(function(){
			var effectiveDateLoadPath = "{{ route('effective-date-load') }}";
			var tripIdLoadPath = '';
			var tripIdLoadBasePath = "{{ route('trip-id-load') }}";
	        $('#effective_date_load').typeahead({
	            source: function(query, process) {
	                return $.get(effectiveDateLoadPath, {
	                    name: query
	                }, function(data) {
	                    return process(data);
	                });
	            }
	        });
        	$('#effective_date_load').change(function() {
	          var current = $(this).typeahead("getActive");
				if (current) {
					// Some item from your model is active!
					if (current.name == $(this).val()) {
						$("#effective_date123").val(current.effective_date);
					  // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
					  // console.log(current.id);
					  tripIdLoadPath = tripIdLoadBasePath+'/'+current.effective_date;
					} else {
					  // This means it is only a partial match, you can either add a new item
					  // or take the active if you don't want new items
					}
				} else {
					// Nothing is active so it is a new value (or maybe empty value)
				}
			});
		});
	</script>
@endpush