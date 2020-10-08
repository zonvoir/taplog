@extends('layouts.app', ['page' => __('Beat Plans'), 'pageSlug' => 'beatplan'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h4 class="card-title"> Beat Plan Table</h4></div>
          <div class="col-md-6"><button type="button" class="btn btn-fill btn-primary" style="float: right;" data-toggle="modal" data-target="#exampleModal">Import CSV</button></div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>
                @if(auth()->user()->type != 'other')
                <th>
                  Action
                </th>
                @endif
                <th>
                  User Name
                </th>
                <th>
                  Date
                </th>
                 <th>
                  Maintenance Point
                </th>
                <th>
                  Site Id
                </th>
                <th>
                  Site Name
                </th>
                <th class="text-center">
                  Site Type
                </th>
                <th class="text-center">
                  Beat Plan(Ltr)
                </th>
                <th class="text-center">
                  Technician Name
                </th>
                <th class="text-center">
                  Tech Mob No.
                </th>
                <th class="text-center">
                  Route Plan
                </th>
                <th class="text-center">
                  RO Name
                </th>
                <th class="text-center">
                  Latitude
                </th>
                <th class="text-center">
                  Longitude
                </th>
                 <th class="text-center">
                  Driver Name
                </th>
                <th class="text-center">
                  Driver Mobile
                </th>
                <th class="text-center">
                  Filler Name
                </th>
                <th class="text-center">
                  Filler Mobile
                </th>
                <th class="text-center">
                  Vehicle No.
                <th class="text-center">
                  Created at
                </th>
              </tr>
            </thead>
            <tbody>
              @if(isset($plans) && !empty($plans))
              @foreach($plans as $plan)
              <tr>
                @if(auth()->user()->type != 'other')
                <td class="td-actions text-right">
                  <a href="{{url('edit-beat-plan/'.$plan->id)}}" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                    <i class="tim-icons icon-pencil"></i>
                </a>
                 <a href="{{url('delete-beat-plan/'.$plan->id)}}" onclick="return confirm('Are you sure?');" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                    <i class="tim-icons icon-simple-remove"></i>
                </a>
                </td>
                @endif
                <td>
                  {{ $plan->name }}
                </td>
                <td>
                  {{ $plan->plan_date }}
                </td>
                <td>
                  {{ $plan->maintenance_point }}
                </td>
                <td>
                  {{ $plan->site_id }}
                </td>
                <td class="text-center">
                  {{ $plan->site_name }}
                </td>
                 <td class="text-center">
                  {{ $plan->site_type }}
                </td>
                 <td class="text-center">
                  {{ $plan->beat_plan_ltr }}
                </td>
                 <td class="text-center">
                  {{ $plan->technician_name }}
                </td>
                 <td class="text-center">
                  {{ $plan->technician_mobile }}
                </td>
                 <td class="text-center">
                  {{ $plan->route_plan }}
                </td>
                 <td class="text-center">
                  {{ $plan->ro_name }}
                </td>
                <td class="text-center">
                  {{ $plan->latitude }}
                </td>
                <td class="text-center">
                  {{ $plan->longitude }}
                </td>
                 <td class="text-center">
                  {{ $plan->driver_name }}
                </td>
                <td class="text-center">
                  {{ $plan->driver_mobile }}
                </td>
                 <td class="text-center">
                  {{ $plan->filler_name }}
                </td>
                <td class="text-center">
                  {{ $plan->filler_mobile }}
                </td>
                <td class="text-center">
                  {{ $plan->vehicle_no }}
                </td>
                <td class="text-center">
                  {{ date("m-d-Y", strtotime($plan->created_at)) }}
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
          {{ $plans->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-black fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="exampleInputCSV">Choose file</label>
            <input type="file" name="file" class="form-control" id="exampleInputCSV" aria-describedby="CSVHelp" placeholder="" required="">
            <small id="CSVHelp" class="form-text text-muted">Click any where here for choose file.</small>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection