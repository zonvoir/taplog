<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userdetails extends Model
{
    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'emp_id', 
        'gender',
        'dob',
        'doj',
        'father_name',
        'mother_name',
        'marital_status',
        'spouse_name',
        'child_status',
        'children',
        'first_child_name',
        'first_child_age',
        'second_child_name',
        'second_child_age',
        'third_child_name',
        'third_child_age',
        'other_contact',
        'emergency_contact_person_name',
        'emergency_contact',
        'adhar_no',
        'adhar_doc',
        'address',
        'address_proof_doc',
        'correspond_address',
        'correspond_address_proof',
        'police_verified_doc',
        'uan_no',
        'esic_no',
        'bank_name',
        'bank_account_no',
        'bank_ifsc',
        'working_status',
        'filled_by_id',
        'designation'
    ];
}
