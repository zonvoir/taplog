@extends('layouts.app', ['page' => __('collections'), 'pageSlug' => 'collections'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h4 class="card-title"> Collection Table</h4></div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="" class="table tablesorter ">
            <thead>
              <tr>
                <th>Actions</th>
                <th>
                  Date
                </th>
                <th>
                  Site Id
                </th>
                <th>
                  Site Name
                </th>
                <th>
                  Site Type
                </th>
                <th>
                  Maintenance Point
                </th>
                <th>
                  Beat Plan(Ltr)
                </th>
                <th>
                  Technician Name
                </th>
                 <th>
                  Tech Mob No.
                </th>
                 <th>
                  Route Plan
                </th>
                 <th>
                  RO Name
                </th>
                <th>
                  Vehicle No
                </th>
                <th>
                  Lefting date
                </th>
                <th>
                  selling date
                </th>
                <th>
                  KWH Reading & Photo
                </th>
                <th>
                  HMR Reading & Photo
                </th>
                <th>
                  GCU Before Filling Photo
                </th>
                <th>
                  Fuel Stock Before Filling
                </th>
                <th>
                  GCU After Filling Photo
                </th>
                <th>
                  Fuel Stock After Filling
                </th>
                <th>
                  Fuel Gauge Before Filling
                </th>
                <th>
                  Fuel Gauge After Filling
                </th>
                <th>
                  Dip Stick Before Filling
                </th>
                <th>
                  Dip Stick After Filling
                </th>
                <th>
                  EB Meter Reading & Photo
                </th>
                <th>
                  Filling Qty
                </th>
              </tr>
            </thead>
            <tbody>
              @if(isset($collections) && !empty($collections))
              @foreach($collections as $collection)
              <tr>
                <td><a href="{{url('create-collection/'.$collection->id)}}"><i class="tim-icons icon-simple-add"></i></a></td>
                <td>{{$collection->plan_date}}</td>
                <td>{{$collection->site_id}}</td>
                <td>{{$collection->site_name}}</td>
                <td>{{$collection->site_type}}</td>
                <td>{{$collection->maintenance_point}}</td>
                <td>{{$collection->beat_plan_ltr}}</td>
                <td>{{$collection->technician_name}}</td>
                <td>{{$collection->technician_mobile}}</td>
                <td>{{$collection->route_plan}}</td>
                <td>{{$collection->ro_name}}</td>
                <td>{{$collection->vehicle_no}}</td>
                <td>{{$collection->lefting_date}}</td>
                <td>{{$collection->selling_date}}</td>
                <td>{{$collection->kwh_reading}} @if(isset($collection->kwh_reading_img))<img style="height: 30px; width: 20px;" src="{{ URL::to('/images/').'/'.$collection->kwh_reading_img}}">@else No image @endif</td>
                <td>{{$collection->hmr_reading}} @if(isset($collection->hmr_reading_img))<img style="height: 30px; width: 20px;" src="{{ URL::to('/images/').'/'.$collection->hmr_reading_img}}">@else No image @endif</td>
                <td>@if(isset($collection->gcu_bef_fill_img))<img style="height: 30px; width: 20px;" src="{{ URL::to('/images/').'/'.$collection->gcu_bef_fill_img}}">@else No image @endif</td>
                <td>{{$collection->fuel_stock_bef_fill}}</td>
                <td>@if(isset($collection->gcu_aft_fill_img))<img style="height: 30px; width: 20px;" src="{{ URL::to('/images/').'/'.$collection->gcu_aft_fill_img}}">@else No image @endif</td>
                <td>{{$collection->fuel_stock_aft_fill}}</td>
                <td>@if(isset($collection->fuel_guage_bef_fill_img))<img style="height: 30px; width: 20px;" src="{{ URL::to('/images/').'/'.$collection->fuel_guage_bef_fill_img}}">@else No image @endif</td>
                <td>@if(isset($collection->fuel_guage_aft_fill_img))<img style="height: 30px; width: 20px;" src="{{ URL::to('/images/').'/'.$collection->fuel_guage_aft_fill_img}}">@else No image @endif</td>
                <td>@if(isset($collection->dip_stick_bef_fill_img))<img style="height: 30px; width: 20px;" src="{{ URL::to('/images/').'/'.$collection->dip_stick_bef_fill_img}}">@else No image @endif</td>
                <td>@if(isset($collection->dip_stick_aft_fill_img))<img style="height: 30px; width: 20px;" src="{{ URL::to('/images/').'/'.$collection->dip_stick_aft_fill_img}}">@else No image @endif</td>
                <td>{{$collection->eb_meter_reading}} @if(isset($collection->eb_meter_reading_img))<img style="height: 30px; width: 20px;" src="{{ URL::to('/images/').'/'.$collection->eb_meter_reading_img}}">@else No image @endif</td>
                <td>{{$collection->filling_qty}}</td>
              </tr>
              @endforeach
              @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
@endsection


