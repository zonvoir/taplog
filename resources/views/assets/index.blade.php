@extends('layouts.app', ['page' => __('assets'), 'pageSlug' => 'assets'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Assets</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('assets.create')}}" class="btn btn-sm btn-primary">Add Asset</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">UAM</th>
                                    <th scope="col">Serials</th>
                                    <th scope="col">Master Location</th>
                                    <th scope="col">Base Location</th>
                                    <th scope="col">Mapped with MP</th>
                                    <th scope="col">Mapped with Customer</th>
                                    @if(auth()->user()->type == 'admin')
                                    <th scope="col">Created By</th>
                                    @endif
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($assets) && !empty($assets))
                                @foreach($assets as $asset)
                                <tr>
                                 <td>{{$asset->item_name}}</td>
                                 <td>{{$asset->qty}}</td>
                                 <td>{{$asset->uam}}</td>
                                 <td><a href="javascript:void(0);" onclick="loadNumbersView({{$asset->id}});" title="view numbers">{{$asset->s_no == 'yes' ? 'Yes' : 'No'}}</a></td>
                                 <td>{{$asset->master_location}}</td>
                                 <td>{{$asset->base_location}}</td>
                                 <td>{{$asset->mapped_with_mp}}</td>
                                 <td>{{$asset->mapped_with_customer}}</td>
                                 @if(auth()->user()->type == 'admin')
                                 <td>{{$asset->createdbyname}}</td>
                                 @endif
                                 <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="{{route('assets.edit',$asset->id)}}">Edit</a>
                                            <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{route('delete-asset',$asset->id)}}">Delete</a>
                                                
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                <nav class="d-flex justify-content-end" aria-label="...">

                </nav>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="numbersModal" tabindex="-1" role="dialog" aria-labelledby="numbersModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="numbersModalLabel">View Serial Number's</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
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
    <input type="hidden" name="itemid" value="">
    <form id="update-serial-form">
    </form>
    <div class="modal-footer">
        <button type="button" onclick="updateSerialKeys()" class="btn btn-primary">Update</button>
    </div>
</div>
</div>
</div>
@endsection
<script type="text/javascript">
    function loadNumbersView(id) {
        var html = '';
        var serials = '';
        $.get( "{{route('assets.serialkeys')}}", {id : id}, function( data ) {
            $("#item-name").html(data.item_name)
            $("#qty-val").html(data.quantity)
            $("input[name='itemid']").val(id);
            serials = JSON.parse(data.serial_keys);
            var qtyVal = parseInt(data.quantity);
            for(var i = 0; i < qtyVal; i++){
                let val = serials && serials[i] ? serials[i].value : '';
                html += '<div class="row">';
                html += '<div class="col"><input type="text" name="serial_no_'+i+'" value="'+val+'" class="form-control" placeholder="{{ __("Serial Number") }}" required/>';
                html += '</div>';
                html += '</div>';
            }
            $( "#update-serial-form" ).html( html );
        });
        $("#numbersModal").modal("show");
    }
    function updateSerialKeys() {
        $('input', '#update-serial-form').each(function(){
            $(this).val() == "" && $(this).remove();
        })
        var formdata = JSON.stringify($("#update-serial-form").serializeArray());
        $.post( "{{route('assets.serialkeys-update')}}", { "_token" : $('meta[name="csrf-token"]').attr('content'), formdata : formdata, 'id' : $("input[name='itemid']").val()}, function( data ) {
            if(data.status == 'ok'){
                $("#numbersModal").modal("hide");           
            }
        });
    }
</script>