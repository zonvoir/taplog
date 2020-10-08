<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Userdetails;
use App\Children;
use Illuminate\Support\Facades\Hash;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $model)
    {
        $model->leftjoin('user_details', function($join){
            $join->on('user_details.user_id','=','users.id');
        });
        if(auth()->user()->type == 'admin'){
            return view('employee.index', ['users' => $model->where('type','==','subadmin')->paginate(15)]);
        }elseif(auth()->user()->type == 'subadmin'){
            return view('employee.index', ['users' => $model->where('type','!=','admin')->where(['created_by_id' => auth()->user()->id, 'type' => 'other'])->paginate(15)]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newUser = new User();
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->contact = $request->contact;
        $newUser->type = 'other';
        $newUser->status = 'deactive';
        $newUser->password = Hash::make($request->contact);
        $newUser->created_by_id = auth()->user()->id;
        if( $newUser->save()){
            $newUserDetails = new Userdetails();
            $newUserDetails->user_id = $newUser->id;
            $newUserDetails->emp_id = $request->emp_id;
            $newUserDetails->gender = $request->gender;
            $newUserDetails->dob = $request->dob;
            $newUserDetails->doj = $request->doj;
            $newUserDetails->father_name = $request->father_name;
            $newUserDetails->mother_name = $request->mother_name;
            $newUserDetails->designation = $request->designation;
            $newUserDetails->marital_status = $request->marital_status;
            if($request->marital_status == 'yes'){
                $newUserDetails->spouse_name = $request->spouse_name;
                if($request->child_status == 'yes'){
                    $newUserDetails->child_status = $request->child_status;
                    $newUserDetails->children = $request->children;
                    $childrenNameArray =  $request->child_name;
                    $childrenAgeArray =  $request->child_age;
                    $i = 0;
                    foreach ($childrenNameArray as $value) {
                        Children::create([
                           'user_id' => $newUser->id,
                           'child_name' => $value,
                           'child_age' => $childrenAgeArray[$i]
                       ]); 
                        $i++;
                    }
                }
            }
            $newUserDetails->other_contact = $request->other_contact;
            $newUserDetails->emergency_contact_person_name = $request->emergency_contact_person_name;
            $newUserDetails->emergency_contact = $request->emergency_contact;
            $newUserDetails->adhar_no = $request->adhar_no;
            if ($request->has('adhar_doc')) {
                $newUserDetails->adhar_doc = $request->file('adhar_doc')->store('adhar');
            }
            $newUserDetails->address = $request->address;
            if ($request->has('address_proof_doc')) {
                $newUserDetails->address_proof_doc = $request->file('address_proof_doc')->store('address');
            }
            $newUserDetails->correspond_address = $request->correspond_address;
            if ($request->has('correspond_address_proof')) {
                $newUserDetails->correspond_address_proof = $request->file('correspond_address_proof')->store('correspond');
            }
            if ($request->has('police_verified_doc')) {
             $newUserDetails->police_verified_doc = $request->file('police_verified_doc')->store('police');
         }
         $newUserDetails->uan_no = $request->uan_no;
         $newUserDetails->esic_no = $request->esic_no;
         $newUserDetails->bank_name = $request->bank_name;
         $newUserDetails->bank_account_no = $request->bank_account_no;
         $newUserDetails->bank_ifsc = $request->bank_ifsc;
         $newUserDetails->working_status = $request->working_status;
         $newUserDetails->filled_by_id = auth()->user()->id;
         $newUserDetails->save();
     }
     return back()->with('success','Employee created successfully!');
 }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $model, $id)
    {
         $userdetails = $model::with('details')->find($id);
        $children = Children::where('user_id','=',$id)->get();
        if(auth()->user()->type == 'subadmin'){
            return view('employee.edit', ['userdetails' => $userdetails, 'children' => $children]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $newUser = User::find($id);
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->contact = $request->contact;
        $newUser->type = 'other';
        $newUser->status = 'deactive';
        $newUser->password = Hash::make($request->contact);
        if( $newUser->save() ){
            $requestData = array();
            $requestData['emp_id'] = $request->emp_id;
            $requestData['gender'] = $request->gender;
            $requestData['dob'] = $request->dob;
            $requestData['doj'] = $request->doj;
            $requestData['father_name'] = $request->father_name;
            $requestData['mother_name'] = $request->mother_name;
            $requestData['designation'] = $request->designation;
            $requestData['marital_status'] = $request->marital_status;
            if($request->marital_status == 'yes'){
                $requestData['spouse_name'] = $request->spouse_name;
                if($request->child_status == 'yes'){
                    $requestData['child_status'] = $request->child_status;
                    $requestData['children'] = $request->children;
                    $childrenNameArray =  $request->child_name;
                    $childrenAgeArray =  $request->child_age;
                    $i = 0;
                    Children::where('user_id',$newUser->id)->delete();
                    foreach ($childrenNameArray as $value) {
                        Children::create([
                           'user_id' => $newUser->id,
                           'child_name' => $value,
                           'child_age' => $childrenAgeArray[$i]
                       ]); 
                        $i++;
                    }
                }elseif ($request->child_status == 'no') {
                    Children::where('user_id',$newUser->id)->delete();
                    $requestData['child_status'] = $request->child_status;
                    $requestData['children'] = 0;
                }
            }elseif ($request->marital_status == 'no') {
                $requestData['spouse_name'] = null;
                Children::where('user_id',$newUser->id)->delete();
                $requestData['child_status'] = 'no';
                $requestData['children'] = 0;
            }
            $requestData['other_contact'] = $request->other_contact;
            $requestData['emergency_contact_person_name'] = $request->emergency_contact_person_name;
            $requestData['emergency_contact'] = $request->emergency_contact;
            $requestData['adhar_no'] = $request->adhar_no;
            if ($request->has('adhar_doc')) {
                $requestData['adhar_doc'] = $request->file('adhar_doc')->store('adhar');
            }
            $requestData['address'] = $request->address;
            if ($request->has('address_proof_doc')) {
                $requestData['address_proof_doc'] = $request->file('address_proof_doc')->store('address');
            }
            $requestData['correspond_address'] = $request->correspond_address;
            if ($request->has('correspond_address_proof')) {
                $requestData['correspond_address_proof'] = $request->file('correspond_address_proof')->store('correspond');
            }
            if ($request->has('police_verified_doc')) {
             $requestData['police_verified_doc'] = $request->file('police_verified_doc')->store('police');
         }
         $requestData['uan_no'] = $request->uan_no;
         $requestData['esic_no'] = $request->esic_no;
         $requestData['bank_name'] = $request->bank_name;
         $requestData['bank_account_no'] = $request->bank_account_no;
         $requestData['bank_ifsc'] = $request->bank_ifsc;
         $requestData['working_status'] = $request->working_status;
         $requestData['filled_by_id'] = auth()->user()->id;
         Userdetails::where('user_id','=',$id)->update($requestData);
     }
     return back()->with('success','Employee updated! Default password is contact number in case login!');
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     $deletedRows = User::destroy($id);
     Userdetails::where('user_id',$id)->delete();
     return back()->with('success','Employee deleted!');
 }
 public function import() 
 {
    if(Excel::import(new EmployeeImport,request()->file('file'))){
        return back()->with('success','CSV imported successfully!');
    }else{
        return back()->with('error','Something went wrong importation un-successfull!');
    }
}
public function isContactExist(Request $request)
{
    if(auth()->user()->type == 'subadmin'){
        $contact = $request->contact;
        if($contact != ''){
            $exist = User::where(['contact'=>$contact,'created_by_id' => auth()->user()->id])->first();
            return response()->json([
                'status' => $exist != null ? $exist['id'] : false
            ]);
        }
    }
}
public function isEmailExist(Request $request)
{
    if(auth()->user()->type == 'subadmin'){
        $emailId = $request->email;
        if($emailId != ''){
            $exist = User::where(['email'=>$emailId,'created_by_id' => auth()->user()->id])->first();
            return response()->json([
                'status' => $exist != null ? $exist['id'] : false
            ]);
        }
    }
}
}