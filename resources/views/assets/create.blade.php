@extends('layouts.app', ['page' => __('assets'), 'pageSlug' => 'create assets'])
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
					<div class="col-md-6"><h4 class="card-title"> Create Assets</h4></div>
				</div>
			</div>
			<div class="card-body">
             <form id="asset-form" method="post" action="{{ route('assets.store') }}">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="input-group{{ $errors->has('item_name') ? ' has-danger' : '' }}">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tim-icons icon-single-02"></i>
                                    </div>
                                </div>
                                <input type="text" name="item_name" class="form-control{{ $errors->has('item_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Item Name') }}" required="">
                                @include('alerts.feedback', ['field' => 'item_name'])
                            </div>    
                        </div>
                        <div class="col">
                         <div class="input-group{{ $errors->has('qty') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="qty" class="form-control{{ $errors->has('qty') ? ' is-invalid' : '' }}" placeholder="{{ __('Quantity') }}" required="">
                            @include('alerts.feedback', ['field' => 'qty'])
                        </div>    
                    </div>  
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group{{ $errors->has('uam') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="uam" class="form-control{{ $errors->has('uam') ? ' is-invalid' : '' }}" placeholder="{{ __('UAM') }}" required="">
                            @include('alerts.feedback', ['field' => 'uam'])
                        </div>    
                    </div>
                    <div class="col">
                     <div class="input-group{{ $errors->has('s_no') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <select name="s_no" class="form-control{{ $errors->has('s_no') ? ' is-invalid' : '' }}" required/>
                            <option value="">S. No.</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        @include('alerts.feedback', ['field' => 's_no'])
                    </div>    
                </div>  
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group{{ $errors->has('master_location') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-single-02"></i>
                            </div>
                        </div>
                        <input type="text" name="master_location" class="form-control{{ $errors->has('master_location') ? ' is-invalid' : '' }}" placeholder="{{ __('Master Location') }}" required="">
                        @include('alerts.feedback', ['field' => 'master_location'])
                    </div>    
                </div>
                <div class="col">
                 <div class="input-group{{ $errors->has('base_location') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="text" name="base_location" class="form-control{{ $errors->has('base_location') ? ' is-invalid' : '' }}" placeholder="{{ __('Base Location') }}" required="">
                    @include('alerts.feedback', ['field' => 'base_location'])
                </div>    
            </div>  
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group{{ $errors->has('mapped_with_mp') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="text" name="mapped_with_mp" class="form-control{{ $errors->has('mapped_with_mp') ? ' is-invalid' : '' }}" placeholder="{{ __('Mapped With MP') }}" required="">
                    @include('alerts.feedback', ['field' => 'mapped_with_mp'])
                </div>    
            </div>
            <div class="col">
             <div class="input-group{{ $errors->has('mapped_with_customer') ? ' has-danger' : '' }}">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="tim-icons icon-single-02"></i>
                    </div>
                </div>
                <input type="text" name="mapped_with_customer" class="form-control{{ $errors->has('mapped_with_customer') ? ' is-invalid' : '' }}" placeholder="{{ __('Mapping with Customer') }}" required="">
                @include('alerts.feedback', ['field' => 'mapped_with_customer'])
            </div>    
        </div>  
    </div>
    <input type="hidden" name="serialsData">
</div>
<div class="card-footer">
    <button type="button" onclick="askSerialNoModal();" class="btn btn-primary">{{ __('Create') }}</button>
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
<script type="text/javascript">
    function askSerialNoModal() {
        $("#asset-form").validate();
        var isSerialNo = $('select[name="s_no"]').val();
        var html = '';
        if(isSerialNo == 'yes'){
            $("#item-name").html($('input[name="item_name"]').val());
            $("#qty-val").html($('input[name="qty"]').val());
            var qtyVal = parseInt($('input[name="qty"]').val());
            for(var i = 0; i < qtyVal; i++){
                html += '<div class="row">';
                html += '<div class="col"><input type="text" name="serial_no_'+i+'" class="form-control" placeholder="{{ __("Serial Number") }}" required/>';
                html += '</div>';
                html += '</div>';
            }
            $("#serial-form").html(html);
            $('input[name="serialsData"]').val('');
            $("#assetDetailsModal").modal('show');
        }else{
            $("#asset-form").submit();
        }
    }
    function addAssetSerial() {
        $("#serial-form").validate();
        $('input', '#serial-form').each(function(){
            $(this).val() == "" && $(this).remove();
        })
        var formData = JSON.stringify($("#serial-form :input[value!=''][value!='.']").serializeArray());
        //console.log(JSON.stringify(formData));
        $('input[name="serialsData"]').val(formData);
        $("#assetDetailsModal").modal('hide');
        $("#asset-form").submit();
    }
</script>

