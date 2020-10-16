@extends('layouts.app', ['page' => __('users'), 'pageSlug' => 'users'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Users</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('clients.create')}}" class="btn btn-sm btn-primary">Add user</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Creation Date</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr></thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @if(isset($users) && !empty($users))
                                    @foreach($users as $user)
                                    <tr>
                                       <td>{{$i}}</td>
                                       <td>{{$user->name}}</td>
                                       <td>{{$user->contact}}</td>
                                       <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                       <td>{{Date('d-m-Y',strtotime($user->created_at))}}</td>
                                       <td>{{$user->type == 'mis' ? 'MIS' : ($user->type == 'technician' ? 'Technician' : '')}}</td>
                                       <td>{{$user->status == 'active' ? 'Active' : 'Deactive'}}</td>
                                       <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="{{route('clients.edit',$user->id)}}">Edit</a>
                                                <a class="dropdown-item" onclick="return confirm('Are you sure?');" href="{{route('delete-user',$user->id)}}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{$users->links()}}
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
@endsection