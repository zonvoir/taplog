@extends('layouts.app', ['page' => __('Employee Details'), 'pageSlug' => 'employee'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h4 class="card-title"> Update Details</h4></div>
        </div>
      </div>
      <div class="card-body">
       <form class="form" method="post" action="{{ route('user.update-profile') }}" enctype="multipart/form-data">
        @csrf
        {{ method_field('PUT') }}
        <input type="hidden" name="user_id" value="{{isset($userdetails->user_id) ? $userdetails->user_id : $user_id}}">
        <div class="card-body">
          <div class="row">
           <div class="col">
            <label>{{ __('Employee ID') }}</label>
            <input type="text" name="emp_id" class="form-control{{ $errors->has('emp_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Employee ID') }}" value="{{isset($userdetails->emp_id) ? $userdetails->emp_id : rand() }}" required="">
            @include('alerts.feedback', ['field' => 'emp_id'])
          </div>
          <div class="col">
            <label>{{ __('Select Gender') }}</label>
            <select name="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" required="">
              <option value="male" {{isset($userdetails->gender) && $userdetails->gender == 'male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{isset($userdetails->gender) && $userdetails->gender == 'female' ? 'selected' : '' }}>Female</option>
              <option value="other" {{isset($userdetails->gender) && $userdetails->gender == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @include('alerts.feedback', ['field' => 'gender'])
          </div>
        </div>
        <div class="row">
         <div class="col">
          <label>{{ __('Date of Birth') }}</label>
          <input type="text" name="dob" class="datepicker form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="{{ __('Date of Birth') }}" value="{{isset($userdetails->dob) ? $userdetails->dob : '' }}" required="">
          @include('alerts.feedback', ['field' => 'dob'])
        </div>
        <div class="col">
          <label>{{ __('Date of Joining') }}</label>
          <input type="text" name="doj" class="datepicker form-control{{ $errors->has('doj') ? ' is-invalid' : '' }}" placeholder="{{ __('Date of Joining') }}" value="{{isset($userdetails->doj) ? $userdetails->doj : '' }}" required="">
          @include('alerts.feedback', ['field' => 'doj'])
        </div>
      </div>
      <div class="row">
       <div class="col">
        <label>{{ __('Father Name') }}</label>
        <input type="text" name="father_name" class="form-control{{ $errors->has('father_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Father Name') }}" value="{{isset($userdetails->father_name) ? $userdetails->father_name : '' }}" required="">
        @include('alerts.feedback', ['field' => 'father_name'])
      </div>
      <div class="col">
        <label>{{ __('Mother Name') }}</label>
        <input type="text" name="mother_name" class="form-control{{ $errors->has('mother_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Mother Name') }}" value="{{isset($userdetails->mother_name) ? $userdetails->mother_name : '' }}" required="">
        @include('alerts.feedback', ['field' => 'mother_name'])
      </div>
    </div>
    <div class="row">
     <div class="col">
      <label>{{ __('Marital Status') }}</label>
      <select name="marital_status" onchange="showMaritalInfo();" class="form-control{{ $errors->has('marital_status') ? ' is-invalid' : '' }}" required="">
        <option value="no" {{isset($userdetails->marital_status) && $userdetails->marital_status == 'no' ? 'selected' : '' }}>No</option>
        <option value="yes" {{isset($userdetails->marital_status) && $userdetails->marital_status == 'yes' ? 'selected' : '' }}>Yes</option>
      </select>
      @include('alerts.feedback', ['field' => 'marital_status'])
    </div>
    <div class="col marital" style="display: {{isset($userdetails->marital_status) && $userdetails->marital_status == 'yes' ? 'block;' : 'none;' }}">
      <label>{{ __('Spouse Name') }}</label>
      <input type="text" name="spouse_name" class="form-control{{ $errors->has('spouse_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Spouse Name') }}" value="{{isset($userdetails->spouse_name) ? $userdetails->spouse_name : '' }}">
      @include('alerts.feedback', ['field' => 'spouse_name'])
    </div>
  </div>
  <div class="row marital" style="display: {{isset($userdetails->marital_status) && $userdetails->marital_status == 'yes' ? '' : 'none;'}}">
   <div class="col-md-6">
    <label>{{ __('Child Status') }}</label>
    <select name="child_status" onchange="showHideChildrensInfo();" class="form-control{{ $errors->has('child_status') ? ' is-invalid' : '' }}" >
      <option value="no" {{isset($userdetails->child_status) && $userdetails->child_status == 'no' ? 'selected' : '' }}>No</option>
      <option value="yes" {{isset($userdetails->child_status) && $userdetails->child_status == 'yes' ? 'selected' : '' }}>Yes</option>
    </select>
    @include('alerts.feedback', ['field' => 'child_status'])
  </div>
  <div class="col-md-6 children" style="display: {{isset($userdetails->child_status) && $userdetails->child_status == 'yes' ? '' : 'none;'}}">
    <label>{{ __('Children') }}</label>
    <input type="hidden" name="savedChildren" value="{{isset($userdetails->children) ? $userdetails->children : '' }}">
    <input type="number" min="0" name="children" onkeyup="addChildFields(this);" class="form-control{{ $errors->has('children') ? ' is-invalid' : '' }}" placeholder="{{ __('Children') }}" value="{{isset($userdetails->children) ? $userdetails->children : '' }}">
    @include('alerts.feedback', ['field' => 'children'])
  </div>
</div>
<div id="children-div" style="display: {{isset($userdetails->children) ? '' : 'none;' }}">
  @php $i=1; @endphp
  @if(isset($children) && !empty($children))
  @foreach($children as $child)
  <div class="row children childrenRow childrenRow" id="child_row_{{$i}}">
    <div class="col">
     <label>{{$i}} Child Name</label>
     <input type="text" name="child_name[]" class="form-control" placeholder="{{ __('Child Name') }}" value="{{isset($child->child_name) ? $child->child_name : '' }}">
   </div>
   <div class="col">
    <label>{{$i}} Child Age</label>
    <input type="number" min="0" name="child_age[]" class="form-control" placeholder="{{ __('Child Age') }}" value="{{isset($child->child_age) ? $child->child_age : '' }}">
  </div>
</div>
@php $i++; @endphp
@endforeach
@endif
</div>
<div class="row">
 <div class="col">
  <label>{{ __('Other Contact Number') }}</label>
  <input type="text" name="other_contact" onblur="checkContactExistOrNot(this);" class="form-control{{ $errors->has('other_contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Other Contact Number') }}" value="{{isset($userdetails->other_contact) ? $userdetails->other_contact : '' }}" required>
  @include('alerts.feedback', ['field' => 'other_contact'])
  <span id="errors-contact" style="color: red; display: none"></span>
</div>
<div class="col">
  <label>{{ __('Emergency Contact Person') }}</label>
  <input type="text" name="emergency_contact_person_name" class="form-control{{ $errors->has('emergency_contact_person_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Emergency Contact Person') }}" value="{{isset($userdetails->emergency_contact_person_name) ? $userdetails->emergency_contact_person_name : '' }}" required="">
  @include('alerts.feedback', ['field' => 'emergency_contact_person_name'])
</div>
</div>
<div class="row">
 <div class="col">
  <label>{{ __('Emergency Contact') }}</label>
  <input type="number" min="0" name="emergency_contact" class="form-control{{ $errors->has('emergency_contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Emergency Contact') }}" value="{{isset($userdetails->emergency_contact) ? $userdetails->emergency_contact : '' }}" required="">
  @include('alerts.feedback', ['field' => 'emergency_contact'])
</div>
<div class="col">
  <label>{{ __('Adhar Number') }}</label>
  <input type="number" min="0" name="adhar_no" class="form-control{{ $errors->has('adhar_no') ? ' is-invalid' : '' }}" placeholder="{{ __('Adhar Number') }}" value="{{isset($userdetails->adhar_no) ? $userdetails->adhar_no : '' }}" required="">
  @include('alerts.feedback', ['field' => 'adhar_no'])
</div>
</div>
<div class="row">
 <div class="col">
   <label>{{ __('Adhar Doc') }}</label>
   <input type="file" name="adhar_doc" class="form-control{{ $errors->has('adhar_doc') ? ' is-invalid' : '' }}" placeholder="{{ __('Adhar Doc') }}">
   @include('alerts.feedback', ['field' => 'adhar_doc'])
   @if(isset($userdetails->adhar_doc))
   <a href="{{$userdetails->adhar_doc}}" download></a>
   @endif
 </div>
 <div class="col">
   <label>{{ __('Address') }}</label>
   <textarea name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}">{{isset($userdetails->address) ? $userdetails->address : 'Address:' }}</textarea>
   @include('alerts.feedback', ['field' => 'address'])
 </div>
</div>
<div class="row">
 <div class="col">
   <label>{{ __('Address Proof') }}</label>
   <input type="file" name="address_proof_doc" class="form-control{{ $errors->has('address_proof_doc') ? ' is-invalid' : '' }}" placeholder="{{ __('Address Proof') }}">
   @include('alerts.feedback', ['field' => 'address_proof_doc'])
   @if(isset($userdetails->address_proof_doc))
   <a href="{{$userdetails->address_proof_doc}}" download></a>
   @endif
 </div>
 <div class="col">
   <label>{{ __('Correspond Address') }}</label>
   <textarea name="correspond_address" class="form-control{{ $errors->has('correspond_address') ? ' is-invalid' : '' }}">{{isset($userdetails->correspond_address) ? $userdetails->correspond_address : 'Correspond Address:' }} </textarea>
   @include('alerts.feedback', ['field' => 'correspond_address'])
 </div>
</div>
<div class="row">
 <div class="col">
   <label>{{ __('Correspond Address Proof') }}</label>
   <input type="file" name="correspond_address_proof" class="form-control{{ $errors->has('correspond_address_proof') ? ' is-invalid' : '' }}" placeholder="{{ __('Correspond Address Proof') }}">
   @include('alerts.feedback', ['field' => 'correspond_address_proof'])
   @if(isset($userdetails->correspond_address_proof))
   <a href="{{$userdetails->correspond_address_proof}}" download></a>
   @endif
 </div>
 <div class="col">
   <label>{{ __('Police Verification Doc') }}</label>
   <input type="file" name="police_verified_doc" class="form-control{{ $errors->has('police_verified_doc') ? ' is-invalid' : '' }}" placeholder="{{ __('Police Verification Doc') }}">
   @include('alerts.feedback', ['field' => 'police_verified_doc'])
   @if(isset($userdetails->police_verified_doc))
   <a href="{{$userdetails->police_verified_doc}}" download></a>
   @endif
 </div>
</div>
<div class="row">
 <div class="col">
   <label>{{ __('UAN Number') }}</label>
   <input type="number" min="0" name="uan_no" class="form-control{{ $errors->has('uan_no') ? ' is-invalid' : '' }}" placeholder="{{ __('UAN Number') }}" value="{{isset($userdetails->uan_no) ? $userdetails->uan_no : '' }}" required="">
   @include('alerts.feedback', ['field' => 'uan_no'])
 </div>
 <div class="col">
   <label>{{ __('ESIC Number') }}</label>
   <input type="text" name="esic_no" class="form-control{{ $errors->has('esic_no') ? ' is-invalid' : '' }}" placeholder="{{ __('ESIC Number') }}" value="{{isset($userdetails->esic_no) ? $userdetails->esic_no : '' }}"  required="">
   @include('alerts.feedback', ['field' => 'esic_no'])
 </div>
</div>
<div class="row">
 <div class="col">
   <label>{{ __('Bank Name') }}</label>
   <input type="text" name="bank_name" class="form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Bank Name') }}" value="{{isset($userdetails->bank_name) ? $userdetails->bank_name : '' }}" required="">
   @include('alerts.feedback', ['field' => 'bank_name'])
 </div>
 <div class="col">
   <label>{{ __('Bank Account Number') }}</label>
   <input type="number" min="0" name="bank_account_no" class="form-control{{ $errors->has('bank_account_no') ? ' is-invalid' : '' }}" placeholder="{{ __('Bank Account Number') }}" value="{{isset($userdetails->bank_account_no) ? $userdetails->bank_account_no : '' }}" required="">
   @include('alerts.feedback', ['field' => 'bank_account_no']) 
 </div>
</div>
<div class="row">
 <div class="col">
   <label>{{ __('IFSC Code') }}</label>
   <input type="text" name="bank_ifsc" class="form-control{{ $errors->has('bank_ifsc') ? ' is-invalid' : '' }}" placeholder="{{ __('IFSC Code') }}" value="{{isset($userdetails->bank_ifsc) ? $userdetails->bank_ifsc : '' }}" required="">
   @include('alerts.feedback', ['field' => 'bank_ifsc'])
 </div>
 <div class="col">
   <label>{{ __('Working Status') }}</label>
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
<div class="card-footer">
  <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
</div>
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
  let savedChildren = parseInt($("input[name='savedChildren']").val())
  console.log('savChill'+savedChildren);
  let totalChildren = parseInt($(e).val());
  console.log('totChill'+totalChildren);
  let new_input = '';
  if(!Number.isNaN(savedChildren) && !Number.isNaN(totalChildren)){
    $("input[name='savedChildren']").val(totalChildren);

    if(totalChildren > savedChildren){
      let finalChildren = totalChildren-savedChildren;
      for(let i=1; i <= finalChildren; i++){
        new_input += '<div class="row children" id="child_row_'+(parseInt(i)+savedChildren)+'">';
        new_input += '<div class="col">';
        new_input += '<label>'+(parseInt(i)+savedChildren)+' Child Name</label>';
        new_input += '<input type="text" name="child_name[]" class="form-control" placeholder="Child Name">';
        new_input += '</div>';
        new_input += '<div class="col">';
        new_input += '<label>'+(parseInt(i)+savedChildren)+' Child Age</label>';
        new_input += '<input type="number" min="0" name="child_age[]" class="form-control" placeholder=" Child Age">';
        new_input += '</div>';
        new_input += '</div>';
      }
      $("#children-div").append(new_input);
    }else if(totalChildren < savedChildren){
      let finalChildren = savedChildren -totalChildren;
      for(let i = savedChildren; i>totalChildren; i--){
        $("#child_row_"+i).remove();
      }
    }
  }else if(Number.isNaN(savedChildren) && !Number.isNaN(totalChildren)){
    console.log("enter children div");
   let finalChildren = totalChildren;
   for(let i=1; i <= finalChildren; i++){
    new_input += '<div class="row children" id="child_row_'+i+'">';
    new_input += '<div class="col">';
    new_input += '<label>'+i+' Child Name</label>';
    new_input += '<input type="text" name="child_name[]" class="form-control" placeholder="Child Name">';
    new_input += '</div>';
    new_input += '<div class="col">';
    new_input += '<label>'+i+' Child Age</label>';
    new_input += '<input type="number" min="0" name="child_age[]" class="form-control" placeholder=" Child Age">';
    new_input += '</div>';
    new_input += '</div>';
  }
  $("#children-div").html(new_input);
  $("#children-div").show();
}else if(Number.isNaN(savedChildren) && Number.isNaN(totalChildren)){
  $("#children-div").html('');
  $("#children-div").hide();
}

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
    // if(validate){
    //     $.get( "{{ route('is-exits-contact') }}", { contact: contactNumber }, function( data ) {
    //       if(data.status){
    //         $(e).val('')
    //         $('#errors-contact').html('Mobile number already exist!');
    //         $('#errors-contact').show();
    //     }else{
    //         $('#errors-contact').html('');
    //         $('#errors-contact').hide();
    //     }
    // });
    // }
  }
</script>