@extends('layouts.app', ['page' => __('assets'), 'pageSlug' => 'edit assets'])
@section('content')

<style>
    #assetDetailsModal .modal-content {
        border: 0;
        height: 600px;
        overflow-y: scroll;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title"> Edit Assets</h4></div>
                </div>
            </div>
            <div class="card-body">
               <form id="asset-form" method="post" action="{{ route('assets.update',$asset->id) }}">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label>{{ __('Item Name') }}</label>
                            
                            <input type="text" name="item_name" class="form-control{{ $errors->has('item_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Item Name') }}" value="{{$asset->item_name}}" required="">
                            @include('alerts.feedback', ['field' => 'item_name'])
                            
                        </div>
                        <div class="col">
                           <label>{{ __('Quantity') }}</label>
                           <input type="text" name="qty" class="form-control{{ $errors->has('qty') ? ' is-invalid' : '' }}" placeholder="{{ __('Quantity') }}" value="{{$asset->qty}}" required="">
                           @include('alerts.feedback', ['field' => 'qty'])
                       </div>  
                   </div>
                   <div class="row">
                    <div class="col">
                        <label>{{ __('UAM') }}</label>
                        <input type="text" name="uam" class="form-control{{ $errors->has('uam') ? ' is-invalid' : '' }}" placeholder="{{ __('UAM') }}" value="{{$asset->uam}}" required="">
                        @include('alerts.feedback', ['field' => 'uam'])
                    </div>
                    <div class="col">
                      <label>{{ __('S. No.') }}</label>
                      <select name="s_no" class="form-control{{ $errors->has('s_no') ? ' is-invalid' : '' }}" required/>
                        <option value="">S. No.</option>
                        <option value="yes" {{$asset->s_no == 'yes' ? 'selected' : ''}}>Yes</option>
                        <option value="no" {{$asset->s_no == 'no' ? 'selected' : ''}}>No</option>
                    </select>
                    @include('alerts.feedback', ['field' => 's_no']) 
                </div>  
            </div>
            <div class="row">
                <div class="col">
                    <label>{{ __('Master Location') }}</label>
                    <input type="text" name="master_location" class="form-control{{ $errors->has('master_location') ? ' is-invalid' : '' }}" placeholder="{{ __('Master Location') }}" value="{{$asset->master_location}}" required="">
                    @include('alerts.feedback', ['field' => 'master_location'])
                </div>
                <div class="col">
                   <label>{{ __('Master Location') }}</label>
                   <input type="text" name="base_location" class="form-control{{ $errors->has('base_location') ? ' is-invalid' : '' }}" placeholder="{{ __('Base Location') }}" value="{{$asset->base_location}}" required="">
                   @include('alerts.feedback', ['field' => 'base_location'])  
               </div>  
           </div>
           <div class="row">
            <div class="col">
                <label>{{ __('Mapped With MP') }}</label>
                    <input type="text" name="mapped_with_mp" class="form-control{{ $errors->has('mapped_with_mp') ? ' is-invalid' : '' }}" placeholder="{{ __('Mapped With MP') }}" value="{{$asset->mapped_with_mp}}" required="">
                    @include('alerts.feedback', ['field' => 'mapped_with_mp'])*
            </div>
            <div class="col">
               <label>{{ __('Mapped with Customer') }}</label>
                <input type="text" name="mapped_with_customer" class="form-control{{ $errors->has('mapped_with_customer') ? ' is-invalid' : '' }}" placeholder="{{ __('*') }}" value="{{$asset->mapped_with_customer}}" required="">
                @include('alerts.feedback', ['field' => 'mapped_with_customer'])
        </div>  
    </div>
    <input type="hidden" name="serialsData">
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Update') }}</button>
</div>
</form>
</div>
</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="assetDetailsModal" tabindex="-1" role="dialog" aria-labelledby="assetDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="assetDetailsModalLabel">Add Serial Number's</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col">
                <label>Item Name: <span id="item-name"></span></label>
            </div>
            <div class="col">
                <label>Quantity: <span id="qty-val"></span></label>
            </div>
        </div>
        <form id="serial-form">

        </form>
        <div class="modal-footer">
            <button type="button" onclick="addAssetSerial();" class="btn btn-primary">Add</button>
        </div>
    </div>
</div>
</div>
@endsection

