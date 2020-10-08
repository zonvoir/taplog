@extends('layouts.app', ['page' => __('Beat Plans'), 'pageSlug' => 'beatplan'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header cust_heder_m">
        <div class="row">
          <div class="col-md-6"><h4 class="card-title"> Beat Plan Table</h4></div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class=" text-primary">
              <tr>
                <th class="text-center">
                  Added Date
                </th>
                <th class="text-center">
                 Mp/Zone
               </th>
               <th class="text-center">
                Effective Date
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
             <td class="text-center">
              <a href="{{ route('clients.trip_data') }}?beat_id={{ $plan->id }}" target="_blank">View</a>
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
<style>
  .cust_heder_m{margin-top: 75px;}
</style>
@endsection