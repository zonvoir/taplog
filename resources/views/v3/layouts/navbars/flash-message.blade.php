@if ($message = Session::get('success'))
<div class="alert alert-custom alert-success fade show" role="alert">
    <div class="alert-text">{{ $message }}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif
  
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-success fade show" role="alert">
    <div class="alert-text">{{ $message }}</div>
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