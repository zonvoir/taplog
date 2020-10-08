@extends('layouts.app', ['page' => __('Beat Plans'), 'pageSlug' => 'beatplan'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header cust_heder_m">
        <div class="row">
          <div class="col-md-2"><h4 class="card-title"> Beat Plan Table</h4></div>
          <div class="col-md-4">
            <form action="{{route('beat-plan')}}" method="get">
              @csrf
              <div class="row">
                <input type="text" class="datepicker form-control" name="from_date" placeholder="From Date" required="">
                <input type="text" class="datepicker form-control" name="to_date" placeholder="To Date" required="">
                <button type="submit" class="btn btn-primary">Search</button>
              </div>
            </form>
          </div>
          <div class="col-md-4">
            <form action="{{route('beat-plan')}}" method="get">
              @csrf
              <div class="row">
                <select class="form-control" name="head_name" required="">
                  <option value="">Select Heading</option>
                  <option value="added_date">DATE</option>
                  <option value="mp_zone">MP/ZONE</option>
                  <option value="effective_date">EFFECTIVE DATE</option>
                  <option value="client_name">CLIENT NAME</option>
                  <option value="mode">MODE</option>
                </select>
                <input type="text" class="form-control" name="search_val" placeholder="Enter Value" required="">
                <button type="submit" class="btn btn-primary">Search</button>
              </div>
            </form>
          </div>
          <div class="col-md-2"><a style="float: right;" class="btn btn-fill btn-primary" href="{{route('create-beat-plan')}}">Create</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>
                <th class="text-center">
                  Date
                </th>
                <th class="text-center">
                 Mp/Zone
               </th>
               <th class="text-center">
                Effective Date
              </th>
              <th class="text-center">
                Client Name
              </th>
              <th class="text-center">
                Mode
              </th>
              <th class="text-center">
                Status
              </th>
              <th class="text-center">

              </th>
            </tr>
          </thead>
          <tbody>
            @if(isset($plans) && !empty($plans))
            @foreach($plans as $plan)
            <tr>
              <td>
                {{ $plan->added_date }}
              </td>
              <td>
                {{ $plan->mp_zone }}
              </td>
              <td>
                {{ $plan->effective_date }}
              </td>
              <td>
                {{ $plan->client->name }}
              </td>

              <td class="text-center">
                {{ $plan->mode }}
              </td>
              <td class="text-center">
               {{ $plan->beatplan_data->count('site_id')??0 }} Sites/
               @if($plan->loaded_count()) 
               Loading Done({{$plan->loaded_count()}})
               @endif
               @if($plan->filled_count()) 
               /Filling Done({{$plan->filled_count()}})
               @endif
             </td>
             <td class="text-center action_btn_cust">
              <a href="{{ route('backlog.trip_data') }}?beat_id={{ $plan->id }}" target="_blank">View</a>
              <a href="{{ route('edit-beat-plan.edit',$plan->id) }}">Edit</a>
              <a href="{{ route('delete-beat-plan',$plan->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
      @if(isset($plans) && !empty($plans))
      {{ $plans->links() }}
      @endif
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

<style>
  .cust_heder_m{margin-top: 75px;}
</style>
@endsection