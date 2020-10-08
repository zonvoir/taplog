@extends('layouts.appClients', ['page' => __('users'), 'pageSlug' => 'users'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Sites</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="myTable">
                        <thead class=" text-primary">
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Site Id</th>
                                <th scope="col">Site Name</th>
                                <th scope="col">Site Address</th>
                                <th scope="col">Client Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @if(isset($sites) && !empty($sites))
                            @foreach($sites as $site)
                            <tr>
                               <td>{{$i}}</td>
                               <td>{{$site->site_id}}</td>
                               <td>{{$site->site_name}}</td>
                               <td>{{$site->site_address}}</td>
                               <td>{{$site->client->name}}</td>
                           </tr>
                           @php $i++; @endphp
                           @endforeach
                           @endif
                       </tbody>
                   </table>
               </div>
               <div class="card-footer py-4">
                <nav class="d-flex justify-content-end" aria-label="...">

                </nav>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
@endpush