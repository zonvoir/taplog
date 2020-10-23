@if ($message = Session::get('success'))
<div class="alert alert-custom alert-success fade show mb-5" id="alert-div" role="alert">
    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
    <div class="alert-text">{{$message}}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-custom alert-danger fade show mb-5" id="alert-div" role="alert">
    <div class="alert-icon"><i class="flaticon-warning"></i></div>
    <div class="alert-text">{{$message}}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif

@if($errors->any())
@foreach ($errors->all() as $error)
<div class="alert alert-warning" role="alert">
    {{ $error }}
</div>
@endforeach
@endif