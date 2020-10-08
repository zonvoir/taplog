@extends('layouts.app', ['page' => __('employees'), 'pageSlug' => 'employees'])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Employees</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('employee.create')}}" class="btn btn-sm btn-primary">Add Employee</a>
                        </div>
                    </div>
                </div>
                <div class="card-body wa_ise">

                    <div class="table-responsive">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">Emp Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Creation Date</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">DOB</th>
                                    <th scope="col">DOJ</th>
                                    <th scope="col">Father</th>
                                    <th scope="col">Mother</th>
                                    <th scope="col">Married</th>
                                    <th scope="col">Spouse</th>
                                    <th scope="col">Child</th>
                                    <th scope="col">Total Children</th>
                                    <th scope="col">Other Contact</th>
                                    <th scope="col">Emergency Contact Person </th>
                                    <th scope="col">Emergency Contact</th>
                                    <th scope="col">Adhar No.</th>
                                    <th scope="col">Adhar Doc.</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Address Proof</th>
                                    <th scope="col">Correspond Address</th>
                                    <th scope="col">Correspond Address Proof</th>
                                    <th scope="col">Police Verification Doc.</th>
                                    <th scope="col">UAN</th>
                                    <th scope="col">ESIC No.</th>
                                    <th scope="col">Bank Name</th>
                                    <th scope="col">Account No.</th>
                                    <th scope="col">IFSC</th>
                                    <th scope="col">Working Status</th>
                                    @if(auth()->user()->type == 'admin')
                                    <th scope="col">Created By</th>
                                    @endif
                                    <th scope="col">Action</th>
                                </tr></thead>
                                <tbody>
                                    @if(isset($users) && !empty($users))
                                    @foreach($users as $user)
                                    <tr>
                                     <td>{{!$user->emp_id ? 'NA' : $user->emp_id}}</td>
                                     <td>{{$user->name}}</td>
                                     <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                     <td>{{$user->contact ? $user->contact : 'NA'}}</td>
                                     <td>{{$user->details()->exists() ? $user->details->designation : 'NA'}}</td>
                                     <td>{{Date('d-m-Y',strtotime($user->created_at))}}</td>
                                     <td>{{!$user->gender ? 'NA' : $user->gender}}</td>
                                     <td>{{!$user->dob ? 'NA' : $user->dob}}</td>
                                     <td>{{!$user->doj ? 'NA' : $user->doj}}</td>
                                     <td>{{!$user->father_name ? 'NA' : $user->father_name}}</td>
                                     <td>{{!$user->mother_name ? 'NA' : $user->mother_name}}</td>
                                     <td>{{!$user->marital_status ? 'NA' : $user->marital_status}}</td>
                                     <td>{{!$user->spouse_name ? 'NA' : $user->spouse_name}}</td>
                                     <td>{{!$user->child_status ? 'NA' : $user->child_status}}</td>
                                     <td>{{!$user->children ? 'NA' : $user->children}}</td>
                                     <td>{{!$user->other_contact ? 'NA' : $user->other_contact}}</td>
                                     <td>{{!$user->emergency_contact_person_name ? 'NA' : $user->emergency_contact_person_name}}</td>
                                     <td>{{!$user->emergency_contact ? 'NA' : $user->emergency_contact}}</td>
                                     <td>{{!$user->adhar_no ? 'NA' : $user->adhar_no}}</td>
                                     <td><a href="{{!$user->adhar_doc ? 'NA' : public_path('/adhar/').$user->adhar_doc}}" download></a></td>
                                     <td>{{!$user->address ? 'NA' : $user->address}}</td>
                                     <td><a href="{{!$user->address_proof_doc ? 'NA' : public_path('/address/').$user->address_proof_doc}}" download></a></td>
                                     <td>{{!$user->correspond_address ? 'NA' : $user->correspond_address}}</td>
                                     <td><a href="{{!$user->correspond_address_proof ? 'NA' : public_path('/correspond/').$user->correspond_address_proof}}" download></a></td>
                                     <td><a href="{{!$user->police_verified_doc ? 'NA' : public_path('/police/').$user->police_verified_doc}}" download></a></td>
                                     <td>{{!$user->uan_no ? 'NA' : $user->uan_no}}</td>
                                     <td>{{!$user->esic_no ? 'NA' : $user->esic_no}}</td>
                                     <td>{{!$user->bank_name ? 'NA' : $user->bank_name}}</td>
                                     <td>{{!$user->bank_account_no ? 'NA' : $user->bank_account_no}}</td>
                                     <td>{{!$user->bank_ifsc ? 'NA' : $user->bank_ifsc}}</td>
                                     <td>{{!$user->working_status ? 'NA' : $user->working_status}}</td>
                                     @if(auth()->user()->type == 'admin')
                                     <td>{{$user->user->name}}</td>
                                     @endif
                                     <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="{{route('employee.edit',$user->id)}}">Edit</a>
                                                <a class="dropdown-item" onclick="return confirm('Are you sure?');" href="{{route('delete-employee',$user->id)}}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{ $users->links() }}
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