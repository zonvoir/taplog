@extends('layouts.app', ['page' => __('Employee Details'), 'pageSlug' => 'employees'])
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title"> Create Employee</h4></div>
                    <div class="col-md-6"><button class="btn btn-primary" data-toggle="modal" data-target="#empImportModal">Import</button></div>
                </div>
            </div>
            <div class="card-body">
               <form class="form" method="post" action="{{ route('employee.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                       <div class="col">
                        <div class="input-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{isset($userdetails->name) ? $userdetails->name : '' }}" required="">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group{{ $errors->has('emp_id') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>
                            </div>
                            <input type="emp_id" name="emp_id" class="form-control{{ $errors->has('emp_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Employee Id') }}" value="{{isset($userdetails->emp_id) ? $userdetails->emp_id : rand() }}" required="">
                            @include('alerts.feedback', ['field' => 'emp_id'])
                        </div>
                    </div>
                </div>
                <div class="row">
                 <div class="col">
                  <div class="input-group{{ $errors->has('contact') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-single-02"></i>
                        </div>
                    </div>
                    <input type="text" name="contact" onblur="checkContactExistOrNot(this);" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter Contact Number') }}" value="{{isset($userdetails->contact) ? $userdetails->contact : '' }}" required="">
                    <span id="errors-contact" style="color: red; display: none"></span>
                </div>
            </div>
            <div class="col">
              <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="tim-icons icon-single-02"></i>
                    </div>
                </div>
                <input type="email" name="email" onblur="checkEmailExistOrNot(this);" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Employee Email') }}" value="{{isset($userdetails->email) ? $userdetails->email : '' }}" required="">
                <span id="errors-email" style="color: red; display: none"></span>
                @include('alerts.feedback', ['field' => 'email'])
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="input-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="tim-icons icon-single-02"></i>
                    </div>
                </div>
                <input type="text" name="designation" class="form-control{{ $errors->has('designation') ? ' is-invalid' : '' }}" placeholder="{{ __('Designation') }}" value="{{isset($userdetails->designation) ? $userdetails->designation : '' }}" required="">
                @include('alerts.feedback', ['field' => 'designation'])
            </div>
        </div>
        <div class="col">
            <div class="input-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="tim-icons icon-single-02"></i>
                    </div>
                </div>
                <select name="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" required="">
                    <option>{{ __('Select Gender') }}</option>
                    <option value="male" {{isset($userdetails->gender) && $userdetails->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{isset($userdetails->gender) && $userdetails->gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{isset($userdetails->gender) && $userdetails->gender == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @include('alerts.feedback', ['field' => 'gender'])
            </div>
        </div>
    </div>
    <div class="row">
     <div class="col">
        <div class="input-group{{ $errors->has('dob') ? ' has-danger' : '' }}">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="tim-icons icon-single-02"></i>
                </div>
            </div>
            <input type="text" name="dob" class="datepicker form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="{{ __('Date of Birth') }}" value="{{isset($userdetails->dob) ? $userdetails->dob : '' }}" required="">
            @include('alerts.feedback', ['field' => 'dob'])
        </div>
    </div>
    <div class="col">
        <div class="input-group{{ $errors->has('doj') ? ' has-danger' : '' }}">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="tim-icons icon-single-02"></i>
                </div>
            </div>
            <input type="text" name="doj" class="datepicker form-control{{ $errors->has('doj') ? ' is-invalid' : '' }}" placeholder="{{ __('Date of Joining') }}" value="{{isset($userdetails->doj) ? $userdetails->doj : '' }}" required="">
            @include('alerts.feedback', ['field' => 'doj'])
        </div>
    </div>
</div>
<div class="row">
 <div class="col">
    <div class="input-group{{ $errors->has('father_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="father_name" class="form-control{{ $errors->has('father_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Father Name') }}" value="{{isset($userdetails->father_name) ? $userdetails->father_name : '' }}" required="">
        @include('alerts.feedback', ['field' => 'father_name'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('mother_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="mother_name" class="form-control{{ $errors->has('mother_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Mother Name') }}" value="{{isset($userdetails->mother_name) ? $userdetails->mother_name : '' }}" required="">
        @include('alerts.feedback', ['field' => 'mother_name'])
    </div>
</div>
</div>
<div class="row">
 <div class="col">
    <div class="input-group{{ $errors->has('marital_status') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <select name="marital_status" onchange="showMaritalInfo();" class="form-control{{ $errors->has('marital_status') ? ' is-invalid' : '' }}" required="">
            <option>{{ __('Marital Status') }}</option>
            <option value="no" {{isset($userdetails->marital_status) && $userdetails->marital_status == 'no' ? 'selected' : '' }}>No</option>
            <option value="yes" {{isset($userdetails->marital_status) && $userdetails->marital_status == 'yes' ? 'selected' : '' }}>Yes</option>
        </select>
        @include('alerts.feedback', ['field' => 'marital_status'])
    </div>
</div>
<div class="col marital" style="display: none;">
    <div class="input-group{{ $errors->has('spouse_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="spouse_name" class="form-control{{ $errors->has('spouse_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Spouse Name') }}" value="{{isset($userdetails->spouse_name) ? $userdetails->spouse_name : '' }}">
        @include('alerts.feedback', ['field' => 'spouse_name'])
    </div>
</div>
</div>
<div class="row marital" style="display: none;">
 <div class="col">
    <div class="input-group{{ $errors->has('child_status') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <select name="child_status" onchange="showHideChildrensInfo();" class="form-control{{ $errors->has('child_status') ? ' is-invalid' : '' }}" >
            <option>{{ __('Child Status') }}</option>
            <option value="no" {{isset($userdetails->child_status) && $userdetails->child_status == 'no' ? 'selected' : '' }}>No</option>
            <option value="yes" {{isset($userdetails->child_status) && $userdetails->child_status == 'yes' ? 'selected' : '' }}>Yes</option>
        </select>
        @include('alerts.feedback', ['field' => 'child_status'])
    </div>
</div>
<div class="col children" style="display: none;">
    <div class="input-group{{ $errors->has('children') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="number" onkeyup="addChildFields(this);" min="0" name="children" class="form-control{{ $errors->has('children') ? ' is-invalid' : '' }}" placeholder="{{ __('Children') }}" value="{{isset($userdetails->children) ? $userdetails->children : '' }}">
        @include('alerts.feedback', ['field' => 'children'])
    </div>
</div>
</div>
<div id="children-div" style="display: none;"></div><!-- 
<div class="row children" style="display: none;">
   <div class="col">
    <div class="input-group{{ $errors->has('first_child_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="first_child_name" class="form-control{{ $errors->has('first_child_name') ? ' is-invalid' : '' }}" placeholder="{{ __('First Child Name') }}" value="{{isset($userdetails->first_child_name) ? $userdetails->first_child_name : '' }}">
        @include('alerts.feedback', ['field' => 'first_child_name'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('first_child_age') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="number" min="0" name="first_child_age" class="form-control{{ $errors->has('first_child_age') ? ' is-invalid' : '' }}" placeholder="{{ __('First Child Age') }}" value="{{isset($userdetails->first_child_age) ? $userdetails->first_child_age : '' }}">
        @include('alerts.feedback', ['field' => 'first_child_age'])
    </div>
</div>
</div>
<div class="row children" style="display: none;">
   <div class="col">
    <div class="input-group{{ $errors->has('second_child_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="second_child_name" class="form-control{{ $errors->has('second_child_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Second Child Name') }}" value="{{isset($userdetails->second_child_name) ? $userdetails->second_child_name : '' }}">
        @include('alerts.feedback', ['field' => 'second_child_name'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('second_child_age') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="number" min="0" min="0" name="second_child_age" class="form-control{{ $errors->has('second_child_age') ? ' is-invalid' : '' }}" placeholder="{{ __('Second Child Age') }}" value="{{isset($userdetails->second_child_age) ? $userdetails->second_child_age : '' }}">
        @include('alerts.feedback', ['field' => 'second_child_age'])
    </div>
</div>
</div>
<div class="row children" style="display: none;">
   <div class="col">
    <div class="input-group{{ $errors->has('third_child_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="third_child_name" class="form-control{{ $errors->has('third_child_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Third Child Name') }}" value="{{isset($userdetails->third_child_name) ? $userdetails->third_child_name : '' }}">
        @include('alerts.feedback', ['field' => 'third_child_name'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('third_child_age') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="number" min="0" min="0" name="third_child_age" class="form-control{{ $errors->has('third_child_age') ? ' is-invalid' : '' }}" placeholder="{{ __('Third Child Age') }}"  value="{{isset($userdetails->third_child_age) ? $userdetails->third_child_age : '' }}">
        @include('alerts.feedback', ['field' => 'third_child_age'])
    </div>
</div> -->
<!-- </div> -->
<div class="row">
   <div class="col">
    <div class="input-group{{ $errors->has('other_contact') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="other_contact" class="form-control{{ $errors->has('other_contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Other Contact Number') }}" value="{{isset($userdetails->other_contact) ? $userdetails->other_contact : '' }}">
        @include('alerts.feedback', ['field' => 'other_contact'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('emergency_contact_person_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="emergency_contact_person_name" class="form-control{{ $errors->has('emergency_contact_person_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Emergency Contact Person') }}" value="{{isset($userdetails->emergency_contact_person_name) ? $userdetails->emergency_contact_person_name : '' }}" required="">
        @include('alerts.feedback', ['field' => 'emergency_contact_person_name'])
    </div>
</div>
</div>
<div class="row">
   <div class="col">
    <div class="input-group{{ $errors->has('emergency_contact') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="number"  min="0" name="emergency_contact" class="form-control{{ $errors->has('emergency_contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Emergency Contact') }}" value="{{isset($userdetails->emergency_contact) ? $userdetails->emergency_contact : '' }}" required="">
        @include('alerts.feedback', ['field' => 'emergency_contact'])
    </div>
</div>
<div class="col">
    <div class="input-group{{ $errors->has('adhar_no') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="number" min="0" name="adhar_no" class="form-control{{ $errors->has('adhar_no') ? ' is-invalid' : '' }}" placeholder="{{ __('Adhar Number') }}" value="{{isset($userdetails->adhar_no) ? $userdetails->adhar_no : '' }}" required="">
        @include('alerts.feedback', ['field' => 'adhar_no'])
    </div>
</div>
</div>
<div class="row">
   <div class="col">
    <div class="file-drop-area">
        <span class="fake-btn">Choose file {{ __('Adhar Doc') }} <i class="fas fa-upload"></i></span>
        <span class="file-msg">or drag and drop file here</span>
        <input class="file-input" name="adhar_doc" type="file">
    </div>
    @include('alerts.feedback', ['field' => 'adhar_doc'])
</div>
<div class="col">
   <div class="input-group{{ $errors->has('address') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <textarea name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}">{{isset($userdetails->address) ? $userdetails->address : 'Address:' }}</textarea>
    @include('alerts.feedback', ['field' => 'address'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
    <div class="file-drop-area">
        <span class="fake-btn">Choose file {{ __('Address Prrof') }} <i class="fas fa-upload"></i></span>
        <span class="file-msg">or drag and drop file here</span>
        <input class="file-input" name="address_proof_doc" type="file">
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('correspond_address') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <textarea name="correspond_address" class="form-control{{ $errors->has('correspond_address') ? ' is-invalid' : '' }}">{{isset($userdetails->correspond_address) ? $userdetails->correspond_address : 'Correspond Address:' }} </textarea>
    @include('alerts.feedback', ['field' => 'correspond_address'])
</div>
</div>
</div>
<div class="row">
    <div class="col">
        <div class="file-drop-area">
            <span class="fake-btn">Choose file {{ __('Correspond Address Prrof') }} <i class="fas fa-upload"></i></span>
            <span class="file-msg">or drag and drop file here</span>
            <input class="file-input" name="correspond_address_proof" type="file">
        </div>
    </div>
    <div class="col">
        <div class="file-drop-area">
            <span class="fake-btn">Choose file {{ __('Police Verification Doc') }} <i class="fas fa-upload"></i></span>
            <span class="file-msg">or drag and drop file here</span>
            <input class="file-input" name="police_verified_doc" type="file">
        </div>
    </div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('uan_no') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="number" min="0" name="uan_no" class="form-control{{ $errors->has('uan_no') ? ' is-invalid' : '' }}" placeholder="{{ __('UAN Number') }}" value="{{isset($userdetails->uan_no) ? $userdetails->uan_no : '' }}" required="">
        @include('alerts.feedback', ['field' => 'uan_no'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('esic_no') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="text" name="esic_no" class="form-control{{ $errors->has('esic_no') ? ' is-invalid' : '' }}" placeholder="{{ __('ESIC Number') }}" value="{{isset($userdetails->esic_no) ? $userdetails->esic_no : '' }}"  required="">
    @include('alerts.feedback', ['field' => 'esic_no'])
</div>
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('bank_name') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="bank_name" class="form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Bank Name') }}" value="{{isset($userdetails->bank_name) ? $userdetails->bank_name : '' }}" required="">
        @include('alerts.feedback', ['field' => 'bank_name'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('bank_account_no') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <input type="number" min="0" name="bank_account_no" class="form-control{{ $errors->has('bank_account_no') ? ' is-invalid' : '' }}" placeholder="{{ __('Bank Account Number') }}" value="{{isset($userdetails->bank_account_no) ? $userdetails->bank_account_no : '' }}" required="">
    @include('alerts.feedback', ['field' => 'bank_account_no'])
</div> 
</div>
</div>
<div class="row">
   <div class="col">
     <div class="input-group{{ $errors->has('bank_ifsc') ? ' has-danger' : '' }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="tim-icons icon-single-02"></i>
            </div>
        </div>
        <input type="text" name="bank_ifsc" class="form-control{{ $errors->has('bank_ifsc') ? ' is-invalid' : '' }}" placeholder="{{ __('IFSC Code') }}" value="{{isset($userdetails->bank_ifsc) ? $userdetails->bank_ifsc : '' }}" required="">
        @include('alerts.feedback', ['field' => 'bank_ifsc'])
    </div>
</div>
<div class="col">
   <div class="input-group{{ $errors->has('working_status') ? ' has-danger' : '' }}">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="tim-icons icon-single-02"></i>
        </div>
    </div>
    <select name="working_status" class="form-control{{ $errors->has('working_status') ? ' is-invalid' : '' }}" required="">
        <option>{{ __('Working Status') }}</option>
        <option value="Working" {{isset($userdetails->working_status) && $userdetails->working_status == 'Working' ? 'selected' : '' }}>Working</option>
        <option value="Terminated" {{isset($userdetails->working_status) && $userdetails->working_status == 'Terminated' ? 'selected' : '' }}>Terminated</option>
        <option value="Black Listed" {{isset($userdetails->working_status) && $userdetails->working_status == 'Black Listed' ? 'selected' : '' }}>Black Listed</option>
        <option value="Resigned" {{isset($userdetails->working_status) && $userdetails->working_status == 'Resigned' ? 'selected' : '' }}>Resigned</option>
    </select>
    @include('alerts.feedback', ['field' => 'working_status'])
</div>
</div>
</div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Create') }}</button>
</div>
</form>
</div>
</div>
</div>
</div>
<div class="modal modal-black fade" id="empImportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
    <form action="{{ route('employee.import') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="exampleInputCSV">Choose file</label>
        <input type="file" name="file" class="form-control" id="exampleInputCSV" aria-describedby="CSVHelp" placeholder="" required="">
        <small id="CSVHelp" class="form-text text-muted">Click any where here for choose file.</small>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
</div>
</div>
@endsection
<script type="text/javascript">
    function showHideChildrensInfo() {
     if($('select[name="child_status"]').val() == 'yes'){
         $(this).find('option:selected').text();
         $(".children").show();
     }else{
       $(".children").hide();
   }
}
function showMaritalInfo() {
 if($('select[name="marital_status"]').val() == 'yes'){
     $(this).find('option:selected').text();
     $(".marital").show();
     showHideChildrensInfo();
 }else{
   $(".marital").hide();
   $(".children").hide();
}
}
function addChildFields(e) {
    let totalChildren = parseInt($(e).val());
    let new_input = '';
    for(let i=1; i <= totalChildren; i++){
        console.log(i);
        new_input += '<div class="row children">';
        new_input += '<div class="col">';
        new_input += '<div class="input-group">';
        new_input += '<div class="input-group-prepend">';
        new_input += '<div class="input-group-text">';
        new_input += '<i class="tim-icons icon-single-02"></i></div></div>';
        new_input += '<input type="text" name="child_name[]" class="form-control" placeholder="Child Name '+i+'">';
        new_input += '</div>';
        new_input += '</div>';
        new_input += '<div class="col">';
        new_input += '<div class="input-group">';
        new_input += '<div class="input-group-prepend">';
        new_input += '<div class="input-group-text">';
        new_input += '<i class="tim-icons icon-single-02"></i>';
        new_input += '</div>';
        new_input += '</div>';
        new_input += '<input type="number" min="0" name="child_age[]" class="form-control" placeholder=" Child Age '+i+'">';
        new_input += '</div>';
        new_input += '</div>';
        new_input += '</div>';
    }
    $("#children-div").html(new_input);
    $("#children-div").show();
}
function checkContactExistOrNot(e) {
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    var contactNumber = $(e).val();
    if (filter.test(contactNumber)) {
        if(contactNumber.length==10){
            var validate = true;
            $('#errors-contact').html('');
            $('#errors-contact').hide();
        } else {
            $(e).val('');
            $('#errors-contact').html('Enter valid mobile number!');
            $('#errors-contact').show();
            var validate = false;
        }
    }else{
        $(e).val('');
        $('#errors-contact').html('Enter valid mobile number!');
        $('#errors-contact').show();
        var validate = false;
    }
    if(validate){
        $.get( "{{ route('is-exits-contact') }}", { contact: contactNumber }, function( data ) {
          if(data.status){
            $(e).val('')
            $('#errors-contact').html('Mobile number already exist!');
            $('#errors-contact').show();
        }else{
            $('#errors-contact').html('');
            $('#errors-contact').hide();
        }
    });
    }
}
function checkEmailExistOrNot(e) {
    var emaiId = $(e).val();
    $.get( "{{ route('is-exits-email') }}", { email: emaiId }, function( data ) {
      if(data.status){
        $(e).val('')
        $('#errors-email').html('Email id already exist!');
        $('#errors-email').show();
    }else{
        $('#errors-email').html('');
        $('#errors-email').hide();
    }
});
}
</script>