@extends('v3.layouts.app', ['page' => __('Site Master'), 'pageSlug' => 'site_master'])
@section('content')
<style type="text/css">
  .table-item-wrap .table td:nth-child(1),
  .table-item-wrap .table th:nth-child(1),
  .table-item-wrap .table th:nth-child(3),
  .table-item-wrap .table td:nth-child(3),
  .table-item-wrap .table td:nth-child(7)  
  {
    border-left-width: 0;
    white-space: nowrap;
  }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Subheader-->
  <div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-1">
        <!--begin::Page Heading-->
        <div class="d-flex align-items-baseline flex-wrap mr-5">
          <!--begin::Page Title-->
          <h5 class="text-dark font-weight-bold my-1 mr-5">Site Master</h5>
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
  <!--begin::Entry-->

  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
      @include('v3.layouts.navbars.flash-message')
      <!--begin::Card-->
      <div class="card card-custom">
        <div class="card-header">
          <div class="card-title">
            <span class="card-icon">
              <i class="flaticon2-supermarket text-primary"></i>
            </span>
            <h3 class="card-label">Site Master</h3>
          </div>

            </div>
            <div class="card-body table-item-wrap">
              <form class="form" id="siteMasterForm" method="post" action="{{ route('site.update',$site->id) }}">
                @csrf
                @method('put')
                <div class="card-body">

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Site id') }}</label>
                        <input type="text" name="site_id" class="form-control{{ $errors->has('site_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Site id') }}" value="{{$site->site_id}}" required="">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Unique Site ID') }}</label>
                        <input type="text" name="unique_site_id" class="form-control{{ $errors->has('unique_site_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Unique Site ID') }}" value="{{$site->unique_site_id}}">
                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Site Name') }}</label>
                        <input type="text" name="site_name" class="form-control{{ $errors->has('site_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Site Name') }}" value="{{$site->site_name}}" required="">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Cluster/JC') }}</label>
                        <input type="text" name="cluster_jc" class="form-control{{ $errors->has('cluster_jc') ? ' is-invalid' : '' }}" placeholder="{{ __('Cluster/JC') }}" value="{{$site->cluster_jc}}">
                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('District') }}</label>
                        <input type="text" name="district" class="form-control{{ $errors->has('district') ? ' is-invalid' : '' }}" placeholder="{{ __('District') }}" value="{{$site->district}}">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('MP / Zone') }}</label>
                        <input type="text" name="mp_zone" class="form-control{{ $errors->has('mp_zone') ? ' is-invalid' : '' }}" placeholder="{{ __('MP / Zone') }}" value="{{$site->mp_zone}}" required="">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Site Address') }}</label>
                        <input type="text" name="site_address" class="form-control{{ $errors->has('site_address') ? ' is-invalid' : '' }}" placeholder="{{ __('Site Address') }}" value="{{$site->site_address}}">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Lat') }}</label>
                        <input type="text" name="latitude" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Lat') }}" value="{{$site->latitude}}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Long') }}</label>
                        <input type="text" name="longitude" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Long') }}" value="{{$site->longitude}}">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Site Type') }}</label>
                        <select name="site_type" class="form-control{{ $errors->has('site_type') ? ' is-invalid' : '' }}">
                          <option>{{ __('Select Site Type') }}</option>
                          <option value="GBT" {{$site->site_type == 'GBT' ? 'selected' : ''}}>GBT</option>
                          <option value="RTT" {{$site->site_type == 'RTT' ? 'selected' : ''}}>RTT</option>
                          <option value="RTP" {{$site->site_type == 'RTP' ? 'selected' : ''}}>RTP</option>
                          <option value="GBM" {{$site->site_type == 'GBM' ? 'selected' : ''}}>GBM</option>
                          <option value="Building" {{$site->site_type == 'Building' ? 'selected' : ''}}>Building</option>
                        </select>
                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('BTS') }}</label>
                        <select name="bts" class="form-control{{ $errors->has('bts') ? ' is-invalid' : '' }}">
                          <option >{{ __('Select BTS') }}</option>
                          <option value="Indoor" {{$site->bts == 'Indoor' ? 'selected' : ''}}>Indoor</option>
                          <option value="Outdoor" {{$site->bts == 'Outdoor' ? 'selected' : ''}}>Outdoor</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Site Category') }}</label>
                        <select name="site_category" class="form-control{{ $errors->has('site_category') ? ' is-invalid' : '' }}" required="">
                          <option>{{ __('Select Site Category') }}</option>
                          <option value="P1" {{$site->site_category == 'P1' ? 'selected' : ''}}>P1</option>
                          <option value="RP1" {{$site->site_category == 'RP1' ? 'selected' : ''}}>RP1</option>
                          <option value="IP Colo" {{$site->site_category == 'IP Colo' ? 'selected' : ''}}>IP Colo</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Battery Bank (AH)') }}</label>
                        <input type="text" name="battery_bank_ah" class="form-control{{ $errors->has('battery_bank_ah') ? ' is-invalid' : '' }}" placeholder="{{ __('Battery Bank (AH)') }}" value="{{$site->battery_bank_ah}}">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('CPH') }}</label>
                        <input type="text" name="cph" class="form-control{{ $errors->has('cph') ? ' is-invalid' : '' }}" placeholder="{{ __('CPH') }}" value="{{$site->cph}}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Indoor BTS') }}</label>
                        <input type="text" name="indoor_bts" class="form-control{{ $errors->has('indoor_bts') ? ' is-invalid' : '' }}" placeholder="{{ __('Indoor BTS') }}" value="{{$site->indoor_bts}}">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Outdoor BTS') }}</label>
                        <input type="text" name="outdoor_bts" class="form-control{{ $errors->has('outdoor_bts') ? ' is-invalid' : '' }}" placeholder="{{ __('Outdoor BTS') }}" value="{{$site->outdoor_bts}}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('DG1 Make') }}</label>
                        <input type="text" name="dg1_make" class="form-control{{ $errors->has('dg1_make') ? ' is-invalid' : '' }}" placeholder="{{ __('DG1 Make') }}" value="{{$site->dg1_make}}" required>
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('DG2 Make') }}</label>
                        <input type="text" name="dg2_make" class="form-control{{ $errors->has('dg2_make') ? ' is-invalid' : '' }}" placeholder="{{ __('DG2 Make') }}" value="{{$site->dg2_make}}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('DG1 rating in KVA') }}</label>
                        <input type="text" name="dg1_rating_in_kva" class="form-control{{ $errors->has('dg1_rating_in_kva') ? ' is-invalid' : '' }}" placeholder="{{ __('DG1 rating in KVA') }}" value="{{$site->dg1_rating_in_kva}}" required="">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('DG2 rating in KVA') }}</label>
                        <input type="text" name="dg2_rating_in_kva" class="form-control{{ $errors->has('dg2_rating_in_kva') ? ' is-invalid' : '' }}" placeholder="{{ __('DG2 rating in KVA') }}" value="{{$site->dg2_rating_in_kva}}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('EB Status') }}</label>
                        <select class="form-control{{ $errors->has('eb_status') ? ' is-invalid' : '' }}" name="eb_status">
                          <option>{{ __('Select EB Status') }}</option>
                          <option value="EB" {{$site->eb_status == 'EB' ? 'selected' : ''}}>EB</option>
                          <option value="Non EB" {{$site->eb_status == 'Non EB' ? 'selected' : ''}}>Non EB</option>
                          <option value="EB Disconnection" {{$site->eb_status == 'EB Disconnection' ? 'selected' : ''}}>EB Disconnection</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('EB Type') }}</label>
                        <select name="eb_type" class="form-control{{ $errors->has('eb_type') ? ' is-invalid' : '' }}">
                          <option>{{ __('Select EB Type ') }}</option>
                          <option value="Permanent" {{$site->eb_type == 'Permanent' ? 'selected' : ''}}>Permanent</option>
                          <option value="Temporary" {{$site->eb_type == 'Temporary' ? 'selected' : ''}}>Temporary</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('EB Load (KW)') }}</label>
                        <input type="text" name="eb_load_kw" class="form-control{{ $errors->has('eb_load_kw') ? ' is-invalid' : '' }}" placeholder="{{ __('EB Load (KW)') }}" value="{{$site->eb_load_kw}}">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Technician Name') }}</label>
                        <input type="text" name="technician_name" class="form-control{{ $errors->has('technician_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Technician Name') }}" value="{{$site->technician_name}}" required="">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Technician Mo No1') }}</label>
                        <input type="text" name="technician_contact1" class="form-control{{ $errors->has('technician_contact1') ? ' is-invalid' : '' }}" placeholder="{{ __('Technician Mo No1') }}" value="{{$site->technician_contact1}}" required="">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Technician Mo No2') }}</label>
                        <input type="text" name="technician_contact2" class="form-control{{ $errors->has('technician_contact2') ? ' is-invalid' : '' }}" value="{{$site->technician_contact2}}" placeholder="{{ __('Technician Mo No2') }}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Cluster Incharge/Supervisor Name') }}</label>
                        <input type="text" name="cluster_incharge_name" class="form-control{{ $errors->has('cluster_incharge_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Cluster Incharge/Supervisor Name') }}" value="{{$site->cluster_incharge_name}}">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Cluster Incharge Nu 1') }}</label>
                        <input type="text" name="cluster_incharge_contact1" class="form-control{{ $errors->has('cluster_incharge_contact1') ? ' is-invalid' : '' }}" placeholder="{{ __('Cluster Incharge Nu 1') }}" value="{{$site->cluster_incharge_contact1}}" >
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Cluster Incharge Nu 2') }}</label>
                        <input type="text" name="cluster_incharge_contact2" class="form-control{{ $errors->has('cluster_incharge_contact2') ? ' is-invalid' : '' }}" placeholder="{{ __('Cluster Incharge Nu 2') }}" value="{{$site->cluster_incharge_contact2}}" >
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Cluster Incharge Email id') }}</label>
                        <input type="email" name="cluster_incharge_email" class="form-control{{ $errors->has('cluster_incharge_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Cluster Incharge Email id') }}" value="{{$site->cluster_incharge_email}}" >
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('L2/ZOM num') }}</label>
                        <input type="text" name="zom_contact" class="form-control{{ $errors->has('zom_contact') ? ' is-invalid' : '' }}" placeholder="{{ __('L2/ZOM num') }}" value="{{$site->zom_contact}}" >
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Energy Manager Name') }}</label>
                        <input type="text" name="energy_man_name" class="form-control{{ $errors->has('energy_man_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Energy Manager Name') }}" value="{{$site->energy_man_name}}" required="">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Energy Manager No') }}</label>
                        <input type="text" name="energy_man_contact" class="form-control{{ $errors->has('energy_man_contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Energy Manager No') }}" value="{{$site->energy_man_contact}}" required="">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Energy Manager email') }}</label>
                        <input type="email" name="energy_man_email" class="form-control{{ $errors->has('energy_man_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Energy Manager email') }}" value="{{$site->energy_man_email}}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Circle Facility Head/O&M Head Name') }}</label>
                        <input type="text" name="circle_facility_head_name" class="form-control{{ $errors->has('circle_facility_head_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Circle Facility Head/O&M Head Name') }}" value="{{$site->circle_facility_head_name}}">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Circle Facility Head/O&M Head Number') }}</label>
                        <input type="number" name="circle_facility_head_contact" class="form-control{{ $errors->has('circle_facility_head_contact') ? ' is-invalid' : '' }}" value="{{$site->circle_facility_head_contact}}" placeholder="{{ __('Circle Facility Head/O&M Head Number') }}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>{{ __('Circle Facility Head/O&M Head Email') }}</label>
                        <input type="email" name="circle_facility_head_email" class="form-control{{ $errors->has('circle_facility_head_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Circle Facility Head/O&M Head Email') }}" value="{{$site->circle_facility_head_email}}">
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>{{ __('Enter and Select Client Name') }}</label>
                        <input type="hidden" name="client_id" id="client_id" value="{{$site->client_id}}">
                        <input type="text" name="client_name" id="client_name" class="form-control{{ $errors->has('client_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Name') }}" value="{{$site->client->name}}" required="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Update') }}</button>
                </div>
              </form>
            </div>
            <!--end::Card-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::Entry-->
      </div>
    </div>

    @endsection
    @push('js')
    <script src="{{ asset('public') }}/assets/js/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function(){

        $('#client_name').typeahead({
            source: function(query, process) {
                return $.get("{{ route('client-name-list') }}", {
                    name: query
                }, function(data) {
                    return process(data);
                });
            }
        });
       
        $('#client_name').change(function() {
              var current = $(this).typeahead("getActive");
              if (current) {
                // Some item from your model is active!
                  if (current.name == $(this).val()) {
                    $("#client_id").val(current.id);
                  } else {
              
                  }
            } else {
                // Nothing is active so it is a new value (or maybe empty value)
            }
        });
    })
      
    const fv = FormValidation.formValidation(
      document.getElementById('siteMasterForm'),
      {
        fields: {
            
            site_id: {
              validators: {
                   notEmpty: {
                    message: 'Site ID is required'
                }
              }
            },
            site_name: {
              validators: {
                   notEmpty: {
                    message: 'Site Name is required'
                }
              }
            },
            mp_zone: {
              validators: {
                   notEmpty: {
                    message: 'MP Zone is required'
                }
              }
            },
            site_category: {
              validators: {
                   notEmpty: {
                    message: 'Site Category is required'
                }
              }
            },
            dg1_make: {
              validators: {
                   notEmpty: {
                    message: 'DG1 Make is required'
                }
              }
            },
            dg1_rating_in_kva: {
              validators: {
                   notEmpty: {
                    message: 'DG1 Rating is required'
                }
              }
            },
            technician_name: {
              validators: {
                   notEmpty: {
                    message: 'Technician Name is required'
                }
              }
            },
            technician_contact1: {
              validators: {
                   notEmpty: {
                    message: 'Technician Contact is required'
                }
              }
            },
            energy_man_name: {
              validators: {
                   notEmpty: {
                    message: 'Energy Man Name is required'
                }
              }
            },
            energy_man_contact: {
              validators: {
                   notEmpty: {
                    message: 'Energy Man Contact is required'
                }
              }
            },
            client_name: {
              validators: {
                   notEmpty: {
                    message: 'Client Name is required'
                }
              }
            },
          },

          plugins: {
              trigger: new FormValidation.plugins.Trigger(),
                      // Bootstrap Framework Integration
                      bootstrap: new FormValidation.plugins.Bootstrap(),
                     // Validate fields when clicking the Submit button
                     submitButton: new FormValidation.plugins.SubmitButton(),
                      // Submit the form when all fields are valid
                      defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
           }
        }
    );

    </script>

    @endpush