<?php

namespace App\Imports;

use App\User;
use App\Userdetails;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class EmployeeImport implements ToModel,WithHeadingRow
{
    private $recordsCache;

    function __construct()
    {

    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $marital_status = 'no';
        $spouse_name = null;
        $child_status = 'no';
        $children = 0;
        $first_child_name = null;
        $first_child_age = 0;
        $second_child_name = null;
        $second_child_age = 0;
        $third_child_name = null;
        $third_child_age = 0;

        $contactExist = $this->isContactExist($row['contact']);
        $emailExist = $this->isEmailExist($row['email']);
        if(!$contactExist || !$emailExist){
            $user = User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'contact' => $row['contact'],
                'type' => $row['type'],
                'status' => 'deactive',
                'password' => Hash::make($row['contact']),
                'created_by_id' => auth()->user()->id
            ]);
            if ($row['marital_status'] == 'yes') {
                $marital_status = $row['marital_status'];
                $spouse_name = $row['spouse_name'];
                if($row['child_status'] == 'yes'){
                    $child_status = $row['child_status'];
                    $children = $row['children'];
                    $first_child_name = $row['first_child_name'];
                    $first_child_age = $row['first_child_age'];
                    $second_child_name = $row['second_child_name'];
                    $second_child_age = $row['second_child_age'];
                    $third_child_name = $row['third_child_name'];
                    $third_child_age = $row['third_child_age'];
                }else{
                    $child_status = 'no';
                }
            }else{
                $marital_status = 'no';
            }
            return new Userdetails([
                'user_id' => $user->id,
                'emp_id' => $row['emp_id'], 
                'gender' => $row['gender'],
                'dob' => $row['dob'],
                'doj' => $row['doj'],
                'father_name' => $row['father_name'],
                'mother_name' => $row['mother_name'],
                'marital_status' => $marital_status,
                'spouse_name' => $spouse_name,   
                'child_status' => $child_status,
                'children' => $children,
                'first_child_name' => $first_child_name,
                'first_child_age' => $first_child_age,
                'second_child_name' => $second_child_name,
                'second_child_age' => $second_child_age,
                'third_child_name' => $third_child_name,
                'third_child_age' => $third_child_age,
                'other_contact' => $row['other_contact'],
                'emergency_contact_person_name' => $row['emergency_contact_person_name'],
                'emergency_contact' => $row['emergency_contact'],
                'adhar_no' => $row['adhar_no'],
                'address' => $row['address'],
                'correspond_address' => $row['correspond_address'],
                'uan_no' => $row['uan_no'],
                'esic_no' => $row['esic_no'],
                'bank_name' => $row['bank_name'],
                'bank_account_no' => $row['bank_account_no'],
                'bank_ifsc' => $row['bank_ifsc'],
                'working_status' => $row['working_status'],
                'designation' => $row['designation'],
                'filled_by_id' => auth()->user()->id
            ]);
        }else{
            return null;
        }
    }
    private function isEmailExist($emailId='')
    {
        if(auth()->user()->type == 'subadmin'){
            if($emailId != ''){
                $exist = User::where(['email'=>$emailId,'created_by_id' => auth()->user()->id])->first();
                return $exist != null ? $exist['id'] : false;
            }
        }
    }
    private function isContactExist($contact='')
    {
        if(auth()->user()->type == 'subadmin'){
            if($contact != ''){
                $exist = User::where(['contact'=>$contact,'created_by_id' => auth()->user()->id])->first();
                return $exist != null ? $exist['id'] : false;
            }
        }
    }
}
